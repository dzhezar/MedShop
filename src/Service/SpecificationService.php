<?php


namespace App\Service;


use App\Entity\Language;
use App\Entity\SpecificationTranslation;
use App\Repository\SpecificationTranslationRepository;
use App\Repository\SpecificationValueRepository;

class SpecificationService
{
    /**
     * @var SpecificationTranslationRepository
     */
    private $specificationTranslationRepository;
    /**
     * @var LanguageService
     */
    private $languageService;
    /**
     * @var SpecificationValueRepository
     */
    private     $specificationValueRepository;

    /**
     * SpecificationService constructor.
     * @param SpecificationTranslationRepository $specificationTranslationRepository
     * @param SpecificationValueRepository $specificationValueRepository
     * @param LanguageService $languageService
     */
    public function __construct(
        SpecificationTranslationRepository $specificationTranslationRepository,
        SpecificationValueRepository $specificationValueRepository,
        LanguageService $languageService
    ) {
        $this->specificationTranslationRepository = $specificationTranslationRepository;
        $this->languageService = $languageService;
        $this->specificationValueRepository = $specificationValueRepository;
    }

    public function getAll()
    {
        return $this->specificationTranslationRepository->getNameAndParentId(
            $this->languageService->getLanguage(Language::EN_LANGUAGE_NAME)
        );
    }

    public function getSpecificationsForProduct(?int $id)
    {
        $data =  $this->specificationValueRepository->getNameAndParentIdByProductId(
            $id,
            $this->languageService->getLanguage(Language::EN_LANGUAGE_NAME)
        );

        $result = [];
        foreach ($data as $datum) {
            $arr = [];
            $arr['id'] = $datum->getSpecification()->getId();
            foreach ($datum->getSpecificationValueTranslations() as $specificationValueTranslation) {
                $arr[$specificationValueTranslation->getLanguage()->getShortName()] = $specificationValueTranslation->getName();
            }
            $result[] = $arr;
        }

        return $result;
    }
}