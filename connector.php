<?php 

$link =  mysqli_connect("127.0.0.1","root","","db537581_2");

function query($queryString){  
    global $link;
    $result = mysqli_query($link, $queryString);
    return $result;
}
 
query("SET NAMES 'utf8' ");
?>
