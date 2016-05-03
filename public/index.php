<?php
ini_set( 'display_errors', 'On' );
require_once( '../private/session.php' );
include( '../includes/header.php' );

find_selected_page(); 
?>

    <main>
        <nav>
            <?php echo public_navigation( $current_subject, $current_page ); ?>
        </nav>
        <div id="page">
            
            <?php 
            if ( $current_subject ) {
                
                echo '<h2>Manage Subject</h2>'; 
                echo "<h4>Menu name: " . htmlentities( $current_subject[ 'menu_name' ] ) . "</h4>";
                
            } elseif ( $current_page ) {
                
                echo "<h4>" . htmlentities( $current_page[ 'menu_name' ] ) . "</h4>";
                echo '<div class="view-content">' . htmlentities( $current_page[ 'content' ] ) . '</div>';
                echo '<br>';
                echo '<p><a href="edit_page.php?page=' . urlencode( $current_page[ 'id' ] ) . '">Edit Page</a></p>';
                
            } else {
                echo "Please select a subject or a page.";
            }
            ?>
            
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>
