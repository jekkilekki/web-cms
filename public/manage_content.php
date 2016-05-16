<?php
ini_set( 'display_errors', 'On' );
require_once( '../private/session.php' );
confirm_logged_in();

$layout_context = 'admin';
include( '../includes/header.php' );

find_selected_page(); 
?>

    <main>
        <nav>
            <br>
            <a href="admin.php">&laquo; Main menu</a>
            <br>
            <?php echo navigation( $current_subject, $current_page ); ?>
            <br>
            <a href="new_subject.php">+ Add a subject</a>
        </nav>
        <div id="admin-page">
            
            <?php echo message(); ?>
            
            <?php 
            if ( $current_subject ) {
                
                echo '<h2>Manage Subject</h2>'; 
                echo "<h4>Menu name: " . htmlentities( $current_subject[ 'menu_name' ] ) . "</h4>";
                echo "<p>Position: " . $current_subject[ 'position' ] . "</p>";
                echo "<p>Visible: " . $current_subject[ 'position' ] ? 'yes' : 'no' . "</p>";
                echo '<br>';
                echo '<p><a href="edit_subject.php?subject=' . urlencode( $current_subject[ 'id' ] ) . '">Edit Subject</a></p>';
                
                echo '<div class="pages">';
                echo '<h3>Pages in this subject:</h3>';
                echo '<ul>';
                
                $subject_pages = find_pages_for_subject( $current_subject[ 'id' ], false );
                while( $page = mysqli_fetch_assoc( $subject_pages ) ) {
                    echo '<li>';
                    $safe_page_id = urlencode( $page[ 'id' ] );
                    echo '<a href="manage_content.php?page=' . $safe_page_id . '">' . htmlentities( $page[ 'menu_name' ] ) . '</a>';
                    echo '</li>';
                }
                
                echo '</ul>';
                echo '<br>';
                
                echo '+ <a href="new_page.php?subject=' . urlencode( $current_subject[ 'id' ] ) . '">Add a new page to this subject</a>';
                echo '</div>';
                
            } elseif ( $current_page ) {
                
                echo '<h2>Manage Page</h2>';
                echo "<h4>Page name: " . htmlentities( $current_page[ 'menu_name' ] ) . "</h4>";
                echo "<p>Position: " . $current_page[ 'position' ] . "</p>";
                echo "<p>Visible: " . $current_page[ 'position' ] ? 'yes' : 'no' . "</p>";
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
