<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\Security\ResetPasswordRequestType;
use App\Form\Security\ResetPasswordType;
use App\Manager\NotificationManager;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route('/lafleur/forgot-password', name: 'reset_password_')]
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private EntityManagerInterface $manager;
    private ResetPasswordHelperInterface $resetPasswordHelper;

    public function __construct(EntityManagerInterface $manager, ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->manager             = $manager;
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    #[Route('', name: 'request')]
    public function request(Request $request, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(ResetPasswordRequestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processSendingPasswordResetEmail(
                $form->get('email')->getData(),
                $mailer,
                $translator
            );
        }

        return $this->render(
            'security/reset_password/request.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/check-email', name: 'check_email')]
    public function checkEmail(): Response
    {
        // Generate a fake token if the user does not exist or someone hit this page directly.
        // This prevents exposing whether or not a user was found with the given email address or not
        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render('security/reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }

    #[Route('/token/{token}', name: 'reset')]
    public function reset(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface, string $token = null): Response
    {
        if ($token) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('reset_password_reset');
        }

        $token = $this->getTokenFromSession();
        if (null === $token) {
            throw $this->createNotFoundException('Token is missing from the URL or in the session.');
        }

        try {
            /** @var User $user */
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        }
        catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('danger', 'Une erreur est survenue : '. $e->getReason());

            return $this->redirectToRoute('reset_password_request');
        }

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ResetPasswordType::class, $user, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            // Encode(hash) the plain password, and set it.
            $user->setPassword($userPasswordHasherInterface->hashPassword($user, $user->getPlainPassword()));
            $this->manager->flush();

            $user->eraseCredentials();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            $this->addFlash('success', 'Votre mot de passe a été modifié avec succès.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password/reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer, TranslatorInterface $translator): RedirectResponse
    {
        $user = $this
            ->manager
            ->getRepository(User::class)
            ->findOneBy(
                [
                    'email'     => $emailFormData,
                    'deletedAt' => null,
                ]
            );

        // Do not reveal whether a user account was found or not.
        if (!$user) {
            return $this->redirectToRoute('reset_password_check_email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        }
        catch (ResetPasswordExceptionInterface $e) {
            // If you want to tell the user why a reset email was not sent, uncomment
            // the lines below and change the redirect to 'app_forgot_password_request'.
            // Caution: This may reveal if a user is registered or not.
            //
            if($_ENV['APP_ENV'] === 'dev') {
                $this->addFlash('danger', sprintf(
                    'There was a problem handling your password reset request - %s',
                    $e->getReason()
                ));
            }

            return $this->redirectToRoute('reset_password_check_email');
        }

        $from = new Address($_ENV['MAILER_ADDRESS'], $_ENV['MAILER_NAME']);
        $to   = new Address($user->getEmail(), $user->getFullName());

        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject('Réinitialisation de votre mot de passe')
            ->htmlTemplate('_emails/security/_reset_password_request.html.twig')
            ->context([
                'user'       => $user,
                'resetToken' => $resetToken,
            ]);

        try {
            $mailer->send($email);
        }
        catch (TransportExceptionInterface $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi du mail de réinitialisation de mot de passe, merci de réessayer ultérieurement.');
        }

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('reset_password_check_email');
    }
}
