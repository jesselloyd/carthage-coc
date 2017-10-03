<?php

add_action('rest_api_init', function() {
    register_rest_route('/directory', '/all', array(
        'methods' => 'GET',
        'callback' => 'get_all_directory_members'
    ));

    register_rest_route('/directory', '/search', array(
        'methods' => 'POST',
        'callback' => 'search'
    ));

    register_rest_route('/directory', '/search-suggestions', array(
        'methods' => 'POST',
        'callback' => 'search_suggestions'
    ));
});

function get_all_directory_members() {
    global $wpdb;

    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT first_name, last_name, address_line_1,
             address_line_2, city, state, zipcode, phone_number 
             profile_picture_url, role_name, user_email
             FROM coc_members cm 
             JOIN wp_users wu ON cm.wp_user_ID = wu.ID 
             JOIN coc_roles cr ON cm.role = cr.id;"
        )
    );
}

function search($request) {
    global $wpdb;
    $terms = str_replace(" ", "|", $request['term']);

    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT first_name, last_name, address_line_1,
             address_line_2, city, state, zipcode, phone_number,
             profile_picture_url, role_name, user_email
             FROM coc_members cm 
             JOIN wp_users wu ON cm.wp_user_ID = wu.ID 
             JOIN coc_roles cr ON cm.role_id = cr.id
             WHERE CONCAT(first_name, ' ', last_name) REGEXP '%s';",
             $terms
         )
     );
}

function search_suggestions($request) {
    global $wpdb;
    $terms = str_replace(" ", "|", trim($request['term']));
    
    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT first_name, last_name, profile_picture_url, 
             role_name
             FROM coc_members cm 
             JOIN wp_users wu ON cm.wp_user_ID = wu.ID 
             JOIN coc_roles cr ON cm.role_id = cr.id
             WHERE CONCAT(first_name, ' ', last_name) REGEXP '%s';",
             $terms
         )
     );
}
