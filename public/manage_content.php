<?php ini_set( 'display_errors', 'On' ); ?>
<?php include( '../includes/header.php' ); ?>

<?php find_selected_page(); ?>

    <main>
        <nav>
            <?php echo navigation( $current_subject, $current_page ); ?>
        </nav>
        <div id="admin-page">
            
            <?php 
            if ( $current_subject ) {
                
                echo '<h2>Manage Subject</h2>'; 
                echo "<h4>Menu name: " . $current_subject[ 'menu_name' ] . "</h4>";
                
            } elseif ( $current_page ) {
                
                echo '<h2>Manage Page</h2>';
                echo "<h4>Page name: " . $current_page[ 'menu_name' ] . "</h4>";
                
            } else {
                echo "Please select a subject or a page.";
            }
            ?>
            
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>
