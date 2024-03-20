<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/brand.php';?>
<?php include '../classes/category.php'; ?>
<?php include '../classes/product.php'; ?>
<?php include_once '../helpers/format.php'; ?>
<?php
$pd = new product();
$fm = new Format();
if (isset($_GET['productid']) ) {
	$id = $_GET['productid'];
	$delSP = $pd->del_product($id);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sach san pham</h2>
        <div class="block">  
		<?php
			if (isset($delSP)) {
				echo $delSP;
			}
			?>
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>Id</th>
					<th>Ten san pham</th>
					<th>So luong SP</th>
					<th>Gia</th>
					<th>Hinh anh</th>
					<th>Danh muc</th>
					<th>Thuong hieu</th>
					<th>Mo ta</th>
					<th>Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				
				$pdlist = $pd->show_product();
				if($pdlist){
					$i=0;
					while($result = $pdlist->fetch_assoc()){
					$i++;
				
				?>
				<tr class="odd gradeX">
					<td><?php echo $i?></td>
					<td><?php echo $result['productName']?></td>
					<td><?php echo $result['product_quantity']?></td>
					<td><?php echo $result['price']?></td>
					<td><img src=uploads/<?php echo $result['hinhanh']?> width="100px"></td>
					<td><?php echo $result['catName']?></td>
					<td><?php echo $result['brandName']?></td>
					<td><?php echo $fm->textShorten($result['mota'],50)?></td>
					<td>
						<?php if($result['type']==0){
							echo " Noi bat";
						}else{
							echo " Khong noi bat";
						}
							?>
					</td>

					<td><a href="productedit.php?productid=<?php echo $result['productId']?>">Edit</a> || 
					<a href="?productid=<?php echo $result['productId']?>">Delete</a></td>
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
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
