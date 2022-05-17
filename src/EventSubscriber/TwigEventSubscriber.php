<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;
use App\Service\UserSetting;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $setting;
        
    public function __construct(Environment $twig, UserSetting $setting)
    {
        $this->twig = $twig;
        $this->setting = $setting;
    }
    
    public function onKernelController()
    {
        $this->twig->addGlobal('theme', $this->setting->usedTheme());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
