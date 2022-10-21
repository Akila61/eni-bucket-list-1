<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\ORM\Doctrine\Populator;


class WishFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $wish1 = new Wish();
        $wish1->setTitle('Saut en parachute');
        $wish1->setDescription('La description...');
        $wish1->setAuthor('Pierre');
        $wish1->setIsPublished(true);
        $wish1->setDateCreated(new \DateTime('2020-01-10 09:15:35'));
        $manager->persist($wish1);

        $wish2 = new Wish();
        $wish2->setTitle('Apprendre le PHP');
        $wish2->setAuthor('Pierre');
        $wish2->setIsPublished(false);
        $manager->persist($wish2);

        $wish3 = new Wish();
        $wish3->setTitle('Finir les dessins pour Axelle & Alan');
        $wish3->setDescription('La description...');
        $wish3->setAuthor('Pierre');
        $wish3->setIsPublished(true);
        $wish3->setDateCreated(new \DateTime('2020-09-11 09:15:35'));
        $manager->persist($wish3);

        //utilisation de Faker (génére des données automatiquement)
        $generator = \Faker\Factory::create('fr_FR');
        $populator = new Populator($generator, $manager);
        $populator->addEntity(Wish::class, 100, [
            'author' => function() use ($generator) {
                return $generator->userName;
            }
        ]);
        $populator->execute();
        $manager->flush();
    }
}
