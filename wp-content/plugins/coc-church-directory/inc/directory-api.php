<?php

add_action('rest_api_init', function() {
    register_rest_route('/directory', '/get', array(
        'methods' => 'GET',
        'callback' => 'get_directory'
    ));
});

function get_directory() {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM wp_usermeta");
}

function search_directory() {

}
