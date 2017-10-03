<?php

add_action('rest_api_init', function() {
    register_rest_route('/directory', '/get', array(
        'methods' => 'GET',
        'callback' => 'get_directory'
    ));

    register_rest_route('/directory', '/get', array(
        'methods' => 'GET',
        'callback' => 'get_directory'
    ));
});

function get_directory() {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM wp_usermeta");
}

function search_suggestions($request) {
    global $wpdb;
    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT first_name, last_name, membership_level FROM coc_members cm JOIN wp_users wu ON cm.wp_user_ID = wu.ID"
        ));
}
