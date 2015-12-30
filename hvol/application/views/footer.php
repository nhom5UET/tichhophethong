<?php

   global $gbSuperUser, $gbVolMgr, $gstrSafeName;

   $strName = $gstrSafeName;
   if ($gbSuperUser){
      $strName .= ' / Super User';
   }elseif ($gbVolMgr){
      $strName .= ' / Vol. Manager';
   }else {
      $strName .= ' / Volunteer';
   }

//            <p class="alignleft" >Copyright &#64;'.date('Y').' '.@$_SESSION[CS_NAMESPACE.'_chapter']->strChapterName.'</p>
   echoT('
         <div id="footer">
            <p class="alignright">You are logged in as <b>'.$strName.'</b></p>
            <div style="clear: both;"></div>
         </div>');
