<?php

   $strDate = strXlateMonth($lMonth).' '.$lYear;
   if ($lNumPVRecs <= 0){
      echoT('<br><br><i>There were no for patient visits for '.$strDate.'.<br><br></i>');
      return;
   }

   echoT('<br>
      <table class="enpRptC">
         <tr>
            <td class="enpRptTitle" colspan="7">
               Volunteer Patient Visits for '.$strDate.'
            </td>
         </tr>');

   echoT('
      <tr>
         <td class="enpRptLabel">
            visitID
         </td>
         <td class="enpRptLabel">
            Date
         </td>
         <td class="enpRptLabel">
            Volunteer
         </td>
         <td class="enpRptLabel">
            Patient
         </td>
         <td class="enpRptLabel">
            Location
         </td>
         <td class="enpRptLabel">
            Activity
         </td>
         <td class="enpRptLabel">
            Duration
         </td>
      </tr>');
      
   $sngDuration = 0.0;
   foreach ($pvInfo as $pvRec){
      $lVisitID = $pvRec->pvRecID;
      $strDuration = pvisit\strMinutesToHoursMin($pvRec->lDuration, true);
      $sngDuration += $pvRec->lDuration;
      echoT('
         <tr class="makeStripe">
            <td class="enpRpt">'
               .str_pad($lVisitID, 5, '0', STR_PAD_LEFT).'&nbsp;'
               .strLinkView_PVisit($lVisitID, 'View patient visit record', true).'
            </td>
            <td class="enpRpt">'
               .date('m/d/Y', $pvRec->dteDOV).'
            </td>
            <td class="enpRpt">'
               .htmlspecialchars($pvRec->strVolLName.', '.$pvRec->strVolFName).'<br>'
               .$pvRec->strVolAddress.'
            </td>
            <td class="enpRpt">'
               .htmlspecialchars($pvRec->strPatientLName.', '.$pvRec->strPatientFName).'<br>'
               .$pvRec->strPatientAddress.'
            </td>
            <td class="enpRpt">'
               .htmlspecialchars($pvRec->strLocation).'
            </td>
            <td class="enpRpt">'
               .htmlspecialchars($pvRec->strActivity).'
            </td>
            <td class="enpRpt">'
               .$strDuration.'
            </td>
         </tr>');
   }
   echoT('
      <tr class="makeStripe">
         <td class="enpRpt">
            <b>Total</b>
         </td>
         <td class="enpRpt" colspan="5">
            &nbsp;
         </td>
         <td class="enpRpt">'
            .number_format($sngDuration/60, 2).' hrs
         </td>
      </tr>');
   


   echoT('</table>');
