<?php
require_once( '../private/session.php' );
require_once( '../private/db_connection.php' );
require_once( '../includes/functions.php' );
require_once( '../private/validation_functions.php' );

$username = '';

if ( isset( $_POST[ 'submit' ] ) ) {
    // Process the form
    
    // validations
    $required_fields = array( 'username', 'password' );
    validate_presences( $required_fields );

    if( empty( $errors ) ) {
        // Attempt login
        
        $username = $_POST[ 'username' ];
        $password = $_POST[ 'password' ];
        
        $found_admin = attempt_login( $username, $password );
        
        if( $found_admin ) {
            // Success
            // Mark user as logged in
            $_SESSION[ 'admin_id' ] = $found_admin[ 'id' ];
            $_SESSION[ 'username' ] = $found_admin[ 'username' ];
            redirect_to( 'admin.php' );
        } else {
            // Failure
            $_SESSION[ 'message' ] = "Username/password not found.";
        }
    }
} else {
    // This is a GET request
}

$layout_context = "admin";
include( '../includes/header.php' );
?>

<main>
        <nav>
            <?php // echo navigation( $current_subject, $current_page ); ?>
        </nav>
        <div id="admin-page">
            
            <?php 
            echo message(); 
            $errors = errors();
            echo form_errors( $errors );
            ?>
            
            <h2>Login</h2>
            
            <form action="login.php" method="POST">
                <label>Username:
                    <input type="text" name="username" value="<?php echo htmlentities( $username ); ?>">
                </label>
                <label>Password:
                    <input type="password" name="password" value="">
                </label>
                <input type="submit" name="submit" value="Submit">
            </form>
            
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>