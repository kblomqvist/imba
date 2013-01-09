<?php
/*
 * Imba theme for WordPress
 * Copyright (c) Kim Blomqvist
 * All rights reserved.
 *
 * GPL license
 */

include 'header.php';
echo $twig->render('page.html', array('post' => $posts[0], 'mainmenu' => $mainmenu));
