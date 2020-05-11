<?php


namespace App\Service;


use Doctrine\Common\Collections\ArrayCollection;
use Predis\Client;
use Symfony\Component\Yaml\Yaml;

class SettingsCRUDService
{
    /**
     * @var string
     */
    private $file_path;
    /**
     * @var ArrayCollection
     */
    private $file_content;
    /**
     * @var Client
     */
    private $redis;

    /**
     * SettingsCRUDService constructor.
     * @param $file_dir
     */
    public function __construct($file_dir)
    {
        $this->file_path = $file_dir . (file_exists(
                $file_dir . 'settings.local.yaml'
            ) ? 'settings.local.yaml' : 'settings.yaml');
        $this->file_content = new ArrayCollection(Yaml::parseFile($this->file_path));
        $this->redis = new Client();
    }

    public function update(array $data)
    {
        foreach ($data as $key => $value) {
            $arr = $this->file_content->get($key);
            $arr['value'] = $value;
            $this->file_content->set($key, $arr);
            $this->redis->set($key, $value);
        }
        $this->save();
    }

    public function updateRedisSettings()
    {
        foreach ($this->file_content as $key => $item) {
            $this->redis->set($key, $item['value']);
        }
    }

    public function getAll()
    {
        return $this->file_content->toArray();
    }

    private function save()
    {
        file_put_contents($this->file_path, Yaml::dump($this->file_content->toArray()));
    }
}