<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class RobotsTxtService
{
    private $robots_file_path;

    /**
     * RobotsTxtService constructor.
     * @param $robots_file_path
     */
    public function __construct($robots_file_path)
    {
        $this->robots_file_path = $robots_file_path;
    }

    public function update(UploadedFile $file)
    {
        $file->move($this->robots_file_path,'robots.txt');
    }
}