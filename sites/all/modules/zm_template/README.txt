ZM Template

Description
--------------------------
Simple template api support Twig syntax. You should install this module
with ZM Slideshow to see how it work.

Requirements
--------------------------
ctools
libraries
Twig

Installation
--------------------------
1. Copy the entire zm_template directory the Drupal sites/all/modules
directory.
2. Download the Twig library from the Twig home page. Unpack the library into
the sites/all/libraries/twig directory so the AutoLoader.php is in the page
sites/all/libraries/twig/lib/Twig/AutoLoader.php
3. Login as an administrator. Enable the module on the Modules page.
4. Go to admin/config/content/zm_template add/edit your template.

Other
--------------------------
ZM Template come with zm_template_field module help you can chose template for
any field.
ZM Template support you debug variables in template with Devel module.
In template you can call {{ dpm(data) }} to debug data variable.

Options
--------------------------
This module support syntax highlight with codemirror, download codemirror
and extract to sites/all/libraries
