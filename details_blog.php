<?php
include 'inc/header.php';
include 'inc/slider.php';
?>
<?php
if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
	echo "<script>window.location = '404.php'</script>";
} else {
	$id = $_GET['proid'];
}
// if($_SERVER['REQUEST_METHOD']=== 'POST'){
// 	$catName = $_POST['catName'];
// 	$updateCat = $cat->update_category($catName,$id);
// }
?>
<div class="main">
	<div class="content">
    <?php
			$name_cat = $pt->getpostbyid($id);
			if ($name_cat) {
				while ($result = $name_cat->fetch_assoc()) {
			?>
		<div class="content_top">
		
					<div class="heading">
						<h3><?php echo $result['title'] ?> </h3>
					</div>
		
			<div class="clear"></div>
		</div>
		<div class="section group">
		
					<div class="col-md-12">
				
						<p><?php echo $result['title'] ?></p>
                        <p><?php echo $result['content'] ?></p>
					</div>
                    <?php
				}
			}
			?>

		</div>



	</div>
</div>
<?php
include 'inc/footer.php';
?>