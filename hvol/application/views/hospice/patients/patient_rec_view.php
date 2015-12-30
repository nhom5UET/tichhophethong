<?php
   global $gbVolMgr;

   $params = array('enumStyle' => 'terse', 'clsRpt');
   $clsRpt = new generic_rpt($params);
   $clsRpt->strWidthLabel = '130pt';

   $attributes = new stdClass;
   $attributes->lTableWidth      = 900;
   $attributes->lUnderscoreWidth = 400;
   $attributes->bStartOpen       = true;

   showPatientRec     ($clsRpt, $patient, $lPatientID);
   showPatientVisits  ($attributes, $clsRpt, $patient, $lPatientID, $lNumPVRecs, $pVisits);
   showPatientContacts($attributes, $clsRpt, $patient, $lPatientID, $lNumPCons, $pCons);
   showPatientVolAssoc($attributes, $clsRpt, $patient, $lPatientID, $volClientAssoc);
   showPatientStats   ($attributes, $clsRpt, $patient);

   function showPatientRec($clsRpt, $patient, $lPatientID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strLinkEdit =
                 strLinkEdit_Patient($lPatientID, 'Edit record', true,  ' id="editPrec" ').'&nbsp;'
                .strLinkEdit_Patient($lPatientID, 'Edit record', false, ' id="editPrec1" ');

      openBlock('Patient', $strLinkEdit);

      echoT(
          $clsRpt->openReport());

         // Patient ID
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Patient ID:')
         .$clsRpt->writeCell (str_pad($lPatientID, 5, '0', STR_PAD_LEFT))
         .$clsRpt->closeRow  ());

         // name
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Name:')
         .$clsRpt->writeCell (htmlspecialchars($patient->strLName.', '
                          .$patient->strFName.' '.$patient->strMName.' '.$patient->strTitle))
         .$clsRpt->closeRow  ());

         // date of birth
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Date of Birth:')
         .$clsRpt->writeCell ($patient->dteBirth)
         .$clsRpt->closeRow  ());

         // status
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Status:')
         .$clsRpt->writeCell (($patient->bActive ? 'Active' : 'Inactive'))
         .$clsRpt->closeRow  ());

         // address 1
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Address 1:')
         .$clsRpt->writeCell (htmlspecialchars($patient->strAddr1))
         .$clsRpt->closeRow  ());

         // address 2
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Address 2:')
         .$clsRpt->writeCell (htmlspecialchars($patient->strAddr2))
         .$clsRpt->closeRow  ());

         // city/state/zip/country
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('City/State/Zip/Country:')
         .$clsRpt->writeCell (htmlspecialchars($patient->strCity.', '.$patient->strState.' '.$patient->strZip.' '.$patient->strCountry))
         .$clsRpt->closeRow  ());

         // phone
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Phone:')
         .$clsRpt->writeCell (htmlspecialchars($patient->strPhone))
         .$clsRpt->closeRow  ());

         // cell
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Cell:')
         .$clsRpt->writeCell (htmlspecialchars($patient->strCell))
         .$clsRpt->closeRow  ());

         // email
      if ($patient->strEmail == ''){
         $strEMail = '';
      }else {
         $strEMail = '<a href="mailto:'.$patient->strEmail.'">'.$patient->strEmail.'</a>';
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
         .$clsRpt->writeCell (nl2br(htmlspecialchars($patient->strBio)))
         .$clsRpt->closeRow  ());
      echoT(
          $clsRpt->closeReport());

      closeBlock();
   }

   function showPatientVolAssoc($attributes, $clsRpt, $patient, $lPatientID, $pvAssoc){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lNumPVAssoc = count($pvAssoc);

      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pVA';
      $attributes->divImageID   = 'pVADivImg';
      openBlock('Patient / Volunteer Associations', '', $attributes);
      if ($lNumPVAssoc==0){
         echoT('<i>There are no associated volunteers for this patient.</i><br>');
      }else {
         echoT('
            <table class="enpRpt">
               <tr>
                  <td class="enpRptLabel">
                     volunteerID
                  </td>
                  <td class="enpRptLabel">
                     Name
                  </td>
                  <td class="enpRptLabel">
                     Address
                  </td>
                  <td class="enpRptLabel">
                     Contact
                  </td>
               </tr>');

         foreach ($pvAssoc as $pva){
            $lVolID = $pva->lVolID;
            echoT('
               <tr class="makeStripe">
                  <td class="enpRpt" style="text-align: center;">'
                     .str_pad($lVolID, 5, '0', STR_PAD_LEFT).'&nbsp;'
                     .strLinkView_VolRecord($lVolID, 'View volunteer record', true).'
                  </td>
                  <td class="enpRpt">'
                     .htmlspecialchars($pva->vol->strLName.', '.$pva->vol->strFName).'
                  </td>
                  <td class="enpRpt">'
                     .$pva->vol->strAddress.'
                  </td>
                  <td class="enpRpt">
                     <table style="width: 100%;">
                        <tr><td style="width: 40pt; height: 7pt; padding-top: 0px;padding-bottom: 0px;"><b>phone: </b></td><td>'.htmlspecialchars($pva->vol->strPhone).'</td></tr>
                        <tr><td style="width: 40pt; height: 7pt; padding-top: 0px;padding-bottom: 0px;"><b>cell: </b></td><td>' .htmlspecialchars($pva->vol->strCell).'</td></tr>
                        <tr><td style="width: 40pt; height: 7pt; padding-top: 0px;padding-bottom: 0px;"><b>email: </b></td><td>'.htmlspecialchars($pva->vol->strEmail).'</td></tr>
                     </table>
                  </td>
               </tr>');
         }
         echoT('</table>');
      }

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }



   function showPatientVisits($attributes, $clsRpt, $patient, $lPatientID, $lNumPVRecs, $pVisits){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------

      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pVisits';
      $attributes->divImageID   = 'pVisitsDivImg';
      openBlock('Patient Visits', '', $attributes);

      if ($lNumPVRecs==0){
         echoT('<i>No visits have been recorded for this patient.</i>');
      }else {
         echoT('
            <table class="enpRpt">
               <tr>
                  <td class="enpRptLabel">
                     visit ID
                  </td>
                  <td class="enpRptLabel">
                     Date of Visit
                  </td>
                  <td class="enpRptLabel">
                     Volunteer
                  </td>
                  <td class="enpRptLabel">
                     Location
                  </td>
                  <td class="enpRptLabel">
                     Activity
                  </td>
               </tr>');

         foreach ($pVisits as $pV){
            $lVisitID = $pV->lKeyID;
            $lVolID   = $pV->lVolID;
            echoT('
                  <tr class="makeStripe">
                     <td class="enpRpt" style="text-align: center;">'
                        .str_pad($lVisitID, 5, '0', STR_PAD_LEFT).'&nbsp;'
                        .strLinkView_PVisit($lVisitID, 'View visit record', true).'
                     </td>
                     <td class="enpRpt" style="text-align: center;">'
                        .date('D m/d/Y', $pV->dteVisit).'
                     </td>
                     <td class="enpRpt">'
                        .strLinkView_VolRecord($lVolID, 'View volunteer record', true).'&nbsp;'
                        .htmlspecialchars($pV->strVolLName.', '.$pV->strVolFName).'
                     </td>
                     <td class="enpRpt">'
                        .htmlspecialchars($pV->strLocation).'
                     </td>
                     <td class="enpRpt">'
                        .htmlspecialchars($pV->strActivity).'
                     </td>
                  </tr>');
         }

         echoT('
            </table>');
      }

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showPatientContacts($attributes, $clsRpt, $patient, $lPatientID, $lNumPCons, $pCons){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pCons';
      $attributes->divImageID   = 'pConsDivImg';
      openBlock('Patient Contacts',
            strLinkAdd_PatientContact($lPatientID, 'Add contact', true).'&nbsp;'
           .strLinkAdd_PatientContact($lPatientID, 'Add contact', false),
            $attributes);

      if ($lNumPCons==0){
         echoT('<i>There are no contacts for this patient.</i><br>');
      }else {
         echoT('
            <table class="enpRpt">
               <tr>
                  <td class="enpRptLabel">
                     contactID
                  </td>
                  <td class="enpRptLabel">
                     Name
                  </td>
                  <td class="enpRptLabel">
                     Relationship
                  </td>
                  <td class="enpRptLabel">
                     Address
                  </td>
                  <td class="enpRptLabel">
                     Contact
                  </td>
               </tr>');

         foreach ($pCons as $pCon){
            $lPCID = $pCon->lContactID;
            echoT('
               <tr class="makeStripe">
                  <td class="enpRpt" style="text-align: center;">'
                     .str_pad($lPCID, 5, '0', STR_PAD_LEFT).'&nbsp;'
                     .strLinkView_PContact($lPCID, 'View contact record', true).'
                  </td>
                  <td class="enpRpt">'
                     .htmlspecialchars($pCon->strLName.', '.$pCon->strFName).'
                  </td>
                  <td class="enpRpt">'
                     .htmlspecialchars($pCon->strRelationship).'
                  </td>
                  <td class="enpRpt">'
                     .$pCon->strAddress.'
                  </td>
                  <td class="enpRpt">
                     <table style="width: 100%;">
                        <tr><td style="width: 40pt; height: 7pt; padding-top: 0px;padding-bottom: 0px;"><b>phone: </b></td><td>'.htmlspecialchars($pCon->strPhone).'</td></tr>
                        <tr><td style="width: 40pt; height: 7pt; padding-top: 0px;padding-bottom: 0px;"><b>cell: </b></td><td>' .htmlspecialchars($pCon->strCell).'</td></tr>
                        <tr><td style="width: 40pt; height: 7pt; padding-top: 0px;padding-bottom: 0px;"><b>email: </b></td><td>'.htmlspecialchars($pCon->strEmail).'</td></tr>
                     </table>
                  </td>
               </tr>');
         }
         echoT('</table>');
      }

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showPatientStats($attributes, $clsRpt, $patient){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pStats';
      $attributes->divImageID   = 'pStatsDivImg';
      openBlock('Record Information', '', $attributes);
      echoT(
         $clsRpt->showRecordStats($patient->dteOrigin,
                               $patient->ucstrFName.' '.$patient->ucstrLName,
                               $patient->dteLastUpdate,
                               $patient->ulstrFName.' '.$patient->ulstrLName,
                               $clsRpt->strWidthLabel));
      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }



