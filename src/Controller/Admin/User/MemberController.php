<?php

namespace App\Controller\Admin\User;

use App\Entity\User;
use App\Entity\User\Member;
use App\Form\Admin\Member\MemberCreateType;
use App\Manager\User\MemberManager;
use App\Repository\User\MemberRepository;
use Knp\Bundle\TimeBundle\DateTimeFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/users', name: 'app_admin_users_')]
class MemberController extends AbstractController
{
    /** @var MemberManager $memberManager */
    private MemberManager $memberManager;
    /** @var MemberRepository $memberRepository */
    private MemberRepository $memberRepository;
    /** @var DateTimeFormatter $dateTimeFormatter */
    private DateTimeFormatter $dateTimeFormatter;
    /** @var UserPasswordHasherInterface $passwordHasher */
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(MemberManager $memberManager, DateTimeFormatter $dateTimeFormatter, MemberRepository $memberRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->memberManager = $memberManager;
        $this->memberRepository = $memberRepository;
        $this->dateTimeFormatter = $dateTimeFormatter;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/', name: 'list')]
    public function index(Request $request): Response
    {
        $datatable = $this->memberManager->getDatatable($request, $this->dateTimeFormatter, $this->isGranted('ROLE_ALLOWED_TO_SWITCH'));

        if ($datatable->isCallback()) {
            return $datatable->getResponse();
        }

        return $this->render('admin/users/list.html.twig', [
            'datatable' => $datatable,
            'genders' => User::GENDERS
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request): Response
    {
        $member = new Member();
        $form = $this->createForm(MemberCreateType::class, $member);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $member->setPassword($this->passwordHasher->hashPassword($member, $member->getPlainPassword()));
            $this->memberRepository->save($member, true);
            $this->addFlash('success', 'Utilisateur créé avec succès');

            return $this->redirectToRoute('app_admin_users_list');
        }

        return $this->render('admin/users/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(Member $member, Request $request): Response
    {
        $form = $this->createForm(MemberCreateType::class, $member);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $member->setPassword($this->passwordHasher->hashPassword($member, $member->getPlainPassword()));
            $this->memberRepository->save($member, true);
            $this->addFlash('success', 'Utilisateur créé avec succès');

            return $this->redirectToRoute('app_admin_users_list');
        }

        return $this->render('admin/users/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(Member $member, Request $request): Response
    {

        if ($member->getDeletedAt()) {
            $this->addFlash('danger', 'Cet utilisateur a déjà été supprimé.');
            return $this->redirectToRoute('app_admin_users_list');
        }

        $token = $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-token', $token)) {
            $this->memberRepository->remove($member, true);
            $this->addFlash('success', "L'utilisateur a bien été supprimé.");
        }
        else {
            $this->addFlash('danger', "Requête invalide, l'utilisateur n'a pas été supprimé");
        }

        return $this->redirectToRoute('app_admin_users_list');
    }
}
