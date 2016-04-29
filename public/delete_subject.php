<?php 
require_once( '../private/session.php' );
require_once( '../private/db_connection.php' );
require_once( '../includes/functions.php' );

$current_subject = find_subject_by_id( $_GET[ 'subject' ] );
if ( ! $current_subject ) {
    redirect_to( 'manage_content.php' );
}

// Don't allow deleting parent pages
$pages_set = find_pages_for_subject( $current_subject[ 'id' ] );
if ( mysqli_num_rows( $pages_set ) > 0 ) {
    $_SESSION[ 'message' ] = "Can't delete a subject with pages.";
    redirect_to( "manage_content.php?subject=$current_subject[ 'id' ]" );
}

$id = $current_subject[ 'id' ];
$query = "DELETE FROM subjects WHERE id = $id LIMIT 1";
$result = mysqli_query( $db, $query );

if ( $result && mysqli_affected_rows( $db ) == 1 ) {
    // Success
    $_SESSION[ 'message' ] = "Subject $id deleted.";
    redirect_to( 'manage_content.php' );
} else {
    // Failure
    $_SESSION[ 'message' ] = "Subject deletion failed.";
    redirect_to( "manage_content.php?subject=$id" );
}