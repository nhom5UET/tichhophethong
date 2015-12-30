<?php

   $strDate = strXlateMonth($lMonth).' '.$lYear;

   if ($lNumPRecs == 0){
      echoT('<br><i>There are no <b>Patients Served</b> during '.$strDate.'.</i><br><br>');
      return;
   }

   echoT('<br>
      <table class="enpRptC">
         <tr>
            <td class="enpRptTitle" colspan="5">
               Patient Served / '.$strDate.'
            </td>
         </tr>');

   echoT('
      <tr>
         <td class="enpRptLabel">
            &nbsp;
         </td>
         <td class="enpRptLabel">
            Patient
         </td>
         <td class="enpRptLabel">
            Address
         </td>
         <td class="enpRptLabel">
            Email/Phone
         </td>
         <td class="enpRptLabel">
            Patient Visits
         </td>
      </tr>');

   $idx = 1;
   foreach ($pInfo as $pRec){
      echoT('<tr class="makeStripe">'."\n");

      showPInfo($idx, $pRec);
      showPVisitInfo($pRec->pVisits);

      echoT('</tr>'."\n");
      ++$idx;
   }
   echoT('</table><br><br>');


   function showPInfo($idx, $pRec){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
//      $lVolID = $volRec->lVID;

      $strPhone = '';
      if ($pRec->strPatientPhone != ''){
         $strPhone .= '<br><b>phone:</b> '.htmlspecialchars($pRec->strPatientPhone);
      }
      if ($pRec->strPatientCell != ''){
         $strPhone .= '<br><b>cell:</b> '.htmlspecialchars($pRec->strPatientCell);
      }

      echoT('
         <td class="enpRpt" style="text-align: center; width: 30pt;">'
            .$idx.'
         </td>
         <td class="enpRpt" style="width: 110pt;"><b>'
            .htmlspecialchars($pRec->strPatientLName).'</b>, '.htmlspecialchars($pRec->strPatientFName).'<br>'
//            .strLinkView_VMgrViewVolLog($lVolID, 'Volunteer Log', true).'&nbsp;'
//            .strLinkView_VMgrViewVolLog($lVolID, 'Volunteer Log', false).'

          .'
         </td>
         <td class="enpRpt" style="width: 110pt;">'
            .$pRec->strPatientAddress.'
         </td>
         <td class="enpRpt" style="width: 110pt;">
            <a href="mailto:'.$pRec->strPatientEmail.'">'.$pRec->strPatientEmail.'</a>'.$strPhone.'
         </td>
         ');
   }

   function showPVisitInfo($pVisits){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      echoT('
         <td class="enpRpt" style="width: 270pt; vertical-align: top;">');

      if (count($pVisits)==0){
         echoT('<i>No patient visits</i>');
      }else {
         foreach($pVisits as $pV){
            $lVisitID = $pV->pvRecID;

            echoT('<table width="100%" cellpadding="0" style="border: 1px solid #ccc; margin-bottom: 5px;">');
            echoT('
               <tr>
                  <td style="width: 60pt; vertical-align: top;">
                     <b>Volunteer:</b>
                  </td>
                  <td>'
                     .htmlspecialchars($pV->strVolLName.', '.$pV->strVolFName).'
                  </td>
               </tr>');
            echoT('
               <tr>
                  <td style="width: 60pt; vertical-align: top;">
                     <b>Date of Visit:</b>
                  </td>
                  <td>'
                     .date('m/d/Y', $pV->dteDOV).'&nbsp;'
                     .strLinkView_PVisit($lVisitID, 'Patient Visit', true).'
                  </td>
               </tr>');
            echoT('
               <tr>
                  <td style="width: 60pt; vertical-align: top;">
                     <b>Location:</b>
                  </td>
                  <td>'
                     .htmlspecialchars($pV->strLocation).'
                  </td>
               </tr>');
            echoT('
               <tr>
                  <td style="width: 60pt; vertical-align: top;">
                     <b>Activity:</b>
                  </td>
                  <td>'
                     .htmlspecialchars($pV->strActivity).'
                  </td>
               </tr>');
            echoT('
               <tr>
                  <td style="width: 60pt; vertical-align: top;">
                     <b>Duration:</b>
                  </td>
                  <td>'
                     .number_format($pV->lDuration/60, 2).' hrs
                  </td>
               </tr>');
            echoT('</table>');
         }
      }
      echoT('</td>'."\n");
   }






