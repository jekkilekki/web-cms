<?php require_once( '../private/db_connection.php' ); ?>
<?php require_once( '../includes/functions.php' ); ?>

<?php 
if ( ! isset( $layout_context ) ) {
    $layout_context = 'public';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>JKL CMS <?php echo $layout_context == "admin" ? 'Admin' : ''; ?></title>
    <link href="css/style.css" media="all" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <h1>JKL CMS <?php echo $layout_context == "admin" ? 'Admin' : ''; ?></h1>
    </header>