<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ClientsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        //Ajout des products
        for ($i = 0; $i < 5; ++$i) {
            $products = new Products();
            $products->setName('Samsung')
                     ->setPrice($faker->numberBetween($min = 100, $max = 700))
                     ->setContent($faker->text($maxNbChars = 200));

            $manager->persist($products);
        }

        //Ajout des customer
        for ($i = 0; $i < 10; ++$i) {
            $user = new Customer();

            $user->setEmail($faker->email()
                  ->setName($faker->name)
                  ->setAddress($faker->address)
                  ->setUserId($faker->numberBetween($min = 52, $max = 53)));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
