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
        if ($orderManager->createOrder($order)) {
            header("Location: index.php");
            exit; // Добавляем выход после перенаправления, чтобы предотвратить выполнение остального кода
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="rus">
<head>
    <meta charset="UTF-8">
    <title>Create Order</title>
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
                    <h2>Создать заказ</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="id">

                    <div class="form-group <?php echo (!empty($errors['driverNameError'])) ? 'has-error' : ''; ?>">
                        <label for="driver_name">Имя водителя</label>
                        <input type="text" id="driver_name" name="driver_name" class="form-control" placeholder="Имя водителя">
                        <span class="help-block"><?php echo $errors['driverNameError'] ?? ''; ?></span>
                    </div>

                    <!-- Номер телефона водителя -->
                    <div class="form-group <?php echo (!empty($errors['driverPhoneError'])) ? 'has-error' : ''; ?>">
                        <label for="driver_phone">Номер телефона водителя</label>
                        <input type="text" id="driver_phone" name="driver_phone" class="form-control" placeholder="Номер телефона водителя">
                        <span class="help-block"><?php echo $errors['driverPhoneError'] ?? ''; ?></span>
                    </div>

                    <!-- Имя пассажира -->
                    <div class="form-group <?php echo (!empty($errors['passengerNameError'])) ? 'has-error' : ''; ?>">
                        <label for="passenger_name">Имя пассажира</label>
                        <input type="text" id="passenger_name" name="passenger_name" class="form-control" placeholder="Имя пассажира">
                        <span class="help-block"><?php echo $errors['passengerNameError'] ?? ''; ?></span>
                    </div>

                    <!-- Номер телефона пассажира -->
                    <div class="form-group <?php echo (!empty($errors['passengerPhoneError'])) ? 'has-error' : ''; ?>">
                        <label for="passenger_phone">Номер телефона пассажира</label>
                        <input type="text" id="passenger_phone" name="passenger_phone" class="form-control" placeholder="Номер телефона пассажира">
                        <span class="help-block"><?php echo $errors['passengerPhoneError'] ?? ''; ?></span>
                    </div>

                    <!-- Номер машины -->
                    <div class="form-group <?php echo (!empty($errors['carNumberError'])) ? 'has-error' : ''; ?>">
                        <label for="car_number">Номер машины</label>
                        <input type="text" id="car_number" name="car_number" class="form-control" placeholder="Номер машины">
                        <span class="help-block"><?php echo $errors['carNumberError'] ?? ''; ?></span>
                    </div>

                    <!-- Состояние заказа -->
                    <div class="form-group <?php echo (!empty($errors['statusError'])) ? 'has-error' : ''; ?>">
                        <label for="status">Состояние заказа</label>
                        <select name="status" id="status" class="form-control">
                            <option value="Заказ в процессе">Заказ в процессе</option>
                            <option value="Заказ выполнен">Заказ выполнен</option>
                            <option value="Заказ отменен">Заказ отменен</option>
                        </select>
                        <span class="help-block"><?php echo $errors['statusError'] ?? ''; ?></span>
                    </div>


                    <input type="submit" class="btn btn-primary" value="Создать">
                    <a href="index.php" class="btn btn-default">Отменить</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>