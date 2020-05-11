<?php


namespace App\Strategy\Validation;


interface ValidationStrategyInterface
{
    public function supports(string $type);

    public function validate($data);
}