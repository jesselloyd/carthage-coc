<?php
/**
 * Plugin Name:     Carthage church of Christ Church Directory
 * Plugin URI:      http://carthage-coc.com/help/directory/
 * Description:     Contains all functionality specific to the church directory service
 * Author URI:      https://github.com/jesselloyd
 * Text Domain:     coc-church-directory
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Coc_Church_Directory
 */

require_once( dirname(__FILE__) . '/inc/setup.php');
register_activation_hook(__FILE__, 'church_directory_install');

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

add_shortcode('theme_uri', 'theme_uri_shortcode' );

function theme_uri_shortcode( $attrs = array (), $content = '' )
{
    $theme_uri = is_child_theme()
        ? get_stylesheet_directory_uri()
        : get_template_directory_uri();

    return trailingslashit( $theme_uri );
}

add_shortcode('search_bar', 'search_bar_shortcode');

add_action('wp_enqueue_scripts', 'jquery_script');
add_action('wp_enqueue_scripts', 'search_bar_script');

function search_bar_shortcode() {
    wp_enqueue_script('jq');
    wp_enqueue_script('jq-debounce');
    wp_enqueue_script('search');
    ob_start();
    ?>
    <form id="search" class="full-width" autocomplete="off">
        <input tabindex="1" placeholder="Search for church members..." id="searchterm" />
        <div class="suggestions"></div>
        <p class="count"></p>
        <div class="results"></div>
    </form>
    <?php
    return ob_get_clean();
}

function jquery_script() {
    wp_register_script('jq-debounce', plugins_url('node_modules/jquery/dist/jquery.throttle.debounce.min.js', __FILE__), '1.0.0', true);
    wp_register_script('jq', plugins_url('node_modules/jquery/dist/jquery.min.js', __FILE__), array(), '3.2.1', true);
}

function search_bar_script() {
    wp_register_script('search', plugins_url('inc/js/search.js', __FILE__), array(), '1.0.0', true );
}

add_shortcode('sign_up_form', 'sign_up_form_shortcode');

function sign_up_form_shortcode() {
    ob_start();
    ?>
        <div id="sign-up-container" class="card">
            <div class="card-header">
                Sign Up
            </div>
            <form id="sign-up" class="center-text card-body">
                <p>After you have signed up, an elder will review your request. You will receive a confirmation email once you are approved. This will permit you to log into the member restricted portion of the website.</p>
                <div class="spacer"></div><div class="spacer"></div>
                <input name="first_name" placeholder="First Name" required />
                <input name="last_name" placeholder="Last Name" required />
                <input name="email" placeholder="Email" email />
                <div class="spacer"></div><div class="spacer"></div>
                <input name="address_line_1" placeholder="Address (Line 1)" required />
                <input name="address_line_2" placeholder="Address (Line 2, Optional)" />
                <input name="city" placeholder="City" required />
                <input name="state" placeholder="State" required />
                <input name="zipcode" placeholder="Zipcode" required />
                <div class="spacer"></div><div class="spacer"></div>
                <input name="phone_number" placeholder="Phone Number" required />
                <input name="password" placeholder="Password" required />
                <input name="confirm_password" placeholder="Confirm Password" required />
                <div class="spacer"></div><div class="spacer"></div>
                <button type="submit">Sign Up</button>
                <div class="spacer"></div>
                <p>Already a member? <a href="/wp-login">Log in</a></p>
            </form>
        </div>
    <?php
    return ob_get_clean();
}
