wordpress-gallery-interceptor
=============================

A simple plugin utilizing the new filters I propose to be added to the gallery_shortcode function in core

==Proposed Patch==
My proposed changes to the gallery_shortcode function include the following:

===Class Shortcode Attribute===

Check for a class attribute in the gallery shortcode. The class (if exists) is appended to the gallery container element.

Example:

```
[gallery class="foobar"]
```

Results in:

```
<div id="gallery-1" class="gallery galleryid-4 gallery-columns-2 gallery-size-thumbnail foobar">
```

===gallery_class Filter===

Introduce a new filter `gallery_class` which can be used by themes or plugins to alter the gallery class. I realise that you could just use the class shortcode attribute above, but this allows for more customization. 

Parameters:

* `$class` - the current gallery class
* `$selector` - the unique id of the gallery
* `$attr` - all the gallery shortcode attributes, to allow for maximum customization

An example:

```
//add a class to the gallery depending on a template tag

function gallery_intercept_class($class, $selector, $attr) {
	if ( is_page() ) {
		return $class . ' page-gallery';
	}
	return $class;
}
add_filter('gallery_class', 'gallery_intercept_class', 10, 3);
```

===gallery_container_start Filter===

Introduce a new filter `gallery_container_start` which can be used by themes or plugins to alter the gallery container's opening HTML markup. You could change the tag or include any other markup you may want to introduce.

Paramaters:

* `$html` - the current gallery opening markup (`<div id='$selector' class='$gallery_class'>`)
* `$selector` - the unique id of the gallery
* `$gallery_class` - the current gallery class
* `$attr` - all the gallery shortcode attributes, to allow for maximum customization

An Example:

```
///change the tag to rather be a ul

function gallery_intercept_container_start($html, $selector, $gallery_class, $attr) {
	return "<ul id='$selector' data-class='$gallery_class'>";
}
add_filter('gallery_container_start', 'gallery_intercept_container_start', 10, 4);
```

===gallery_container_end Filter===

Introduce a new filter `gallery_container_end` which, as the name suggests, can be used to alter the closing markup of the gallery.

Paramters:

* `$html` - the current gallery closing markup (`<br style='clear: both;' /></div>\n`)
* `$selector` - the unique id of the gallery
* `$attr` - all the gallery shortcode attributes, to allow for maximum customization

An Example:

```
///change the closing tag to a ul

function gallery_intercept_container_end($html, $selector, $attr) {
	return "</ul> <!-- $selector gallery -->";
}
add_filter('gallery_container_end', 'gallery_intercept_container_end', 10, 3);
```

===gallery_intercept_separator Filter===

Introduce a new filter `gallery_intercept_separator` which can be used to alter the separator markup of the gallery. This filter can be used to override the <br /> tag that is inserted when the column count is met.

Paramters:

* `$html` - the current gallery closing markup (`<br style="clear: both" />`)
* `$selector` - the unique id of the gallery
* `$attr` - all the gallery shortcode attributes, to allow for maximum customization

An Example:

```
//do not output any separator

function gallery_intercept_separator($html, $selector, $attr) {
	return "<!-- no separator please -->";
}
add_filter('gallery_column_separator', 'gallery_intercept_separator', 10, 3);
```