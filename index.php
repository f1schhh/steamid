<?php
require('inc/getsteaminfo.php');
$userinfo = new getInfo();

?>
<!DOCTYPE html>
<html>
<head>
	<title>SteamID.se</title>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="js/searchuser.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet" />
    <script>
      $(document).ready(function(){
        $(".info").hide();
            $(".searchbarbtn").click(function(){

               if($(".info").is(":hidden")){

                $(".info").slideDown("slow");

                }else{
                  if($(".searchtext").is(":empty")){
                }else{
                  $(".info").slideUp("slow");
                }
                }
      });
      });
    </script>
</head>
<body>
  <!----Start of contentbox ----->
  <div id="contentbox">
        <div id="searchbar">
        	<div class="searchbarpos">
            <form id="search4user" method="POST" action="#">
        		<input type="text" required="" placeholder="Steamid, steam64id, steam32id, profile url" name="searchid" class="searchtext" />
        		<input type="submit" class="searchbarbtn" value="Sök" />
          </form>
        		<br />

        		<div class="info">

        	</div>
        	</div>		
   </div>

   <div id="footer">

    <div class="insidefooter">

      © SteamID.se 2019 ^ Designed and coded by <a href="http://fischerwebb.se" target="_blank">Adam Fischer</a> 

    </div>

  </div>
</div>


</body>
</html>