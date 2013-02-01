<?php
class VoteAction extends YouYaX
{
    public function dovote()
    {
        if (match($_SESSION['youyax_user'], "session_user")) {
            $vradio = addslashes($_POST['vradio']);
            $vid    = addslashes($_POST['vid']);
            $cid    = addslashes($_POST['cid']);
            if (!empty($_SERVER['HTTP_CLIENT_IP']))
                $myIp = $_SERVER['HTTP_CLIENT_IP'];
            else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                $myIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else
                $myIp = $_SERVER['REMOTE_ADDR'];
            if (match($vradio, "vote")) {
                if ($ips_arr = $this->find(C('db_prefix') . "vote_ips", "string", "vid=" . $vid)) {
                    $ips = unserialize($ips_arr['ips']);
                    
                    if (in_array($myIp, $ips)) {
                        echo '<script>alert("您已经投过票了");history.back();</script>';
                        exit;
                    } else {
                        $ips[]       = $myIp;
                        $data['ips'] = serialize($ips);
                        $this->save($data, C('db_prefix') . "vote_ips", "vid=" . $vid);
                        
                        $vote_arr = $this->find(C('db_prefix') . "vote", "string", "id=" . $vid);
                        $comb     = unserialize($vote_arr['comb']);
                        $comb[$vradio]['nums']++;
                        $data['comb'] = serialize($comb);
                        $this->save($data, C('db_prefix') . "vote", "id=" . $vid);
                    }
                } else {
                    $array       = array();
                    $array[]     = $myIp;
                    $data['vid'] = $vid;
                    $data['ips'] = serialize($array);
                    $this->add($data, C('db_prefix') . "vote_ips");
                    
                    $vote_arr = $this->find(C('db_prefix') . "vote", "string", "id=" . $vid);
                    $comb     = unserialize($vote_arr['comb']);
                    $comb[$vradio]['nums']++;
                    $data['comb'] = serialize($comb);
                    $this->save($data, C('db_prefix') . "vote", "id=" . $vid);
                }
            }
            $this->redirect("Content" . C('default_url') . "index" . C('default_url') . "id" . C('default_url') . $cid . C('static_url'));
        }
    }
}
?>