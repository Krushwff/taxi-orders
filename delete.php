<?php
require_once "src/app.php";

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];

    $orderRepository = new OrderManager($conn);
    if ($orderRepository->deleteOrder($id)) {
        header("location: index.php");
    } else {
        echo "Something went wrong. Please try again later.";
    }
} else {
    if (empty(trim($_GET["id"]))) {
        echo "Something went wrong. Please try again later.";
        header("location: index.php");
        exit();
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Удалить заказ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Удалить заказ</h1>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                        <p>Вы уверены что хотите удалить заказ?</p><br>
                        <p>
                            <input type="submit" value="Да" class="btn btn-danger">
                            <a href="index.php" class="btn btn-default">Нет</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
