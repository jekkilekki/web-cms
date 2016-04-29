<?php 
require_once( '../private/session.php' );
include( '../includes/header.php' );

find_selected_page(); 
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
            
            <h2>Create New Subject</h2>
            
            <form action="create_subject.php" method="POST">
                <label>Subject name:
                    <input type="text" name="menu_name" value="">
                </label>
                <label>Position:
                    <select name="position">
                        <?php
                        $subject_set = find_all_subjects();
                        $subject_count = mysqli_num_rows( $subject_set );
                        
                        for ( $count = 1; $count <= $subject_count + 1; $count++ ) {
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
                <input type="submit" name="submit" value="Create Subject">
            </form>
            
            <br>
            
            <a href="manage_content.php">Cancel</a>
            
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>
