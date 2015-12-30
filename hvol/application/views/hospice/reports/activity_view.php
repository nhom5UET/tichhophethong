<?php

   if ($lNumAct == 0){
      echoT('<br><i>There are no non-visit volunteer activities for '.$lYear.'.</i>');
      return;
   }

   $attributes = new stdClass;
   $attributes->lTableWidth      = 900;
   $attributes->lUnderscoreWidth = 350;
   $attributes->bStartOpen       = false;

   showActivities('For the year '.$lYear, $lNumAct, $activities, false, $attributes, null);

   for ($idx=1; $idx<=12; ++$idx){
      showActivities(strXlateMonth($idx).' '.$lYear,
          $actMonth[$idx]->lNumAct, $actMonth[$idx]->activities, true, $attributes, $idx);
   }

   function showActivities($strLabel, $lNumAct, $activities, $bUseAtts, $attributes, $lMonth){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($bUseAtts){
         $attributes->bCloseDiv  = false;
         $attributes->divID      = 'group_'.$lMonth.'_Div';
         $attributes->divImageID = 'group_'.$lMonth.'_DivImg';
         openBlock($strLabel, '', $attributes);
      }else {
         openBlock($strLabel, '');
      }

      if ($lNumAct == 0){
         echoT('<i>No non-patient visit volunteer activity for this month.</i><br>');
      }else {
         echoT('<br>
            <table class="enpRpt">
               <tr>
                  <td class="enpRptLabel">
                     Activity
                  </td>
                  <td class="enpRptLabel">
                     # Activities
                  </td>
                  <td class="enpRptLabel">
                     Hours
                  </td>
               </tr>');

         $sngTotHrs = 0.0;
         foreach ($activities as $act){
            $sngTotHrs += $act->dHours;
            echoT('
               <tr class="makeStripe">
                  <td class="enpRpt">'
                     .htmlspecialchars($act->strActivity).'
                  </td>
                  <td class="enpRpt" style="text-align: center;">'
                     .number_format($act->lNumActs).'
                  </td>
                  <td class="enpRpt" style="text-align: right;">'
                     .number_format($act->dHours, 2).' hrs
                  </td>
               </tr>');
         }
         echoT('
            <tr class="makeStripe">
               <td class="enpRptLabel" colspan="2">
                  Total
               </td>
               <td class="enpRpt" style="text-align: right;"><b>'
                  .number_format($sngTotHrs, 2).' hrs</b>
               </td>
            </tr>');

         echoT('
            </table><br>');
      }

      if ($bUseAtts){
         $attributes->bCloseDiv = true;
         closeBlock($attributes);
      }else {
         closeBlock();
      }
   }

