<?php
class Fenye
{
    public $page_size; //每页条数
    public $page; //第几页
    public $page_count; //总页数
    public $num; //总条数
    function __construct($count, $page_size)
    {
        $this->page       = 1;
        $this->num        = $count;
        $this->page_size  = $page_size;
        $this->page_count = ceil($this->num / $this->page_size);
    }
    function show()
    {
        if ($this->page_count <= 5) {
            $array = array();
            array_push($array, "<a  style=\"font-weight:600;width:22px;height:22px;text-align:center;color:#666666;line-height:22px;font-size:14px;background:#dddde2;display:inline-block\" href=?page=1>首</a>");
            for ($i = 1; $i <= $this->page_count; $i++) {
                array_push($array, "<a  style=\"font-weight:600;width:22px;height:22px;text-align:center;color:#666666;line-height:22px;font-size:14px;background:#dddde2;display:inline-block\"  id=$i href=?page=$i>$i</a>");
            }
            array_push($array, "<a  style=\"font-weight:600;width:22px;height:22px;text-align:center;color:#666666;line-height:22px;font-size:14px;background:#dddde2;display:inline-block\" href=?page=$this->page_count>末</a>");
            return $array;
        } else {
            $this->page = $_REQUEST['page'];
            if ($this->page + 2 >= $this->page_count)
                $this->page = $this->page_count - 2;
            if ($this->page - 2 <= 1)
                $this->page = 3;
            $array = array();
            array_push($array, "<a  style=\"font-weight:600;width:22px;height:22px;text-align:center;color:#666666;line-height:22px;font-size:14px;background:#dddde2;display:inline-block\" href=?page=1>首</a>");
            for ($i = $this->page - 2; $i <= $this->page + 2; $i++) {
                array_push($array, "<a  style=\"font-weight:600;width:22px;height:22px;text-align:center;color:#666666;line-height:22px;font-size:14px;background:#dddde2;display:inline-block\"  id=$i href=?page=$i>$i</a>");
            }
            array_push($array, "<a  style=\"font-weight:600;width:22px;height:22px;text-align:center;color:#666666;line-height:22px;font-size:14px;background:#dddde2;display:inline-block\" href=?page=$this->page_count>末</a>");
            return $array;
        }
    }
    function listcon($sql)
    {
        $this->page = empty($_REQUEST['page']) ? 0 : $_REQUEST['page'];
        if ($this->page <= 0)
            $this->page = 1;
        if ($this->page >= $this->page_count)
            $this->page = $this->page_count;
        $offset = ($this->page - 1) * $this->page_size;
        $sql .= " limit " . $offset . "," . $this->page_size;
        return $sql;
    }
    
}
?>