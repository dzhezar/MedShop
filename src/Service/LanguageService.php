<?php


namespace App\Service;


use App\Entity\Language;
use App\Repository\LanguageRepository;

class LanguageService
{
    private $languageArray = [];
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * LanguageService constructor.
     * @param LanguageRepository $languageRepository
     */
    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function getLanguage(string $short_name): ?Language
    {
        if(!isset($this->languageArray[$short_name])) {
            $language = $this->languageRepository->findOneBy(['short_name' => $short_name]);
            $this->languageArray[$short_name] = $language;
            return $language;
        }

        return $this->languageArray[$short_name];
    }
}