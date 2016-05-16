<?php 
require_once( '../private/session.php' );
confirm_logged_in();
require_once( '../private/db_connection.php' );
require_once( '../includes/functions.php' );

if( ! $admin ) {
    // admin ID missing or invalid or can't be found in DB
    redirect_to( 'manage_admins.php' );
}

$id = $admin[ 'id' ];
$query = "DELETE FROM admins WHERE id = $id LIMIT 1";
$result = mysqli_query( $db, $query );

if ( $result && mysqli_affected_rows( $db ) == 1 ) {
    // Success
    $_SESSION[ 'message' ] = "Admin $id deleted.";
    redirect_to( 'manage_admins.php' );
} else {
    // Failure
    $_SESSION[ 'message' ] = "Admin deletion failed.";
    redirect_to( "manage_admins.php" );
}