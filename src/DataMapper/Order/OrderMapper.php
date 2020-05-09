<?php


namespace App\DataMapper\Order;


use App\Entity\Orders as Order;
use App\Model\FormModel\CheckoutModel;
use App\Service\LanguageService;

class OrderMapper
{
    /**
     * @var LanguageService
     */
    private $languageService;

    /**
     * OrderMapper constructor.
     * @param LanguageService $languageService
     */
    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function modelToEntity(CheckoutModel $checkoutModel)
    {
        return (new Order())
            ->setLanguage($this->languageService->getLanguage($checkoutModel->getLanguage()))
            ->setAddress($checkoutModel->getAddress())
            ->setCity($checkoutModel->getCity())
            ->setEmail($checkoutModel->getEmail())
            ->setFullName($checkoutModel->getFullName())
            ->setPhone($checkoutModel->getPhone())
            ->setState($checkoutModel->getState())
            ->setZip($checkoutModel->getZip());
    }
}