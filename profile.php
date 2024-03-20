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
            <h3>Profile Customer</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
           
            <table class="tblone">
                <?php
                $id =Session::get('customer_id');
                $get_customers = $cs->show_customer($id);
                if($get_customers){
                    while($result = $get_customers->fetch_assoc()){
                
                ?>
                <tr>
                  <td>Ten</td>
                  <td>:</td>
                  <td><?php echo $result['name']?></td>
                </tr>
                <tr>
                  <td>Thanh pho</td>
                  <td>:</td>
                  <td><?php echo $result['city']?></td>
                </tr>
                <tr>
                  <td>So dien thoai</td>
                  <td>:</td>
                  <td><?php echo $result['phone']?></td>
                </tr>
                <tr>
                  <td>Que Quan</td>
                  <td>:</td>
                  <td><?php echo $result['country']?></td>
                </tr>
                <tr>
                  <td>Zipcode</td>
                  <td>:</td>
                  <td><?php echo $result['zipcode']?></td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <td><?php echo $result['email']?></td>
                </tr>
                <tr>
                  <td>Dia chi</td>
                  <td>:</td>
                  <td><?php echo $result['address']?></td>
                </tr>
                <tr>
                  <td colspan="3"><a href="editprofile.php">Update Profile</a></td>
                  
                </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>
<?php
include 'inc/footer.php';
?>