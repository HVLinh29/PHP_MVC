<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>
<?php
class blog
{

    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function search_product($tukhoa){
        $tukhoa = $this->fm->validation($tukhoa);
        $query = "SELECT * FROM tbl_sanpham WHERE productName LIKE '%$tukhoa%'";
        $result = $this->db->select($query);
        return $result;
    }
    public function insert_blog($data,$FILES){

        $title = mysqli_real_escape_string($this->db->link, $data['title']);
        $category = mysqli_real_escape_string($this->db->link, $data['category_post']);
        $mota = mysqli_real_escape_string($this->db->link, $data['mota']);
        $content = mysqli_real_escape_string($this->db->link, $data['content']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);
        //Kiem tra hinh anh va lay hinh anh cho vao folder 
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['hinhanh']['name'];
        $file_size = $_FILES['hinhanh']['size'];
        $file_temp = $_FILES['hinhanh']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        if ($title == "" || $category == "" || $mota == ""  || $content == "" || $type == "" || $file_name == "") {
            $alert = " <span class='error'>Khong duoc de trong du lieu </span>";
            return $alert;
        } else {
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "INSERT INTO tbl_blog(title, mota  ,content, category_post,hinhanh,status) VALUES('$title',
            '$mota','$content','$category','$unique_image','$type') ";
            $result = $this->db->insert($query);
            if ($result) {
                $alert = "<span class='success'>Them tin tuc thanh cong</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Them tin tuc khong thanh cong</span>";
                return $alert;
            }
        }
    }

    public function show_blog()
    {
        $query = "SELECT tbl_blog.*,tbl_danhmuctintuc.title FROM tbl_blog
            INNER JOIN tbl_danhmuctintuc ON tbl_danhmuctintuc.id_cate_post = tbl_blog.category_post
            ORDER BY tbl_blog.id DESC";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_blog($data, $file, $id)
    {
        $title = mysqli_real_escape_string($this->db->link, $data['title']);
        $category = mysqli_real_escape_string($this->db->link, $data['category_post']);
        $mota = mysqli_real_escape_string($this->db->link, $data['mota']);
        $content = mysqli_real_escape_string($this->db->link, $data['content']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);
        //Kiem tra hinh anh va lay hinh anh cho vao folder 
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['hinhanh']['name'];
        $file_size = $_FILES['hinhanh']['size'];
        $file_temp = $_FILES['hinhanh']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;


        if ($title == "" || $category == "" || $mota == ""  || $content == "" || $type == "") {
            $alert = " <span class='error'>Khong duoc de trong du lieu </span>";
            return $alert;
        } else {
            if (!empty($file_name)) {
                //Neu nguoi dung chon anh
                if ($file_size > 204800) {
                    $alert = "<span class='error'>Kich co hinh anh nen nho hon 2MB</span>";
                    return $alert;
                } elseif (in_array($file_ext, $permited) === false) {
                    $alert = "<span class='error'>Ban co the upload:-" . implode(', ', $permited) . "</span>";
                    return $alert;
                }
                move_uploaded_file($file_temp, $uploaded_image);
                $query = "UPDATE tbl_blog SET 
                title = '$title',
                mota = '$mota',
                content = '$content',
                category_post = '$category',
                hinhanh = '$unique_image',
                status = '$type' 
                WHERE id = '$id' ";
            } else {
                // Neu nguoi dung khong chon anh
                $query = "UPDATE tbl_blog SET 
                title = '$title',
                mota = '$mota',
                content = '$content',
                category_post = '$category',
                status = '$type' 
                WHERE id = '$id' ";
            }
            $result = $this->db->update($query);
            if ($result) {
                $alert = "<span class='success'>Sua tin tuc thanh cong</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Sua tin tuc khong thanh cong</span>";
                return $alert;
            }
        }
    }
    public function del_blog($id)
    {
        $query = "DELETE FROM tbl_blog WHERE id='$id' ";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class='success'>Xoa tin tuc thanh cong</span>";
            return $alert;
        } else {
            $alert = "<span class='error'>Xoa tin tuc khong thanh cong</span>";
            return $alert;
        }
    }
    public function getblogbyId($id)
    {
        $query = "SELECT * FROM tbl_blog WHERE id='$id' ";
        $result = $this->db->select($query);
        return $result;
    }
   
}
?>