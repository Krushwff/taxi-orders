<?php

class OrderManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function fetchOrder($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
        return new Order($order['id'], $order['driver_name'], $order['passenger_name'], $order['driver_phone'], $order['passenger_phone'], $order['car_number'], $order['status']);
    }

    public function updateOrder($order)
    {
        $stmt = $this->conn->prepare("UPDATE orders SET driver_name = ?, passenger_name = ?, driver_phone = ?, passenger_phone = ?, car_number = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $order->driverName, $order->passengerName, $order->driverPhone, $order->passengerPhone, $order->carNumber, $order->status, $order->id);
        $status = $stmt->execute();
        $stmt->close();
        return $status;
    }

    public function createOrder(Order $order)
    {
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


