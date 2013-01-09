<?php
/*
 * Imba theme for WordPress
 * Copyright (c) Kim Blomqvist
 * All rights reserved.
 *
 * GPL license
 */

include 'header.php';
echo $twig->render('blog_posts.html', array('posts' => $posts, 'mainmenu' => $mainmenu));
