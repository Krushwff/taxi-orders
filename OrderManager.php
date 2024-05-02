<?php
class OrderManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchOrder($id) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
        return new Order($order['id'], $order['driver_name'], $order['passenger_name'], $order['driver_phone'], $order['passenger_phone'], $order['car_number'], $order['status']);
    }

    public function updateOrder($order) {
        $stmt = $this->conn->prepare("UPDATE orders SET driver_name = ?, passenger_name = ?, driver_phone = ?, passenger_phone = ?, car_number = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $order->driverName, $order->passengerName, $order->driverPhone, $order->passengerPhone, $order->carNumber, $order->status, $order->id);
        $status = $stmt->execute();
        $stmt->close();
        return $status;
    }
    public function createOrder(Order $order) {
        $sql = "INSERT INTO orders (driver_name, passenger_name, driver_phone, passenger_phone, car_number, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssss", $order->driverName, $order->passengerName, $order->driverPhone, $order->passengerPhone, $order->carNumber, $order->status);

        return $stmt->execute();
    }

    public function deleteOrder($id)
    {
        $query = "DELETE FROM orders WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}



class Views
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllOrders()
    {
        $query = "SELECT * FROM orders";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }

    public function getStatusStyle($status)
    {
        switch ($status) {
            case "Заказ в процессе":
                return "background-color: yellow;";
            case "Заказ выполнен":
                return "background-color: green;";
            case "Заказ отменен":
                return "background-color: red;";
            default:
                return "";
        }
    }

    public function displayOrdersTable()
    {
        // Retrieve orders
        $orders = $this->getAllOrders();

        if ($orders && mysqli_num_rows($orders) > 0) {
            echo "<table class='table table-bordered table-striped'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ФИО водителя</th>
                    <th>Имя пассажира</th>
                    <th>Номер водителя</th>
                    <th>Номер пассажира</th>
                    <th>Номер машины</th>
                    <th>Состояние заказа</th>
                    <th>Действия</th>
                  </tr>
                </thead>
                <tbody>";

            while ($order = mysqli_fetch_array($orders)) {
                echo "<tr>
                    <td>" . $order['id'] . "</td>
                    <td>" . $order['driver_name'] . "</td>
                    <td>" . $order['passenger_name'] . "</td>
                    <td>" . $order['driver_phone'] . "</td>
                    <td>" . $order['passenger_phone'] . "</td>
                    <td>" . $order['car_number'] . "</td>
                    <td style='" . $this->getStatusStyle($order['status']) . "'>" . $order['status'] . "</td>
                    <td>
                      <a href='edit.php?id=" . $order['id'] . "' title='Edit Order' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>
                      <a href='delete.php?id=" . $order['id'] . "' title='Delete Order' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>
                    </td>
                  </tr>";
            }

            echo "</tbody></table>";
            mysqli_free_result($orders);
        } else {
            echo "<p class='lead'><em>No records found.</em></p>";
        }
    }
}

