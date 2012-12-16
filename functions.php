<?php
/*
 * Copyright (c) Kim Blomqvist
 * All rights reserved.
 *
 * GPL license
 */

// ---------------------------------------------------------------------
// Twig
// ---------------------------------------------------------------------
class WordpressTwigProxy {
        public function __call($name, $arguments) {
                if (function_exists($name))
                        return call_user_func_array($name, $arguments);
        }
}

require_once 'Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$twig_loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($twig_loader, array());
$twig->addGlobal('wp', new WordpressTwigProxy());
$twig->addGlobal('basepath', get_bloginfo('stylesheet_directory'));



// ---------------------------------------------------------------------
// Menus
// ---------------------------------------------------------------------
function register_my_menus() {
	register_nav_menus(
		array('mainmenu' => 'Päävalikko')
	);
}

add_action('init', 'register_my_menus');



// ---------------------------------------------------------------------
// Filters
// ---------------------------------------------------------------------
add_filter('pre_site_transient_update_core', function () { return null; });
//remove_filter('the_content', 'wpautop'); /* Disables auto p-tags */



// ---------------------------------------------------------------------
// Shortcodes
// ---------------------------------------------------------------------
function placeholder($attrs, $content) {
	extract(shortcode_atts(array('id' => '', 'place' => 'inner'), $attrs));
	$content = str_replace("\r\n", '', $content);
	$script = "<script>jQuery(function(){";
	if ($place == 'append') {
		$script .= "\$('#$id').append('$content');";
	} elseif ($place == 'prepend') {
		$script .= "\$('#$id').prepend('$content');";
	} else {
		$script .= "\$('#$id').html('$content');";
	}
	return $script . "});</script>";
}

add_shortcode('placeholder', 'placeholder');



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
