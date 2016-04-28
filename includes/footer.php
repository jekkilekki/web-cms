    <footer>
        <p>&copy; 20xx, Aaron Snowberger</p>
    </footer>
</body>
</html>

<?php
// 5. Close database connection
if ( isset( $db ) ) { // not all pages will use the $db
    mysqli_close( $db );   
}
?>