<?php
include_once(ABSPATH . 'wp-includes/pluggable.php');
add_action('rest_api_init', function() {
    register_rest_route('/directory', '/all', array(
        'methods' => 'GET',
        'callback' => 'get_all_directory_members',
        'permission_callback' => function() {
            return current_user_can('manage_options');
        }
    ));

    register_rest_route('/directory', '/search', array(
        'methods' => 'POST',
        'callback' => 'search',
        'permission_callback' => function() {
            return current_user_can('read');
        }
    ));

    register_rest_route('/directory', '/search-suggestions', array(
        'methods' => 'POST',
        'callback' => 'search_suggestions',
        'permission_callback' => function() {
           return current_user_can('read'); 
        }
    ));

    register_rest_route('/directory', '/register', array(
        'methods' => 'POST',
        'callback' => 'register',
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

function register($request) {
    global $wpdb;
    
    // Check username is present and not already in use  
    $username = $wpdb->escape($request['username']);  
      
    if (strpos($username, ' ') !== false) {  
        $errors['username'] = "Sorry, no spaces allowed in usernames";  
    }  
      
    if (empty($username)) {  
        $errors['username'] = "Please enter a username";  
    } elseif (username_exists($username)) {  
        $errors['username'] = "Username already exists, please try another";  
    }  
      
    // Check email address is present and valid  
    $email = $wpdb->escape($request['email']);  
      
    if (!is_email($email)) {  
        $errors['email'] = "Please enter a valid email";  
    } elseif (email_exists($email)) {  
        $errors['email'] = "This email address is already in use";  
    }  
      
    // Check password is valid  
    if (0 === preg_match("/.{6,}/", $request['password'])) {  
        $errors['password'] = "Password must be at least six characters";  
    }  
      
    // Check password confirmation_matches  
    if (0 !== strcmp($_POST['password'], $request['password_confirmation'])) {  
        $errors['password_confirmation'] = "Passwords do not match";  
    }  
      
    if (0 === count($errors)) {  
        $password = $_POST['password'];  
        $new_user_id = wp_create_user($username, $password, $email);

        if ($new_user_id) {
            directory_specific_register($new_user_id, $request);
        }
      
        $success = 1;  
        header('Location:' . get_bloginfo('url') . '/login/?success=1&u=' . $username);
        return $success;
    } else {
        return $errors;
    }
}

function directory_specific_register($wp_user_id, $details) {
    global $wpdb;

    $wpdb->get_results(
        $wpdb->prepare(
            "INSERT INTO coc_members 
            (wp_user_id, first_name, last_name, 
            address_line_1, address_line_2, 
            city, state, zipcode, 
            phone_number, role_id)
            VALUES
            (%d, %s, %s, %s, %s, %s, %s, %s, %s, %d)",
            $wp_user_id, $details['first_name'], $details['last_name'],
            $details['address_line_1'], $details['address_line_2'],
            $details['city'], $details['state'], $details['zipcode'],
            $details['phone_number'], 1
        )
    );

    return $wpdb->get_results($wpdb->prepare("SELECT id FROM coc_members WHERE wp_user_id = %d", $wp_user_id));
}
