<?php

class Guest extends DB_Object
{
    protected static $db_table = "tblguest";
    protected static $db_table_fields = array(
        'id',
        'booking_id',
        'fullname',
        'address',
        'priority',
        'relationship',
        'message',
        'city'
    );

    public $id;
    public $booking_id;
    public $fullname;
    public $address;
    public $city;
    public $priority;
    public $relationship;
    public $message;

    public static function getGuest($booking_id) {
        global $db;
        $sql = "SELECT * FROM tblguest WHERE booking_id = $booking_id";
        $result_set = $db->query($sql);
        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiation($row);
        }

        return $the_object_array;
    }

    public static function count_guest($id) {
        global $db;
        $sql = "SELECT count(booking_id) FROM " .static::$db_table." WHERE booking_id = $id";
        $result_count = $db->query($sql);
        $row = mysqli_fetch_array($result_count);
        return array_shift($row);
    }


}

?>


