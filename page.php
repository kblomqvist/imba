<?php
/*
 * Imba theme for WordPress
 * Copyright (c) Kim Blomqvist
 * All rights reserved.
 *
 * GPL license
 */

global $twig;
echo $twig->render('page.html', array('post' => $posts[0]));
