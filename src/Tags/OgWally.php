<?php

namespace State\OgWally\Tags;

use Statamic\Tags\Tags;
use State\OgWally\Image;
use State\OgWally\Settings;

class OgWally extends Tags
{

    public function image()
    {
        $title = $this->context->get('title');
        $filename = $this->context->get('slug') . '.png';
        $url = asset("assets/{$filename}");

        $this->makeImageIfNotExists($title, $filename);

        return "<img src='{$url}' alt='{$title}' class='{$this->params->get('class', '')}'>";
    }

    public function ogImage()
    {
        $title = $this->context->get('title');
        $filename = $this->context->get('slug') . '.png';
        $url = asset("assets/{$filename}");

        $this->makeImageIfNotExists($title, $filename);

        return "<meta property='og:image' content='{$url}' />";
    }

    private function makeImageIfNotExists(string $title, string $filename)
    {
        // if (file_exists(public_path("assets/{$filename}"))) {
        //     return;
        // }

        Image::fromSettings(Settings::load())->text($title)->save("assets/{$filename}");
    }
}
