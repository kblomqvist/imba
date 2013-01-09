<?php
/*
 * Imba theme for WordPress
 * Copyright (c) Kim Blomqvist
 * All rights reserved.
 *
 * GPL license
 */

include 'header.php';
echo $twig->render('404.html', array('mainmenu' => $mainmenu));
