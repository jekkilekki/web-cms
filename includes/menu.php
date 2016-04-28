<nav>
    <ul class="subjects">
        <?php 
            $subject_set = find_all_subjects();    
            while( $subject = mysqli_fetch_assoc( $subject_set ) ) : 
        ?>
        <?php 
            echo '<li'; 
            if ( $subject[ 'id' ] == $selected_subject_id ) {
                echo ' class="selected"';
            } 
            echo '>';
        ?>
            <a href="manage_content.php?subject=<?php echo urlencode( $subject[ 'id' ] ); ?>">
                <?php echo $subject[ 'menu_name' ]; ?>
            </a>
            <?php find_pages_for_subject( $subject[ 'id' ]; ?>
            <ul class="pages">
                <?php while( $page = mysqli_fetch_assoc( $page_set ) ) : ?>
                    <?php 
                        echo '<li'; 
                        if ( $page[ 'id' ] == $selected_page_id ) {
                            echo ' class="selected"';
                        } 
                        echo '>';
                    ?>
                        <a href="manage_content.php?page=<?php echo urlencode( $page[ 'id' ] ); ?>">
                            <?php echo $page[ 'menu_name' ]; ?>
                        </a>
                    </li>
                <?php endwhile; ?>
                <?php mysqli_free_result( $page_set ); ?>
            </ul>
        </li>
    <?php endwhile; ?>
    <?php mysqli_free_result( $subject_set ); ?>
    </ul>
</nav>