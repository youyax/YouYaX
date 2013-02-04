<?php
session_start();
class Upload
{
    public $size = '';
    public $type = '';
    public $path = '';
    public $conf = '';
    public function __construct()
    {
        $this->type = array();
        $this->type2 = array();
        $this->conf = array();
    }
    public function upload_limit()
    {
    	if(empty($_SESSION['youyax_user'])){
    		echo "<script>alert('Please log in');</script>";
    		exit;
    	}
			$hz = substr(strstr($_FILES["file"]["name"],"."),1);  
        if (in_array($_FILES["file"]["type"], $this->type) && in_array(strtolower($hz),$this->type2) && ($_FILES["file"]["size"] < $this->size)) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
            } else {
                echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                echo "Type: " . $_FILES["file"]["type"] . "<br />";
                echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
                
                if (!file_exists($this->path)) {
                    mkdir($this->path);
                }
                if (file_exists($this->path . "/" . $_FILES["file"]["name"])) {
                    echo $_FILES["file"]["name"] . " already exists. ";
                } else {
                    list($font, $back) = explode(".", $_FILES["file"]["name"]);
                    $newpic = time() . "." . $back;
                    move_uploaded_file($_FILES["file"]["tmp_name"], $this->path . "/" . $newpic);
                    echo "Stored in: " . $this->path . "/" . $_FILES["file"]["name"];
                    echo '<script>
                     if (parent.document.all) {
                	parent.document.getElementById("web_editor_con2").value += "[img=' . $this->conf['SITE'] . "/Public/upload/" . $newpic . '][/img]";
        }else {
            var obj = parent.document.getElementById("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
             parent.document.getElementById("web_editor_con2").value = obj.value.substring(0, startPos) + "[img=' . $this->conf['SITE'] . "/Public/upload/" . $newpic . '][/img]" + obj.value.substring(endPos);
        }</script>';
                }
            }
        } else {
            echo "<script>alert('Invalid file');</script>";
        }
        
    }
    public function upload()
    {
        if (isset($_FILES["file"]["tmp_name"])) {
            if (!file_exists($this->path)) {
                mkdir($this->path);
            }
            $filename = $_FILES["file"]["name"];
            if (file_exists($this->path . "/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " already exists. ";
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $this->path . "/" . $filename)) {
                    echo "upload success!";
                } else {
                    echo "upload fail!";
                }
            }
        }
    }
}
$config = include('../../../../Conf/config.php');

$up = new Upload();

$up->conf = $config;

$up->size = 200000;

$up->path = "../../../../Public/upload";

$up->type = array(
    'image/jpeg',
    'image/pjpeg',
    'image/gif',
    'image/png',
    'image/x-png'
);
$up->type2 = array(
    'jpg',
    'jpeg',
    'gif',
    'png'
);
$up->upload_limit();
?>