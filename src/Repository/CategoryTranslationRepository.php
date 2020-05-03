<?php

namespace App\Repository;

use App\Entity\CategoryTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryTranslation[]    findAll()
 * @method CategoryTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryTranslation::class);
    }

    public function getAllWithSubCategories(int $langId)
    {
        return $this->createQueryBuilder('category_translation')
            ->addSelect('category', 'child_categories', 'child_categories_translation')
            ->leftJoin('category_translation.category', 'category')
            ->leftJoin('category.categories', 'child_categories')
            ->leftJoin('child_categories.categoryTranslations', 'child_categories_translation')
            ->andWhere('category.category is null')
            ->andWhere('category_translation.language = :langId')
            ->setParameter('langId', $langId)
            ->getQuery()->getResult();
    }

    public function getPopularCategories(int $langId)
    {
        return $this->createQueryBuilder('category_translation')
            ->addSelect('category')
            ->leftJoin('category_translation.category', 'category')
            ->where('category.is_on_main = true')
            ->andWhere('category_translation.language = :langId')
            ->setParameter('langId', $langId)
            ->getQuery()->getResult();
    }

    public function getCategoryBySlugAndLanguage(string $slug, int $languageId, string $subCategorySlug = null)
    {
        $query = $this->createQueryBuilder('category_translation')
            ->addSelect('category', 'sub_category', 'sub_category_translations', 'sub_category_translations_language')
            ->leftJoin('category_translation.category', 'category')
            ->leftJoin('category.category', 'sub_category')
            ->leftJoin('category.categoryTranslations', 'sub_category_translations')
            ->leftJoin('sub_category_translations.language', 'sub_category_translations_language')
            ->where('category.slug = :slug')
            ->andWhere('category_translation.language = :languageId')
            ->setParameter('slug', $slug)
            ->setParameter('languageId', $languageId);

        if ($subCategorySlug) {
            $query
                ->andWhere('sub_category.slug =:subCategorySlug')
                ->andWhere('sub_category_translations_language = :languageId')
                ->setParameter('subCategorySlug', $subCategorySlug);
        }

        return $query->getQuery()->getOneOrNullResult();
    }
}
