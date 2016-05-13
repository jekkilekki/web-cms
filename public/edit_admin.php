<?php
require_once( '../private/session.php' );
require_once( '../private/db_connection.php' );
require_once( '../includes/functions.php' );
require_once( '../private/validation_functions.php' );

$admin = find_admin_by_id( $_GET[ 'id' ] );

if( ! $admin ) {
    // admin ID missing or invalid or can't be found in DB
    redirect_to( 'manage_admins.php' );
}

if ( isset( $_POST[ 'submit' ] ) ) {
    // Process the form
    
    // validations
    $required_fields = array( 'username', 'password' );
    validate_presences( $required_fields );
    
    $fields_with_max_lengths = array( 'username' => 30 );
    validate_max_lengths( $fields_with_max_lengths );
    
    if( empty( $errors ) ) {
        // Perform update
        
        $id = $admin[ 'id' ];
        $username = mysql_prep( $_POST[ 'username' ] );
        $hashed_password = password_encrypt( $_POST[ 'password' ] );
    }
    
    $query  = "UPDATE admins SET ";
    $query .= "username = '$username', ";
    $query .= "hashed_password = '$hashed_password' ";
    $query .= "WHERE id = $id ";
    $query .= "LIMIT 1";
    $result = mysqli_query( $db, $query );
    
    if( $result && mysqli_affected_rows( $db ) == 1 ) {
        // Success
        $_SESSION[ 'message' ] = "Admin updated.";
        redirect_to( 'manage_admins.php' );
    } else {
        // Failure
        $_SESSION[ 'message' ] = "Admin update failed.";
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
            
            <h2>Edit Admin: <?php echo htmlentities( $admin[ 'username' ] ); ?></h2>
            
            <form action="edit_admin.php?id=<?php echo urlencode( $admin[ 'id' ] ); ?>" method="POST">
                <label>Username:
                    <input type="text" name="username" value="<?php echo htmlentities( $admin[ 'username' ] ); ?>">
                </label>
                <label>Password:
                    <input type="password" name="password" value="">
                </label>
                <input type="submit" name="submit" value="Edit Admin">
            </form>
            
            <br>
            
            <a href="manage_admins.php">Cancel</a>
            
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>