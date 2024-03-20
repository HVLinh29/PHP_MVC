<?php
include 'inc/header.php';
?>
<?php
$login_check = Session::get('customer_login');
if ($login_check == false) {
    header('Location:login.php');
}
?>
<!-- <?php
        if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
            echo "<script>window.location = '404.php'</script>";
        } else {
            $id = $_GET['proid'];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $soluong = $_POST['soluong'];
            $Addtocart = $ct->add_to_cart($soluong, $id);
        }
        ?> -->
<div class="main">
    <div class="content">
        <div class="section group">
            <div class="content_top">
                <div class="heading">
                    <h3>Thanh toan</h3>
                </div>
                <div class="clear"></div>
                <div class="wrapper_method">
                    <h3 class="payment">Chon phuong thuc thanh toan</h3>
                    <p><a class="btn btn-success" href="donhangthanhtoanOL.php">Thanh toan VNPAY</a></p>
                    <p><a class="btn btn-danger" href="donhangthanhtoanOL.php">Thanh toan MOMO</a></p>
                    </br><br>
                    <a style="background: grey;" href="cart.php">Quay về</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'inc/footer.php';
?>
<style>
    h3.payment {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        text-decoration: underline;
    }

    .wrapper_method {
        text-align: center;
        width: 550px;
        margin: 0 auto;
        border: 1px solid #666;
        padding: 20px;
        background: cornsilk;
    }

    .wrapper_method a {
        padding: 10px;
        background: red;
        color: #fff;
    }

    .wrapper_method h3 {
        margin-bottom: 20px;
    }
</style>