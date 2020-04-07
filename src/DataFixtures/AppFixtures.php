<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Prospects;
use App\Entity\Reservations;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    //                   ADD ENCODER FUNCTION                  //
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        //                 ADD FAKER LIBRARY                  //
        $faker = Factory::create('fr_FR');

        //                  USERS GESTION                      //
        // add super admin
        $superadmin = new Users();
        $superadmin->setUsername('bruno')
            ->setPassword($this->encoder->encodePassword($superadmin, 'superadmin'))
            //->setMail('bruno@mediservice.fr')
            ->setMail('demo_sad@mediservice.fr')
            ->setCategory('ROLE_SUPER_ADMIN')
        ;
        // $manager->persist($product);
        $manager->persist($superadmin);
        // add admin
        $admin = new Users();
        $admin->setUsername('clem')
            ->setPassword($this->encoder->encodePassword($admin, 'admin'))
            //->setMail('clem@mediservice.fr')
            ->setMail('demo_ad@mediservice.fr')
            ->setCategory('ROLE_ADMIN')
        ;
        $manager->persist($admin);
        // add maintenance
        $users = [];
        for ($m = 1; $m <= 4; $m++) {
            $maintenanceUser = new Users();
            $maintenanceUser->setUsername($faker->firstName)
                ->setPassword($this->encoder->encodePassword($maintenanceUser, 'maintenance'))
                ->setMail($maintenanceUser.'@mediservice.fr')
                ->setCategory('ROLE_MAINTENANCE')
            ;
            $manager->persist($maintenanceUser);
            $users[] = $maintenanceUser;
        }
        //add commercial
        for ($c = 1; $c <= 5; $c++) {
            $commercialUser = new Users();
            $commercialUser->setUsername($faker->firstName)
                ->setPassword($this->encoder->encodePassword($commercialUser, 'commercial'))
                ->setMail($commercialUser.'@mediservice.fr')
                ->setCategory('ROLE_COMMERCIAL')
            ;
            $manager->persist($commercialUser);
            $users[] = $commercialUser;
        }

       //                          PROSPECTS GESTION                        //
        $propects = [];
        for ($p = 1; $p <= 400; $p++) {
            $prospect = new Prospects();
            $prospect->setName($faker->company)
                ->setMail($faker->email)
                ->setCity($faker->city)
                ->setPhone($faker->numberBetween(0110132255, 0600441050))
                ->setZipCode($faker->numberBetween(13000, 86600))
                ->setAddress($faker->address);
            $manager->persist($prospect);
            $propects[] = $prospect;
        }
        //                         ARTICLES GESTION                         //
        $state = ['neuf', 'bon', 'moyen', 'usagé'];
        $options = ['electrique','manuel','ultra leger','enfant','confort'];
        $available = ['oui', 'non'];
        $articles = [];

        // add fauteuils
        for ($f = 1; $f <= 40; $f++) {
            $fauteuil = new Articles();
            $fauteuil->setName('fauteuil '.$f)
                ->setReference('F348H32MECL'.$faker->numberBetween(1, 10))
                ->setSerialNumber($faker->numberBetween(115329, 7157500075))
                ->setMaterialState($faker->randomElement($state))
                ->setType('fauteuil')
                ->setOptions($faker->randomElement($options))
                ->setAvailability($faker->randomElement($available))
                ->setDescription($faker->text(150))
                ->setImg($faker->imageUrl())
            ;
            $manager->persist($fauteuil);
            $articles[] = $fauteuil;
        }
        // add lits
        for ($l = 1; $l <= 12; $l++) {
            $lit = new Articles();
            $lit->setName('lit '.$l)
                ->setReference('L4858CMED'.$faker->numberBetween(1, 5))
                ->setSerialNumber($faker->numberBetween(115329, 7157500075))
                ->setMaterialState($faker->randomElement($state))
                ->setType('lit')
                ->setOptions($faker->randomElement($options))
                ->setAvailability($faker->randomElement($available))
                ->setDescription($faker->text(150))
                ->setImg($faker->imageUrl())
            ;
            $manager->persist($lit);
            $articles[] = $lit;
        }
        // add défibrillateurs
        for ($d = 1; $d<=20; $d++) {
            $defibrilateur = new Articles();
            $defibrilateur->setName('defibrillateur '.$d)
                ->setReference('D1424J43')
                ->setSerialNumber($faker->numberBetween(115329, 7157500075))
                ->setMaterialState($faker->randomElement($state))
                ->setType('defibrillateur')
                ->setAvailability($faker->randomElement($available))
                ->setDescription($faker->text(150))
                ->setImg($faker->imageUrl())
            ;
            $manager->persist($defibrilateur);
            $articles[] = $defibrilateur;
        }

        //                        RESERVATIONS GESTION                      //
        $reservations = [];
        for ($j = 1; $j <= mt_rand(40, 100); $j++) {
            $reservationDate = $faker->dateTimeBetween('- 6 months');
            $loanDate = $faker->dateTimeBetween('- 3 months');
            $duration = mt_rand(5 , 15);
            $returnDate = (clone $loanDate)->modify("+$duration days");
            $durationBis = mt_rand(0, 7);
            $realReturnDate = (clone $returnDate)->modify("+$durationBis days");
            $availability = (clone $realReturnDate)->modify('+3 days');

            $reservation = new Reservations();
            $reservation->setReservationDate($reservationDate)
                ->setLoanDate($loanDate)
                ->setReturnDate($returnDate)
                ->setRealReturnDate($realReturnDate)
                ->setAvailabilityDate($availability)
                ->setUser($faker->randomElement($users))
                ->setProspect($faker->randomElement($propects))
                ->setArticle($faker->randomElement($articles))
            ;
            $manager->persist($reservation);
            $reservations[] = $reservation;
        }

        $manager->flush();
    }
}
