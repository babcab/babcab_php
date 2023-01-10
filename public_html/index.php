<?php
$rootDir = $_SERVER['DOCUMENT_ROOT'];
$filename = basename(__FILE__, '.php');

// Redirect Driver
include $rootDir.'/includes/redirectuser.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="src/css/style.css">
    <script defer src="src/js/index.js"></script>
</head>
<body class="section-home">
    <?php include $rootDir.'/includes/sidebar.php'; ?>


    <div class="sidebar-overlay"></div>
</body>
</html>