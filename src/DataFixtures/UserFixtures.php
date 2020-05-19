<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('formateur@formateur.fr');
        $user->setNom('wick');
        $user->setPrenom('john');
        $user->setRoles(['ROLE_FORMATEUR']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'formateur'
        ));
        $manager->persist($user);
        $user2 = new User();
        $user2->setNom('el mouelhi');
        $user2->setPrenom('achref');
        $user2->setEmail('stagiaire@stagiaire.fr');
        $user2->setRoles(['ROLE_STAGIAIRE']);
        $user2->setPassword($this->passwordEncoder->encodePassword(
            $user2,
            'stagiaire'
        ));
        $manager->persist($user2);
        $manager->flush();
    }
    
}
