<h2>Welcome to <?php echoT(CS_PROGNAME.'!');?></h2>
<?php

global $glUserID, $gbVolMgr;

if ($gbVolMgr){
   echoT('<br><i>You are logged in as a <b>Volunteer Manager</b>.</i><br><br><br>');
}

