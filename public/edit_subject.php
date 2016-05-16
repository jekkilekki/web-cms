<?php 
require_once( '../private/session.php' );
confirm_logged_in();
require_once( '../private/validation_functions.php' );

$layout_context = 'admin';
include( '../includes/header.php' );

find_selected_page(); 
if ( ! $current_subject ) {
    // subject ID was missing or invalid or couldn't be found in database
    redirect_to( 'manage_content.php' );
}

if ( isset( $_POST[ 'submit' ] ) ) {
    
    // Process the form
    // Validations
    $required_fields = array( 'menu_name', 'position', 'visible' );
    validate_presences( $required_fields );
    
    $fields_with_max_lengths = array( 'menu_name' => 30 );
    validate_max_lengths( $fields_with_max_lengths );
    
    if ( empty( $errors ) ) {
        
        // Perform update
        $id = $current_subject[ 'id' ];
        $menu_name = mysql_prep( $_POST[ 'menu_name' ] ); // custom file in functions.php to escape the value that's passed in
        $position = (int) $_POST[ 'position' ];
        $visible = (int) $_POST[ 'visible' ];
        
        // Database query
        $query  = "UPDATE subjects SET ";
        $query .= "menu_name = '{$menu_name}', ";
        $query .= "position = $position, ";
        $query .= "visible = $visible ";
        $query .= "WHERE id = $id ";
        $query .= "LIMIT 1";
        $result = mysqli_query( $db, $query );

        if ( $result && mysqli_affected_rows( $db ) >= 0 ) {
            // Success
            $_SESSION[ 'message' ] = "Subject $menu_name successfully updated!";
            redirect_to( 'manage_content.php' );
        } else {
            $message = "Subject update failed.";
        }
    }
    
} else {
    // This is probably a GET request
}
?>

    <main>
        <nav>
            <?php echo navigation( $current_subject, $current_page ); ?>
        </nav>
        <div id="admin-page">
            
            <?php 
            if ( ! empty( $message ) ) {
                echo '<div class="message">' . htmlentities( $message ) . '</div>';
            }
            echo form_errors( $errors );
            ?>
            
            <h2>Edit Subject: <?php echo htmlentities( $current_subject[ 'menu_name' ] ); ?></h2>
            
            <form action="edit_subject.php?subject=<?php echo urlencode( $current_subject[ 'id' ] ); ?>" method="POST">
                <label>Subject name:
                    <input type="text" name="menu_name" value="<?php echo htmlentities( $current_subject[ 'menu_name' ] ); ?>">
                </label>
                <label>Position:
                    <select name="position">
                        <?php
                        $subject_set = find_all_subjects( false );
                        $subject_count = mysqli_num_rows( $subject_set );
                        
                        for ( $count = 1; $count <= $subject_count; $count++ ) {
                            echo "<option value='$count'";
                            if ( $current_subject[ 'position' ] == $count ) {
                                echo " selected";
                            }
                            echo ">$count</option>";  
                        }
                        ?>
                    </select>
                </label>
                <label>Visible:
                    <input type="radio" name="visible" value="0" <?php
                           if ( $current_subject[ 'visible' ] == 0 ) { echo "checked"; }
                           ?>> No
                    &nbsp;
                    <input type="radio" name="visible" value="1" <?php
                           if ( $current_subject[ 'visible' ] == 1 ) { echo "checked"; }
                           ?>> Yes
                </label>
                <input type="submit" name="submit" value="Edit Subject">
            </form>
            
            <br>
            
            <a href="manage_content.php">Cancel</a>
            &nbsp;&nbsp;
            <a href="delete_subject.php?subject=<?php echo urlencode( $current_subject[ 'id' ] ); ?>" onclick="return confirm( 'Are you sure you want to delete <?= $current_subject[ 'id' ]; ?>?' );">Delete subject</a>
            
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>
