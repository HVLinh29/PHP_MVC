<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/post.php'; ?>
<?php include '../classes/blog.php'; ?>
<?php
$blog = new blog();
if (!isset($_GET['id']) || $_GET['id'] == NULL) {
    echo "<script>window.location = 'bloglist.php'</script>";
} else {
    $id = $_GET['id'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $updateBlog = $blog->update_blog($_POST, $_FILES, $id);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Sua tin tuc</h2>
        <div class="block">
            <?php
            if (isset($updateBlog)) {
                echo $updateBlog;
            }
            ?>
            <?php
            $get_blog_by_id = $blog->getblogbyId($id);
            if ($get_blog_by_id) {
                while ($resultBL = $get_blog_by_id->fetch_assoc()) {
            ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <table class="form">

                            <tr>
                                <td>
                                    <label>Title</label>
                                </td>
                                <td>
                                    <input type="text" name="title" value="<?php echo $resultBL['title'] ?>" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Category</label>
                                </td>
                                <td>
                                    <select id="select" name="category_post">
                                        <option>Select Category</option>
                                        <?php
                                        $post = new post();
                                        $catlist = $post->show_post();
                                        if ($catlist) {
                                            while ($result = $catlist->fetch_assoc()) {
                                        ?>
                                                <option <?php
                                                        if ($result['id_cate_post'] == $resultBL['category_post']) {
                                                            echo 'selected';
                                                        }
                                                        ?> value="<?php echo $result['id_cate_post'] ?>"><?php echo $result['title'] ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top; padding-top: 9px;">
                                    <label>Description</label>
                                </td>
                                <td>
                                    <textarea name="mota" class="tinymce" <?php echo $resultBL['mota'] ?></textarea>
                                </td>
                            </tr>       
                            <tr>
                                <td style="vertical-align: top; padding-top: 9px;">
                                    <label>Content</label>
                                </td>
                                <td>
                                    <textarea name="content" class="tinymce" <?php echo $resultBL['content'] ?></textarea>
                                </td>
                            </tr>      

                    <tr>
                        <td>
                            <label>Upload Image</label>
                        </td>
                        <td>
                            <img src=uploads/<?php echo $resultBL['hinhanh'] ?> width="100px"><br>
                            <input type="file" name="hinhanh" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Blog Status</label>
                        </td>
                        <td>
                            <select id="select" name="type"> 
                                <option>Select Type</option>
                                <?php
                                if ($resultBL['status'] == 0) {
                                ?>
                                <option selected value="0">Hien thi</option>
                                <option value="1">An</option>
                                <?php
                                } else {
                                ?>
                                 <option value="0">Hien thi</option>
                                <option selected value="1">An</option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" Value="Update" />
                        </td>
                    </tr>
                </table>
            </form>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php'; ?>