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
	$cn = 'piwibar_notification_bar';
	$duration = (isset($data['duration'])) ? $data['duration'] : 0;
	$stop = ($duration != 0) ? (int)(86400 * $data['duration']) : 86400 * 365;
	$flag = 1;

	$info = json_encode([
		'msg' 			=> $data['msg'],
		'url_link'	=> $data['url_link'],
		'duration' 	=> $duration,
		'stop' 			=> $stop + time(),
		'start'			=> time()
	], true);

	// If the cookie is not set we need to set it.
	if(!isset($_COOKIE[$cn])) {

		setcookie($cn, $info, time() + 86400 * 365, "/");

	// If it is set we should check if a new notice should be shown
	} else {
		$old_cn = json_decode(stripslashes($_COOKIE[$cn]));
		$ct = time();

		// If the message or url have changed reset cookie
		if ($old_cn->msg != $data['msg'] || $old_cn->url_link != $data['url_link']) {

			setcookie($cn, $info, time() + 86400 * 365, "/");

		} else {

			// Has the cookie specified show time expired?
			if($old_cn->stop < $ct) {

				// Was the original intention to show it for some period of time?
				if($old_cn->duration != 0) {
					$flag = 0;
				}

			} else {

				// Was the original intention to show it once?
				if($old_cn->duration == 0) {
					$flag = 0;
				}
			}
		}
	}

	if ($data['test_mode'] == '1') {

		if (isset($_SESSION['pwg_uid'])) {
			$uid = $_SESSION['pwg_uid'];
			$query = 'SELECT status FROM '.USER_INFOS_TABLE.' WHERE user_id ='.$uid.';';
			$row = pwg_db_fetch_assoc(pwg_query($query));

			if($row['status'] == 'webmaster' || $row['status'] == 'administrator') {
				define('PIWIBAR_COOKIE', 1);
			} else {
				define('PIWIBAR_COOKIE', $flag);
			}
		} else {
			define('PIWIBAR_COOKIE', 0);
		}
	} else {
		define('PIWIBAR_COOKIE', $flag);
	}
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
