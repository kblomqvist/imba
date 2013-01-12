<?php
/*
 * Imba theme for WordPress
 * Copyright (c) Kim Blomqvist
 * All rights reserved.
 *
 * GPL license
 */

// ---------------------------------------------------------------------
// Twig
// ---------------------------------------------------------------------
require_once 'Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$twigLoader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($twigLoader, array());

class WordpressTwigProxy {
        public function __call($name, $arguments) {
                if (function_exists($name))
                        return call_user_func_array($name, $arguments);
        }
}

$twig->addGlobal('wp', new WordpressTwigProxy());

$twig->addFilter(new Twig_SimpleFilter('markdown', function($string) {
	require_once 'php-markdown/markdown.php';
	$string = do_shortcode($string);
	return Markdown($string);
}));

$jquery = '';
$twig->addGlobal('jquery', $jquery);

$twig->addGlobal('basepath', get_bloginfo('stylesheet_directory'));


// ---------------------------------------------------------------------
// Menus
// ---------------------------------------------------------------------
function my_register_menus() {
	register_nav_menus(
		array('mainmenu' => 'Päävalikko')
	);
}

add_action('init', 'my_register_menus');

function my_get_nav_menu_items($menu_name, $post_id) {
	$menu_items = array();
	$locations = get_nav_menu_locations();

	if (!isset($locations[$menu_name])) {
		return $menu_items;
	}

	$menu = wp_get_nav_menu_object($locations[$menu_name]);
	$menu_items2 = wp_get_nav_menu_items($menu->term_id);

	foreach ($menu_items2 as $menu_item) {
		if ($menu_item->menu_item_parent == 0) {
			$menu_items[$menu_item->ID] = array(
				'title' => $menu_item->title,
				'url' => $menu_item->url
			);
                	if ($menu_item->object_id == $post_id) {
        	                $menu_items[$menu_item->ID]['active'] = true;
	                }
		} else {
			if (array_key_exists($menu_item->menu_item_parent, $menu_items)) {
				$menu_items[$menu_item->menu_item_parent]['childs'][$menu_item->ID] = array(
					'title' => $menu_item->title,
					'url' => $menu_item->url
				);
			}
                	if ($menu_item->object_id == $post_id) {
        	                $menu_items[$menu_item->menu_item_parent]['active'] = true;
				$menu_items[$menu_item->menu_item_parent]['childs'][$menu_item->ID]['active'] = true;
	                }
		}
	}
		
	return $menu_items;
}


// ---------------------------------------------------------------------
// Filters
// ---------------------------------------------------------------------
add_filter('pre_site_transient_update_core', function () { return null; });
//remove_filter('the_content', 'wpautop'); /* Disables auto p-tags */



// ---------------------------------------------------------------------
// Shortcodes
// ---------------------------------------------------------------------
function replace($attrs, $content) {
	global $jquery;
	extract(shortcode_atts(array('id' => ''), $attrs));
	$content = str_replace("\r\n", '', $content);
	$jquery .= "\$('#$id').html('$content');\n";
}
function append($attrs, $content) {
	global $jquery;
	extract(shortcode_atts(array('id' => ''), $attrs));
	$content = str_replace("\r\n", '', $content);
	$jquery .= "\$('#$id').append('$content');\n";
}
function prepend($attrs, $content) {
	global $jquery;
	extract(shortcode_atts(array('id' => ''), $attrs));
	$content = str_replace("\r\n", '', $content);
	$jquery .= "\$('#$id').prepend('$content');\n";
}

add_shortcode('replace', 'replace');
add_shortcode('append', 'append');
add_shortcode('prepend', 'prepend');



// ---------------------------------------------------------------------
// Widgets
// ---------------------------------------------------------------------
register_sidebar(array(
	'id'            => 'right-sidebar',
	'name'          => 'Right Sidebar',
	'description'   => '',
	'before_title'  => '<h1 class="widget-title">',
	'after_title'   => '</h1>',
	'before_widget' => '<section class="widget %2$s">',
	'after_widget'  => '</section>'
));
