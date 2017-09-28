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
	add_menu_page( 'Church Directory', 'Church Directory', 'manage_options', 'Church Directory', 'church_directory_options', 'dashicons-admin-users', 2 );
}

function church_directory_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
    echo '<h1>Church Directory</h1>';
    echo '<div class="group"><input name="directory_search" class="plugin-search pull-left" placeholder="Search for Members">';
    echo '<button id="create-member" class="button button-primary action pull-right">Add Member</button>';
    echo '<button id="review-member-requests" class="button button-primary action pull-right">Review Membership Requests</button></div>';
    echo '<h3>Directory</h3>';
    echo '========= PAGINATED DIRECTORY TO GO HERE =========';
	echo '</div>';
}

add_shortcode('get_leadership', 'coc_get_leadership_list');

function coc_get_leadership_list() {
    ob_start();
    global $wpdb;
    $leader_meta = $wpdb->get_results("SELECT * FROM wp_usermeta WHERE user_id IN (SELECT user_id FROM wp_users) AND (meta_key = 'first_name' || meta_key = 'last_name');");

    foreach ($leader_meta as $meta_key) {
        if ($meta_key->meta_key == 'first_name') {
            ?>
                <div class="leader-item">
                    <h3 class="grey-header"><?php echo $meta_key->meta_value . ' ' ?>
            <?php
        } else if ($meta_key->meta_key == 'last_name'){
            ?>
                <?php echo $meta_key->meta_value; ?></h3>
                <h4>(417) 434 - 0754</h4>
                <p>Description goes here</p>
            </div>
            <?php
        }
    }

    return ob_get_clean();
}

add_shortcode('youtube_live_stream', 'render_live_stream');

function render_live_stream() {
    do_action("youtube_live_stream");
}

add_shortcode('theme_uri', 'coc_theme_uri_shortcode' );

function coc_theme_uri_shortcode( $attrs = array (), $content = '' )
{
    $theme_uri = is_child_theme()
        ? get_stylesheet_directory_uri()
        : get_template_directory_uri();

    return trailingslashit( $theme_uri );
}
