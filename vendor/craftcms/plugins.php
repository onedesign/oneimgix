<?php

$vendorDir = dirname(__DIR__);
$rootDir = dirname(dirname(__DIR__));

return array (
  'onedesign/oneimgix' => 
  array (
    'class' => 'onedesign\\oneimgix\\OneImgix',
    'basePath' => '/Users/brianhanson/Development/oneimgix/src',
    'handle' => 'one-imgix',
    'aliases' => 
    array (
      '@onedesign/oneimgix' => $rootDir . '/src',
    ),
    'name' => 'One Imgix',
    'version' => '2.0-beta.5',
    'description' => 'Tools for working with Imgix in Craft',
    'developer' => 'One Design Company',
    'developerUrl' => 'https://onedesigncompany.com/',
    'documentationUrl' => 'https://github.com/onedesign/oneimgix/blob/master/README.md',
    'changelogUrl' => 'https://raw.githubusercontent.com/onedesign/oneimgix/master/CHANGELOG.md',
    'hasCpSettings' => true,
    'hasCpSection' => false,
  ),
);
