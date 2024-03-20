<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../classes/cart.php');
include_once($filepath . '/../helpers/format.php');

?>
<?php
$ct = new cart();
if (isset($_GET['shiftid'])) {
	$id = $_GET['shiftid'];
	$shifted = $ct->shifted($id);
	if($shifted){
		echo "<script>window.location = 'inbox.php'</script>";
	}
}
if (isset($_GET['delid'])) {
	$id = $_GET['delid'];
	$del_shifted = $ct->del_shifted($id);
	if($del_shifted){
		echo "<script>window.location = 'inbox.php'</script>";
	}
}

?>
<div class="grid_10">
	<div class="box round first grid">
		<h2>Don hang da dat</h2>
		<div class="block">
			<?php
			if (isset($shifted)) {
				echo $shifted;
			};
			?>
			<?php
			if (isset($del_shifted)) {
				echo $del_shifted;
			};
			?>
			<table class="data display datatable" id="example">
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
					$get_inbox_cart = $ct->get_inbox_cart();
					$i = 0;
					if ($get_inbox_cart) {
						while ($result = $get_inbox_cart->fetch_assoc()) {
							$i++;


					?>
							<tr class="odd gradeX">
								<td><?php echo $i ?></td>
								<td><?php echo $fm->formatDate($result['date_created']) ?></td>
								<td><?php echo $result['order_code'] ?></td>
								<td><?php echo $result['name'] ?></td>
								<td>
									<?php
									if ($result['status'] == 0) {
									?>
										<a href="?shiftid=<?php echo $result['order_code'] ?>">Tinh trang moi</a>

										<?php
									} elseif ($result['status'] == 1) {
										?><?php
										echo 'Dang van chuyen hang';
										?>
									<?php
									} elseif ($result['status'] == 2) {
									?>
										<a href="?delid=<?php echo $result['order_code'] ?>">Da nhan | Xoa</a>

									<?php
									}
									?>
								</td>
								<td><a href="customer.php?customerid=<?php echo $result['customer_id'] ?>&order_code=<?php echo $result['order_code'] ?>">View Order</a></td>
								
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
<script type="text/javascript">
	$(document).ready(function() {
		setupLeftMenu();

		$('.datatable').dataTable();
		setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php'; ?>