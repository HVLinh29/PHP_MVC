<?php
include 'inc/header.php';
include 'inc/slider.php';
?>
<?php
if (!isset($_GET['idpost']) || $_GET['idpost'] == NULL) {
	echo "<script>window.location = '404.php'</script>";
} else {
	$id = $_GET['idpost'];
}
// if($_SERVER['REQUEST_METHOD']=== 'POST'){
// 	$catName = $_POST['catName'];
// 	$updateCat = $cat->update_category($catName,$id);
// }
?>
<div class="main">
	<div class="content">
		<div class="content_top">
			<?php
			$name_cat = $pt->getpost($id);
			if ($name_cat) {
				while ($result = $name_cat->fetch_assoc()) {
			?>
					<div class="heading">
						<h3>Danh muc :<?php echo $result['title'] ?> </h3>
					</div>
			<?php
				}
			}
			?>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$postbycat = $pt->get_post_by_cat($id);
			if ($postbycat) {
				while ($result = $postbycat->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details_blog.php?blogid=<?php echo $result['id'] ?>"><img src="admin/uploads/<?php echo $result['hinhanh'] ?>" alt="" /></a>
						<p><?php echo $result['title'] ?></p>
						<p><?php echo $fm->textShorten($result['mota'], 50) ?></p>
						<div class="button"><span><a href="details_blog.php?proid=<?php echo $result['id'] ?>" class="details">Chi tiet</a></span></div>
					</div>
			<?php
				}
			} else {
				echo 'Hien tai chua co tin tuc thuoc danh muc nay';
			}
			?>

		</div>



	</div>
</div>
<?php
include 'inc/footer.php';
?>