<?php
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
$url = $_REQUEST['a'];
$url = addurl($url);
$cuturl = cuturl($url);
if(checkurl($cuturl)){
    //echo $url."</br>";
    echo file_get_contents($url);
}
?>
