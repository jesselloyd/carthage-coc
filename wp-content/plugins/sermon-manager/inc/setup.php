<?php 

function sermon_manager_install() {
    global $wpdb;
    $coc_links = 'coc_links';
    if ($wpdb->get_var("SHOW TABLES LIKE '$coc_links'") != $coc_links) {
        $create_coc_links = "CREATE TABLE " . $coc_links . " (
            id INT(11) NOT NULL AUTO_INCREMENT,
            link_name VARCHAR(255) NOT NULL,
            link_url VARCHAR(255) NOT NULL,
            logo_image_name VARCHAR(255) NOT NULL,
            CONSTRAINT PK_COCLinks PRIMARY KEY (id)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($create_coc_links);
    }
}
