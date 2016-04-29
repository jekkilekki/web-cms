<?php ini_set( 'display_errors', 'On' ); ?>
<?php include( '../includes/header.php' ); ?>

<?php
if ( isset( $_GET[ 'subject' ] ) ) {
    $selected_subject_id = $_GET[ 'subject' ];
    $selected_page_id = null;
} elseif ( isset( $_GET[ 'page' ] ) ) {
    $selected_subject_id = null;
    $selected_page_id = $_GET[ 'page' ];
} else {
    $selected_subject_id = null;
    $selected_page_id = null;
}
?>

    <main>
        <nav>
            <?php echo navigation( $selected_subject_id, $selected_page_id ); ?>
        </nav>
        <div id="admin-page">
            <h2>Manage Content</h2>
            
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>
