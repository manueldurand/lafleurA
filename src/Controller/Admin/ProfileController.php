<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\Profile\PasswordsType;
use App\Form\Admin\Profile\ProfileType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lafleur/admin', name: 'app_admin_')]
class ProfileController extends AbstractController
{

    /** @var UserRepository $userRepository */
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    #[Route('/lafleur/profile', name: 'profile')]
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $detailForm = $this->createForm(ProfileType::class, $user);
        $detailForm->handleRequest($request);

        if($detailForm->isSubmitted() && $detailForm->isValid()){
            $this->userRepository->save($user, true);
            $this->addFlash('success', 'Mise à jour du compte effectuée');

            return $this->redirectToRoute('app_admin_profile');
        }

        $passwordsForm = $this->createForm(PasswordsType::class, $user);
        $passwordsForm->handleRequest($request);

        if($passwordsForm->isSubmitted() && $passwordsForm->isValid()){

            // Encode(hash) the plain password, and set it.
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $user->getPlainPassword()));
            $this->userRepository->save($user, true);
            $user->eraseCredentials();
            $this->addFlash('success', 'Votre mot de passe a été modifié avec succès');

            return $this->redirectToRoute('app_admin_profile');
        }

        return $this->render('admin/profile/profile.html.twig', [
            'detailForm' => $detailForm->createView(),
            'passwordForm' => $passwordsForm->createView(),
        ]);
    }

    private function manageDetailForm(Request $request, User $user): FormInterface|RedirectResponse
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->userRepository->save($user, true);
            $this->addFlash('success', 'Mise à jour du compte effectuée');

            return $this->redirectToRoute('app_admin_profile');
        }

        return $form;
    }

    private function managePasswordForm(Request $request, User $user): FormInterface|RedirectResponse
    {
        $form = $this->createForm(PasswordsType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Encode(hash) the plain password, and set it.
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $user->getPlainPassword()));
            $this->userRepository->save($user, true);
            $user->eraseCredentials();
            $this->addFlash('success', 'Votre mot de passe a été modifié avec succès');

            return $this->redirectToRoute('app_admin_profile');
        }

        return $form;
    }
}
