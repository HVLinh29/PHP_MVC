<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/post.php'; ?>
<?php
$post = new post();
if (isset($_GET['delid']) ) {
	$id = $_GET['delid'];
	$delCat = $post->del_post($id);
}
?>
<div class="grid_10">
	<div class="box round first grid">
		<h2>Danh sach tin tuc</h2>
		<div class="block">
			<?php
			if (isset($delCat)) {
				echo $delCat;
			}
			?>
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>Id</th>
						<th>Ten danh muc</th>
						<th>Mo ta</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$show_post = $post->show_post();
					if ($show_post) {
						$i = 0;
						while ($result = $show_post->fetch_assoc()) {
							$i++;
					?>
							<tr class="odd gradeX">
								<td><?php echo $i ?></td>
								<td><?php echo  $result['title'] ?></td>
                                <td><?php echo  $result['mota'] ?></td>
                                <td><?php
                                if($result['status']==0){
                                    echo 'Hien thi';
                                }
                                else{
                                    echo 'An';
                                }
                                 ?></td>
								<td><a href="postedit.php?postid=<?php echo $result['id_cate_post'] ?>">Edit</a> ||
									<a onclick="return confirm('Ban co muon xoa danh muc nay?')" href="?delid=<?php echo $result['id_cate_post'] ?>">Delete</a>
								</td>
							</tr>
					<?php
						}
					} ?>
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