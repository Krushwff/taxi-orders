<?php
require_once "src/app.php";

$orderManager = new OrderManager($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order = new Order(
        $_POST["id"],
        $_POST["driver_name"],
        $_POST["passenger_name"],
        $_POST["driver_phone"],
        $_POST["passenger_phone"],
        $_POST["car_number"],
        $_POST["status"]
    );
    $errors = $order->validate();

    if (empty($errors)) {
        if ($orderManager->updateOrder($order)) {
            header("Location: index.php");
            exit;
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
} else if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);
    $order = $orderManager->fetchOrder($id);

    $driverName = $order->driverName;
    $passengerName = $order->passengerName;
    $driverPhone = $order->driverPhone;
    $passengerPhone = $order->passengerPhone;
    $carNumber = $order->carNumber;
    $status = $order->status;
    // Продолжить этот паттерн для других полей
} else {
    echo "Error fetching record.";
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="rus">
<head>
    <meta charset="UTF-8">
    <title>Редактировать заказ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        .wrapper { width: 1200px; margin: 0 auto; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Редактировать заказ</h2>
                </div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order->id); ?>">

    <div class="form-group <?php echo (!empty($errors['driverNameError'])) ? 'has-error' : ''; ?>">
        <label for="driver_name">Имя водителя</label>
        <input type="text" id="driver_name" name="driver_name" class="form-control" value="<?php echo htmlspecialchars($order->driverName); ?>">
        <span class="help-block"><?php echo $errors['driverNameError'] ?? ''; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($errors['driverPhoneError'])) ? 'has-error' : ''; ?>">
        <label for="driver_phone">Номер телефона водителя</label>
        <input type="text" id="driver_phone" name="driver_phone" class="form-control" value="<?php echo htmlspecialchars($order->driverPhone); ?>">
        <span class="help-block"><?php echo $errors['driverPhoneError'] ?? ''; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($errors['passengerNameError'])) ? 'has-error' : ''; ?>">
        <label for="passenger_name">Имя пассажира</label>
        <input type="text" id="passenger_name" name="passenger_name" class="form-control" value="<?php echo htmlspecialchars($order->passengerName); ?>">
        <span class="help-block"><?php echo $errors['passengerNameError'] ?? ''; ?></span>
    </div>

<div class="form-group <?php echo (!empty($errors['passengerPhoneError'])) ? 'has-error' : ''; ?>">
    <label for="passenger_phone">Номер телефона пассажира</label>
    <input type="text" id="passenger_phone" name="passenger_phone" class="form-control" value="<?php echo htmlspecialchars($order->passengerPhone); ?>">
    <span class="help-block"><?php echo $errors['passengerPhoneError '] ?? ''; ?></span>
</div>

    <div class="form-group <?php echo (!empty($errors['carNumberError'])) ? 'has-error' : ''; ?>">
        <label for="car_number">Номер машины</label>
        <input type="text" id="car_number" name="car_number" class="form-control" value="<?php echo htmlspecialchars($order->carNumber); ?>">
        <span class="help-block"><?php echo $errors['carNumberError'] ?? ''; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($errors['statusError'])) ? 'has-error' : ''; ?>">
        <label for="status">Состояние заказа</label>
        <select name="status" id="status" class="form-control">
            <option value="Заказ в процессе" <?php echo ($order->status === "Заказ в процессе") ? 'selected' : ''; ?>>Заказ в процессе</option>
            <option value="Заказ выполнен" <?php echo ($order->status === "Заказ выполнен") ? 'selected' : ''; ?>>Заказ выполнен</option>
            <option value="Заказ отменен" <?php echo ($order->status === "Заказ отменен") ? 'selected' : ''; ?>>Заказ отменен</option>
        </select>
        <span class="help-block"><?php echo $errors['statusError'] ?? ''; ?></span>
    </div>

    <input type="submit" class="btn btn-primary" value="Применить">
    <a href="index.php" class="btn btn-default">Отменить</a>
</form>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="src/js/mask.js"></script>
</body>
</html>
