<?php
   global $genumDateFormat;

   $strDate = strXlateMonth($lMonth).' '.$lYear;
   if ($lNumNonPVRecs <= 0){
      echoT('<br><br><i>There was no additional volunteer activity for '.$strDate.'.<br><br></i>');
      return;
   }

   echoT('<br>
      <table class="enpRptC"style="width: 800px;">
         <tr>
            <td class="enpRptTitle" colspan="8">
               Non-Patient Volunteer Hours for '.$strDate.'
            </td>
         </tr>
         <tr class="makeStripe">
            <td class="enpRptLabel">
               activityID
            </td>');
   echoT('
            <td class="enpRptLabel">
               &nbsp;
            </td>');

   echoT('
            <td class="enpRptLabel">
               Date
            </td>
            <td class="enpRptLabel">
               Volunteer
            </td>
            <td class="enpRptLabel" >
               Hours<br>Logged
            </td>
            <td class="enpRptLabel" >
               Activity / Job Code
            </td>
            <td class="enpRptLabel" style="width: 220pt;">
               Notes
            </td>
         </tr>');

   $sngHoursTot = 0.0;
   foreach ($nonPVInfo as $nonPVRec){
      $lVolID = $nonPVRec->lVolID;
      $dHours = $nonPVRec->dHoursWorked;
      if ($dHours==0){
         $strHours = '-';
         $strAlign = 'center';
      }else {
         $strHours = number_format($dHours, 2);
         $sngHoursTot += $dHours;
         $strAlign = 'right';
      }
      $dteActivity = dteMySQLDate2Unix($nonPVRec->dteActivity);
      $lActivityID = $nonPVRec->nonPVRecID;

      $strJobCode = $nonPVRec->strJobCode.'';
      if ($strJobCode == ''){
         $strJobCode = '<i>(not set)</i>';
      }else {
         $strJobCode = htmlspecialchars($strJobCode);
      }

      echo('
         <tr class="makeStripe">
            <td class="enpRpt" style="width: 65px; text-align: center;">'
               .strLinkEdit_VolMgrMiscVolActivity($lActivityID, $lVolID, 'Edit activity', true).'&nbsp;'
               .str_pad($lActivityID, 5, '0', STR_PAD_LEFT).'
            </td>');
            
      echo('
            <td class="enpRpt" style="width: 25px; text-align: center;">'
               .strLinkRem_VolUnschedHrs($lVolID, $lActivityID, 'Remove volunteer activity', true, true).'
            </td>');
            
      echo('
            <td class="enpRpt" style="width: 100px;">'
               .date($genumDateFormat, $dteActivity).'
            </td>
            <td class="enpRpt" style="width: 130px;">'
               .$nonPVRec->strVolSafeNameLF.'<br>'
               .$nonPVRec->strVolAddress.'
            </td>
            <td class="enpRpt" style="text-align:'.$strAlign.'; width: 60px;">'
               .$strHours.'
            </td>
            <td class="enpRpt" style="width: 180px;">'
               .htmlspecialchars($nonPVRec->strActivity).'<br>
               <b>Job code:</b> '.$strJobCode.'
            </td>
            <td class="enpRpt" style="width: 220pt;">'
               .nl2br(htmlspecialchars($nonPVRec->strNotes)).'
            </td>
         </tr>');
   }

   
   echo('
      <tr class="makeStripe">
         <td class="enpRptLabel" colspan="4">
            Total
         </td>
         <td class="enpRpt" style="text-align:right; width: 60px;"><b>'
            .number_format($sngHoursTot, 2).'</b>
         </td>
         <td class="enpRpt" colspan="2">
         </td>
      </tr>');
   
   
   
   echoT('</table>');
