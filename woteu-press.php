<?php

/**
Plugin Name: WOTEU Press
Plugin URI:  http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Displays account data from Wargaming.net. Now is statistic from your profile in World of Tanks game available.
Version: 0.2
Author: lafhq
Author URI: http://www.lafhq.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: woteu-press
*/
$GLOBALS['app_id'] = '91e2384531272e6f052b86a9f02357e0';
$GLOBALS['text_domain'] = 'woteu-press';

// add functions
require_once 'inc/woteu-press-func.php';

// add widget
require_once 'inc/woteu-press-widget.php';

// include the settings page
require_once 'inc/woteu-press-settings.php';

// include de shortcode
require_once 'inc/woteu-press-shortcode.php';

?>
