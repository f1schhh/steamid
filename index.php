<?php
require('inc/getsteaminfo.php');
$userinfo = new getInfo();

?>
<!DOCTYPE html>
<html>
<head>
	<title>SteamID.se</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="SteamID.se - är en enkel väg att få reda mycket information om en persons steamkonto.">
  <link rel="shortcut icon" href="img/icon.ico">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="js/searchuser.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet">
  <link href="css/lightbox.css" rel="stylesheet" />
  <script src="js/lightbox.js"></script>
    <link href="css/index.css" rel="stylesheet" />
    <script>
      $(document).ready(function(){
        $(".info").hide();
            $(".searchbarbtn").click(function(){

              $(".siteinformation").hide();
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
        		<input type="text" required="" placeholder="Steam64 ID / profil länk" name="searchid" class="searchtext" />
        		<input type="submit" class="searchbarbtn" value="Sök" />
          </form>
        		<br />
            <div class="siteinformation">

              SteamID.se -
              är en enkel väg att få reda mycket information om en persons steamkonto. <br />
              Använd dig utav något av detta nedanför &darr; för att söka i formuläret ovanför 
              <br />
              <br />
              - http://steamcommunity.com/profiles/765XXXXXXXXXXXXX
              <br />
              - http://steamcommunity.com/id/URL/
              <br />
              - 765XXXXXXXXXXXXXX

          </div>
        		<div class="info"></div>
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