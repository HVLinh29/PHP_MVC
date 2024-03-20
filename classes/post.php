<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/format.php');
?>
<?php
    class post {

        private $db;
        private $fm;
        public function __construct()
        {
            $this->db = new Database();
            $this->fm = new Format();

        } 
        public function insert_post($catName,$catDesc,$catStatus){
            $catName = $this->fm->validation($catName);
            $catDesc = $this->fm->validation($catDesc);
            $catStatus = $this->fm->validation($catStatus);
            $catName = mysqli_real_escape_string($this->db->link, $catName);
            $catDesc = mysqli_real_escape_string($this->db->link, $catDesc);
            $catStatus = mysqli_real_escape_string($this->db->link, $catStatus);



            if(empty($catName) ||empty($catDesc) ){
                $alert =" <span class='error'>Danh muc tin tuc khong duoc bo trong </span>";
                return $alert;
            }else{
                $query = "INSERT INTO tbl_danhmuctintuc(title,mota,status) VALUES('$catName','$catDesc','$catStatus') ";
                $result = $this->db->insert($query);
                if($result){
                    $alert = "<span class='success'>Them danh muc tin tuc thanh cong</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Them danh muc tin tuc khong thanh cong</span>";
                    return $alert;
                }
                
            }
        }
    
        public function show_post(){
            $query = "SELECT * FROM tbl_danhmuctintuc ORDER BY id_cate_post DESC";
            $result = $this->db->select($query);
            return $result;
        }
        public function getpost($id){
            $query = "SELECT * FROM tbl_danhmuctintuc WHERE id_cate_post ='$id'";
            $result = $this->db->select($query);
            return $result;
        }
        
        public function getcatebyId($id){
            $query = "SELECT * FROM tbl_category WHERE catId='$id' ";
            $result = $this->db->select($query);
            return $result;
        }
        public function update_category($catName,$id){

            $catName = $this->fm->validation($catName);
            $catName = mysqli_real_escape_string($this->db->link, $catName);
            $id = mysqli_real_escape_string($this->db->link, $id);


            if(empty($catName) ){
                $alert =" <span class='error'>Danh muc khong duoc bo trong </span>";
                return $alert;
            }else{
                $query = "UPDATE tbl_category SET catName = '$catName' WHERE catId = '$id' ";
                $result = $this->db->update($query);
                if($result){
                    $alert = "<span class='success'>Sua danh muc thanh cong</span>";
                    return $alert;
                
                }
                else{
                    $alert = "<span class='error'>Sua danh muc khong thanh cong</span>";
                    return $alert;
                }
                
            }
        }
        public function del_post($id){
            $query = "DELETE FROM tbl_danhmuctintuc WHERE id_cate_post='$id' ";
            $result = $this->db->delete($query);
            if($result){
                $alert = "<span class='success'>Xoa danh muc tin tuc thanh cong</span>";
                return $alert;
            
            }
            else{
                $alert = "<span class='error'>Xoa danh muc tin tuc khong thanh cong</span>";
                return $alert;
            }
        }
        public function show_category_gd(){
            $query = "SELECT * FROM tbl_category ORDER BY catId DESC";
            $result = $this->db->select($query);
            return $result;
        }
        public function get_post_by_cat($id){
            $query = "SELECT tbl_blog.* FROM tbl_blog
            WHERE  tbl_blog.category_post ='$id'";
           $result = $this->db->select($query);
           return $result;
        }
        public function get_name_by_cat($id){
            $query = "SELECT tbl_sanpham.*,tbl_category.catName,tbl_category.catId
             FROM tbl_sanpham,tbl_category WHERE tbl_sanpham.catId=tbl_category.catId AND tbl_sanpham.catId = '$id' LIMIT 1 ";
            $result = $this->db->select($query);
            return $result;
        }
        public function getpostbyid($id){
            $query = "SELECT * FROM tbl_blog WHERE  tbl_blog.id ='$id'";
           $result = $this->db->select($query);
           return $result;
        }
    
    }
?>