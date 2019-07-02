<?php
include('config.inc.php');
class getInfo extends Config{


	public function getSteamInfo($steamid){
            // Get config

            $config = new Config();

            $apikey = $config->apiKey();


            // Start of linking profile url with steam id
            $newsteamurl=rtrim($steamid,"/ ");
            $urlSteamArray = explode('/',$newsteamurl);
            $steamprofileid = $urlSteamArray[sizeof($urlSteamArray)-1];

            $getUserinfoURL = 'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='. $apikey . '&steamids=' . $steamid . '';

            $steamurl = "https://steamcommunity.com/id/moonsterplayer/";

            $getuserinfojson = file_get_contents($getUserinfoURL);

             $userinfo = json_decode($getuserinfojson , TRUE);

              // Check vacban on user 

            $vacURL = 'http://api.steampowered.com/ISteamUser/GetPlayerBans/v1/?key='. $apikey . '&steamids='. $steamid . '';
            $vacinfojson = file_get_contents($vacURL);

            $vacinfo = json_decode($vacinfojson , TRUE);
            foreach ($vacinfo['players'] as $key => $vac) {
            $vacuser = $vac['VACBanned'];
            $gamebanneduser = $vac['NumberOfGameBans'];
            $communitybanneduser = $vac['CommunityBanned'];
            $tradebanneduser = $vac['EconomyBan'];

            }

            //End of check vacban on user

            if($steamid == null){
                echo "FEL!";
            }else{

              foreach ($userinfo['response']['players'] as $key => $user) {

                if($user['steamid'] == null){
                    echo "Fel!";
                }else{

                @$nolinkSteam = $user['steamid'];

                if($user['personastate'] == 1){
                    $userstatus = '<font color="green">Online</font>';
                }else if($user['personastate'] == 0){
                    $userstatus = '<font color="red">Offline</font>';
                }else if($user['personastate'] == 3){
                    $userstatus = "Upptagen";
                }else if($user['personastate'] == 4){
                    $userstatus = '<font color="yellow">Borta</font>';
                }else if($user['personastate'] == 5){
                    $userstatus = "Snooze";
                }else if($user['personastate'] == 6){
                    $userstatus = "Letar efter trade";
                }

                $usercreated = date("j F Y", @$user['timecreated']);

                if($usercreated == "1 January 1970"){
                    $createduser = " ";
                }else{
                    $createduser = $usercreated;
                }

                if($user['communityvisibilitystate'] == 1){
                    $uservisibility = '<font color="red">Private</font>';
                }else if($user['communityvisibilitystate'] == 3){
                    $uservisibility = '<font color="green">Public</font>';
                }

                $lastonline = date("j F Y H:i", @$user['lastlogoff']);

                if($lastonline == "1 January 1970"){
                    $lastlogin = " ";
                }else{
                    $lastlogin = $lastonline;
                }
                if($vacuser == 0){
                    $vacuserinfo = '<font color="green">✔</font>';

                }else{
                    $vacuserinfo = '<font color="red">X</font>';
                }

                if($communitybanneduser == 0){
                    $communityuserinfo = '<font color="green">✔</font>';
                }else{
                    $communityuserinfo = '<font color="red">X</font>';
                }

                if($tradebanneduser == "none"){
                    $tradebanneduserinfo = '<font color="green">✔</font>';
                }else{
                    $tradebanneduserinfo = '<font color="red">X</font>';
                }



                echo '

                <div class="profileimg"> 
                <a href="' . $user['avatarfull'] .  '" data-lightbox="'. $user['personaname'] .'"><img src=" ' . $user['avatarfull'] .  ' " /></a>
                 </div>
                <div class="personalinfo">
                <i>Riktiga namn:<i/> ' . @$user['realname'] .'
                <br /><i>Status:<i/> ' . @$userstatus .'
                <br /><i>Land:<i/> ' . @$user['loccountrycode'] .'
                <br /><i>Spelar just nu:<i/><font color="green"> ' . @$user['gameextrainfo'] .'</font>
                <br /><i>Kontot skapat:<i/> '. @$createduser .'
                <br /><i>Synlighet:<i/> '. @$uservisibility .'
                <br /><i>Senast inloggad:<i/> '. @$lastlogin .'
                <br /><i>VAC: ' . $vacuserinfo . ' 
                Community: ' . $communityuserinfo .'
                Trade: ' . $tradebanneduserinfo .'
                GameBans: ' . $gamebanneduser .'
                 </i>
                </div>
                <br />
                Steam64 ID:  <br />
                <input type="text" class="inputinfo" value=" '. $user['steamid'] .'" />

                Användarnamn: <br />
                <input type="text" class="inputinfo" value=" '. $user['personaname'] .'" />

                Profil länk: <br />
                <input type="text" class="inputinfo" value="'. $user['profileurl'] .'" />

                Profil perma länk: <br />
                <input type="text" class="inputinfo" value="http://steamcommunity.com/profiles/' . $user['steamid'] . '" />
                <br />
                <br />

                <a href="steam://friends/add/' . $user['steamid'] . '"><input type="button" class="addfriend" value="Lägg till som vän"></a>
                ';
 
                }
            }
        }

        // End of linking profile url with steamid


        if(@$nolinkSteam == null){

            // Check if there is a link
            if(filter_var($steamid, FILTER_VALIDATE_URL)){

            // Start of getting the steamid from the profile url 
            $newsteamurl=rtrim($steamid,"/ ");
            $urlSteamArray = explode('/',$newsteamurl);
            $steamprofileid = $urlSteamArray[sizeof($urlSteamArray)-1];

            $URLSteamID = 'http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key='. $apikey . '&vanityurl=' . $steamprofileid . '';

            $getURLSteamID = file_get_contents($URLSteamID);

            $getUserSteamID = json_decode($getURLSteamID , TRUE);

            @$userSteamID = $getUserSteamID['response']['steamid'];

            // End of getting the steamid from the profile url

            // Start of getting users steam information

            if($userSteamID == null){

                echo "<font color='red'>Användaren kunde inte hittas...</font>";

            }else{

            $getUserinfoURL = 'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='. $apikey . '&steamids=' . $userSteamID . '';

            $getuserinfojson = file_get_contents($getUserinfoURL);

            $userinfo = json_decode($getuserinfojson , TRUE);

            // Check vacban on user 

            $vacURL = 'http://api.steampowered.com/ISteamUser/GetPlayerBans/v1/?key='. $apikey . '&steamids='. $userSteamID . '';
            $vacinfojson = file_get_contents($vacURL);

            $vacinfo = json_decode($vacinfojson , TRUE);
            foreach ($vacinfo['players'] as $key => $vac) {
            $vacuser = $vac['VACBanned'];
            $gamebanneduser = $vac['NumberOfGameBans'];
            $communitybanneduser = $vac['CommunityBanned'];
            $tradebanneduser = $vac['EconomyBan'];

            }

            //End of check vacban on user
         
            foreach ($userinfo['response']['players'] as $key => $user) {

                 if($user['personastate'] == 1){
                    $userstatus = '<font color="green">Online</font>';
                }else if($user['personastate'] == 0){
                    $userstatus = '<font color="red">Offline</font>';
                }else if($user['personastate'] == 3){
                    $userstatus = "Upptagen";
                }else if($user['personastate'] == 4){
                    $userstatus = '<font color="yellow">Borta</font>';
                }else if($user['personastate'] == 5){
                    $userstatus = "Snooze";
                }else if($user['personastate'] == 6){
                    $userstatus = "Letar efter trade";
                }

                $usercreated = date("j F Y", @$user['timecreated']);

                if($usercreated == "1 January 1970"){
                    $createduser = " ";
                }else{
                    $createduser = $usercreated;
                }

                if($user['communityvisibilitystate'] == 1){
                    $uservisibility = '<font color="red">Private</font>';
                }else if($user['communityvisibilitystate'] == 3){
                    $uservisibility = '<font color="green">Public</font>';
                }

                $lastonline = date("j F Y H:i", @$user['lastlogoff']);

                if($lastonline == "1 January 1970"){
                    $lastlogin = " ";
                }else{
                    $lastlogin = $lastonline;
                }
                if($vacuser == 0){
                    $vacuserinfo = '<font color="green">✔</font>';

                }else{
                    $vacuserinfo = '<font color="red">X</font>';
                }

                if($communitybanneduser == 0){
                    $communityuserinfo = '<font color="green">✔</font>';
                }else{
                    $communityuserinfo = '<font color="red">X</font>';
                }

                if($tradebanneduser == "none"){
                    $tradebanneduserinfo = '<font color="green">✔</font>';
                }else{
                    $tradebanneduserinfo = '<font color="red">X</font>';
                }



                echo '

                <div class="profileimg"> 
                <a href="' . $user['avatarfull'] .  '" data-lightbox="'. $user['personaname'] .'"><img src=" ' . $user['avatarfull'] .  ' " /></a>
                 </div><br />
                <div class="personalinfo">
                <i>Riktiga namn:<i/> ' . @$user['realname'] .'
                <br /><i>Status:<i/> ' . @$userstatus .'
                <br /><i>Land:<i/> ' . @$user['loccountrycode'] .'
                <br /><i>Spelar just nu:<i/><font color="green"> ' . @$user['gameextrainfo'] .'</font>
                <br /><i>Kontot skapat:<i/> '. @$createduser .'
                <br /><i>Synlighet:<i/> '. @$uservisibility .'
                <br /><i>Senast inloggad:<i/> '. @$lastlogin .'
                <br /><i>VAC: ' . $vacuserinfo . ' 
                Community: ' . $communityuserinfo .'
                Trade: ' . $tradebanneduserinfo .'
                GameBans: ' . $gamebanneduser .'
                 </i>
                </div>
                <br />
                Steam64 ID:  <br />
                <input type="text" class="inputinfo" value=" '. $user['steamid'] .'" />

                Användarnamn: <br />
                <input type="text" class="inputinfo" value=" '. $user['personaname'] .'" />

                Profil länk: <br />
                <input type="text" class="inputinfo" value="'. $user['profileurl'] .'" />

                Profil perma länk: <br />
                <input type="text" class="inputinfo" value="http://steamcommunity.com/profiles/' . $user['steamid'] . '" />
                <br />
                <br />

                <a href="steam://friends/add/' . $user['steamid'] . '"><input type="button" class="addfriend" value="Lägg till som vän"></a>
                ';
            }
            
        }
            // End of getting steam users information

        }else{


        $getUserinfoURL = 'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='. $apikey . '&steamids=' . $steamid . '';

        $getuserinfojson = file_get_contents($getUserinfoURL);

        $userinfo = json_decode($getuserinfojson , TRUE);

        // Check vacban on user 

            $vacURL = 'http://api.steampowered.com/ISteamUser/GetPlayerBans/v1/?key='. $apikey . '&steamids='. $steamid . '';
            $vacinfojson = file_get_contents($vacURL);

            $vacinfo = json_decode($vacinfojson , TRUE);
            foreach ($vacinfo['players'] as $key => $vac) {
            $vacuser = $vac['VACBanned'];
            $gamebanneduser = $vac['NumberOfGameBans'];
            $communitybanneduser = $vac['CommunityBanned'];
            $tradebanneduser = $vac['EconomyBan'];

            }

            //End of check vacban on user

            if(@$vacuser == null){
                echo "<font color='red'>Fel steam64 ID kunde inte hittas...1</font>";
            }else{

        foreach ($userinfo['response']['players'] as $key => $user) {
 
                if($user['steamid'] == null){
                echo "Användaren kunde inte hittas...";
                 }else{

                if($user['personastate'] == 1){
                    $userstatus = '<font color="green">Online</font>';
                }else if($user['personastate'] == 0){
                    $userstatus = '<font color="red">Offline</font>';
                }else if($user['personastate'] == 3){
                    $userstatus = "Upptagen";
                }else if($user['personastate'] == 4){
                    $userstatus = '<font color="yellow">Borta</font>';
                }else if($user['personastate'] == 5){
                    $userstatus = "Snooze";
                }else if($user['personastate'] == 6){
                    $userstatus = "Letar efter trade";
                }

                $usercreated = date("j F Y", @$user['timecreated']);

                if($usercreated == "1 January 1970"){
                    $createduser = " ";
                }else{
                    $createduser = $usercreated;
                }

                if($user['communityvisibilitystate'] == 1){
                    $uservisibility = '<font color="red">Private</font>';
                }else if($user['communityvisibilitystate'] == 3){
                    $uservisibility = '<font color="green">Public</font>';
                }

                $lastonline = date("j F Y H:i", @$user['lastlogoff']);

                if($lastonline == "1 January 1970"){
                    $lastlogin = " ";
                }else{
                    $lastlogin = $lastonline;
                }
                if($vacuser == 0){
                    $vacuserinfo = '<font color="green">✔</font>';

                }else{
                    $vacuserinfo = '<font color="red">X</font>';
                }

                if($communitybanneduser == 0){
                    $communityuserinfo = '<font color="green">✔</font>';
                }else{
                    $communityuserinfo = '<font color="red">X</font>';
                }

                if($tradebanneduser == "none"){
                    $tradebanneduserinfo = '<font color="green">✔</font>';
                }else{
                    $tradebanneduserinfo = '<font color="red">X</font>';
                }



                echo '

                <div class="profileimg"> 
                <a href="' . $user['avatarfull'] .  '" data-lightbox="'. $user['personaname'] .'"><img src=" ' . $user['avatarfull'] .  ' " /></a>
                 </div>
                <div class="personalinfo">
                <i>Riktiga namn:<i/> ' . @$user['realname'] .'
                <br /><i>Status:<i/> ' . @$userstatus .'
                <br /><i>Land:<i/> ' . @$user['loccountrycode'] .'
                <br /><i>Spelar just nu:<i/><font color="green"> ' . @$user['gameextrainfo'] .'</font>
                <br /><i>Kontot skapat:<i/> '. @$createduser .'
                <br /><i>Synlighet:<i/> '. @$uservisibility .'
                <br /><i>Senast inloggad:<i/> '. @$lastlogin .'
                <br /><i>VAC: ' . $vacuserinfo . ' 
                Community: ' . $communityuserinfo .'
                Trade: ' . $tradebanneduserinfo .'
                GameBans: ' . $gamebanneduser .'
                 </i>
                </div>
                <br />
                Steam64 ID:  <br />
                <input type="text" class="inputinfo" value=" '. $user['steamid'] .'" />

                Användarnamn: <br />
                <input type="text" class="inputinfo" value=" '. $user['personaname'] .'" />

                Profil länk: <br />
                <input type="text" class="inputinfo" value="'. $user['profileurl'] .'" />

                Profil perma länk: <br />
                <input type="text" class="inputinfo" value="http://steamcommunity.com/profiles/' . $user['steamid'] . '" />
                <br />
                <br />

                <a href="steam://friends/add/' . $user['steamid'] . '"><input type="button" class="addfriend" value="Lägg till som vän"></a>
                ';
 
            }
        }
        }

        }

        }

	}

}
?>