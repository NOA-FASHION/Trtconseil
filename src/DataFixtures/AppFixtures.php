<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Recruteur;
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
        for ($i=0; $i < 10; $i++) { 
        $recruteur = new Recruteur();
        $recruteur->setNameEntreprise($this->faker->name())
        ->setActive(true)
        ->setAdresseEntreprise($this->faker->word());
        $manager->persist($recruteur);

        $manager->flush();
        }
    }
}
