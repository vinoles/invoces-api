<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Company;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        // Create User example
        $user = new User();
        $email = 'test@email.com';
        $user->setEmail($email);
        $user->setUsername($email);
        $password = $this->encoder->encodePassword($user, 'pass_1234');
        $user->setPassword($password);
        $manager->persist($user);

        // Ceeate companies lis examples
        for($i = 1; $i < 11; $i++ ) {
            $company = new Company();
            $company->setCompanyRuc('company-' .$i );
            $company->setCompanyBusinessName('Company '.$i );
            $company->setCompanyCommercialName('Company Example' . $i .' ');
            $company->setCompanyCodeSri('1234567'.$i);
            $manager->persist($company);
        }
        

        $manager->flush();
    }
}
