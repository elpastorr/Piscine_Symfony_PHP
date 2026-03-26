<?php

namespace App\Twig;

use App\Service\Ex03Service;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Ex03Extension extends AbstractExtension
{
    private Ex03Service $service;

    public function __construct(Ex03Service $service)
    {
        $this->service = $service;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('uppercaseWords', [$this->service, 'uppercaseWords']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('countNumbers', [$this->service, 'countNumbers']),
        ];
    }
}