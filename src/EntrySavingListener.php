<?php
namespace State\OgWally;

use Statamic\Entries\Entry;
use Statamic\Events\EntrySaving;
use State\OgWally\Image;
use State\OgWally\Settings;

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

            $entry->set('og_wally_image', $filename);
        }
    }

}
