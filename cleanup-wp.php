<?php
/*
Plugin Name: Cleanup Wordpress
Plugin URI: http://en.nisi.ro/
Description: Clean your wordpresss blog database from unused data like spam comments, revisions for post and pages
Author: Nisipeanu Mihai
Version: 1.2.0
Author URI: http://en.nisi.ro/
*/
include_once('wp_plugin.php');
$wp_plugin = new wp_nplugin();
define('PG_VERSION', '1.2.0');

define('ASSETS_URL', esc_url( trailingslashit( plugins_url( '/img/', __FILE__ ) ) ));

function add_page_to_tools(){
	$wppg = & $GLOBALS['wp_plugin'];
	$wppg->addAdminHeader();
	add_management_page("Cleanup Wordpress ".PG_VERSION, 'Cleanup Wordpress', 'manage_options', $wppg->getDir().'/cleanup-wp-tools.php');
}
add_action('admin_menu', 'add_page_to_tools');
?>