<?php
/*
 * Imba theme for WordPress
 * Copyright (c) Kim Blomqvist
 * All rights reserved.
 *
 * GPL license
 */

$mainmenu = wp_nav_menu(array(
    'theme_location' => 'mainmenu',
    'container' => false,
    'container_class' => '',
    'container_id' => '',
    'menu_class' => '',
    'menu_id' => 'main-menu',
    'items_wrap' => '<ul class="nav nav-pills pull-right">%3$s</ul>',
    'echo' => false
));
