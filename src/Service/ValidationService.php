<?php


namespace App\Service;


use App\Strategy\Validation\ValidationStrategyInterface;

class ValidationService
{

    private $strategies;

    public function __construct($strategies)
    {
        $this->strategies = $strategies;
    }

    public function validate($data, $type)
    {
        $strategy = $this->chooseStrategy($type);
        return $strategy->validate($data);
    }

    /**
     * @return ValidationStrategyInterface
     * @throws \Exception
     * @var string $type
     */
    private function chooseStrategy(string $type)
    {
        foreach ($this->strategies as $strategy) {
            if($strategy->supports($type)) {
                return $strategy;
            }
        }

        throw new \Exception('Strategy not found');
    }
}