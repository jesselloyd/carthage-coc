<?php
/**
 * Plugin Name:     Sermon Manager
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     sermon-manager
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Sermon_Manager
 */


require_once( dirname(__FILE__) . '/inc/youtube-live-stream.php');

add_action('admin_head', 'plugin_menu_styles');

function plugin_menu_styles() {
    ?>
    <style>
        .group:before,
        .group:after {
            content: "";
            display: table;
        }

        .group:after {
            clear: both;
        }

        .group {
            zoom: 1;
            /* For IE 6/7 */
        }

        .pull-left {
            float: left;
        }

        .pull-right {
            float: right;
        }

        input.plugin-search {
            min-width: 60%;
        }

        button.pull-right + button.pull-right {
            margin-right: 1rem;
        }
    </style>
    <?php
}

add_action( 'admin_menu', 'sermon_manager_menu' );
function sermon_manager_menu() {
	add_menu_page( 'Sermon Manager', 'Sermon Manager', 'manage_options', 'Sermon Manager', 'sermon_manager_options', 'dashicons-video-alt2', 2 );
}

function sermon_manager_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
	echo '<div class="wrap">';
    echo '<h1>Sermon Manager</h1>';
    echo '<div class="group"><input name="sermon_search" class="plugin-search pull-left" placeholder="Search Sermons">';
    echo '<button id="create-new-sermon" class="button button-primary action pull-right">Create New Sermon</button></div>';
    echo '<h3>Sermons</h3>';
    echo '========= LIST OF SERMONS TO GO HERE =========';
	echo '</div>';
}
