<?php
require_once( '../private/session.php' );
require_once( '../includes/functions.php' );

// v1: simple logout
// session_start();
$_SESSION[ 'admin_id' ] = null;
$_SESSION[ 'username' ] = null;
redirect_to( 'index.php' );

// v2: destroy session (heavy handed)
// assumes nothing else in session to keep
//session_start();
//$_SESSION = array();
//if ( isset( $_COOKIE[ session_name() ] ) ) {
//    setcookie( session_name(), '', time()-42000, '/' );
//}
//session_destroy();
//redirect_to( 'index.php' );
?>