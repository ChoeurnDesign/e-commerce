<?php

namespace App\Traits;

trait HasImageHelper
{
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return $this->getPlaceholderImage();
        }

        $paths = [
            'img/products/' . $this->image,
            'images/products/' . $this->image,
            'storage/products/' . $this->image,
            'img/' . $this->image,
        ];

        foreach ($paths as $path) {
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return $this->getPlaceholderImage();
    }

    public function getImagesUrlsAttribute()
    {
        $urls = [$this->image_url];

        foreach (array_merge($this->images ?? [], $this->gallery ?? []) as $img) {
            $paths = [
                'img/products/' . $img,
                'images/products/' . $img,
                'storage/products/' . $img,
            ];
            foreach ($paths as $path) {
                if (file_exists(public_path($path))) {
                    $urls[] = asset($path);
                    break;
                }
            }
        }

        return array_unique($urls);
    }

    public function getThumbnailUrlAttribute()
    {
        $paths = [
            'img/products/thumbnails/' . $this->image,
            'storage/products/thumbnails/' . $this->image,
        ];

        foreach ($paths as $path) {
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return $this->image_url;
    }

    private function getPlaceholderImage()
    {
        $color = '#4ECDC4';
        $initials = strtoupper(substr($this->name ?? 'Product', 0, 2));

        $svg = "<svg xmlns='http://www.w3.org/2000/svg' width='400' height='400'><rect width='100%' height='100%' fill='{$color}'/><text x='50%' y='50%' alignment-baseline='middle' text-anchor='middle' font-size='60' fill='white'>{$initials}</text></svg>";

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
