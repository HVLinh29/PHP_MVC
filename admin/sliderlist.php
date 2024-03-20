<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/product.php'; ?>
<?php
$product = new product();
if(isset($_GET['update_slider']) && isset($_GET['type'])){
	$id = $_GET['update_slider']; 
	$type = $_GET['type'];
	$update_type_slider = $product->update_type_slider($id ,$type);
}
if(isset($_GET['del_slider'])) {
	$id = $_GET['del_slider']; 
	$del_slider = $product->del_slider($id);
}
?>
<div class="grid_10">
	<div class="box round first grid">
		<h2>Slider List</h2>
		<div class="block">
			<?php
			if (isset($del_slider)) {
				echo $del_slider;
			}
			?>
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>No.</th>
						<th>Slider Title</th>
						<th>Slider Image</th>
						<th>Type</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$product = new product();
					$get_slider = $product->show_slider_list();
					if ($get_slider) {
						$i=0;
						while ($result = $get_slider->fetch_assoc()) {
							$i++
					?>
							<tr class="odd gradeX">
								<td><?php echo $i?></td>
								<td><?php echo $result['sliderName']?></td>
								<td><img src="uploads/<?php echo $result['sliderimg']?>" height="120px" width="500px" /></td>
								<td>
									<?php if($result['type']==1){
									?> 
									<a href="?update_slider=<?php echo $result['sliderId']?>&type=0">Off</a>
									<?php
									}else{
										
									?>
									<a href="?update_slider=<?php echo $result['sliderId']?>&type=1">On</a>
									<?php
									}
									?>
								</td>
								<td>
								
									<a href="?del_slider=<?php echo $result['sliderId']?>" onclick="return confirm('Are you sure to Delete!');">Delete</a>
								</td>
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