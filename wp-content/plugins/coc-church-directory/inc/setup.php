<?php 

function church_directory_install() {
    global $wpdb;

    $coc_roles = 'coc_roles';
    if ($wpdb->get_var("SHOW TABLES LIKE '$coc_roles'") != $coc_roles) {
        $create_coc_roles = "CREATE TABLE " . $coc_roles . " (
            id INT(11) NOT NULL AUTO_INCREMENT,
            role_name VARCHAR(255) NOT NULL,
            CONSTRAINT PK_COCRole PRIMARY KEY (id)
        );";

        $insert_coc_roles = "INSERT INTO " . $coc_roles . " (role_name)
            VALUES ('Member'), ('Deacon'), ('Elder'), ('Minister');";

        $coc_roles_init = array( 
            create_coc_roles => $create_coc_roles,
            insert_coc_roles => $insert_coc_roles 
        );

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($coc_roles_init);
    }


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
            state CHAR(2) NOT NULL,
            zipcode CHAR(5) NOT NULL,
            phone_number VARCHAR(20),
            profile_picture_url VARCHAR(255) DEFAULT 'no_profile_picture.png' NOT NULL,
            role_id INT(11) NOT NULL, 
            CONSTRAINT PK_COCMember PRIMARY KEY (id),
            CONSTRAINT FK_WPUser_COCMember FOREIGN KEY (wp_user_id)
            REFERENCES wp_users(ID),
            CONSTRAINT FK_COCRole_COCMember FOREIGN KEY (role_id)
            REFERENCES coc_roles(id)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($create_coc_members);
    }
}
