<?php 
require_once( '../private/session.php' );

$layout_context = 'admin';
include( '../includes/header.php' );

find_selected_page(); 

// Can't add a new page unless we have a subject as a parent!
if ( ! $current_subject ) {
    redirect_to( 'manage_content.php' );
}

if ( isset( $_POST[ 'submit' ] ) ) {
    // Process the form
    // validations
    $required_fields = array( 'menu_name', 'position', 'visible', 'content' );
    validate_presences( $required_fields );
    
    $fields_with_max_lengths = array( 'menu_name' => 30 );
    validate_max_lengths( $fields_with_max_lengths );
    
    if ( empty( $errors ) ) {
        // Perform create
        
        // make sure you add the subject_id!
        $subject_id = $current_subject[ 'id' ];
        $menu_name = mysql_prep( $_POST[ 'menu_name' ] );
        $position = (int) $_POST[ 'position' ];
        $visible = (int) $_POST[ 'visible' ];
        // be sure to escape the content
        $content = mysql_prep( $_POST[ 'content' ] );
        
        $query  = "INSERT INTO pages (";
        $query .= " subject_id, menu_name, position, visible, content ";
        $query .= ") VALUES (";
        $query .= " $subject_id, '$menu_name', $position, $visible, '$content' ";
        $query .= ")";
        $result = mysqli_query( $db, $query );
        
        if ( $result ) {
            // Success
            $_SESSION[ 'message' ] = "Page created.";
            redirect_to( 'manage_content.php?subject=' . urlencode( $current_subject[ 'id' ] ) );
        } else {
            // Failure
            $_SESSION[ 'message' ] = "Page creation failed.";
        }
    } else {
        // This is probably a GET request
    }
}
?>

    <main>
        <nav>
            <?php echo navigation( $current_subject, $current_page ); ?>
        </nav>
        <div id="admin-page">
            
            <?php 
            echo message(); 
            $errors = errors();
            echo form_errors( $errors );
            ?>
            
            <h2>Create New Page</h2>
            
            <form action="new_page.php?subject=<?php echo urlencode( $current_subject[ 'id' ] ); ?>" method="POST">
                <label>Subject name:
                    <input type="text" name="menu_name" value="">
                </label>
                <label>Position:
                    <select name="position">
                        <?php
                        $page_set = find_pages_for_subject( $current_subject[ 'id' ], false );
                        $page_count = mysqli_num_rows( $page_set );
                        
                        for ( $count = 1; $count <= $page_count + 1; $count++ ) {
                            echo "<option value=\"$count\">$count</option>";  
                        }
                        ?>
                    </select>
                </label>
                <label>Visible:
                    <input type="radio" name="visible" value="0"> No
                    &nbsp;
                    <input type="radio" name="visible" value="1"> Yes
                </label>
                <label>Content:
                    <textarea name="content" rows="20" cols="80"></textarea>
                </label>
                <input type="submit" name="submit" value="Create Page">
            </form>
            
            <br>
            
            <a href="manage_content.php?subject=<?php echo urlencode( $current_subject[ 'id' ] ); ?>">Cancel</a>
            
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>
