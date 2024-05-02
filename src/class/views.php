<?php
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
            echo "<p class='lead'><em>Записей не найдено.</em></p>";
        }
    }
}