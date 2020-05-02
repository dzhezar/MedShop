<?php


namespace App\Service;


use App\Strategy\Breadcurmbs\BreadcrumbsStrategyInterface;

class BreadcrumbsService
{
    /**
     * @var BreadcrumbsStrategyInterface[]
     */
    private $strategies;

    /**
     * BreadcrumbsService constructor.
     * @param $strategies
     */
    public function __construct($strategies)
    {
        $this->strategies = $strategies;
    }

    public function generateBreadcrumbs($data, $type)
    {
        $strategy = $this->chooseStrategy($type);
        return $strategy->generateBreadcrumbs($data);
    }

    /**
     * @return BreadcrumbsStrategyInterface|mixed
     * @throws \Exception
     * @var string $type
     */
    private function chooseStrategy(string $type)
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($type)) {
                return $strategy;
            }
        }

        throw new \Exception('Strategy not found');
    }
}