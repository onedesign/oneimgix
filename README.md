# Imgix plugin for Craft CMS

Tools for working with Imgix in Craft

## Installation

1. Download & unzip the file and place the `oneimgix` directory into your `craft/plugins` directory
2. -OR- install with Composer via `composer require onedesign/oneimgix`
3. Install plugin in the Craft Control Panel under Settings > Plugins
4. The plugin folder should be named `oneimgix` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.
5. Update the settings for the plugin as explained below.

## Use

### Configuration:

OneImgix expects the following settings to be configured:

- **Imgix API Key:** Your Imgix API key, obtained from the Imgix control panel.
- **Imgix Source Name:** The name of your source defined in the Imgix control panel.
- **Asset Base URL:** The base path to your original assets, which will be replaced with the Imgix base URL by this plugin. This will typically be something like `http://mysite.com/assets/` or `https://s3.amazonaws.com/my-bucket-name/`

### Generating Image URLs in Twig:

```twig
{% set url = craft.oneImgix.url(myAssetField.first, {
    w: 1000,
    h: 800,
    q: 50,
    auto: 'format',
    fit: 'max'
}) %}
```

Any options supported by the Imgix image API can be passed into these options. OneImgix will do the work of transforming the original asset URL into the appropriate Imgix URL based on your plugin settings.

### Clearing Imgix Caches:

Whenever an asset in Craft is replaced or deleted, OneImgix will attempt to automatically clear the corresponding Imgix cache for that asset.