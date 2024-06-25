<?php
namespace State\OgGenerator;

use Statamic\Entries\Entry;
use Statamic\Events\EntrySaving;
use State\OgGenerator\Image;
use State\OgGenerator\Settings;

class EntrySavingListener
{

    public function handle(EntrySaving $event)
    {
        /** @var Entry */
        $entry = $event->entry;
        $filename = "{$entry->slug()}.jpg";
        $settings = Settings::load();

        if(in_array( $entry->collectionHandle(), $settings->get('collections', []))) {
            Image::fromSettings($settings)
                ->text($entry->get('title'))
                ->save("assets/$filename");

            $entry->set('og_generator_image', $filename);
        }
    }

}
