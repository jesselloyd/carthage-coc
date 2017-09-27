<?php
/**
 * Plugin Name:     Carthage church of Christ Church Directory
 * Plugin URI:      http://carthage-coc.com/help/directory/
 * Description:     Contains all functionality specific to the church directory service
 * Author:          Jesse Lloyd
 * Author URI:      https://github.com/jesselloyd
 * Text Domain:     coc-church-directory
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Coc_Church_Directory
 */

require_once( dirname(__FILE__) . '/inc/register-authentication.php');
require_once( dirname(__FILE__) . '/inc/directory-api.php');

add_action( 'admin_menu', 'church_directory_menu' );
function church_directory_menu() {
	add_menu_page( 'Church Directory', 'Church Directory', 'manage_options', 'Church Directory', 'church_directory_options', '', 2 );
}

function church_directory_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<input placeholder="Search">';
	echo '</div>';
}
