<?php

namespace App\DataFixtures;

use Faker;
use DateTimeImmutable;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductFixtures extends Fixture
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        for($i = 0; $i < 12; $i++)
        {
            $product = new Product();

            $product->setName("Nom du produit ".$i+1);
            $product->setDescription("Lorem ipsum dolor sit amet.");
            $product->setPrice(rand(1, 50));
            $product->setSlug("nom-du-produit-".$i);
            $manager->persist($product);
            
            //FAKER_BUG
            // $product->setName($faker->sentence($nbWords = 2, $variableNbWords = true));
            // $product->setDescription($faker->sentence($nbWords = 125, $variableNbWords = true));
            // $product->setPrice($faker->numberBetween(10, 300));
            // $product->setSlug($this->slugger->slug($product->getName()));
            //FAKER_BUG
        }

        $manager->flush();
    }
}
