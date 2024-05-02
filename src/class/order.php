<?php

class Order
{
    public $id;
    public $driverName;
    public $passengerName;
    public $driverPhone;
    public $passengerPhone;
    public $carNumber;
    public $status;

    public function __construct($id, $driverName, $passengerName, $driverPhone, $passengerPhone, $carNumber, $status)
    {
        $this->id = $id;
        $this->driverName = $driverName;
        $this->passengerName = $passengerName;
        $this->driverPhone = $driverPhone;
        $this->passengerPhone = $passengerPhone;
        $this->carNumber = $carNumber;
        $this->status = $status;
    }

    public function validate()
    {
        $errors = [];
        if (empty($this->driverName)) {
            $errors['driverNameError'] = "Требуется имя водителя.";
        }
        if (empty($this->passengerName)) {
            $errors['passengerNameError'] = "Требуется имя пассажира.";
        }
        if (empty($this->driverPhone)) {
            $errors['driverPhoneError'] = "Требуется номер телефона водителя.";
        }
        if (empty($this->passengerPhone)) {
            $errors['passengerPhoneError'] = "Требуется номер телефона пассажира.";
        }
        if (empty($this->carNumber)) {
            $errors['carNumberError'] = "Требуется номер автомобиля.";
        }
        if (empty($this->status)) {
            $errors['statusError'] = "Статус обязателен.";
        }
        return $errors;
    }
}

