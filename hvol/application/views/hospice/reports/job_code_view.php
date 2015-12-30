<?php

   if ($lNumJC == 0){
      echoT('<br><i>There is no job code info for '.$lYear.'.</i>');
      return;
   }

   $attributes = new stdClass;
   $attributes->lTableWidth      = 900;
   $attributes->lUnderscoreWidth = 350;
   $attributes->bStartOpen       = false;

   showJobCodes('For the year '.$lYear, $lNumJC, $jobCodes, false, $attributes, null);

   for ($idx=1; $idx<=12; ++$idx){
      showJobCodes(strXlateMonth($idx).' '.$lYear,
          $jcMonth[$idx]->lNumJC, $jcMonth[$idx]->jobCodes, true, $attributes, $idx);
   }

   function showJobCodes($strLabel, $lNumJC, $jobCodes, $bUseAtts, $attributes, $lMonth){
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

      if ($lNumJC == 0){
         echoT('<i>No job code information for this month.</i><br>');
      }else {
         echoT('<br>
            <table class="enpRpt">
               <tr>
                  <td class="enpRptLabel">
                     Job Code
                  </td>
                  <td class="enpRptLabel">
                     # Activities
                  </td>
                  <td class="enpRptLabel">
                     Hours
                  </td>
               </tr>');

         $sngTotHrs = 0.0;
         foreach ($jobCodes as $jc){
            $sngTotHrs += $jc->dHours;
            echoT('
               <tr class="makeStripe">
                  <td class="enpRpt">'
                     .htmlspecialchars($jc->strActivity).'
                  </td>
                  <td class="enpRpt" style="text-align: center;">'
                     .number_format($jc->lNumActs).'
                  </td>
                  <td class="enpRpt" style="text-align: right;">'
                     .number_format($jc->dHours, 2).' hrs
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

