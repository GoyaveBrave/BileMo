<?php

namespace App\DataFixtures;


use App\Entity\User;
use App\Entity\Clients;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Proxies\__CG__\App\Entity\Operateur;

class ClientsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        
        //Ajout des products
        for ($i = 0; $i < 5; $i++) {
            $products = new Products();
            $products->setName('Samsung')
                     ->setPrice($faker->numberBetween($min = 100, $max = 700))
                     ->setContent($faker->text($maxNbChars = 200));
            
            $manager->persist($products);
        }

        //Ajout des users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->name())
                ->setEmail($faker->email())
                ->setPassword($faker->password())
                ->setAdress($faker->address())
                ->setToken($faker->regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}'));
            
            $manager->persist($user);
        }
        

        $manager->flush();
    }
}
