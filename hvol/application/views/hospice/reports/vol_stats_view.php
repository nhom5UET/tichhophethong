<?php

   $attributes = new stdClass;
   $attributes->lTableWidth      = 900;
   $attributes->lUnderscoreWidth = 350;
   $attributes->bStartOpen       = false;

   $params = array('enumStyle' => 'terse', 'clsRpt');
   $clsRpt = new generic_rpt($params);
   $clsRpt->strWidthLabel = '130pt';

   showVolStats($clsRpt, 'For the year '.$lYear, $yearStats, false, $attributes, null);

   for ($idx=1; $idx<=12; ++$idx){
      showVolStats($clsRpt, strXlateMonth($idx).' '.$lYear, $volMonth[$idx], true, $attributes, $idx);
   }

   function showVolStats($clsRpt, $strLabel, $volStats, $bUseAtts, $attributes, $lMonth){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($bUseAtts){
         $attributes->bCloseDiv  = false;
         $attributes->divID      = 'group_'.$lMonth.'_Div';
         $attributes->divImageID = 'group_'.$lMonth.'_DivImg';
         openBlock($strLabel, '', $attributes);
      }else {
         openBlock($strLabel, '');
      }

      echoT(
          $clsRpt->openReport());

         // new volunteers
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('# New Volunteers:')
         .$clsRpt->writeCell(number_format($volStats->lNewVols))
         .$clsRpt->closeRow  ());

         // inactive volunteers
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('# Inactive Volunteers:')
         .$clsRpt->writeCell(number_format($volStats->lInactiveVols)
                     .' <i>(volunteers who became inactive in this time period)</i>')
         .$clsRpt->closeRow  ());

         // patient visit hours
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Patient Visit Hours:')
         .$clsRpt->writeCell(number_format($volStats->sngPVisitHrs, 2).' hrs.')
         .$clsRpt->closeRow  ());

         // other volunteer hours
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Other Volunteer Hours:')
         .$clsRpt->writeCell(number_format($volStats->sngNonPVHrs, 2).' hrs.')
         .$clsRpt->closeRow  ());

         // Total volunteer training hours
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Vol. Training Hours:')
         .$clsRpt->writeCell(number_format($volStats->sngVolTrainingHrs, 2).' hrs.')
         .$clsRpt->closeRow  ());

         // Total volunteer training sessions
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Vol. Training Sessions:')
         .$clsRpt->writeCell(number_format($volStats->lNumTrainingSessions))
         .$clsRpt->closeRow  ());


      echoT($clsRpt->closeReport());
      if ($bUseAtts){
         $attributes->bCloseDiv = true;
         closeBlock($attributes);
      }else {
         closeBlock();
      }
   }
