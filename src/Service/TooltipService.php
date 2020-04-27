<?php


namespace App\Service;


class TooltipService
{
    const OLD_IMAGE = 'Старое фото';
    public static function createImageElement(string $image, string $text = null): string
    {
        $block = '<img style="object-fit:contain; width: 340px; height: 340px" src="'.$image.'">';
        if($text) {
            $block = $text.'<br>'.$block;
        }

        return $block;
    }
}