<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
        if (isset($_GET['orderid']) && $_GET['orderid'] == 'order') {
            $customers_id = Session::get('customer_id');
            $insertOrder = $ct->inserOrder($customers_id);
            $delCart = $ct->del_all_data_cart();
            header('Location:success.php');
        } 
        ?>
<form action="" method="POST">
    <div class="main">
        <div class="content">
            <div class="section group">
                <h2>Success Order</h2>
                <?php
                 $customers_id = Session::get('customer_id');
                $get_amount = $ct->getAmountPrice($customers_id);
                if($get_amount){
                    $amount = 0;
                    while($result = $get_amount->fetch_assoc()){
                        $price = $result['price'];
                        $amount += $price;
                    }
                }
                ?>
                <p> Tong tien ban da mua tu Website :<?php $vat =$amount*0.1; $total= $vat +$amount; echo $fm->format_currency($total).' '.'VND'?></p>
                <p>Chung toi se  lien lac som nhat. Lam on xem lai gio hang tai day <a href="orderdetails.php">Click here</a></p>
            </div>
        </div>
        <center><a href="?orderid=order" class="submit_order">Order Now</a></center>
    </div>
</form>
<?php
include 'inc/footer.php';
?>
<style>
    .box_left {
        width: 50%;
        border: 1px solid #666;
        float: left;
        padding: 4px;
    }

    .box_right {
        width: 46%;
        border: 1px solid #666;
        float: left;
        padding: 4px;
    }
    a.submit_order{
        padding: 10px 70px;
        background: red;
        font-size: 25px;
        color: #fff;
       
        cursor: pointer;
    }
</style>