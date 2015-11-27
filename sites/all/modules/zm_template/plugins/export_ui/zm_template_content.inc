<?php

/**
 * @file
 *  UI configuration for ckeditor_styles_config exportable objects.
 */

$plugin = array(
  'schema' => 'zm_template',
  'access' => 'administer site configuration',

  'menu' => array(
    'menu prefix' => 'admin/config/content',
    'menu item' => 'zm_template',
    'menu title' => 'ZM Template',
    'menu description' => 'Simple template for website like widget, slideshow...',
  ),

  'title singular' => t('ZM template'),
  'title singular proper' => t('ZM templates'),
  'title plural' => t('ZM templates'),
  'title plural proper' => t('ZM templates'),

  'handler' => 'ZMTemplateUI',
);
