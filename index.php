<?php
function ip() {
    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    return $res;
    //dump(phpinfo());//所有PHP配置信息
}
function getipxx($ip) {
  $checkipurl = "http://freeapi.ipip.net/".$ip;
  $ipxx = file_get_contents($checkipurl);
  $find = array('[',']',']',',','"');
  $replace = array('');
  return str_replace($find,$replace,$ipxx);
}
function sqlconect(){
  $ip = ip();
  $ipxx = getipxx($ip);
  $db = new mysqli('127.0.0.1', '1', '1', '1');
  if(mysqli_connect_errno()){
    die;
  }
  if(!$db-> query("insert into ip (ip,ipxx) values ('$ip','$ipxx')")){
    $db-> query("CREATE TABLE ip (ip varchar(15),ipxx varchar(30),time timestamp)");
    $db-> query("insert into ip (ip,ipxx) values ('$ip','$ipxx')");
  }
  mysqli_close($db);
}
function addurl($url) {
    if((stristr($url,"https://") == FALSE) && (stristr($url,"http://") == FALSE)){
          $url = "https://".$url;
      }
    return $url;
}
function checkurl($url) {
    $befores = array("https://www.","https://","http://www.","http://");
    $middles = array("网址1","网址2","网址3");
    $afters = array("/link");
    foreach ($befores as $before) {
        foreach ($middles as $middle) {
            foreach ($afters as $after) {
                if ($before.$middle.$after == $url)
                {
                  $before.$middle.$after;
                  return 1;
                }
            }
        }
    }
    return 0;
}
function cuturl($url) {
    $key = "/";
    return substr($url,0,strripos($url,$key));;
}
//sqlconect();如需开启数据库记录ip，请把//去掉。
$url = $_REQUEST['a'];
$url = addurl($url);
$cuturl = cuturl($url);
if(checkurl($cuturl)){
    //echo $url."</br>";
    echo file_get_contents($url);
}
?>
