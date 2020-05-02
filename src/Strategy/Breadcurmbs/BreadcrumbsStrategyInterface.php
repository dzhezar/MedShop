<?php


namespace App\Strategy\Breadcurmbs;


interface BreadcrumbsStrategyInterface
{
    public function supports(string $type);

    public function generateBreadcrumbs($data): array;
}