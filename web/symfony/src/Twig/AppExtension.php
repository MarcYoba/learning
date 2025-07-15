<?php
// src/Twig/AppExtension.php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_bytes', [$this, 'formatBytes']),
        ];
    }

    public function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['o', 'Ko', 'Mo', 'Go', 'To', 'Po', 'Eo', 'Zo'];
        
        if ($bytes <= 0) {
            return '0 ' . $units[0];
        }
        
        $pow = floor(log($bytes) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $size = $bytes / (1024 ** $pow);
        return round($size, $precision) . ' ' . $units[$pow];
    }
}