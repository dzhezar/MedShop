<?php


namespace App\Service;


class TooltipService
{
    const OLD_IMAGE = 'Старое фото';
    public static function createImageElement(string $image, string $text = null): string
    {
        $block = '<img src="'.$image.'">';
        if($text) {
            $block = $text.'<br>'.$block;
        }

        return $block;
    }
}