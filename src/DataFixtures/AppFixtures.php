<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\User\Administrator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Filesystem\Filesystem;

class AppFixtures extends Fixture
{
    const SUPER_ADMINS = [
        [User::GENDERS['Monsieur'], "KEOLE", "Système", "dev+starter-sf@keole.net", "castor1234"],
        [User::GENDERS['Monsieur'], "Alzounies", "Alexandre", "alex@keole.net", "alex"],
        [User::GENDERS['Monsieur'], "Schmitt", "Julien", "julien@keole.net", "julien"],
        [User::GENDERS['Monsieur'], "Corso", "Rémi", "remi@keole.net", "remi"],
        [User::GENDERS['Monsieur'], "Mariolle", "Thibault", "thibault@keole.net", "thibault"],
        [User::GENDERS['Monsieur'], "Legagneux", "Matteo", "Matteo@keole.net", "matteo"],
    ];

    const ADMINS = [
        [User::GENDERS['Monsieur'], "Admin", "Test", "dev+admin-test@keole.net", "castor1234"],
        [User::GENDERS['Monsieur'], "Admin2", "Test2", "dev+admin-test2@keole.net", "castor1234"],
    ];

    private UserPasswordHasherInterface $passwordHasher;
    private Filesystem $filesystem;

    public function __construct(UserPasswordHasherInterface $passwordHasher, Filesystem $filesystem)
    {
        $this->passwordHasher  = $passwordHasher;
        $this->filesystem      = $filesystem;

        $this->faker = Factory::create("fr_FR");
    }

    public function load(ObjectManager $manager): void
    {
        $this->purgeFiles();

        $this->loadSuperAdmins($manager);
        $this->loadAdministrators($manager);
//        $this->loadMembers($manager);
    }

    public function purgeFiles()
    {
        $this->filesystem->remove([__DIR__ . '/../../public/uploads']);
        $this->filesystem->remove([__DIR__ . '/../../var/uploads']);
    }

    private function loadSuperAdmins(ObjectManager $manager)
    {
        echo "Loading administrators...\n";

        foreach (self::SUPER_ADMINS as [$civility, $lastName, $firstName, $email, $plainPassword]) {
            $user = new User\Administrator();

            // Hash user password
            $password = $this->passwordHasher->hashPassword($user, (string)$plainPassword);

            $user
                ->setGender($civility)
                ->setLastname($lastName)
                ->setFirstname($firstName)
                ->setEmail($email)
                ->setPassword($password)
                ->setRoles([Administrator::ROLES['Super Admin']]);

            $manager->persist($user);

            echo ".";
        }

        $manager->flush();
        $manager->clear();

        echo "\n";
        echo "Done\n";
        echo "\n";
    }

    private function loadAdministrators(ObjectManager $manager)
    {
        echo "Loading administrators...\n";

        foreach (self::ADMINS as [$civility, $lastName, $firstName, $email, $plainPassword]) {
            $user = new User\Administrator();

            // Hash user password
            $password = $this->passwordHasher->hashPassword($user, (string)$plainPassword);

            $user
                ->setGender($civility)
                ->setLastname($lastName)
                ->setFirstname($firstName)
                ->setEmail($email)
                ->setPassword($password)
                ->setRoles([Administrator::ROLES['Administrateur']]);

            $manager->persist($user);

            echo ".";
        }

        $manager->flush();
        $manager->clear();

        echo "\n";
        echo "Done\n";
        echo "\n";
    }
}
