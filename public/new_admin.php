<?php
require_once( '../private/session.php' );
require_once( '../private/db_connection.php' );
require_once( '../includes/functions.php' );
require_once( '../private/validation_functions.php' );

if ( isset( $_POST[ 'submit' ] ) ) {
    // Process the form
    
    // validations
    $required_fields = array( 'username', 'password' );
    validate_presences( $required_fields );
    
    $fields_with_max_lengths = array( 'username' => 30 );
    validate_max_lengths( $fields_with_max_lengths );
    
    if( empty( $errors ) ) {
        // Perform create
        
        $username = mysql_prep( $_POST[ 'username' ] );
        $hashed_password = password_encrypt( $_POST[ 'password' ] ); // our own encryption function
    }
    
    $query  = "INSERT INTO admins (";
    $query .= " username, hashed_password ";
    $query .= ") VALUES (";
    $query .= " '$username', '$hashed_password' ";
    $query .= ")";
    $result = mysqli_query( $db, $query );
    
    if( $result ) {
        // Success
        $_SESSION[ 'message' ] = "Admin created.";
        redirect_to( 'manage_admins.php' );
    } else {
        // Failure
        $_SESSION[ 'message' ] = "Admin creation failed.";
    }
} else {
    // This is a GET request
}

$layout_context = "admin";
include( '../includes/header.php' );
?>

<main>
        <nav>
            <?php echo navigation( $current_subject, $current_page ); ?>
        </nav>
        <div id="admin-page">
            
            <?php 
            echo message(); 
            $errors = errors();
            echo form_errors( $errors );
            ?>
            
            <h2>Create Admin</h2>
            
            <form action="new_admin.php" method="POST">
                <label>Username:
                    <input type="text" name="username" value="">
                </label>
                <label>Password:
                    <input type="password" name="password" value="">
                </label>
                <input type="submit" name="submit" value="Create Admin">
            </form>
            
            <br>
            
            <a href="manage_admins.php">Cancel</a>
            
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>