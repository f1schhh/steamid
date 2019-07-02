<?php
require('inc/getsteaminfo.php');

    $userinfo = new getInfo();
    $searchid = $_POST['searchid'];

    parse_str($searchid, $searchuser);


    if($searchid == "searchid="){
    	echo "<font color='red'>Fel du angav inte något i formuläret!</font>";
    }else{
    	$userinfo->getSteamInfo($searchuser['searchid']);
    	
    }
?>