<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $languages = [
            [
                'name' => 'English',
                'short_name' => 'en'
            ],
            [
                'name' => 'Русский',
                'short_name' => 'ru'
            ]
        ];

        foreach ($languages as $language) {
            $entity = new Language();
            $entity->setName($language['name']);
            $entity->setShortName($language['short_name']);
            $manager->persist($entity);
        }



        $manager->flush();
    }
}
