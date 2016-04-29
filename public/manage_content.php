<?php
ini_set( 'display_errors', 'On' );
require_once( '../private/session.php' );
include( '../includes/header.php' );

find_selected_page(); 
?>

    <main>
        <nav>
            <?php echo navigation( $current_subject, $current_page ); ?>
            <br>
            <a href="new_subject.php">+ Add a subject</a>
        </nav>
        <div id="admin-page">
            
            <?php echo message(); ?>
            
            <?php 
            if ( $current_subject ) {
                
                echo '<h2>Manage Subject</h2>'; 
                echo "<h4>Menu name: " . $current_subject[ 'menu_name' ] . "</h4>";
                echo '<a href="edit_subject.php?subject=' . $current_subject[ 'id' ] . '">Edit Subject</a>';
                
            } elseif ( $current_page ) {
                
                echo '<h2>Manage Page</h2>';
                echo "<h4>Page name: " . $current_page[ 'menu_name' ] . "</h4>";
                echo '<a href="edit_subject.php?subject=' . $current_page[ 'id' ] . '">Edit Page</a>';
                
            } else {
                echo "Please select a subject or a page.";
            }
            ?>
            
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>
