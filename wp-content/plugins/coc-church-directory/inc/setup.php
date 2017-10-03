<?php 

function church_directory_install() {
    global $wpdb;
    $coc_members = 'coc_members';
    if ($wpdb->get_var("SHOW TABLES LIKE '$coc_members'") != $coc_members) {
        $create_coc_members = "CREATE TABLE " . $coc_members . " (
            id INT(11) NOT NULL AUTO_INCREMENT,
            wp_user_id BIGINT(20) UNSIGNED NOT NULL,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            address_line_1 VARCHAR(255) NOT NULL,
            address_line_2 VARCHAR(255), 
            city VARCHAR(255) NOT NULL,
            state_id INT(11) NOT NULL,
            zipcode CHAR(5) NOT NULL,
            profile_picture_url VARCHAR(255) DEFAULT 'no_profile_picture.png' NOT NULL,
            CONSTRAINT PK_COCMember PRIMARY KEY (id),
            CONSTRAINT FK_WPUser_COCMember FOREIGN KEY (wp_user_id)
            REFERENCES wp_users(ID) 
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($create_coc_members);
    }
}
