<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Annonce;
use App\Entity\Candidat;
use App\Entity\Recruteur;
use App\Entity\Consultant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private Generator $faker;
    
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
        
    }
    public function load(ObjectManager $manager): void
    {

        //users

        $users = [];
        for ($i=0; $i < 10; $i++) { 
            $user = new User();
            $user->setEmail($this->faker->email())
            ->setRoles(['ROLE_USER'])
            ->setIsRecruteur(true)
            ->setPlainPassword('password');
           $users[]=$user;
            
            $manager->persist($user);

        }

        // data 
        $recruteurs =[];
        for ($i=0; $i < 10; $i++) { 
        $recruteur = new Recruteur();
        $recruteur->setNameEntreprise($this->faker->name())
        ->setActive(true)
        ->setAdresseEntreprise($this->faker->word());
        $recruteurs []=$recruteur;
        $manager->persist($recruteur);

        $manager->flush();
        }

        // data candidat

        for ($i=0; $i < 10; $i++) { 
            $candidat = new Candidat();
            $candidat->setName($this->faker->name())
            ->setLastname($this->faker->name())
            ->setActivation(true)
            ->setCvLien($this->faker->word());
            $manager->persist($candidat);
    
            $manager->flush();
            }


            // data consultant

  for ($i=0; $i < 10; $i++) { 
    $consultant = new Consultant();
    $consultant->setName($this->faker->name())
    ->setLastname($this->faker->name());
    $manager->persist($consultant);

    $manager->flush();
    }


    // data Annonces
   for ($i=0; $i < 10; $i++) { 
    $annonce = new Annonce();
    $annonce->setName($this->faker->name())
    ->setActive(true)
    ->setIntitulePoste($this->faker->word())
    ->setLieuTravail($this->faker->name())
    ->setHorairePost($this->faker->name())
    ->setSalaire("2000")
    ->setDesciptionPoste($this->faker->word())
    ->setRecruteur($recruteurs[mt_rand(0,count($recruteurs)-1)]);
    $manager->persist($annonce);

    $manager->flush();
    }
    }
}
