<?php


namespace App\DataMapper\MainPageSlider;


use App\Entity\MainPageSliderTranslation;
use App\Model\OutputModel\MainPageSliderModel;

class MainPageSliderOutputMapper
{
    public static function entityToModel(MainPageSliderTranslation $mainPageSliderTranslation): MainPageSliderModel
    {
        return (new MainPageSliderModel())
            ->setId($mainPageSliderTranslation->getMainPageSlider()->getId())
            ->setImage($mainPageSliderTranslation->getMainPageSlider()->getImage())
            ->setText($mainPageSliderTranslation->getText());
    }
}