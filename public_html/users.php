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
    <title>Users</title>

    <link rel="stylesheet" href="src/css/style.css">
    <script defer src="src/js/index.js"></script>
</head>
<body class="section-home">
    <?php include $rootDir.'/includes/sidebar.php'; ?>

    <div class="section-home__wrapper">
        <div class="section-users">
            <h1 class="h__1 h__sb">Users</h1>  

            <div class="section-users__filters">
                <p id="order-filters" data-f="" class="btn-chip active">All</p>
                <p id="order-filters" data-f="driver" class="btn-chip">Driver</p>
                <p id="order-filters" data-f="rider" class="btn-chip">Ryder</p>
                <p id="order-filters" data-f="both" class="btn-chip">Driver & Ryder</p>
            </div>

            <div class="table__users" id="table-users">
                <div class="table__users__h">
                    <div class="table__users__h--el">Name</div>
                    <div class="table__users__h--el">Role</div>
                    <div class="table__users__h--el">Vehicle</div>
                    <div class="table__users__h--el">Vehicle no.</div>
                    <div class="table__users__h--el">City</div>
                    <div class="table__users__h--el">Email</div>
                    <div class="table__users__h--el">Phone no.</div>
                </div>

                <div class="table__users__b">
                   <p class="p__4 p__r notfound">Loading...</p>
                </div>
            </div>
            <div class="table__pagination" id="table__pagination">
            </div>
        </div>
    </div>

    <div class="sidebar-overlay"></div>
</body>
</html>