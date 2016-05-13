<?php $layout_context = 'admin'; ?>
<?php include( '../includes/header.php' ); ?>
    <main>
        <nav>
            &nbsp;
        </nav>
        <div id="admin-page">
            <h2>Admin Menu</h2>
            <p>Welcome to the admin area.</p>
            <ul>
                <li><a href="manage_content.php">Manage Website Content</a></li>
                <li><a href="manage_admins.php">Manage Admin Users</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </main>
<?php include( '../includes/footer.php' ); ?>