<?php

   $strDate = strXlateMonth($lMonth).' '.$lYear;

   if ($lNumVolRecs == 0){
      echoT('<br><i>There are no <b>Patient Visits</b> for '.$strDate.'.</i><br><br>');
      return;
   }

   echoT('<br>
      <table class="enpRptC">
         <tr>
            <td class="enpRptTitle" colspan="5">
               Volunteer Engagement / Patient Visits for '.$strDate.'
            </td>
         </tr>');

   echoT('
      <tr>
         <td class="enpRptLabel">
            &nbsp;
         </td>
         <td class="enpRptLabel">
            Volunteer
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
   foreach ($volInfo as $volRec){
      echoT('<tr class="makeStripe">'."\n");

      showVolInfo($idx, $volRec);
      showPVisitInfo($volRec->pVisits);

      echoT('</tr>'."\n");
      ++$idx;
   }
   echoT('</table><br><br>');


   function showVolInfo($idx, $volRec){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lVolID = $volRec->lVID;

      $strPhone = '';
      if ($volRec->strVolPhone != ''){
         $strPhone .= '<br><b>phone:</b> '.htmlspecialchars($volRec->strVolPhone);
      }
      if ($volRec->strVolCell != ''){
         $strPhone .= '<br><b>cell:</b> '.htmlspecialchars($volRec->strVolCell);
      }

      echoT('
         <td class="enpRpt" style="text-align: center; width: 30pt;">'
            .$idx.'
         </td>
         <td class="enpRpt" style="width: 110pt;"><b>'
            .htmlspecialchars($volRec->strVolLName).'</b>, '.htmlspecialchars($volRec->strVolFName).'<br>'
            .strLinkView_VMgrViewVolLog($lVolID, 'Volunteer Log', true).'&nbsp;'
            .strLinkView_VMgrViewVolLog($lVolID, 'Volunteer Log', false).'
         </td>
         <td class="enpRpt" style="width: 110pt;">'
            .$volRec->strVolAddress.'
         </td>
         <td class="enpRpt" style="width: 110pt;">
            <a href="mailto:'.$volRec->strVolEmail.'">'.$volRec->strVolEmail.'</a>'.$strPhone.'
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
                     <b>Patient:</b>
                  </td>
                  <td>'
                     .htmlspecialchars($pV->strPatientLName.', '.$pV->strPatientFName).'
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
                     .htmlspecialchars($pV->strDuration).'
                  </td>
               </tr>');
            echoT('</table>');
         }
      }
      echoT('</td>'."\n");
   }






