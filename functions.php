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

class TwigJqueryContainer {
	public $js = '';
	public function __toString() {
		return $this->js;
	}
}

$twigFilterMarkdown = new Twig_SimpleFilter('markdown', function($string) {
	require_once 'php-markdown/markdown.php';
	$string = do_shortcode($string);
	return Markdown($string);
});

$twig->addGlobal('wp', new WordpressTwigProxy());

$twigJqueryContainer = new TwigJqueryContainer();
$twig->addGlobal('jquery', &$twigJqueryContainer);

$twig->addGlobal('basepath', get_bloginfo('stylesheet_directory'));

$twig->addFilter($twigFilterMarkdown);


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
function edit($attrs, $content) {
	global $twigJqueryContainer;
	extract(shortcode_atts(array('id' => '', 'place' => 'inner'), $attrs));
	$content = str_replace("\r\n", '', $content);
	if ($place == 'append') {
		$twigJqueryContainer->js .= "\$('#$id').append('$content');\n";
	} elseif ($place == 'prepend') {
		$twigJqueryContainer->js .= "\$('#$id').prepend('$content');\n";
	} else {
		$twigJqueryContainer->js .= "\$('#$id').html('$content');\n";
	}
}

add_shortcode('edit', 'edit');



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
