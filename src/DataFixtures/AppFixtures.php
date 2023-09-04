<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->addCategories($manager);
        $this->addWishes(30, $manager);
    }

    private function addWishes(int $number, ObjectManager $manager)
    {
        $faker = Factory::create('en_EN');

        $categories = $manager->getRepository(Category::class)->findAll();

        for ($i = 0; $i < $number; $i++) {
            $wish = new Wish();

            $wish
                ->setTitle(implode("", $faker->words()))
                ->setAuthor($faker->firstName)
                ->setDescription($faker->sentence)
                ->setIsPublished($faker->boolean(70))
                ->setDateCreated($faker->dateTimeBetween(new \DateTime("-1 year")))
                ->setCategory($faker->randomElement($categories));


            $manager->persist($wish);
        }

        $manager->flush();
    }

    private function addCategories(ObjectManager $manager)
    {
        $categories = ["Travel & Adventure", "Sport", "Entertainment", "Human Relations", "Others"];

        foreach ($categories as $key) {
            $category = new Category();
            $category->setName($key);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
