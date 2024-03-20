
<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
$login_check = Session::get('customer_login');
if ($login_check == false) {
    header(('Location:login.php'));
} 
?>
<div class="main">
    <div class="content">
        <div class="cartoption">
            <div class="cartpage">
                <div class="order_page">
                    <h3> Order Pages</h3>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <?php
    include 'inc/footer.php';
    ?>