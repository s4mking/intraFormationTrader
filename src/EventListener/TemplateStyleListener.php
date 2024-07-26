<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;

class TemplateStyleListener
{
    private $twig;

    public function __construct(Environment $twig)
    {
     $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $style = $_ENV['TEMPLATE_STYLE'] ?? 'default';
        $this->twig->addGlobal('templateStyle', $style);
    }
}
