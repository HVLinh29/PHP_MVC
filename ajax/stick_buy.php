<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/format.php');
?>
<?php
$db = new database();
$id_cart = $_POST['id_cart'];
$cart_status = $_POST['cart_status'];
    $query = "UPDATE tbl_cart SET tbl_cart.status = '$cart_status' WHERE cartId = '$id_cart' ";

    $result = $db->update($query);
    if($result){
       echo 'Update thanh cong';

    }
    else{
        echo 'Update khong thanh cong';
       
    }
    

?>