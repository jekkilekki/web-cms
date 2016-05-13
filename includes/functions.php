<?php
function redirect_to( $new_location ) {
    header( "Location: " . $new_location );
    exit;
}

function mysql_prep( $string ) {
    global $db;
    return mysqli_real_escape_string( $db, $string );
}

function form_errors( $errors = array() ) {
    $output = '';
    if ( ! empty( $errors ) ) {
        $output .= '<div class="error">';
        $output .= 'Please fix the following errors: ';
        $output .= '<ul>';
        foreach( $errors as $key => $error ) {
            $output .= "<li>" . htmlentities( $error ) . "</li>";
        }
        $output .= '</ul>';
        $output .= '</div>';
    }
    return $output;
}

function confirm_query( $result_set ) {
    if ( ! $result_set ) {
        die( 'Database query failed: ' . mysqli_connect_error() . ' (' . mysqli_connect_errno() . ')' );
    }
}

function find_all_subjects( $public=true ) {
    global $db;
    
    $query  = "SELECT * ";
    $query .= "FROM subjects ";
    if ( $public ) {
        $query .= "WHERE visible = 1 ";
    }
    $query .= "ORDER BY position ASC";
    $subject_set = mysqli_query( $db, $query );
    confirm_query( $subject_set ); // in the functions.php file
    
    return $subject_set;
}

function find_pages_for_subject( $subject_id, $public=true ) {
    global $db;
    
    // Escape the input to avoid SQL injection
    $safe_subject_id = mysqli_real_escape_string( $db, $subject_id );
    
    $query  = "SELECT * ";
    $query .= "FROM pages ";
    $query .= "WHERE subject_id = $safe_subject_id ";
    if( $public ) {
        $query .= "AND visible = 1 ";
    }
    $query .= "ORDER BY position ASC";
    $page_set = mysqli_query( $db, $query );
    confirm_query( $page_set ); // in the functions.php file
    
    return $page_set;
}

function find_subject_by_id( $subject_id, $public=true ) {
    global $db;
    
    // Escape the input to avoid SQL injection
    $safe_subject_id = mysqli_real_escape_string( $db, $subject_id );
    
    $query  = "SELECT * ";
    $query .= "FROM subjects ";
    $query .= "WHERE id = $safe_subject_id ";
    if( $public ) {
        $query .= "AND visible = 1 ";
    }
    $query .= "LIMIT 1";
    $subject_set = mysqli_query( $db, $query );
    confirm_query( $subject_set ); // in the functions.php file
    
    if ( $subject = mysqli_fetch_assoc( $subject_set ) ) {
        return $subject;
    } else {
        return null;
    }
}

function find_page_by_id( $page_id, $public=true ) {
    global $db;
    
    // Escape the input to avoid SQL injection
    $safe_page_id = mysqli_real_escape_string( $db, $page_id );
    
    $query  = "SELECT * ";
    $query .= "FROM pages ";
    $query .= "WHERE id = $safe_page_id ";
    if( $public ) {
        $query .= "AND visible = 1 ";
    }
    $query .= "LIMIT 1";
    $page_set = mysqli_query( $db, $query );
    confirm_query( $page_set ); // in the functions.php file
    
    if ( $page = mysqli_fetch_assoc( $page_set ) ) {
        return $page;
    } else {
        return null;
    }
}

function find_default_page_for_subject( $subject_id ) {
    $page_set = find_pages_for_subject( $subject_id );
    if( $first_page = mysqli_fetch_assoc( $page_set ) ) {
        return $first_page;
    } else {
        return null;
    }
}

function find_selected_page( $public=false ) {
    global $current_subject;
    global $current_page;
    
    if ( isset( $_GET[ 'subject' ] ) ) {
        $current_subject = find_subject_by_id( $_GET[ 'subject' ], $public );
        if( $current_subject && $public ) {
            $current_page = find_default_page_for_subject( $current_subject[ 'id' ] );
        } else {
            $current_page = null;
        }
    } elseif ( isset( $_GET[ 'page' ] ) ) {
        $current_subject = null;
        $current_page = find_page_by_id( $_GET[ 'page' ], $public ); 
    } else {
        $current_subject = null;
        $current_page = null;
    }
}

