<?php
   global $gbVolMgr;

   $params = array('enumStyle' => 'terse', 'clsRpt');
   $clsRpt = new generic_rpt($params);
   $clsRpt->strWidthLabel = '130pt';

   $attributes = new stdClass;
   $attributes->lTableWidth      = 900;
   $attributes->bStartOpen       = true;

   showVolunteerRec($clsRpt, $volRec, $lVolID);
   if ($gbVolMgr) showPatientAssoc($attributes, $clsRpt, $volRec, $lVolID, $volClient);
   showVolTraining($attributes, $clsRpt, $lVolID, $lNumTraining, $training);
   showVolStats($attributes, $clsRpt, $lVolID, $volStats);
   if ($gbVolMgr) showVolRecStats ($attributes, $clsRpt, $volRec);

   function showVolTraining($attributes, $clsRpt, $lVolID, $lNumTraining, $training){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr, $genumDateFormat;

      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'vTrain';
      $attributes->divImageID   = 'vTrainDivImg';
      $attributes->lUnderscoreWidth = 400;

      if ($gbVolMgr){
         openBlock('Volunteer Training',
                       strLinkAdd_VolTraining($lVolID, 'Add training record', true, ' id="newVT_'.$lVolID.'" ').'&nbsp;'
                      .strLinkAdd_VolTraining($lVolID, 'Add training record', false).'&nbsp;&nbsp;&nbsp;&nbsp;'
                      .strLinkView_VMgrViewVolTraining($lVolID, 'View training log', true).'&nbsp;'
                      .strLinkView_VMgrViewVolTraining($lVolID, 'View training log', false),
                      $attributes);
      }else {
         openBlock('Volunteer Training', '', $attributes);
      }

      if ($lNumTraining==0){
         echoT('<i>No training sessions have been logged for this volunteer.</i>');
      }else {
         echoT(
            '<table class="enpRpt">
               <tr>
                  <td class="enpRptLabel">
                     Date
                  </td>
                  <td class="enpRptLabel">
                     Type
                  </td>
                  <td class="enpRptLabel">
                     Duration
                  </td>
               </tr>');
         foreach ($training as $train){
            echoT('
               <tr class="makeStripe">
                  <td class="enpRpt" style="text-align: center;">'
                     .date($genumDateFormat, $train->dteTraining).'
                  </td>
                  <td class="enpRpt">'
                     .htmlspecialchars($train->strTrainingType).'
                  </td>
                  <td class="enpRpt" style="text-align: right;">'
                     .number_format(($train->lDuration/60), 2).' hrs.
                  </td>
               </tr>');
         }

         echoT('</table>');
      }

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }


   function showVolunteerRec($clsRpt, &$volRec, $lVolID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr;
      $strLinkEdit =
                 strLinkEdit_Volunteer($lVolID, 'Edit record', true,  ' id="editPrec" ').'&nbsp;'
                .strLinkEdit_Volunteer($lVolID, 'Edit', false, ' id="editPrec1" ');

      openBlock(($gbVolMgr ? 'Volunteer' : 'Your Contact Information'), $strLinkEdit);

      echoT(
          $clsRpt->openReport());

         // Vol. ID
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Vol ID:')
         .$clsRpt->writeCell (str_pad($lVolID, 5, '0', STR_PAD_LEFT))
         .$clsRpt->closeRow  ());

         // name
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Name:')
         .$clsRpt->writeCell (htmlspecialchars($volRec->strLName.', '.$volRec->strFName.' '.$volRec->strTitle))
         .$clsRpt->closeRow  ());

         // Prefered name
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Prefered Name:')
         .$clsRpt->writeCell (htmlspecialchars($volRec->strPreferred))
         .$clsRpt->closeRow  ());

         // date of birth
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Date of Birth:')
         .$clsRpt->writeCell ($volRec->mdteBirthDate)
         .$clsRpt->closeRow  ());

         // status
      if ($gbVolMgr){
         $bActive = $volRec->bActive;
         $strLinkAct = '&nbsp;&nbsp;&nbsp;'
                      .strLink_VolActiveInactive($lVolID, !$bActive, 'Set to '.(!$bActive ? 'active' : 'inactive'), true).'&nbsp;'
                      .strLink_VolActiveInactive($lVolID, !$bActive, 'Set to '.(!$bActive ? 'active' : 'inactive'), false);

         echoT(
             $clsRpt->openRow   ()
            .$clsRpt->writeLabel('Status:')
            .$clsRpt->writeCell (($volRec->bActive ? 'Active' : 'Inactive').$strLinkAct)
            .$clsRpt->closeRow  ());
      }

         // address 1
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Address 1:')
         .$clsRpt->writeCell (htmlspecialchars($volRec->strAddr1))
         .$clsRpt->closeRow  ());

         // address 2
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Address 2:')
         .$clsRpt->writeCell (htmlspecialchars($volRec->strAddr2))
         .$clsRpt->closeRow  ());

         // city/state/zip/country
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('City/State/Zip/Country:')
         .$clsRpt->writeCell (htmlspecialchars($volRec->strCity.', '.$volRec->strState.' '.$volRec->strZip.' '.$volRec->strCountry))
         .$clsRpt->closeRow  ());

         // phone
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Phone:')
         .$clsRpt->writeCell (htmlspecialchars($volRec->strPhone))
         .$clsRpt->closeRow  ());

         // cell
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Cell:')
         .$clsRpt->writeCell (htmlspecialchars($volRec->strCell))
         .$clsRpt->closeRow  ());

         // email
      if ($volRec->strEmail == ''){
         $strEMail = '';
      }else {
         $strEMail = '<a href="mailto:'.$volRec->strEmail.'">'.$volRec->strEmail.'</a>';
      }
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('EMail:')
         .$clsRpt->writeCell ($strEMail)
         .$clsRpt->closeRow  ());

         // notes
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Notes:')
         .$clsRpt->writeCell (nl2br(htmlspecialchars($volRec->strNotes)))
         .$clsRpt->closeRow  ());
      echoT(
          $clsRpt->closeReport());

      closeBlock();
   }

   function showVolStats($attributes, $clsRpt, $lVolID, $volStats){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------

      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pVH';
      $attributes->divImageID   = 'pVHDivImg';
      $attributes->lUnderscoreWidth = 400;

      openBlock('Volunteer Hours',
                    strLinkView_VMgrViewVolLog($lVolID, 'View volunteer log', true).'&nbsp;'
                   .strLinkView_VMgrViewVolLog($lVolID, 'View volunteer log', false),
                   $attributes);

      echoT(
          $clsRpt->openReport());

         // # Patient Visits
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('# Patient Visits:')
         .$clsRpt->writeCell ($volStats->lNumPVisit)
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Patient Visit Hours:')
         .$clsRpt->writeCell (number_format($volStats->pvHrs, 2).' hrs.')
         .$clsRpt->closeRow  ());

         // # Other Activities
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('# Other Activities:')
         .$clsRpt->writeCell ($volStats->lNumNonPVisit)
         .$clsRpt->closeRow  ());

         // Other Activities
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Other Activity Hours:')
         .$clsRpt->writeCell (number_format($volStats->nonPVHrs, 2).' hrs.')
         .$clsRpt->closeRow  ());

         // Total Hours
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Total Hours:')
         .$clsRpt->writeCell (number_format($volStats->nonPVHrs+$volStats->pvHrs, 2).' hrs.')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->closeReport());

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showPatientAssoc($attributes, $clsRpt, $volRec, $lVolID, $volClient){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $bActive = $volRec->bActive;

      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pAssoc';
      $attributes->divImageID   = 'pAssocDivImg';
      $attributes->lUnderscoreWidth = 400;

      if ($bActive){
         $strLinkAddNewA =
              strLinkAdd_PatientAssociation($lVolID, 'Add patient association', true).'&nbsp;'
             .strLinkAdd_PatientAssociation($lVolID, 'Add patient association', false);

      }else {
         $strLinkAddNewA = '';
      }

      openBlock('Volunteer/Patient Associations', $strLinkAddNewA, $attributes);
      if (count($volClient)==0){
         echoT('<i>No associated patients</i>');
      }else {
         echoT('
            <table class="enpRpt">
               <tr>
                  <td class="enpRptLabel">
                     Patient ID
                  </td>
                  <td class="enpRptLabel">
                     Patient
                  </td>
                  <td class="enpRptLabel">
                     Status
                  </td>');
         if ($bActive){
            echoT('
                  <td class="enpRptLabel">
                     &nbsp;
                  </td>
                  <td class="enpRptLabel">
                     &nbsp;
                  </td>');
         }
         echoT('
               </tr>');

         foreach($volClient as $vc){
            $bVCActive    = $vc->bActive;
            if ($bVCActive){
               $strALabel  = 'Set inactive';
               $lRowSpan   = 3;
               $strNameColor = '#000';
            }else {
               $strALabel  = 'Set active';
               $lRowSpan   = 2;
               $strNameColor = '#999';
            }
            $lAssocID   = $vc->lKeyID;
            $lPatientID = $vc->lPatientID;
            echoT('
               <tr class="makeStripe">
                  <td style="vertical-align: top; color: '.$strNameColor.';" class="enpRpt">'
                     .strLinkView_PatientRecord($lPatientID, 'View patient record', true).'&nbsp;'
                     .str_pad($lPatientID, 5, '0', STR_PAD_LEFT).'
                  </td>');

            echoT('
                  <td style="vertical-align: top; padding-right: 8px; color: '.$strNameColor.';" class="enpRpt">'
                     .htmlspecialchars($vc->patient->strLName.', '.$vc->patient->strFName).'
                  </td>');

            echoT('
                  <td style="vertical-align: top; padding-right: 8px; color: '.$strNameColor.';" class="enpRpt">'
                     .($bVCActive ? '<b>Active</b>':'Inactive').'
                  </td>');

            if ($bActive){

               if ($bVCActive){
                  echoT('
                     <td style="vertical-align: top;" class="enpRpt">'
                        .strLinkAdd_HospicePVist($lVolID, $vc->lPatientID, 'Add patient visit', true).'&nbsp;'
                        .strLinkAdd_HospicePVist($lVolID, $vc->lPatientID, 'Add patient visit', false).'
                     </td>');
               }else {
                  echoT('
                     <td style="vertical-align: top;" class="enpRpt">&nbsp;</td>');
               }
               echoT('
                     <td style="vertical-align: top;" class="enpRpt">'
                        .strLink_VolAssocActiveInactive($lVolID, $lAssocID, !$bActive, $strALabel, true).'&nbsp;'
                        .strLink_VolAssocActiveInactive($lVolID, $lAssocID, !$bActive, $strALabel, false).'
                     </td>');
            }
            echoT('
               </tr>');
         }
         echoT('</table>');
      }

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showVolRecStats($attributes, $clsRpt, $volRec){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pStats';
      $attributes->divImageID   = 'pStatsDivImg';
      $attributes->lUnderscoreWidth = 400;
      openBlock('Record Information', '', $attributes);
      echoT(
         $clsRpt->showRecordStats($volRec->dteOrigin,
                               $volRec->strUCFName.' '.$volRec->strUCLName,
                               $volRec->dteLastUpdate,
                               $volRec->strULFName.' '.$volRec->strULLName,
                               $clsRpt->strWidthLabel));
      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }



