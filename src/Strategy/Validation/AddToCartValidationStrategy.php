<?php


namespace App\Strategy\Validation;


class AddToCartValidationStrategy implements ValidationStrategyInterface
{
    const TYPE_NAME = 'add_to_cart';

    public function supports(string $type)
    {
        return $type === self::TYPE_NAME;
    }

    /** @return bool
     * @var array $data
     */
    public function validate($data)
    {
        return isset($data['id']) && !empty($data['id']);
    }
}