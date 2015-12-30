<?php

   $strDate = strXlateMonth($lMonth).' '.$lYear;

   if ($lNumVolRecs == 0){
      echoT('<br><i>There are no <b>Non-Patient Visit Volunteer Activities</b> for '.$strDate.'.</i><br><br>');
      return;
   }

   echoT('<br>
      <table class="enpRptC">
         <tr>
            <td class="enpRptTitle" colspan="5">
               Volunteer Engagement / Other Activities for '.$strDate.'
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
            Activities
         </td>
      </tr>');

   $idx = 1;
   foreach ($volInfo as $volRec){
      echoT('<tr class="makeStripe">'."\n");

      showVolInfo($idx, $volRec);
      showActivitiesInfo($volRec->lVID, $volRec->activities);

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




   function showActivitiesInfo($lVolID, $activities){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      echoT('
         <td class="enpRpt" style="width: 270pt; vertical-align: top;">');

      if (count($activities)==0){
         echoT('<i>No patient activities</i>');
      }else {
         foreach($activities as $act){
            $lActID = $act->nonPVRecID;

            echoT('<table width="100%" cellpadding="0" style="border: 1px solid #ccc; margin-bottom: 5px;">');
            echoT('
               <tr>
                  <td style="width: 60pt; vertical-align: top;">
                     <b>Date:</b>
                  </td>
                  <td>'
                     .date('m/d/Y', strtotime($act->dteActivity)).'&nbsp;&nbsp;/&nbsp;'.number_format($act->dHoursWorked, 2).' hrs.
                  </td>
               </tr>');
            echoT('
               <tr>
                  <td style="width: 60pt; vertical-align: top;">
                     <b>Activity:</b>
                  </td>
                  <td>'
                     .htmlspecialchars($act->strActivity).'
                  </td>
               </tr>');
            echoT('
               <tr>
                  <td style="width: 60pt; vertical-align: top;">
                     <b>Job Code:</b>
                  </td>
                  <td>'
                     .htmlspecialchars($act->strJobCode).'
                  </td>
               </tr>');
            echoT('
               <tr>
                  <td style="width: 60pt; vertical-align: top;">
                     <b>Notes:</b>
                  </td>
                  <td>'
                     .nl2br(htmlspecialchars($act->strNotes)).'
                  </td>
               </tr>');
            echoT('
               <tr>
                  <td style="vertical-align: top;" colspan="2">'
                     .strLinkEdit_VolMgrMiscVolActivity($lActID, $lVolID, 'Edit', true).'&nbsp;'
                     .strLinkEdit_VolMgrMiscVolActivity($lActID, $lVolID, 'Edit', false).'
                  </td>
               </tr>');
            echoT('</table>');
         }
      }
      echoT('</td>'."\n");
   }











