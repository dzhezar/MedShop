<?php


namespace App\DataMapper\MainPageSlider;


use App\Entity\MainPageSlider;
use App\Model\FormModel\MainPageSliderModel;

class MainPageSliderFormMapper
{
    public function entityToModel(MainPageSlider $mainPageSlider): MainPageSliderModel
    {
        $model = new MainPageSliderModel();

        foreach ($mainPageSlider->getMainPageSliderTranslations() as $mainPageSliderTranslation) {
            $language = strtoupper($mainPageSliderTranslation->getLanguage()->getShortName());
            $model->{'setText' . $language}(
                $mainPageSliderTranslation->getText()
            );
        }

        return $model;
    }
}