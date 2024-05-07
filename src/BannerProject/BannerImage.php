<?php

namespace BannerProject;

class BannerImage {
    private string $image;
    private string $contentType;

    public function __construct($image) {
        $this->contentType = 'image/png';
        $this->image = file_get_contents($image) ?? '';
    }

    public function render(): void {
        header('Content-type: '.$this->contentType.';');
        echo $this->image;
    }
}
