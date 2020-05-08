<?php


namespace App\Strategy\Validation;


use App\Form\CheckoutForm;

class CheckoutFormValidation extends BaseFormValidation implements ValidationStrategyInterface
{

    public function supports(string $type)
    {
        return $type === CheckoutForm::class;
    }

    public function validate($data)
    {
        return $this->submit(CheckoutForm::class, $data);
    }
}