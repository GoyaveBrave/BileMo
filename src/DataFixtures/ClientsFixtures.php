<?php

namespace App\DataFixtures;


use App\Entity\Clients;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ClientsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        
        //$operateur = new Operateur();

        for ($i = 0; $i < 10; $i++) {
            $clients = new Clients();
            $clients->setName($faker->name)
                ->setMail($faker->email)
                ->setPassword($faker->password);
            
            $manager->persist($clients);
        }
        

        $manager->flush();
    }
}
