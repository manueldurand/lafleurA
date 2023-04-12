<?php

namespace App\Manager\User;

use App\Entity\User;
use App\Entity\User\Member;
use DateTime;
use Doctrine\ORM\QueryBuilder;
use Knp\Bundle\TimeBundle\DateTimeFormatter;
use Omines\DataTablesBundle\Adapter\Doctrine\FetchJoinORMAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORM\SearchCriteriaProvider;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\AbstractColumn;
use Omines\DataTablesBundle\Column\BoolColumn;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\DataTableState;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class MemberManager
{
    private DataTableFactory           $dataTableFactory;
    private UrlGeneratorInterface      $urlGenerator;
    private CsrfTokenManagerInterface  $csrfTokenManager;
//    private VerifyEmailHelperInterface $verifyEmailHelper;
    private MailerInterface            $mailer;

    public function __construct(DataTableFactory $dataTableFactory, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, MailerInterface $mailer)
    {
        $this->dataTableFactory  = $dataTableFactory;
        $this->urlGenerator      = $urlGenerator;
        $this->csrfTokenManager  = $csrfTokenManager;
//        $this->verifyEmailHelper = $verifyEmailHelper;
        $this->mailer            = $mailer;
    }

    public function getDatatable(Request $request, DateTimeFormatter $dateTimeFormatter, bool $enableImpersonate) {
        return $this
            ->dataTableFactory
            ->create()
            ->add(
                'gender',
                TextColumn::class,
                [
                    'label' => 'Civilité',
                    'field' => 'user.gender',
                    'render' => function ($value, Member $user) {
                        return array_search($user->getGender(), User::GENDERS);
                    }
                ]
            )
            ->add(
                'lastname',
                TextColumn::class,
                [
                    'label' => 'Nom',
                    'render' => function ($value, Member $user) {
                        $showUrl = $this->urlGenerator->generate(
                            'app_admin_users_edit',
                            [
                                'id' => $user->getId()
                            ],
                            // UrlGeneratorInterface::ABSOLUTE_URL
                            UrlGeneratorInterface::NETWORK_PATH
                        );

                        if ($value) {
                            $value = '<a href="' . $showUrl . '" class="text-gray-800 text-hover-primary mb-1">' . $value . '</a>';
                        }

                        return $value;
                    }
                ]
            )
            ->add(
                'firstname',
                TextColumn::class,
                [
                    'label' => 'Prénom',
                    'render' => function ($value, Member $user) {

                        $showUrl = $this->urlGenerator->generate(
                            'app_admin_users_edit',
                            [
                                'id' => $user->getId()
                            ],
                            // UrlGeneratorInterface::ABSOLUTE_URL
                            UrlGeneratorInterface::NETWORK_PATH
                        );

                        if ($value) {
                            $value = '<a href="' . $showUrl . '" class="text-gray-800 text-hover-primary mb-1">' . $value . '</a>';
                        }

                        return $value;
                    }
                ]
            )
            ->add(
                'email',
                TextColumn::class,
                [
                    'label' => 'Email',
                    'render' => function ($value, Member $user) {
                        if ($value) {
                            $value = "<a class='me-1' href='mailto:$value' data-bs-toggle='tooltip' data-bs-placement='top' title='Contacter'><i class='bi bi-envelope'></i></a>" . $value;
                        }

                        return $value;
                    }
                ]
            )
            ->add(
                'active',
                BoolColumn::class,
                [
                    'label'      => 'Active',
                    'field'      => 'user.active',
                    'trueValue'  => '<i class="bi bi-circle-fill text-success fs-8 me-2"></i> Oui',
                    'falseValue' => '<i class="bi bi-circle-fill text-danger fs-8 me-2"></i> Non',
                ]
            )
            ->add(
                'lastLoggedAt',
                DateTimeColumn::class,
                [
                    'label'     => 'Dernière connexion',
                    'format'    => 'd/m/Y H:i',
                    'render' => function($value, Member $user) use ($dateTimeFormatter){
                        return $user->getLastLoggedAt() ? $dateTimeFormatter->formatDiff($user->getLastLoggedAt(), (new \DateTime())) : '';
                    }
                ]
            )
            ->add(
                'action',
                TextColumn::class,
                [
                    'label' => 'Actions',
                    'render' => function ($value, Member $user) use ($enableImpersonate) {
                        $editUrl = $this->urlGenerator->generate(
                            'app_admin_users_edit',
                            [
                                'id' => $user->getId()
                            ],
                            // UrlGeneratorInterface::ABSOLUTE_URL
                            UrlGeneratorInterface::NETWORK_PATH
                        );
                        $deleteUrl = $this->urlGenerator->generate(
                            'app_admin_users_delete',
                            [
                                'id' => $user->getId()
                            ],
                            // UrlGeneratorInterface::ABSOLUTE_URL
                            UrlGeneratorInterface::NETWORK_PATH
                        );
                        $csrfToken = $this->csrfTokenManager->getToken('delete-token');

                        $value = '<a href="'.$editUrl.'" class="btn btn-icon btn-light-primary w-30px h-30px me-1">
                                      <span data-bs-toggle="tooltip" data-bs-trigger="hover" aria-label="Edit" data-bs-original-title="Modifier" data-kt-initialized="1">                                
                                            <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
                                      </span>
                                    </a>';
                        $value .= '<a href="'.$deleteUrl.'" data-token="'.$csrfToken.'" class="btn btn-icon btn-light-danger w-30px h-30px delete-button">
                                      <span data-bs-toggle="tooltip" data-bs-trigger="hover" aria-label="Edit" data-bs-original-title="Supprimer" data-kt-initialized="1">                                
                                            <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span></i>
                                      </span>
                                    </a>';
                        return $value;
                    },
                    'orderable' => false,
                    'className' => 'text-center'
                ]
            )
            ->createAdapter(
                ORMAdapter::class,
                [
                    'entity'   => Member::class,
                    'query'    => [
                        function (QueryBuilder $builder, DataTableState $state) {
                        $builder
                            ->select('user')
                            ->from(Member::class, 'user')
                            ->andWhere('user.deletedAt IS NULL');
                        },
                        new SearchCriteriaProvider(),
                    ],
                    'criteria' => [
                        function (QueryBuilder $builder, DataTableState $state) {
                            $search = $state->getGlobalSearch();

                            foreach ($state->getSearchColumns() as $key => $value) {
                                /** @var AbstractColumn $column */
                                $column = $value['column'];
                                $columnSearch = $value['search'];

                                $builder
                                    ->andWhere("{$column->getField()} = :$key")
                                    ->setParameter(":$key", $columnSearch);
                            }

                            $builder
                                ->andWhere('
                                    user.lastname LIKE :search
                                    OR user.firstname LIKE :search
                                    OR user.email LIKE :search
                                ')
                                ->setParameter('search', "%$search%");
                        },
                    ],
                ]
            )
            ->setName("users")
            ->handleRequest($request);
    }

    public function sendAccountValidationEmail(Member $user): bool
    {
        // Generate signature to validate email
        $signatureComponent = $this->verifyEmailHelper->generateSignature(
            'app_account_confirmation',
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()] // add User's id as an extra query param
        );

        // Send signature
        $email = (new TemplatedEmail())
            ->to(new Address($user->getEmail(), $user->__toString()))
            ->from(new Address($_ENV['MAILER_ADDRESS'], $_ENV['MAILER_NAME']))
            ->subject("Confirmation de compte")
            ->htmlTemplate('security/_emails/_confirmation-required.html.twig')
            ->context([
                'user'      => $user,
                'signedUrl' => $signatureComponent->getSignedUrl(),
            ]);

        try {
            $this->mailer->send($email);
            return true;
        }
        catch (TransportExceptionInterface $e) {
            return false;
        }
    }
}