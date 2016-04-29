<?php 

ini_set( 'display_errors', 'On' );
require_once( '../private/session.php' );
require_once( '../private/validation_functions.php' );

// Open database connection
require_once( '../private/db_connection.php' );
require_once( '../includes/functions.php' );

if ( isset( $_POST[ 'submit' ] ) ) {
    
    // Process the form
    $menu_name = mysql_prep( $_POST[ 'menu_name' ] ); // custom file in functions.php to escape the value that's passed in
    $position = (int) $_POST[ 'position' ];
    $visible = (int) $_POST[ 'visible' ];
    
    // Validations
    $required_fields = array( 'menu_name', 'position', 'visible' );
    validate_presences( $required_fields );
    
    $fields_with_max_lengths = array( 'menu_name' => 30 );
    validate_max_lengths( $fields_with_max_lengths );
    
    if ( ! empty( $errors ) ) {
        $_SESSION[ 'errors' ] = $errors;
        redirect_to( 'new_subject.php' );
    }
    
    // Database query
    $query  = "INSERT INTO subjects (";
    $query .= " menu_name, position, visible ";
    $query .= ") VALUES (";
    $query .= " '$menu_name', $position, $visible ";
    $query .= ")";
    $result = mysqli_query( $db, $query );
    
    if ( $result ) {
        // Success
        $_SESSION[ 'message' ] = "Subject $menu_name created!";
        redirect_to( 'manage_content.php' );
    } else {
        $_SESSION[ 'message' ] = "Subject creation failed.";
        redirect_to( 'new_subject.php' );
    }
    
} else {
    // This is probably a GET request
    redirect_to( 'new_subject.php' );
}

// Close database connection
if ( isset( $db ) ) { mysqli_close( $db ); }
?>