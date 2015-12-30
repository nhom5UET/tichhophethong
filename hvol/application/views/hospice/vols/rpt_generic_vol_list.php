<?php

   global $genumDateFormat, $gbAdmin;

   $params = array('enumStyle' => 'enpRptC');
   $clsRpt = new generic_rpt($params);

   $lNumCols = 8;
   $lPatientWidth = 240;

   echoT('<br>'.$clsRpt->openReport());
   echoT($clsRpt->writeTitle($strRptTitle, '', '', $lNumCols));

   echoT($clsRpt->openRow(true));
   echoT($clsRpt->writeLabel('Vol. ID',              60));
   echoT($clsRpt->writeLabel('Active?',              60));
   echoT($clsRpt->writeLabel('Volunteer Name',      220));
   echoT($clsRpt->writeLabel('Address',              60));
   echoT($clsRpt->writeLabel('Phone/Email',          60));
   echoT($clsRpt->writeLabel('Vol. Tools',          100));
   echoT($clsRpt->writeLabel('Associated Patients', $lPatientWidth));
   echoT($clsRpt->closeRow());

   if ($lNumVols == 0){
      echoT($clsRpt->openRow(true));
      echoT($clsRpt->writeCell('<i>No volunteers match your search criteria</i>', '', '', $lNumCols));
      echoT($clsRpt->closeReport());
   }else {
      foreach ($vols as $vol){
         $bInactive = $vol->bInactive;
         $lVolID    = $vol->lKeyID;
         $lAcctID   = $vol->lAcctID;
         if ($bInactive){
            $strColor = ' color: #888;';
         }else {
            $strColor = '';
         }

         if ($bInactive){
            $strLinkResetPW     =
            $strLinkAddMiscAct  =
            $strLinkAddNewAssoc = 
            $strLinkTraining    = '';
         }else {
            $strLinkResetPW =
                  strLinkEdit_ResetPWord($lAcctID, true,  'Password').'&nbsp;'
                 .strLinkEdit_ResetPWord($lAcctID, false, 'Password').'<br>';
            $strLinkAddMiscAct =
                  strLinkAdd_VolMgrAddMiscVolActivity($lVolID, 'Vol. activity', true, ' id="otherVAct_'.$lVolID.'" ').'&nbsp;'
                 .strLinkAdd_VolMgrAddMiscVolActivity($lVolID, 'Vol. activity', false).'<br>';
            $strLinkAddNewAssoc =
                  strLinkAdd_PatientAssociation($lVolID, 'Add association', true,
                            ' id="pvAssoc_'.$lVolID.'" ').'&nbsp;'
                 .strLinkAdd_PatientAssociation($lVolID, 'Add association', false).'<br>';
            $strLinkTraining = 
                  strLinkView_VMgrViewVolTraining($lVolID, 'Training Log', true, ' id="vTrain_'.$lVolID.'" ').'&nbsp;'
                 .strLinkView_VMgrViewVolTraining($lVolID, 'Training Log', false);
         }

         echoT($clsRpt->openRow(true));
         echoT($clsRpt->writeCell(
                               strLinkView_VolRecord($lVolID, 'View record', true, ' id="vvolRec_'.$lVolID.'" ')
                              .'&nbsp;'.str_pad($lVolID, 5, '0', STR_PAD_LEFT)
                              , 60, 'text-align: center;'.$strColor)
                              );
         echoT($clsRpt->writeCell(
                            ($vol->bInactive ? 'No' : 'Yes').'&nbsp;'
                            .strLink_VolActiveInactive($lVolID, $bInactive, 'Set to '.($bInactive ? 'active' : 'inactive'), true),
                            60, 'text-align: center;'.$strColor));

            //---------------------------
            // name
            //---------------------------
         echoT($clsRpt->writeCell($vol->strSafeNameLF
                              .'<br><br>'
                              .strLinkView_VMgrViewVolLog($lVolID, 'Volunteer Log', true).'&nbsp;'
                              .strLinkView_VMgrViewVolLog($lVolID, 'Volunteer Log', false).'<br>',
                              220, $strColor));

            //---------------------------
            // address
            //---------------------------
         $strPC = trim(strPhoneCell($vol->strPhone, $vol->strCell, true, true));
         if ($strPC != '') $strPC .= '<br>';
         echoT($clsRpt->writeCell($vol->strAddress, 160, $strColor));
         echoT($clsRpt->writeCell($strPC.$vol->strEmailFormatted, 100, $strColor));

            //---------------------------
            // tools
            //---------------------------
         echoT($clsRpt->writeCell($strLinkAddMiscAct.$strLinkResetPW.$strLinkTraining, 100, $strColor));

            //---------------------------
            // patient associations
            //---------------------------
         if (count($vol->volClient)==0){
            echoT($clsRpt->writeCell('<table width="100%"><tr><td style="text-align: center;">- none -</td></tr></table>'.$strLinkAddNewAssoc,
                                $lPatientWidth, $strColor));
         }else {
            $strPatients = '<table style="border: 1px solid #aaa; margin-bottom: 10px; width: 100%">';
            foreach ($vol->volClient as $vc){
               $bVAActive    = $vc->bActive;
               if ($bVAActive){
                  $strALabel  = 'Set inactive';
                  $lRowSpan   = 3;
                  $strNameColor = '#000';
               }else {
                  $strALabel  = 'Set active';
                  $lRowSpan   = 2;
                  $strNameColor = '#999';
               }
               if ($bInactive) $lRowSpan = 1;
               $lAssocID   = $vc->lKeyID;
               $lPatientID = $vc->lPatientID;

               if ($bInactive) $strNameColor = '#999';

               $strPatients .=
                  '<tr>
                     <td style="vertical-align: top; padding-right: 8px; color: '.$strNameColor.';" rowspan='.$lRowSpan.'>'
                        .htmlspecialchars($vc->patient->strLName.', '.$vc->patient->strFName).'
                     </td>';
               if (!$bInactive && $bVAActive){
                  $strPatients .= '
                     <td style="vertical-align: top;">'
                        .strLinkAdd_HospicePVist($lVolID, $vc->lPatientID, 'Patient visit', true,
                                   ' id="addVisit_'.$lVolID.'_'.$vc->lPatientID.'" ').'&nbsp;'
                        .strLinkAdd_HospicePVist($lVolID, $vc->lPatientID, 'Patient visit', false).'
                     </td>
                  </tr>
                  <tr>';
               }
               if (!$bInactive){
                  $strPatients .= '
                        <td style="vertical-align: top;">'
                           .strLink_VolAssocActiveInactive($lVolID, $lAssocID, !$bVAActive, $strALabel, true).'&nbsp;'
                           .strLink_VolAssocActiveInactive($lVolID, $lAssocID, !$bVAActive, $strALabel, false).'
                        </td>
                     </tr>
                     <tr>
                        <td style="vertical-align: top; padding-bottom: 8px;">'
                           .strLinkView_PatientRecord($lPatientID, 'View patient record', true).'&nbsp;patient ID: '
                           .str_pad($lPatientID, 5, '0', STR_PAD_LEFT).'
                        </td>';
               }
               $strPatients .= '
                  </tr>';
            }
            echoT($clsRpt->writeCell($strPatients.'</table>'.$strLinkAddNewAssoc, $lPatientWidth, $strColor));
         }
      }
      echoT($clsRpt->closeReport());
   }









