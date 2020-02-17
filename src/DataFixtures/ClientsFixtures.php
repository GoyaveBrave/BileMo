<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Products;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ClientsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $user1 = new User('sfr@sfr.fr', null, '$argon2id$v=19$m=65536,t=4,p=1$VVRzLld1TTd6Mmh3aDZ5Uw$yDmHgIH8duMxQ8g/hw2vDsQvZWuvK4qeQuE04DKOnYY');
        $user2 = new User('orange@orange.fr', null, '$argon2id$v=19$m=65536,t=4,p=1$VVRzLld1TTd6Mmh3aDZ5Uw$yDmHgIH8duMxQ8g/hw2vDsQvZWuvK4qeQuE04DKOnYY');
        $manager->persist($user1);
        $manager->persist($user2);

        //SFR customers
        for ($i = 0; $i < 10; ++$i) {
            $number = $i + 1;
            $customer = new Customer(
                'customer '.$number,
                'Doe',
                'email'.$number.'@gmail.com',
                $user1,
                null
            );
            $manager->persist($customer);
        }

        //Orange customers
        for ($i = 10; $i < 20; ++$i) {
            $number = $i + 1;
            $customer = new Customer(
                'customer '.$number,
                'Doe',
                'email'.$number.'@gmail.com',
                $user2,
                null
            );
            $manager->persist($customer);
        }

        $manager->flush();
    }

    /*
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
    } */
}
