<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style>
        .wrapper { width: 1200px; margin: 0 auto; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Заказы</h2>
                    <a href="create.php" class="btn btn-success pull-right">Создать новый заказ</a>
                </div>
                <?php
                require_once "src/app.php";
                $order = new Views($conn);
                $order->displayOrdersTable();

                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
