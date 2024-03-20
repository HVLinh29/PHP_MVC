<?php
include 'inc/header.php';
?>
<?php
if (!isset($_GET['catid']) || $_GET['catid'] == NULL) {
	echo "<script>window.location = '404.php'</script>";
} else {
	$id = $_GET['catid'];
}
// if($_SERVER['REQUEST_METHOD']=== 'POST'){
// 	$catName = $_POST['catName'];
// 	$updateCat = $cat->update_category($catName,$id);
// }
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['themgiohang'])) {

	$soluong = $_POST['soluong'];
	$product_stock = $_POST['stock'];
	$id = $_POST['productId'];
	$insertCart = $ct->add_to_cart($soluong, $product_stock, $id);
	if($insertCart){
		echo "<script>window.location = 'cart.php'</script>";
	}
}
?>
<div class="main">
	<div class="content">
		<div class="content_top">
		<?php
			$name_cat = $cat->get_name_by_cat($id);
			if ($name_cat) {
				while ($result = $name_cat->fetch_assoc()) {
			?>
			<div class="heading">
				<h3>Danh Muc:<?php echo $result['catName']?> </h3>
			</div>
			<?php
				}
			}
			?>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$productbycat = $cat->get_product_by_cat($id);
			if ($productbycat) {
				while ($resultbycat = $productbycat->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="preview-3.php"><img src="admin/uploads/<?php echo $resultbycat['hinhanh']?>" alt="" /></a>
						<h2><?php echo $resultbycat['productName']?> </h2>
						<p><?php echo $fm->textShorten($resultbycat['mota'],50)?></p>
						<p><span class="price"><?php echo $resultbycat['price'].' '.'VND'?></span></p>
						<form method="POST" action="">
							<input type="hidden" name="soluong" value="1" />
							<input type="hidden" name="stock" value="<?php echo $resultbycat['product_quantity'] ?>" />
							<input type="hidden" name="productId" value="<?php echo $resultbycat['productId'] ?>" />
							<input type="submit" name="themgiohang" value="Them gio hang" class="btn btn-success ">
						</form>
						<div class="button"><span><a href="details.php?proid=<?php echo $resultbycat['productId']?>" class="details">Chi tiet</a></span></div>					</div>
			<?php
				}
			}else{
				echo 'Khong co san pham';
			}
			?>

		</div>



	</div>
</div>
<?php
include 'inc/footer.php';
?>