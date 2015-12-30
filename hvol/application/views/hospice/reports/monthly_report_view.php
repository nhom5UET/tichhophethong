<?php

   $params = array('enumStyle' => 'terse', 'clsRpt');
   $clsRpt = new generic_rpt($params);
   $clsRpt->strWidthLabel = '170pt';

   $attributes = new stdClass;
   $attributes->lTableWidth      = 900;
   $attributes->lUnderscoreWidth = 350;
   $attributes->bStartOpen       = true;


   openBlock('Monthly Report for '.strXlateMonth($lMonth).' '.$lYear, '');

   showHours   ($clsRpt, $attributes, $lMonth, $lYear, $sngHrsMins, $sngNonPVHrs);
   showVolCount($clsRpt, $attributes, $lMonth, $lYear, $lNumVolsPV,
                              $lNumVolsNonPV, $lNumUniqueVolID);
   showPatientsServed($clsRpt, $attributes, $lMonth, $lYear, $lNumPatients, $lNumPatientVisits);

   closeBlock();

   function showPatientsServed($clsRpt, $attributes, $lMonth, $lYear, $lNumPatients, $lNumPatientVisits){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv        = false;
      $attributes->divID            = 'csDiv';
      $attributes->divImageID       = 'csDivImg';

      openBlock('Patients Served', '', $attributes);
      echoT(
          $clsRpt->openReport());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('# Patient Visits:')
         .$clsRpt->writeCell(number_format($lNumPatientVisits).' '
                    .strLinkView_VMgrRptPVViaMonth($lMonth, $lYear, 'View details', true)
                            )
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('# Unique Patients:')
         .$clsRpt->writeCell(number_format($lNumPatients).' '
                    .strLinkView_VMgrRptUniquePatientsViaMonth($lMonth, $lYear, 'View details', true)
                            )
         .$clsRpt->closeRow  ());

      echoT($clsRpt->closeReport());
      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showVolCount($clsRpt, $attributes, $lMonth, $lYear,
                         $lNumVolsPV, $lNumVolsNonPV, $lNumUniqueVolID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv        = false;
      $attributes->divID            = 'cntDiv';
      $attributes->divImageID       = 'cntDivImg';

      openBlock('Volunteer Engagement', '', $attributes);
      echoT(
          $clsRpt->openReport());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('# Vols making Patient Visits:')
         .$clsRpt->writeCell(number_format($lNumVolsPV).' '
                    .strLinkView_VMgrRptVolCntPVViaMonth($lMonth, $lYear, 'View details', true)
                            )
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('# Vols / Other Activities:')
         .$clsRpt->writeCell(number_format($lNumVolsNonPV).' '
                    .strLinkView_VMgrRptVolCntNonPVViaMonth($lMonth, $lYear, 'View details', true)
                            )
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('# Unique Volunteers:')
         .$clsRpt->writeCell(number_format($lNumUniqueVolID))
         .$clsRpt->closeRow  ());


      echoT($clsRpt->closeReport());
      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showHours($clsRpt, $attributes, $lMonth, $lYear, $sngHrsMins, $sngNonPVHrs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv        = false;
      $attributes->divID            = 'hrsDiv';
      $attributes->divImageID       = 'hrsDivImg';

      openBlock('Volunteer Hours', '', $attributes);
      echoT(
          $clsRpt->openReport());

         // patient visit hours
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Patient Visit Hours:')
         .$clsRpt->writeCell(number_format($sngHrsMins, 2).' hours '
                    .strLinkView_VMgrRptVolHrsPVViaMonth($lMonth, $lYear, 'View details', true)
                            )
         .$clsRpt->closeRow  ());

         // non-patient visit hours
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Other Volunteer Hours:')
         .$clsRpt->writeCell(number_format($sngNonPVHrs, 2).' hours'
                     .strLinkView_VMgrRptVolHrsNonPVViaMonth($lMonth, $lYear, 'View details', true)
                            )
         .$clsRpt->closeRow  ());

         // total volunteer hours
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Total Volunteer Hours:')
         .$clsRpt->writeCell('<b>'.number_format($sngNonPVHrs+$sngHrsMins, 2).' hours</b>')
         .$clsRpt->closeRow  ());


      echoT($clsRpt->closeReport());
      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }



