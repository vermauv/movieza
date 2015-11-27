<?php

class ZMTemplateUI extends ctools_export_ui {

	function edit_form(&$form, &$form_state) {
		parent::edit_form($form, $form_state);
		$item = $form_state['item'];
	  $form['html'] = array(
	    '#type' => 'textarea',
	    '#title' => t('HTML Code'),
	    '#default_value' => $item->html,
	    '#required' => TRUE,
	    '#description' => t('Html code template.'),
	    "#rows" => 20,
	  );

	  $form['css'] = array(
	    '#type' => 'textarea',
	    '#title' => t('Inline CSS'),
	    '#default_value' => $item->css,
	    '#required' => FALSE,
	    '#description' => t('CSS code for template.'),
	    "#rows" => 20,
	  );

	  $form['ext_js'] = array(
	    '#type' => 'textarea',
	    '#title' => t('External JS'),
	    '#default_value' => $item->ext_js,
	    '#required' => FALSE,
	    '#description' => t('Add external Javascript files to template, each css link per line.'),
	    "#rows" => 5,
	  );

	  $form['ext_css'] = array(
	    '#type' => 'textarea',
	    '#title' => t('External CSS'),
	    '#default_value' => $item->ext_css,
	    '#required' => FALSE,
	    '#description' => t('Add external CSS files to template, each css link per line.'),
	    "#rows" => 5,
	  );
	}
  /**
   * Validate callback for the edit form.
   */
  function edit_form_validate(&$form, &$form_state) {
  	parent::edit_form_validate($form, $form_state);
  	if(!empty($form_state['values']['html'])){
  		if($validate = zm_template_engine_validate_template($form_state['values']['html'])){
  			$current_item = $this->load_item($form_state['item']->name);
  			if($current_item && $engine = zm_template_engine_load()){
  				$filename = $engine->getCacheFilename($current_item->name);
  				$engine->clearCacheFiles();
  			}
  		}else{
  			form_set_error('html', 'HTML template code error, please check again!!!');
  		}
  	}
  }

  function edit_form_submit(&$form, &$form_state) {
    $form_state["values"]['changed'] = time();
    parent::edit_form_submit($form, $form_state);
    $template_code = $form_state["values"]['html'];
    $item = $form_state['item'];
    zm_template_save_template($template_code, $item->name);
  }
}
