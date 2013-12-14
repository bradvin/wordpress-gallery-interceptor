<?php
/**
 * Gallery Interceptor
 *
 * Intercept all the new gallery filters to customize the generated gallery markup
 *
 * @package   Gallery_Interceptor
 * @author    Brad Vincent <bradvin@gmail.com>
 * @license   GPL-2.0+
 * @link      https://github.com/fooplugins/gallery-interceptor
 * @copyright 2013 Brad Vincent
 *
 * @wordpress-plugin
 * Plugin Name:       Gallery Interceptor
 * Plugin URI:        https://github.com/fooplugins/gallery-interceptor
 * Description:       Intercept all the new gallery filters to customize the generated gallery markup
 * Version:           1.0.0
 * Author:            Brad Vincent
 * Author URI:        http://fooplugins.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/fooplugins/gallery-interceptor
 */

function gallery_intercept_class($class, $selector, $attr) {
	if ( is_page() ) {
		return $class . ' page-gallery';
	}
	return $class;
}
add_filter('gallery_class', 'gallery_intercept_class', 10, 3);

function gallery_intercept_container_start($html, $selector, $gallery_class, $attr) {
	return "<ul id='$selector' data-class='$gallery_class'>";
}
add_filter('gallery_container_start', 'gallery_intercept_container_start', 10, 4);

function gallery_intercept_container_end($html, $selector, $attr) {
	return "</ul> <!-- $selector gallery -->";
}
add_filter('gallery_container_end', 'gallery_intercept_container_end', 10, 3);

function gallery_intercept_separator($html, $selector, $attr) {
	return "<!-- no separator please -->";
}
add_filter('gallery_column_separator', 'gallery_intercept_separator', 10, 3);