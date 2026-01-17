<?php

namespace App\Helpers;

class PlaceholderAvatar
{
    /**
     * svgDataUri($text, $size = 400, $parentSeed = null)
     * - $text: shown initials (category name)
     * - $parentSeed: string used to derive base hue for parent categories
     */
    public static function svgDataUri(string $text, int $size = 400, ?string $parentSeed = null): string
    {
        $initials = self::initials($text);
        $bg = self::colorFor($parentSeed ?? $text); // Use parentSeed for consistent colors
        $fontSize = (int)($size * 0.38);
        $escaped = htmlspecialchars($initials, ENT_QUOTES | ENT_SUBSTITUTE);

        $svg = <<<SVG
            <svg xmlns='http://www.w3.org/2000/svg' width='{$size}' height='{$size}' viewBox='0 0 {$size} {$size}'>
                <circle cx='50%' cy='50%' r='100%' fill='{$bg}'/>
                <text x='50%' y='50%' dy='.35em' text-anchor='middle' font-family='Segoe UI, Roboto, Arial, sans-serif' font-size='{$fontSize}' fill='#ffffff'>{$escaped}</text>
            </svg>
        SVG;
        $svg = str_replace(["\n", "\r", "\t"], '', $svg);
        $encoded = rawurlencode($svg);
        return "data:image/svg+xml;utf8,{$encoded}";
    }

    protected static function initials(string $text): string
    {
        $words = preg_split('/[\\s&,\\-\\/]+/u', trim($text), -1, PREG_SPLIT_NO_EMPTY);
        $words = array_values($words);

        if (!$words || count($words) === 0) return 'C';
        if (count($words) === 1) return mb_strtoupper(mb_substr($words[0], 0, 1));
        return mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
    }

    /**
     * colorFor($seed)
     * - Deterministic pastel-like color from $seed (parent category seed)
     */
    protected static function colorFor(string $seed): string
    {
        $hash = crc32($seed);
        $baseHue = $hash % 360;

        // Fixed lightness and saturation for parent categories
        $baseLight = 50; // pastel mid-light
        $s = 62;

        return self::hslToHex($baseHue, $s, $baseLight);
    }

    protected static function hslToHex($h, $s, $l)
    {
        $s /= 100; $l /= 100;
        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs((($h / 60) % 2) - 1));
        $m = $l - $c / 2;
        if ($h < 60) [$r,$g,$b] = [$c,$x,0];
        elseif ($h < 120) [$r,$g,$b] = [$x,$c,0];
        elseif ($h < 180) [$r,$g,$b] = [0,$c,$x];
        elseif ($h < 240) [$r,$g,$b] = [0,$x,$c];
        elseif ($h < 300) [$r,$g,$b] = [$x,0,$c];
        else [$r,$g,$b] = [$c,0,$x];
        $r = (int)(($r + $m) * 255);
        $g = (int)(($g + $m) * 255);
        $b = (int)(($b + $m) * 255);
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}