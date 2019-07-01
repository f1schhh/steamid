<?php
require('inc/getsteaminfo.php');
$userinfo = new getInfo();
    $searchid = $_POST['searchid'];

    parse_str($searchid, $searchuser);

    if($searchid == null){

    }else{

    	$userinfo->getSteamInfo($searchuser['searchid']);

    }

        	

?>