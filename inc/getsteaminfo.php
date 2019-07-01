<?php
class getInfo{


	public function getSteamInfo($steamid){

            // Start of linking profile url with steam id
            $newsteamurl=rtrim($steamid,"/ ");
            $urlSteamArray = explode('/',$newsteamurl);
            $steamprofileid = $urlSteamArray[sizeof($urlSteamArray)-1];

            $getUserinfoURL = 'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=4FD1CA494FC40FDA38140D4B288DCFEA&steamids=' . $steamid . '';

            $steamurl = "https://steamcommunity.com/id/moonsterplayer/";

            $getuserinfojson = file_get_contents($getUserinfoURL);

             $userinfo = json_decode($getuserinfojson , TRUE);

              foreach ($userinfo['response']['players'] as $key => $user) {

                if($user['steamid'] == null){
                
                }else{

                @$nolinkSteam = $user['steamid'];

                if($user['personastate'] == 1){
                    $userstatus = '<font color="green">Online</font>';
                }else if($user['personastate'] == 0){
                    $userstatus = '<font color="red">Offline</font>';
                }else if($user['personastate'] == 3){
                    $userstatus = "Busy";
                }else if($user['personastate'] == 4){
                    $userstatus = '<font color="yellow">Away</font>';
                }else if($user['personastate'] == 5){
                    $userstatus = "Snooze";
                }else if($user['personastate'] == 6){
                    $userstatus = "Looking for trade";
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

                echo '

                <div class="profileimg"> 
                <img src=" ' . $user['avatarfull'] .  ' " />
                 </div>
                <div class="personalinfo">
                <i>Real name:<i/> ' . @$user['realname'] .'
                <br /><i>Status:<i/> ' . @$userstatus .'
                <br /><i>Country:<i/> ' . @$user['loccountrycode'] .'
                <br /><i>Currently playing:<i/><font color="green"> ' . @$user['gameextrainfo'] .'</font>
                <br /><i>Account created:<i/> '. @$createduser .'
                <br /><i>Visibilty:<i/> '. @$uservisibility .'
                <br /><i>Last online:<i/> '. @$lastlogin .'
                </div>
                <br />
                <br />
                Steam64 ID: <br />
                <input type="text" class="inputinfo" value=" '. $user['steamid'] .'" />

                Nickname: <br />
                <input type="text" class="inputinfo" value=" '. $user['personaname'] .'" />

                Profile url: <br />
                <input type="text" class="inputinfo" value=" '. $user['profileurl'] .'" />

                Profile perma url: <br />
                <input type="text" class="inputinfo" value="http://steamcommunity.com/profiles/' . $user['steamid'] . '" />
                <br /><br />
                <a href="steam://friends/add/' . $user['steamid'] . '"><input type="button" class="addfriend" value="Add as friend"></a>
                ';
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

            $URLSteamID = 'http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=4FD1CA494FC40FDA38140D4B288DCFEA&vanityurl=' . $steamprofileid . '';

            $getURLSteamID = file_get_contents($URLSteamID);

            $getUserSteamID = json_decode($getURLSteamID , TRUE);

            @$userSteamID = $getUserSteamID['response']['steamid'];

            // End of getting the steamid from the profile url

            // Start of getting users steam information

            if($userSteamID == null){

                echo "Wrong";

            }else{

            $getUserinfoURL = 'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=4FD1CA494FC40FDA38140D4B288DCFEA&steamids=' . $userSteamID . '';

            $getuserinfojson = file_get_contents($getUserinfoURL);

            $userinfo = json_decode($getuserinfojson , TRUE);

            // Check vacban on user 

            $vacURL = 'http://api.steampowered.com/ISteamUser/GetPlayerBans/v1/?key=4FD1CA494FC40FDA38140D4B288DCFEA&steamids='. $userSteamID . '';
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
                    $userstatus = "Busy";
                }else if($user['personastate'] == 4){
                    $userstatus = '<font color="yellow">Away</font>';
                }else if($user['personastate'] == 5){
                    $userstatus = "Snooze";
                }else if($user['personastate'] == 6){
                    $userstatus = "Looking for trade";
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
                <img src=" ' . $user['avatarfull'] .  ' " />
                 </div>
                <div class="personalinfo">
                <i>Real name:<i/> ' . @$user['realname'] .'
                <br /><i>Status:<i/> ' . @$userstatus .'
                <br /><i>Country:<i/> ' . @$user['loccountrycode'] .'
                <br /><i>Currently playing:<i/><font color="green"> ' . @$user['gameextrainfo'] .'</font>
                <br /><i>Account created:<i/> '. @$createduser .'
                <br /><i>Visibilty:<i/> '. @$uservisibility .'
                <br /><i>Last online:<i/> '. @$lastlogin .'
                <br /><i>VAC: ' . $vacuserinfo . ' 
                Community: ' . $communityuserinfo .'
                Trade: ' . $tradebanneduserinfo .'
                GameBans: ' . $gamebanneduser .'
                 </i>
                </div>
                <br />
                <br />
                Steam64 ID:  <br />
                <input type="text" class="inputinfo" value=" '. $user['steamid'] .'" />

                Nickname: <br />
                <input type="text" class="inputinfo" value=" '. $user['personaname'] .'" />

                Profile url: <br />
                <input type="text" class="inputinfo" value="'. $user['profileurl'] .'" />

                Profile perma url: <br />
                <input type="text" class="inputinfo" value="http://steamcommunity.com/profiles/' . $user['steamid'] . '" />
                <br />
                <br />

                <a href="steam://friends/add/' . $user['steamid'] . '"><input type="button" class="addfriend" value="Add as friend"></a>
                ';
 
            }
            }
            // End of getting steam users information

        }else{


        $getUserinfoURL = 'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=4FD1CA494FC40FDA38140D4B288DCFEA&steamids=' . $steamid . '';

        $steamurl = "https://steamcommunity.com/id/moonsterplayer/";

        $getuserinfojson = file_get_contents($getUserinfoURL);

        $userinfo = json_decode($getuserinfojson , TRUE);

        foreach ($userinfo['response']['players'] as $key => $user) {

            if($user['steamid'] == null){
                echo "There is no user with this steamid....";
            }else{

                echo $user['steamid'];
            }

        }

        }

        }

	}

}
?>