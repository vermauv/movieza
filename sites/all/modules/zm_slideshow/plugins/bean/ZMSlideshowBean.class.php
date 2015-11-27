<?php
/**
 * @file
 *   A bean slideshow plugin.
 */

class ZMSlideshowBean extends BeanPlugin {
  /**
   * Implements BeanPlugin::values().
   */
  public function values() {
    return array(
      'template' => '',
      'image_style_1' => 'thumbnail',
      'image_style_2' => 'large',
    );
  }

  /**
   * Implements BeanPlugin::form().
   */
  public function form($bean, $form, &$form_state) {
    $form = array();
 // Show select box for the option set
  $optionsets = array();
  ctools_include('export');
  foreach (zm_template_load_all() as $name => $optionset) {
    $optionsets[$name] = check_plain($optionset->title);
  }
  $template_empty_des = '';
  if(empty($optionsets)){
    $template_empty_des = t(' You don\'t have any template, please <a href="@href">click here</a> to create one.', array(
      '@href' => url('admin/config/content/zm_template/add')
    ));
  }

  $form['template'] = array(
    '#title' => t('Template'),
    '#type' => 'select',
    '#options' => $optionsets,
    '#default_value' => $bean->template,
    '#description' => t("Chose template apply for slideshow.") . $template_empty_des,
  );

  $image_styles = image_styles();
  $image_style_options = array();
  foreach ($image_styles as $stylename => $style) {
    $image_style_options[$stylename] = $style['label'];
  }

  $form['image_style_1'] = array(
    '#type' => 'select',
    '#title' => t('Image Style 1'),
    '#options' => $image_style_options,
    '#default_value' => $bean->image_style_1,
    '#description' => t("Chose image style 1 apply for image field"),
  );

  $form['image_style_2'] = array(
    '#type' => 'select',
    '#title' => t('Image Style 2'),
    '#options' => $image_style_options,
    '#default_value' => $bean->image_style_2,
    '#description' => t("Chose image style 2 apply for image field"),
  );

    return $form;
  }

  /**
   * Implements BeanPlugin::view().
   */
  public function view($bean, $content, $view_mode = 'full', $langcode = NULL) {
    return $content;
  }
}
