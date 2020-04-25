<?php


namespace App\Service;


use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;

class SlugService
{
    /**
     * @var Slugify
     */
    private $slugify;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * SlugService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->slugify = new Slugify();
        $this->entityManager = $entityManager;
    }

    public function slugify(string $text, $entity, $property)
    {
        $original_text = $text;
        $slug = $this->slugify->slugify($text);

        $number = 1;

        while ($this->isExists($slug, $entity, $property)) {
            $text = $original_text.'-'.$number;
            $slug = $this->slugify->slugify($text);
            $number++;
        }


        return $slug;
    }

    private function isExists(string $slug, $entity, $property): bool
    {
        return (bool) $this->entityManager->getRepository($entity)->findOneBy([$property => $slug]);
    }

}