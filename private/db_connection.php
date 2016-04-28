<?php
// 1. Create a database connection
// define constants
define( 'DB_SERVER', 'localhost' );
define( 'DB_USER', 'jekkilekki' );
define( 'DB_PASS', 'fluffh34d' );
define( 'DB_NAME', 'jkl_web' );

$db = mysqli_connect( DB_SERVER, DB_USER, DB_PASS, DB_NAME );

// Test if connection succeeded
if ( mysqli_connect_errno() ) {
    die( 'Database connection failed: ' . mysqli_connect_error() . ' (' . mysqli_connect_errno() . ')' );
}
?>