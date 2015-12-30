<?php
   global $gbSuperUser, $gbVolMgr, $gbVolLogin;

   $params = array('enumStyle' => 'terse', 'clsRpt');
   $clsRpt = new generic_rpt($params);
   if ($gbSuperUser){
      $clsRpt->strWidthLabel = '120pt';
   }else {
      $clsRpt->strWidthLabel = '90pt';
   }

   showResources($clsRpt, $versionInfo, $location);

   if ($gbVolMgr){
      showSupers($clsRpt, $superUsers);
   }elseif ($gbVolLogin){
      showVolMgrs($clsRpt, $volMgrs);
   }

   function showVolMgrs($clsRpt, $volMgrs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      openBlock('Volunteer Managers for Your Location', '');

      $strOut = '<ul  style="margin-top: 0px; margin-left: -20px; margin-bottom: 0px;">';
      foreach ($volMgrs as $vm){
         if (!$vm->us_bInactive){
            $strOut .= '<li><b>'.$vm->strSafeName.'</b><br>'
                .'<a href="mailto:'.$vm->us_strEmail.'">'.$vm->us_strEmail.'</a><br>
                  <b>phone: </b>'.htmlspecialchars($vm->us_strPhone).'<br>
                  <b>cell: </b>'.htmlspecialchars($vm->us_strCell).'<br><br>';
         }
      }
      $strOut .= '</ul>';

      echoT($strOut);

      closeBlock();
   
   }

   function showSupers($clsRpt, $superUsers){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      openBlock('Program Administrators', '');

      $strOut = '<ul  style="margin-top: 0px; margin-left: -20px; margin-bottom: 0px;">';
      foreach ($superUsers as $su){
         if (!$su->us_bInactive){
            $strOut .= '<li><b>'.$su->strSafeName.'</b><br>'
                .'<a href="mailto:'.$su->us_strEmail.'">'.$su->us_strEmail.'</a><br>
                  <b>phone: </b>'.htmlspecialchars($su->us_strPhone).'<br>
                  <b>cell: </b>'.htmlspecialchars($su->us_strCell).'<br><br>';
         }
      }
      $strOut .= '</ul>';

      echoT($strOut);

      closeBlock();
   }

   function showResources($clsRpt, $versionInfo, $location){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbSuperUser, $gbVolMgr, $gbVolLogin;
      openBlock('Resources', '');

      echoT(
          $clsRpt->openReport());

         //--------------------
         // User's Guide
         //--------------------
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('User\'s Guide:')
         .$clsRpt->writeCell('<a href="http://www.hospicevolunteersolutions.org/userGuide" target="_blank">www.hospicevolunteersolutions.org/userGuide</a>')
         .$clsRpt->closeRow  ());

      if ($gbSuperUser){
         echoT(
             $clsRpt->openRow   ()
            .$clsRpt->writeLabel('php Version:')
            .$clsRpt->writeCell (phpversion())
            .$clsRpt->closeRow  ());

         echoT(
             $clsRpt->openRow   ()
            .$clsRpt->writeLabel('Software Level:')
            .$clsRpt->writeCell ($versionInfo->softwareLevel.' ('.$versionInfo->softwareDate.')')
            .$clsRpt->closeRow  ());

         echoT(
             $clsRpt->openRow   ()
            .$clsRpt->writeLabel('Database Version:')
            .$clsRpt->writeCell ($versionInfo->dbVersion)
            .$clsRpt->closeRow  ());
      }

      if ($gbVolMgr || $gbVolLogin){
         echoT(
             $clsRpt->openRow   ()
            .$clsRpt->writeLabel('Location:')
            .$clsRpt->writeCell ('<b>'.$location->strSafeLocationName.'</b><br>'.$location->strAddress)
            .$clsRpt->closeRow  ());
      }

      echoT($clsRpt->closeReport());

      closeBlock();
   }

