<?php
/*
Plugin Name: Piwigo Notification Bar
Version: 0.0.5
Description: Enables a notification bar to appear based on specifications you provide
Plugin URI:
Author: cccraig
*/

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');


// +-----------------------------------------------------------------------+
// | Define plugin constants                                               |
// +-----------------------------------------------------------------------+
define('PIWIBAR_ID',      basename(dirname(__FILE__)));
define('PIWIBAR_PATH' ,   PHPWG_PLUGINS_PATH . PIWIBAR_ID . '/');
define('PIWIBAR_ADMIN',   get_root_url() . 'admin.php?page=plugin-' . PIWIBAR_ID);
define('PIWIBAR_VERSION', '0.0.5');



// +-----------------------------------------------------------------------+
// | Event handlers                                                        |
// +-----------------------------------------------------------------------+
// add_event_handler('loc_end_page_tail', 'insert_piwibar');
add_event_handler('get_admin_plugin_menu_links', 'piwibar_admin_menu');
add_event_handler('init', 'piwibar_lang_init');
add_event_handler('init', 'piwibar_cookie_monster');
add_event_handler('loc_begin_page_header', 'insert_piwibar', 40, 2);



// +-----------------------------------------------------------------------+
// | functions                                                             |
// +-----------------------------------------------------------------------+


/*
 * Loads translations
 */
function piwibar_lang_init(){
	load_language('plugin.lang', PIWIBAR_PATH);
}


/*
 * Checks and sets cookies for notification
 */
function piwibar_cookie_monster(){
	$data = unserialize(conf_get_param(PIWIBAR_ID));
	$cookie_name1 = 'piwibar_notification_bar_msg';
	$cookie_name2 = 'piwibar_notification_bar_url';
	$cookie1 = $data['msg'];
	$cookie2 = $data['url_link'];
	$flag = 1;

	// If the cookie is not set we need to set it
	if(!isset($_COOKIE[$cookie_name1]) || !isset($_COOKIE[$cookie_name2])) {

		// Set it for thirty days
		setcookie($cookie_name1, $cookie1, time() + (86400 * 30), "/");
		setcookie($cookie_name2, $cookie2, time() + (86400 * 30), "/");

	// If it is set we should check if a new notice should be shown
	} else {
		$old_cookie1 = $_COOKIE[$cookie_name1];
		$old_cookie2 = $_COOKIE[$cookie_name2];

		if($old_cookie1 == $data['msg'] && $old_cookie2 == $data['url_link']) {
			$flag = 0;
		}

		// If the notice hasn't changed only the expiration is updated.
		// If it has changed, it's all updated.
		setcookie($cookie_name1, $cookie1, time() + (86400 * 30), "/");
		setcookie($cookie_name2, $cookie2, time() + (86400 * 30), "/");
	}

	define('PIWIBAR_COOKIE', $flag);
}


/*
 * Initializes the admin menu
 */
function piwibar_admin_menu( $menu ) {
	array_push(
		$menu,
		array(
			'NAME'  => 'PiwiBar',
			'URL'   => get_admin_plugin_menu_link(dirname(__FILE__)).'/admin.php'
		)
	);

	return $menu;
}



/*
 * Catch the page end and insert our footer template
 */
function insert_piwibar( ) {

	if(script_basename() != 'admin' && PIWIBAR_COOKIE == 1) {

			global $template, $page;
			$path = 'plugins/PiwiBar/css/default.css';

			/*
			 * Specify the header template file path
			 */
			$template -> func_combine_css(
				array(
					'id' => 'PIWIBAR',
					'path' => $path
				));

			/*
			 * Retrieve footer configuration variable
			 */
			$data = unserialize(conf_get_param(PIWIBAR_ID));

			/*
			 * Assign these to the template
			 */
			$template -> assign($data);

			/*
			 * Assign file path to template
			 */
			$template -> assign('PIWIBAR_STYLE', realpath(PIWIBAR_PATH));

			/*
			 * Specify the footer template file
			 */
			$template -> set_filename('PIWIBAR', realpath(PIWIBAR_PATH . 'bar.tpl'));

			/*
			 * Parse template file and append to main template
			 */
			$template -> append('bar_elements', $template -> parse('PIWIBAR', false));
		}
}
?>
