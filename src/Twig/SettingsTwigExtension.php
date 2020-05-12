<?php


namespace App\Twig;


use Predis\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SettingsTwigExtension extends AbstractExtension
{
    /**
     * @var RequestStack
     */
    private $request;
    /**
     * @var Client
     */
    private $redis;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * SettingsTwigExtension constructor.
     * @param RequestStack $request
     * @param ContainerInterface $container
     */
    public function __construct(RequestStack $request, ContainerInterface $container)
    {
        $this->redis = new Client();
        $this->request = $request;
        $this->container = $container;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('settings', [$this, 'getSettings']),
        ];
    }

    public function getSettings($key)
    {
        if(!$this->redis->exists($key.'_'.strtoupper($this->request->getCurrentRequest()->getLocale()))) {
            $this->container->get('app.service.settings')->updateRedisSettings();
        }

        return $this->redis->get($key.'_'.strtoupper($this->request->getCurrentRequest()->getLocale()));
    }
}