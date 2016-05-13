<?php
/*
Plugin Name: ATL Simple Facebook Publish
Description: MODIFIED - DO NOT UPDATE : Most simple implementation of automated facebook posts.
Author: Markus Kottländer
Version: 0.3
Text Domain: simple-facebook-publish
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

session_start();

use SimpleFacebookPublish\SimpleFacebookPublish;

// only run in admin section
if (is_admin()) {
    require_once __DIR__ . '/facebook-php-sdk-v4-4.0-dev/autoload.php';
    require_once __DIR__ . '/SimpleFacebookPublish.php';
    require_once __DIR__ . '/MetaBox.php';
    require_once __DIR__ . '/Settings.php';

    $simpleFacebookPublish = new SimpleFacebookPublish();
}


// MOD - Stop plugin from updating

add_filter('site_transient_update_plugins', 'dd_remove_update_nag');
function dd_remove_update_nag($value) {
 unset($value->response[ plugin_basename(__FILE__) ]);
 return $value;
}