<?php

namespace State\OgGenerator;

use Illuminate\Support\Collection;
use Statamic\Facades\Blueprint;
use Statamic\Facades\File;
use Statamic\Facades\YAML;

class Settings extends Collection
{

    public function __construct($items = null)
    {
        if (!is_null($items)) {
            $items = collect($items)->all();
        }

        $this->items = $items ?? $this->getDefaults();
    }

    public static function load($items = null)
    {
        return new static($items);
    }

    public function augmented()
    {
        $defaultValues = static::blueprint()
            ->fields()
            ->addValues($this->items)
            ->augment()
            ->values();

        return $defaultValues
            ->only(array_keys($this->items))
            ->all();
    }

    public function save()
    {
        File::put($this->path(), YAML::dump($this->items));
    }

    protected function getDefaults()
    {
        return collect(YAML::file($this->path())->parse())
            ->all();
    }

    protected function path()
    {
        return base_path('content/og-generator.yaml');
    }

    public static function blueprint()
    {
        return Blueprint::make()->setContents([
            'sections' => [
                'main' => [
                    'fields' => [
                        [
                            'handle' => 'Image Generation Settings',
                            'field' => [
                                'type' => 'section',
                                'icon' => 'section',
                                'instructions' => '',
                                'listable' => 'visible',
                                'instructions_position' => 'above',
                                'visibility' => 'visible',
                            ]
                        ],
                        [
                            'handle' => 'background_option',
                            'field' => [
                                'type' => 'radio',
                                'display' => 'Background option',
                                'options' => [
                                    'image' => 'Image',
                                    'color' => 'Color',
                                ],
                            ]
                        ],
                        [
                            'handle' => 'bg_image',
                            'field' => [
                                'type' => 'assets',
                                'display' => 'Background Image',
                                'container' => 'assets',
                                'restrict' => true,
                                'max_files' => 1,
                                'mode' => 'grid',
                                'allow_uploads' => true,
                                'width' => 50,
                                'if' => ['background_option' => 'equals image']
                            ]
                        ],
                        [
                            'handle' => 'bg_color',
                            'field' => [
                                'type' => 'color',
                                'display' => 'Background Color',
                                'listable' => 'visible',
                                'instructions_position' => 'above',
                                'visibility' => 'visible',
                                'validate' => 'required',
                                'width' => 50,
                                'if' => ['background_option' => 'equals color']
                            ]
                        ],
                        [
                            'handle' => 'font',
                            'field' => [
                                'type' => 'assets',
                                'display' => 'Font',
                                'container' => 'assets',
                                'restrict' => false,
                                'max_files' => 1,
                                'mode' => 'grid',
                                'allow_uploads' => true,
                                'width' => 50,
                            ]
                        ],
                        [
                            'handle' => 'font_size',
                            'field' => [
                                'type' => 'text',
                                'display' => 'Font Size',
                                'input_type' => 'number',
                                'antlers' => 'false',
                                'listable' => 'visible',
                                'instructions_position' => 'above',
                                'visibility' => 'visible',
                                'validate' => 'required',
                                'width' => 50,
                            ]
                        ],
                        [
                            'handle' => 'text_color',
                            'field' => [
                                'type' => 'color',
                                'display' => 'Text Color',
                                'listable' => 'visible',
                                'instructions_position' => 'above',
                                'visibility' => 'visible',
                                'validate' => 'required',
                                'width' => 50,
                            ]
                        ],
                        [
                            'handle' => 'width',
                            'field' => [
                                'type' => 'text',
                                'display' => 'Width',
                                'input_type' => 'number',
                                'antlers' => 'false',
                                'listable' => 'visible',
                                'instructions_position' => 'above',
                                'visibility' => 'visible',
                                'validate' => 'required',
                                'width' => 50,
                            ]
                        ],
                        [
                            'handle' => 'height',
                            'field' => [
                                'type' => 'text',
                                'display' => 'Height',
                                'input_type' => 'number',
                                'antlers' => 'false',
                                'listable' => 'visible',
                                'instructions_position' => 'above',
                                'visibility' => 'visible',
                                'validate' => 'required',
                                'width' => 50,
                            ]
                        ],
                        [
                            'handle' => 'top',
                            'field' => [
                                'type' => 'text',
                                'display' => 'Top',
                                'input_type' => 'number',
                                'antlers' => 'false',
                                'listable' => 'visible',
                                'instructions_position' => 'above',
                                'visibility' => 'visible',
                                'validate' => 'required',
                                'width' => 50,
                            ]
                        ],
                        [
                            'handle' => 'left',
                            'field' => [
                                'type' => 'text',
                                'display' => 'Left',
                                'input_type' => 'number',
                                'antlers' => 'false',
                                'listable' => 'visible',
                                'instructions_position' => 'above',
                                'visibility' => 'visible',
                                'validate' => 'required',
                                'width' => 50,
                            ]
                        ],
                        [
                            'handle' => 'wrap',
                            'field' => [
                                'type' => 'text',
                                'display' => 'Wrap at',
                                'input_type' => 'number',
                                'antlers' => 'false',
                                'listable' => 'visible',
                                'instructions_position' => 'above',
                                'instructions' => 'the number of characters before text wraps',
                                'visibility' => 'visible',
                                'validate' => 'required',
                                'width' => 50,
                            ]
                        ],
                        [
                            'handle' => 'collections',
                            'field' => [
                                'type' => 'collections',
                                'display' => 'Collections',
                                'instructions' => 'the collections that image generation is enabled',
                            ],
                        ]
                    ],
                ],
            ],
        ]);
    }
}
