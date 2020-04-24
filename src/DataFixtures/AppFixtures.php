<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("langlersylvain@gmail.com");
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'Sylvain1234'
        ));
        $manager->persist($user);

        $manager->flush();
    }
}
