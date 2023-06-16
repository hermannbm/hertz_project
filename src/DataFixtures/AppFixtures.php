<?php

namespace App\DataFixtures;

use App\Entity\Voiture;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    /** 
     * @var Generator
     */
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=20;$i++){
            $voiture = new Voiture; 
            $voiture->setTitre($this->faker->sentence(3))
            ->setMarque($this->faker->sentence(1))
            ->setModele($this->faker->sentence(1))
            ->setDescription($this->faker->paragraph(8))
            ->setPhoto($this->faker->imageUrl(640 , 480 , 'voiture'))
            ->setPrixJournalier($this->faker->randomNumber(3))
            ->setDateEnregistrement($this->faker->dateTimeBetween('-3 days'));
            $manager->persist($voiture);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
