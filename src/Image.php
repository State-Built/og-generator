<?php

namespace State\OgGenerator;


class Image
{
    protected \Intervention\Image\Image $img;
    protected string $text = "";
    protected int $fontSize = 64;
    protected int $wrap = 20;
    protected string $textColor = "#FFFFFF";
    protected string $font;
    protected int $textTop = 0;
    protected int $textLeft = 0;
    protected int $width = 1920;
    protected int $height = 1080;

    public static function fromImage(string $src): self
    {
        $instance = new self;
        $instance->img = \Intervention\Image\Facades\Image::make($src);

        return $instance;
    }

    public static function fromBgColor(string $color): self
    {
        $instance = new self;
        $instance->img = \Intervention\Image\Facades\Image::canvas($instance->width, $instance->height);
        $instance->img->fill($color);

        return $instance;
    }

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function wrap(int $characterCount = 20): self
    {
        $this->wrap = $characterCount;

        return $this;
    }

    public function font(string $fontPath): self
    {
        $this->font = $fontPath;

        return $this;
    }


    public function fontSize(int $fontSize = 38): self
    {
        $this->fontSize = $fontSize;

        return $this;
    }

    public function textColor(string $color = "#FFFFFF"): self
    {
        $this->textColor = $color;

        return $this;
    }

    public function textPos(int $left, int $top): self
    {
        $this->textLeft = $left;
        $this->textTop = $top;

        return $this;
    }

    public function size(int $width, int $height): self
    {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }


    public function save(string $path)
    {
        $this->build();

        $this->img->save($path);
    }

    public function build()
    {
        if(blank($this->font)) {
            return;
        }

        $text = $this->wrap > 0 ? $this->wrapText() : $this->text;

        $this->img->resize($this->width, $this->height);

        $this->img->text($text, $this->textLeft, $this->textTop, function ($font) {
            $font->file($this->font);
            $font->color($this->textColor);
            $font->size($this->fontSize);
        });
    }

    public function encode(string $format = null, int $quality = 90): string
    {
        $this->build();

        return $this->img->encode($format, $quality)->encoded;
    }

    private function wrapText()
    {
        $parts = explode(" ", $this->text);
        $result = "";
        $lineLength = 0;

        foreach ($parts as $part) {
            $lineLength += strlen($part) + 1;

            if ($lineLength < $this->wrap) {
                $result .= $part . ' ';
            } else {
                $result .= "\n$part ";
                $lineLength = 0;
            }
        }

        return $result;
    }


    public static function fromSettings(Settings $settings)
    {
        $settings = Settings::load();

        if ($settings->get('background_option') === 'image') {
            $bgImage = $settings->get('bg_image');
            $instance = self::fromImage("assets/{$bgImage}");
        } else {
            $instance = self::fromBgColor($settings->get('bg_color', '#000000'));
        }

        if($settings->get('font', false)) {
            $font = 'assets/' . $settings->get('font');
        }
        else {
            $font = '';
        }

        return $instance->size($settings->get('width', 1920), $settings->get('height', 1080))
            ->fontSize($settings->get('font_size', 150))
            ->textPos($settings->get('left', 150), $settings->get('top', 75))
            ->textColor($settings->get('text_color', '#FFFFFF'))
            ->wrap($settings->get('wrap', 20))
            ->font($font);
    }
}