// Navigation takes 2 arguments
// - the current subject array or null
// - the current page array or null
function navigation( $subject_array, $page_array ) {
    
    $output = '<ul class="subjects">';
    $subject_set = find_all_subjects( false );    
            
    while( $subject = mysqli_fetch_assoc( $subject_set ) ) : 

        $output .= '<li'; 
        if ( $subject_array && $subject[ 'id' ] == $subject_array[ 'id' ] ) {
            $output .= ' class="selected"';
        } 
        $output .= '>';
            
        $output .= '<a href="manage_content.php?subject=';
        $output .= urlencode( $subject[ 'id' ] ); 
        $output .= '">';
        $output .= htmlentities( $subject[ 'menu_name' ] );
        $output .= '</a>';
        
        $page_set = find_pages_for_subject( $subject[ 'id' ], false );
        $output .= '<ul class="pages">';
        while( $page = mysqli_fetch_assoc( $page_set ) ) :
                               
            $output .= '<li'; 
            if ( $page_array && $page[ 'id' ] == $page_array[ 'id' ] ) {
                $output .= ' class="selected"';
            } 
            $output .= '>';

            $output .= '<a href="manage_content.php?page=';
            $output .= urlencode( $page[ 'id' ] ); 
            $output .= '">';
            $output .= htmlentities( $page[ 'menu_name' ] );
            $output .= '</a>';
                               
            $output .= '</li>';
                               
        endwhile;
        mysqli_free_result( $page_set );
                               
        $output .= '</ul>';
        $output .= '</li>';
                               
    endwhile;
    mysqli_free_result( $subject_set );
                               
    $output .= '</ul>';
                               
    return $output;
}

function public_navigation( $subject_array, $page_array ) {
    
    $output = '<ul class="subjects">';
    $subject_set = find_all_subjects();    
            
    while( $subject = mysqli_fetch_assoc( $subject_set ) ) : 

        $output .= '<li'; 
        if ( $subject_array && $subject[ 'id' ] == $subject_array[ 'id' ] ) {
            $output .= ' class="selected"';
        } 
        $output .= '>';
            
        $output .= '<a href="index.php?subject=';
        $output .= urlencode( $subject[ 'id' ] ); 
        $output .= '">';
        $output .= htmlentities( $subject[ 'menu_name' ] );
        $output .= '</a>';
        
        if( $subject_array[ 'id' ] == $subject[ 'id' ] || $page_array[ 'subject_id' ] == $subject[ 'id' ] ) {
            $page_set = find_pages_for_subject( $subject[ 'id' ] );
            $output .= '<ul class="pages">';
            while( $page = mysqli_fetch_assoc( $page_set ) ) :

                $output .= '<li'; 
                if ( $page_array && $page[ 'id' ] == $page_array[ 'id' ] ) {
                    $output .= ' class="selected"';
                } 
                $output .= '>';

                $output .= '<a href="index.php?page=';
                $output .= urlencode( $page[ 'id' ] ); 
                $output .= '">';
                $output .= htmlentities( $page[ 'menu_name' ] );
                $output .= '</a>';

                $output .= '</li>';

            endwhile;
            mysqli_free_result( $page_set );

            $output .= '</ul>';
        }
        $output .= '</li>'; // end subject li
                               
    endwhile;
    mysqli_free_result( $subject_set );
                               
    $output .= '</ul>';
                               
    return $output;
}

/**
 * ADMIN Functions
 */
function find_all_admins() {
    global $db;
    
    $query  = "SELECT * ";
    $query .= "FROM admins ";
    $query .= "ORDER BY username ASC";
    
    $admin_set = mysqli_query( $db, $query );
    confirm_query( $admin_set );
    
    return $admin_set;
}

function find_admin_by_id( $admin_id ) {
    global $db;
    
    $safe_admin_id = mysqli_real_escape_string( $db, $admin_id );
    
    $query  = "SELECT * ";
    $query .= "FROM admins ";
    $query .= "WHERE id = $safe_admin_id ";
    $query .= "LIMIT 1";
    
    $admin_set = mysqli_query( $db, $query );
    confirm_query( $admin_set );
    
    if( $admin = mysqli_fetch_assoc( $admin_set ) ) {
        return $admin;
    } else {
        return null;
    }
}

function password_encrypt( $password ) {
    $hash_format = '$2y$10$';   // tells PHP to use Blowfish with a "cost" of 10
    $salt_length = 22;          // Blowfish salts should be 22-characters or more
    $salt = generate_salt( $salt_length );
    $format_and_salt = $hash_format . $salt;
    $hash = crypt( $password, $format_and_salt );
    return $hash;
}

function generate_salt( $length ) {
    // Not 100% unique, not 100% random, but good enough for a salt
    // MD5 returns 32 chars
    $unique_random_string = md5( uniqid( mt_rand(), true ) );
    
    // Valid chars for a salt are [a-zA-Z0-9./] - but base64 uses + instead of .
    $base64_string = base64_encode( $unique_random_string );
    
    // But not '+' which is valid in base64 encoding
    $modified_base64_string = str_replace( '+', '.', $base64_string );
    
    // Truncate string to the correct length
    $salt = substr( $modified_base64_string, 0, $length );
    
    return $salt;
}

function password_check( $password, $existing_hash ) {
    // existing hash contains format and salt at start
    $hash = crypt( $password, $existing_hash );
    if( $hash === $existing_hash ) {
        return true;
    } else {
        return false;
    }
}