<?php
ini_set( 'display_errors', 'On' );
require_once( '../private/session.php' );
confirm_logged_in();

$layout_context = 'admin';
include( '../includes/header.php' );

$admin_set = find_all_admins(); 
?>

    <main>
        <nav>
            <br>
            <a href="admin.php">&laquo; Main menu</a>
            <br>
        </nav>
        <div id="admin-page">
            
            <?php echo message(); ?>
            
            <h2>Manage Admins</h2>
            <table class="admin-table">
                <tr>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
                <?php while( $admin = mysqli_fetch_assoc( $admin_set ) ) { ?>
                <tr>
                    <td><?php echo htmlentities( $admin[ 'username' ] ); ?></td>
                    <td><a href="edit_admin.php?id=<?php echo urlencode( $admin[ 'id' ] ); ?>">Edit</a></td>
                    <td><a href="delete_admin.php?id=<?php echo urlencode( $admin[ 'id' ] ); ?>" onclick="return confirm( 'Are you sure?' );">Delete</a></td>
                </tr>
                <?php } ?>
            </table>
            <br>
            <a href="new_admin.php">Add new admin</a>
            <hr>
            <?php
            
            $password = "secret";
            $hash_format = "$2y$10$"; // 2y = use Blowfish, 10 = cost param (how many times to run it - more = slower)
            $salt = "Salt22CharactersOrMore"; // Blowfish wants 22 char or longer - longer salts truncate to 22 chars - pads with $$$$ if shorter
            echo "Length: " . strlen( $salt );
            $format_and_salt = $hash_format . $salt;
            
            $hash = crypt( $password, $format_and_salt );
            echo '<br>';
            echo $hash;
            
            // Someone logging in
            $hash2 = crypt( "secret", $hash );
            echo '<br>';
            echo $hash2;
            ?>
        </div>
    </main>

<?php include( '../includes/footer.php' ); ?>
