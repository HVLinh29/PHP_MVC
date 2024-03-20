<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
include($filepath . '/../lib/session.php');

$db = new database();
if (isset($_POST['index'])) {
    $index = $_POST['index'];
    $product_id = $_POST['product_id'];
    $customerId = $_POST['customer_id'];
    $query = "INSERT INTO tbl_rating(rating,product_id,customer_id) VALUES('$index','$product_id', '$customerId') ";

    $result = $db->insert($query);
    if ($result) {
        echo 'Thanh cong';
    }
}
?>