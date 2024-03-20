<?php
include 'inc/header.php';
?>
<?php
$login_check = Session::get('customer_login');
if ($login_check == false) {
    header('Location:login.php');
} 
?>
<?php
if (isset($_GET['danhanhang'])) {
	$danhanhang = $_GET['danhanhang'];
	$danhanhang = $ct->danhanhang($danhanhang);
	if($danhanhang){
		echo "<script>window.location = 'lichsudonhang.php'</script>";
	}


}
?>
<div class="main">
    <div class="content">
        <div class="section group">
        <div class="content_top">
    		<div class="heading">
            <h3 class="payment">Lich su don hang</h3>
    		</div>
    		<div class="clear"></div>
            <div class="wrapper_method">
            <table class="table table-striped table-hover table-bordered" id="example">
				<thead>
					<tr>
						<th>STT</th>
						<th>Thoi gian dat</th>
						<th>Order code</th>					
						<th>Customer Name</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$ct = new cart();
					$fm = new Format();
					$get_inbox_cart = $ct->get_inbox_cart_history(Session::get('customer_id'));
					$i = 0;
					if ($get_inbox_cart) {
						while ($result = $get_inbox_cart->fetch_assoc()) {
							$i++;


					?>
							<tr class="odd gradeX">
								<td><?php echo $i ?></td>
								<td><?php echo $fm->formatDate($result['date_created']) ?></td>
								<td><?php echo $result['order_code'] ?></td>
								<!-- <td><?php echo $result['soluong'] ?></td>
								<td><?php echo $result['price'] . ' ' . 'VND' ?></td> -->
								<td><?php echo $result['name'] ?></td>
								<td>
									<?php
									if ($result['status'] == 1) {
									?>
										<a href="?danhanhang=<?php echo $result['order_code'] ?>">Da nhan hang</a>

										<?php
									} elseif ($result['status'] == 2) {
										?>
                                        <?php
										echo 'Don hang thanh cong';
										?>
									
									<?php
									}
									?>
								</td>
								<td><a href="history_order_details.php?customerid=<?php echo $result['customer_id'] ?>&order_code=<?php echo $result['order_code'] ?>">View Order</a></td>
								
							</tr>
					<?php
						}
					}
					?>

				</tbody>
			</table>
                
            </div>
    	</div>
        </div>
    </div>
</div>

<?php
include 'inc/footer.php';
?>
