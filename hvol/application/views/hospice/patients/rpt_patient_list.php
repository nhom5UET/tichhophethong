<?php
   global $genumDateFormat, $gbVolMgr;

   if ($lNumPatients == 0){
      echoT('<br><br><i>No patients match your search criteria</i><br>');
      return;
   }

   echoT('<br>
      <table class="enpRptC">
         <tr>
            <td class="enpRptLabel">&nbsp;</td>
            <td class="enpRptLabel">Patient ID</td>
            <td class="enpRptLabel">&nbsp;</td>
            <td class="enpRptLabel">Name</td>
            <td class="enpRptLabel">Contact Info</td>
            <td class="enpRptLabel">Assigned Vols.</td>
            <td class="enpRptLabel">Patient Contacts</td>
         </tr>');
   $params = array('enumStyle' => 'enpRptC');
   $clsRpt = new generic_rpt($params);

   $lRowIDX = 1;
   $lVolWidth = 170;
   foreach ($patientInfo as $patient){
      $bActive = $patient->bActive;
      if ($bActive){
         $strStyleActive = '';
      }else {
         $strStyleActive = 'color: #999;';
      }

      $lPatientID = $patient->lKeyID;
      echoT($clsRpt->openRow(true));
      echoT($clsRpt->writeCell($lRowIDX, '', 'text-align: center;'));

      echoT($clsRpt->writeCell(
                    strLinkView_PatientRecord($lPatientID, 'View patient record', true,
                          ' id="prec_'.$lPatientID.'" ')
                          .'&nbsp;'.str_pad($lPatientID, 5, '0', STR_PAD_LEFT), 60,
                          $strStyleActive.'text-align: center;'));

      echoT($clsRpt->writeCell(
               strLink_PatientActiveInactive($lPatientID, !$bActive, ($bActive ? 'Set Inactive' : 'Activate'), true),
               30, $strStyleActive.'text-align: center;'));

      echoT($clsRpt->writeCell('<b>'.$patient->strSafeNameLF.'</b><br>DOB: '
                        .$patient->dteBirth, 170, $strStyleActive));

      echoT($clsRpt->writeCell($patient->strAddress, 170, $strStyleActive));

         //---------------------------
         // volunteer associations
         //---------------------------
      if (count($patient->volClient)==0){
         echoT($clsRpt->writeCell('- none -', $lVolWidth, 'text-align: center;'));
      }else {
         $strVols = '<ul style="list-style-position: inside; list-style-type: square; display:inline;
                              margin-left: 0pt; padding-left: 0pt;">';
         foreach ($patient->volClient as $vc){
            $strVols .= '<li>'.htmlspecialchars($vc->vol->strLName.', '.$vc->vol->strFName).'&nbsp;'
            .strLinkAdd_HospicePVist($vc->lVolID, $vc->lPatientID,
                            'Add visit', false, ' id="apv_'.$vc->lVolID.'_'.$vc->lPatientID.' " ').'</li>';
         }
         echoT($clsRpt->writeCell($strVols.'</ul>', $lVolWidth, ''));
      }

         //---------------------------
         // patient contacts
         //---------------------------
      $strLinkAddNewPC = strLinkAdd_PatientContact($lPatientID, 'Add patient contact', true, ' id="newPCon_'.$lPatientID.'" ' ).'&nbsp;'
                        .strLinkAdd_PatientContact($lPatientID, 'Add patient contact', false);
      if (count($patient->pContacts)==0){
         echoT($clsRpt->writeCell('<span style="text-align: center; margin-left: 40pt;">- none -</span><br>'
                    .$strLinkAddNewPC, '200pt;', ''));
      }else {
         $strPC = '';
         foreach ($patient->pContacts[0]->contacts as $pc){
            $lPConID = $pc->lContactID;
            $strPC .= trim(htmlspecialchars($pc->strPConTitle.' '.$pc->strFName.' '.$pc->strLName
                       .' ('.$pc->strRelationship.')'))
                       .strLinkView_PContact($lPConID, 'View patient contact record', true, ' id="viewPCon_'.$lPConID.'" ')
                       .'<br>';
         }
         echoT($clsRpt->writeCell($strPC.'<br>'.$strLinkAddNewPC, '200', ''));
      }

      echoT($clsRpt->closeRow());
      ++$lRowIDX;
   }
   echoT($clsRpt->closeReport());

