<?php

   if ($bByMonth){
      $strLabelExtra = ' for '.strXlateMonth($lMonth).' '.$lYear;
   }elseif ($bByYear){
      $strLabelExtra = ' for the year '.$lYear;
   }else {
      $strLabelExtra = '';
   }

   $params = array('enumStyle' => 'terse', 'clsRpt');
   $clsRpt = new generic_rpt($params);
   $clsRpt->strWidthLabel = '170pt';

   $attributes = new stdClass;
   $attributes->lTableWidth      = 900;
   $attributes->lUnderscoreWidth = 350;
   $attributes->bStartOpen       = false;
   displayOrgStatSet('Organization Stats'.$strLabelExtra, $clsRpt, $attributes, false, null, $orgStats, $bByYear, $lYear);

   foreach ($locations as $loc){
      $strLocName = $loc->strSafeLocationName;
      if (!$loc->bActive) $strLocName .= ' (inactive)';

      displayOrgStatSet($strLocName.$strLabelExtra, $clsRpt, $attributes, true, $loc->lKeyID, $loc->stats, $bByYear, $lYear);
   }

   function displayOrgStatSet($strLabel, &$clsRpt, &$attributes, $bUseAtts, $locID, $stats, $bByYear, $lYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
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

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Total Patient Visits:')
         .$clsRpt->writeCell(number_format($stats->lNumPatientVisits))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Patients Receiving Visits:')
         .$clsRpt->writeCell(number_format($stats->lNumPatients))
         .$clsRpt->closeRow  ());

      echoT($clsRpt->blankRow());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Total Patient Records:')
         .$clsRpt->writeCell(number_format($stats->lNumPRecsActive + $stats->lNumPRecsInactive))
         .$clsRpt->closeRow  ());

      if ($bByYear){
         $strLabelActPatients   = ' <i>Patients added in '.$lYear.'</i>';
         $strLabelInactPatients = ' <i>Patients who became inactive in '.$lYear.'</i>';
         $strLabelActVols       = ' <i>Volunteers added in '.$lYear.'</i>';
         $strLabelInactVols     = ' <i>Volunteers who became inactive in '.$lYear.'</i>';
      }else {
         $strLabelActPatients   = 
         $strLabelInactPatients = 
         $strLabelActVols       = 
         $strLabelInactVols     = '';
      }
      
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Active Patients:')
         .$clsRpt->writeCell(number_format($stats->lNumPRecsActive).$strLabelActPatients)
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Inactive Patient:')
         .$clsRpt->writeCell(number_format($stats->lNumPRecsInactive).$strLabelInactPatients)
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('# Patient Contacts:')
         .$clsRpt->writeCell(number_format($stats->lNumPRConRecs))
         .$clsRpt->closeRow  ());

      echoT($clsRpt->blankRow());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Total # of Volunteers:')
         .$clsRpt->writeCell(number_format($stats->lNumVolsActive + $stats->lNumVolsInactive))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Active Volunteers:')
         .$clsRpt->writeCell(number_format($stats->lNumVolsActive).$strLabelActVols)
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Inactive Volunteers:')
         .$clsRpt->writeCell(number_format($stats->lNumVolsInactive).$strLabelInactVols)
         .$clsRpt->closeRow  ());

      echoT($clsRpt->blankRow());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Total Patient Visit Hours:')
         .$clsRpt->writeCell(number_format($stats->sngTotPVHrsMins, 2))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Total Non-Visit Vol. Hours:')
         .$clsRpt->writeCell(number_format($stats->sngTotNonPVHrsMins, 2))
         .$clsRpt->closeRow  ());

      echoT($clsRpt->closeReport());

      if ($bUseAtts){
         $attributes->bCloseDiv = true;
         closeBlock($attributes);
      }else {
         closeBlock();
      }
   }

