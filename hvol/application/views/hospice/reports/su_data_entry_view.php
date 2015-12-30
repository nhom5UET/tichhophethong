<?php

   $strLabelExtra = strXlateMonth($lMonth).' '.$lYear;

   $params = array('enumStyle' => 'terse', 'clsRpt');
   $clsRpt = new generic_rpt($params);
   $clsRpt->strWidthLabel = '170pt';

   $attributes = new stdClass;
   $attributes->lTableWidth      = 900;
   $attributes->lUnderscoreWidth = 400;
   $attributes->bStartOpen       = false;

   displayOrgDataEntryStats('Organizational Data Entry: '.$strLabelExtra, $clsRpt, $attributes,
              false, null, $deStats);

   foreach ($locations as $loc){
      $strLocName = $loc->strSafeLocationName;
      if (!$loc->bActive) $strLocName .= ' (inactive)';

      displayOrgDataEntryStats($strLocName.' '.$strLabelExtra, $clsRpt, $attributes,
                  true, $loc->lKeyID, $loc->deStats);
   }



   function displayOrgDataEntryStats($strLabel, &$clsRpt, &$attributes, $bUseAtts, $locID, $stats){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strStyleHeaders = ' style="border-bottom: 1px solid black; font-weight: normal; font-size:11pt;" ';
      $bSU = is_null($locID);
      if ($bUseAtts){
         $attributes->bCloseDiv  = false;
         $attributes->divID      = 'group_'.$locID.'_Div';
         $attributes->divImageID = 'group_'.$locID.'_DivImg';
         openBlock($strLabel, '', $attributes);
      }else {
         openBlock($strLabel, '');
      }

      echoT(
          $clsRpt->openReport());

         //--------------------
         // Log-Ins
         //--------------------
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeTitle('Log-Ins', 366, '', 3, 1, $strStyleHeaders)
         .$clsRpt->closeRow  ());

      if ($bSU){
         echoT(
             $clsRpt->openRow   ()
            .$clsRpt->writeLabel('Sucessful Log-Ins:')
            .$clsRpt->writeCell(number_format($stats->lLogInGood))
            .$clsRpt->closeRow  ());

         echoT(
             $clsRpt->openRow   ()
            .$clsRpt->writeLabel('Unsucessful Log-Ins:')
            .$clsRpt->writeCell(number_format($stats->lLogInBad))
            .$clsRpt->closeRow  ());

         echoT(
             $clsRpt->openRow   ()
            .$clsRpt->writeLabel('Log-Ins <span style="font-weight: normal;">(Super User)</span>:')
            .$clsRpt->writeCell(number_format($stats->lLogInsSU))
            .$clsRpt->closeRow  ());
      }

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Log-Ins <span style="font-weight: normal;">(Vol. Mgrs.)</span>:')
         .$clsRpt->writeCell(number_format($stats->lLogInsVM))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Log-Ins <span style="font-weight: normal;">(Vol.)</span>:')
         .$clsRpt->writeCell(number_format($stats->lLogInsVols))
         .$clsRpt->closeRow  ());


         //--------------------
         // Patient Visits
         //--------------------
      echoT($clsRpt->blankRow());
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeTitle('Patient Visits', 366, '', 3, 1, $strStyleHeaders)
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Records Entered <span style="font-weight: normal;">(Vol. Mgr.)</span>:')
         .$clsRpt->writeCell(number_format($stats->lPVRecsViaVM))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Records Entered <span style="font-weight: normal;">(Vol.)</span>:')
         .$clsRpt->writeCell(number_format($stats->lPVRecsViaVol))
         .$clsRpt->closeRow  ());

         //-----------------------
         // Other Vol. Activities
         //-----------------------
      echoT($clsRpt->blankRow());
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeTitle('Other Vol. Activities', 366, '', 3, 1, $strStyleHeaders)
         .$clsRpt->closeRow  ());

               echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Records Entered <span style="font-weight: normal;">(Vol. Mgr.)</span>:')
         .$clsRpt->writeCell(number_format($stats->lVolActViaVM))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Records Entered <span style="font-weight: normal;">(Vol.)</span>:')
         .$clsRpt->writeCell(number_format($stats->lVolActViaVol))
         .$clsRpt->closeRow  ());
      echoT($clsRpt->closeReport());

      if ($bUseAtts){
         $attributes->bCloseDiv = true;
         closeBlock($attributes);
      }else {
         closeBlock();
      }
   }
