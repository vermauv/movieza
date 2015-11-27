<?php

/**
 * Load the template engine.
 * @return object Return engine object or FALSE if library not found.
 */
function zm_template_engine_load($stringLoader = FALSE){
  static $loaded = FALSE;
  if($loaded) return $loaded;

  $registered = false;
  if(class_exists('Twig_Environment')){
    $registered = true;
  }elseif($libpath = libraries_get_path("twig")){
    require "$libpath/lib/Twig/Autoloader.php";
    Twig_Autoloader::register();
    $registered = true;
  }else{
    drupal_set_message(t("Twig library not found, please download Twig libraries and place at folder'sites\all\libraries'"), 'warning');
  }

  if($registered){
    if($stringLoader){
     $loader = new Twig_Loader_String();
    }else{
      $loader = new Twig_Loader_Filesystem(zm_template_twig_path());
    }

    $twig   = new Twig_Environment($loader, array(
      'cache' => zm_template_twig_cachepath(),
    ));
    $functions = module_invoke_all('zm_template_functions');
    foreach ($functions as $key => $function) {
      $twig->addFunction($function);
    }
    $twig->addFunction('fn__*', new Twig_Function_Function('zm__fn'));
    $twig->addFunction('proc__*', new Twig_Function_Function('zm__fn_proc'));

    $loaded = $twig;
  }

  return $loaded;
}

/**
 * Call function from template.
 * @return array
 */
function zm__fn(){
  $args = func_get_args();
  $fn = array_shift($args);

  if(function_exists($fn)){
    return call_user_func_array($fn, $args);
  }else{
    return FALSE;
  }
}

function zm__fn_proc(){
  $args = func_get_args();
  $fn = array_shift($args);

  if(function_exists($fn)){
    call_user_func_array($fn, $args);
  }
  return '';
}
/**
 * Validate template code.
 * @param  string $template_code The template.
 * @return boolean               Validate result.
 */
function zm_template_engine_validate_template($template_code){
  if($engine = zm_template_engine_load(TRUE)){
    try {
        $engine->parse($engine->tokenize($template_code));
        return TRUE;
    } catch (Twig_Error_Syntax $e) {
        drupal_set_message($e->getRawMessage(), 'warning');
        return FALSE;
    }
  }

  return FALSE;
}

/**
 * Prepare compiled code for template.
 * @param  string $template_object Template object.
 * @return string         Prepared code.
 */
function zm_template_engine_render_template($template_object, $data = array()){
  $rendered = '';
  if($engine = zm_template_engine_load()){
    $template_twig = $template_object->name . ".twig";
    $template_file = zm_template_twig_path($template_object->name);

    if(!file_exists($template_file)){
      $template_object->changed = time();
      // Save template to file.
      zm_template_save_template($template_object->html, $template_object->name);
      // Update changed time.
      ctools_export_crud_save('zm_template', $template_object);
      // Clear cache files
      $engine->clearCacheFiles();
    }

    if($template_object->changed < fileatime($template_file)){
      // Save back to database.
      $template_object->changed = time();
      $template_object->html = file_get_contents($template_file);

      ctools_export_crud_save('zm_template', $template_object);

      $engine->clearCacheFiles();
    }

    $rendered = $engine->render($template_twig, $data);
  }
  return $rendered;
}
