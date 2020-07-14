<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Image;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * L'encodeur de mots de passe
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($u = 0; $u < 3; $u++ ) {
            $user = new User();

            $hash = $this->encoder->encodePassword($user, "password");

            $user->setName($faker->firstName())
                ->setEmail($faker->email)
                ->setPhone($faker->e164PhoneNumber)
                ->setPassword($hash);

            $manager->persist($user);


            for($a = 0; $a < mt_rand(2, 3); $a++)
            {
                $annonce = new Annonce();
                $annonce
                    ->setTitle($faker->randomElement(['CIAM', 'Excellence', 'NATHAN', 'Sciences de la vie et de la terre', 'Champions', 'Chemin de la réussite', 'Histoire', 'Géographie', 'CARGO', 'Physique', 'Chimie']))
                    ->setHouseEdition($faker->randomElement(['Les Classiques Africains', 'EDICEF', 'HATIER', 'Editions Clé', 'Professeurs réunis']))
                    ->setDescription($faker->paragraphs(1, true))
                    ->setYearParution($faker->year)
                    ->setExigences($faker->paragraphs(1, true))
                    ->setUser($user);



                $manager->persist($annonce);
            }

            for($i = 0; $i < mt_rand(0, 20); $i++)
            {
                $image = new Image();
                $image
                    ->setUrl($faker->imageUrl($width = 640, $height = 480))
                ;

                $manager->persist($image);
            }
        }
        $manager->flush();
    }

}