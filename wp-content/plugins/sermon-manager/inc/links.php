<?php

add_action('rest_api_init', function() {
    register_rest_route('/links', '/get', array(
        'methods' => 'GET',
        'callback' => 'get_coc_links'
    ));

    register_rest_route('/links', '/create', array(
        'methods' => 'POST',
        'callback' => 'create_coc_link'
    ));
});

function get_coc_links() {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM coc_links;");
}

function create_coc_link($request) {
    global $wpdb;
    $wpdb->query(
        $wpdb->prepare("INSERT INTO coc_links
                        (link_name, link_url, logo_image_name)
                        VALUES (%s, %s, %s)", 
                        $request['link_name'], $request['link_url'], $_FILES['logo_image_name']['name']));

    $sourcePath = $_FILES['logo_image_name']['tmp_name'];                                       
    $targetPath = get_stylesheet_directory() . '/images/' . $_FILES['logo_image_name']['name']; 
    move_uploaded_file($sourcePath, $targetPath);
}
