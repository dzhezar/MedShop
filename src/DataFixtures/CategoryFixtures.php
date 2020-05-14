<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\CategoryTranslation;
use App\Entity\Language;
use App\Service\LanguageService;
use App\Service\SlugService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var \Faker\Generator
     */
    private $faker;
    /**
     * @var SlugService
     */
    private $slugService;
    /**
     * @var LanguageService
     */
    private $languageService;
    /**
     * @var array
     */
    private $languagesArray;

    /**
     * CategoryFixtures constructor.
     * @param SlugService $slugService
     * @param LanguageService $languageService
     */
    public function __construct(SlugService $slugService, LanguageService $languageService)
    {
        $this->languagesArray = Language::LANGUAGES_ARRAY;
        $this->faker = Factory::create();
        $this->slugService = $slugService;
        $this->languageService = $languageService;
    }

    public function load(ObjectManager $manager)
    {
//        $categoryPrevious = null;
//        for ($i = 0; $i < 30; $i++) {
//            $category = new Category();
//
//            $name = $this->faker->realText(20);
//            $slug = $this->slugService->slugify($name, Category::class, 'slug');
//            $category->setSlug($slug);
//            $category->setIsOnMain(rand(0, 1));
//            $category->setImage('https://i.picsum.photos/id/'.rand(500, 1000).'/300/300.jpg');
//            $manager->persist($category);
//            $manager->flush();
//            foreach ($this->languagesArray as $language) {
//                $categoryTranslation = new CategoryTranslation();
//                $categoryTranslation->setCategory($category);
//                $categoryTranslation->setTitle($this->faker->realText(20));
//                $categoryTranslation->setDescription($this->faker->realText(200));
//                $categoryTranslation->setSeoTitle($this->faker->realText(40));
//                $categoryTranslation->setSeoDescription($this->faker->realText(60));
//                $categoryTranslation->setLanguage($this->languageService->getLanguage($language));
//                $manager->persist($categoryTranslation);
//                $manager->flush();
//            }
//            $categoryPrevious = $category;
//        }
    }

    public function getDependencies()
    {
        return [
           LanguageFixtures::class
        ];
    }
}
