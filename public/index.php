<?php
ini_set( 'display_errors', 'On' );
require_once( '../private/session.php' );

$layout_context = 'public';
include( '../includes/header.php' );

find_selected_page( true ); 
?>

    <main>
        <nav>
            <?php echo public_navigation( $current_subject, $current_page ); ?>
        </nav>
        <div id="page">
            
            <?php 
            if ( $current_page ) {
                
                echo "<h2>" . htmlentities( $current_page[ 'menu_name' ] ) . "</h2>";
                echo '<div class="view-content">' . nl2br( htmlentities( $current_page[ 'content' ] ) ) . '</div>';
                echo '<br>';
                echo '<p><a href="edit_page.php?page=' . urlencode( $current_page[ 'id' ] ) . '">Edit Page</a></p>';
                
            } else {
                echo "<h1>Welcome!</h1>";
            }
            ?>
            
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>
