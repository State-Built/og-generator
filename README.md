Automatically generate images based on the title of your entries, customize backgrounds and fonts via the cp!

## How to Install

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or run the following command from your project root:

BASH

```bash
composer require state/og-generator
```

## Configuration

You can configure via the cp by clicking "OG Generator" in the sidebar, and customize the form.

### Options

#### Background

You can customize the background by choosing either background image or color, then choose an image or pick a color.

#### Font

You can upload your own ttf files, you can download ttf files from google fonts. Then you can set your font size and color.

Top and left will offset and place the text based on the values.

#### Size

To set the size of the image set the width and height. I recommend creating a higher resolution image initially, because the text can be fuzzy at a lower resolution.

#### Text wrapping

To wrap text at a certain point set the wrap at value, it is the number of characters until wrap, not pixels.

#### Collections

The last option to configure is to pick which collections the og generator will run on when saved.

## Usage

If you configured the addon to generate on save for collections you can access the og_generator_image field on your entry as a normal asset field.

HTML

```html
{{ if og_generator_image }}
    <meta property="og:image" content="{{ og_generator_image:permalink }}" />
{{ else }}
    {{ asset url="/assets/ogimage-default.jpg" }}
        <meta property="og:image" content="{{ permalink }}" />
    {{ /asset }}
{{ /if }}
```

Otherwise, you could use the built-in tags, these will generate new images if they don't exist and work on every collection.

HTML

```html
{{ og_generator:og_image }}
<!-- outputs -->
<meta property="og:image" content="https://example.com/assets/post-slug.png" />

{{ og_generator:image class="rounded" }}
<!-- outputs -->
<img src="https://example.com/assets/post-slug.png" alt="Post Title" class="rounded" />
```


