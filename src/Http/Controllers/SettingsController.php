<?php

namespace State\OgGenerator\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;
use Statamic\Support\Arr;
use State\OgGenerator\Image;
use State\OgGenerator\Settings;

class SettingsController extends CpController
{

    public function edit()
    {
        $blueprint = Settings::blueprint();
        $settings = Settings::load();

        $fields = $blueprint
            ->fields()
            ->addValues($settings->all())
            ->preProcess();

        $preview = Image::fromSettings($settings)->text('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        return view('og-generator::settings', [
            'title' => 'Config',
            'action' => cp_route('og-generator.update'),
            'blueprint' => $blueprint->toPublishArray(),
            'meta' => $fields->meta(),
            'values' => $fields->values(),
            'preview' => $preview->encode('data-url')
        ]);
    }

    public function update(Request $request)
    {
        $blueprint = Settings::blueprint();

        $fields = $blueprint->fields()->addValues($request->all());

        $fields->validate();

        $values = Arr::removeNullValues($fields->process()->values()->all());

        Settings::load($values)->save();
    }

    public function preview()
    {
        $settings = Settings::load();
        $preview = Image::fromSettings($settings)->text('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        return [
            'preview' => $preview->encode('data-url'),
        ];
    }

}
