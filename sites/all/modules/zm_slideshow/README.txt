ZM Slideshow

Description
--------------------------
A Bean slideshow plugin used with ZM Template help you can quick and easy create slideshow with many jQuery plugin like FlexSlider, Cycle2, Caroufredsel...

Requirements
--------------------------
zm_template
bean
link
field_collection

Installation
--------------------------
1. Copy the entire zm_slideshow directory the Drupal sites/all/modules
directory.
2. Login as an administrator. Enable the module on the Modules page.

Usage
--------------------------
You need define template to display with slideshow, go to
admin/config/content/zm_template add you custom template.
Variables you can using in template is:
{% for item in data %}
  {{item.image}}
  {{item.image_1}}
  {{item.image_2}}
  {{item.title}}
  {{item.description}}
{% endfor %}

{{data}}: array store information of image, title, and description.
{{image}}: image path of each slide.
{{image_1}}: image path styled with image style select by "Image Style 1"
{{image_2}}: image path styled with image style select by "Image Style 2"
{{title}}: title of each slide.
{{description}}: description of each slide.

Example html template used with FlexSlider:
<div class="flexslider">
  <ul class="slides">
    {% for item in data %}
    <li>
      <img src="{{item.image}}" />
    </li>
    {% endfor %}
  </ul>
</div>

You can read more about Twig syntax here:
http://twig.sensiolabs.org/doc/templates.html

Create a block slideshow at "block/add/zm-slideshow", chose your template and
see how it work.
