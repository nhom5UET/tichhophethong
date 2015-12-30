<?php
   global $genumDateFormat;

   echoT('<br>'
     .strLinkAdd_VolTraining($lVolID, 'Add training', true).'&nbsp;'
     .strLinkAdd_VolTraining($lVolID, 'Add training', false).'<br><br>');

   if ($lNumTraining==0){
      echoT('<i>There are no training records for this volunteer.</i><br><br>');
      return;
   }

   echoT('
      <table class="enpRptC">
         <tr>
            <td colspan="6" class="enpRptTitle">
               Training Log for '.$volRec->strSafeName.'
            </td>
         </tr>
         <tr>
            <td class="enpRptLabel">
               &nbsp;
            </td>
            <td class="enpRptLabel">
               &nbsp;
            </td>
            <td class="enpRptLabel">
               Date
            </td>
            <td class="enpRptLabel">
               Duration
            </td>
            <td class="enpRptLabel">
               Training
            </td>
            <td class="enpRptLabel">
               Notes
            </td>
         </tr>');

   $dTotHrs = 0.0;
   foreach ($training as $train){
      $dTotHrs += $train->dHoursTrained;

      $lVTID = $train->lKeyID;
      echoT('
         <tr class="makeStripe">
            <td class="enpRpt" style="width: 40pt; text-align: center;">'
               .str_pad($lVTID, 5, '0', STR_PAD_LEFT).'&nbsp;'
               .strLinkEdit_VolTraining($lVTID, $lVolID, 'Edit training record', true).'
            </td>
            <td class="enpRpt" style="width: 40pt; text-align: center;">'
               .strLinkRem_VolTraining($lVTID, 'Remove volunteer training record', true, true).'
            </td>
            <td class="enpRpt" style="width: 70pt; text-align: center;">'
               .date($genumDateFormat, $train->dteTraining).'
            </td>
            <td class="enpRpt" style="width: 40pt; text-align: right;">'
               .number_format($train->dHoursTrained, 2).' hrs.
            </td>
            <td class="enpRpt" style="width: 170pt;">'
               .htmlspecialchars($train->strTrainingType).'<br><br>
               Conducted by: '.htmlspecialchars($train->strTrainingBy).'
            </td>
            <td class="enpRpt" style="width: 200pt;">'
               .nl2br(htmlspecialchars($train->strNotes)).'
            </td>
         </tr>');
   }
      echoT('
         <tr>
            <td class="enpRptLabel" colspan="3">
               Total:
            </td>
            <td class="enpRpt" style="width: 40pt; text-align: right;"><b>'
               .number_format($dTotHrs, 2).' hrs.</b>
            </td>
            <td class="enpRptLabel" colspan="2">
               &nbsp;
            </td>
         </tr>');


   echoT('</table>');
