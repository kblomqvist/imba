<?php
/*
 * Copyright (c) Kim Blomqvist
 * All rights reserved.
 *
 * GPL license
 */

global $twig;
echo $twig->render('blog_posts.html', array('posts' => $posts));
