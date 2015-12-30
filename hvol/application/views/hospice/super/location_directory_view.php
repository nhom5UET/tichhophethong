<?php

   echoT('<br>
      <table class="enpRptC">
         <tr>
            <td class="enpRptTitle" colspan="7">
               Your Hospice Volunteer Locations
            </td>
         </tr>');

   echoT('
      <tr>
         <td class="enpRptLabel">
            Location ID
         </td>
         <td class="enpRptLabel">
            &nbsp;
         </td>
         <td class="enpRptLabel">
            &nbsp;
         </td>
         <td class="enpRptLabel">
            Location
         </td>
         <td class="enpRptLabel">
            Address
         </td>
         <td class="enpRptLabel">
            Contact Info
         </td>
         <td class="enpRptLabel" style="width: 200pt;">
            Notes
         </td>
      </tr>');

   foreach ($locations as $loc){
      $lLocID = $loc->lKeyID;
      $bActive = $loc->bActive;
      $strLabel = $bActive ? 'Set Inactive' : 'Set Active';

      $bAllowDelete = ($loc->lNumPatients + $loc->lNumVolMgrs + $loc->lNumVols) == 0;
      if ($bAllowDelete){
         $strDelLink = strLinkRem_Location($lLocID, 
                           'Remove location', true, true, '');
      }else {
         $strDelLink = strCantDelete('To remove this location, you must first remove the location\'s patients, volunteers, and volunteer managers.');
             //'<img src="'.base_url().'images/misc/'.IMGLINK_NODELETE.'">';
      }

      if ($bActive){
         $strColor = '#000';
         if ($lNumActive > 1){
            $strLinkActInAct = strLink_LocActiveInactive($lLocID, !$bActive, $strLabel, true);
         }else {
            $strLinkActInAct = '&nbsp;';
         }
      }else {
         $strLinkActInAct = strLink_LocActiveInactive($lLocID, !$bActive, $strLabel, true);
         $strColor = '#999';
      }
      echoT('
         <tr class="makeStripe">
            <td class="enpRpt" style="text-align: center; color: '.$strColor.';">'
               .str_pad($lLocID, 5, '0', STR_PAD_LEFT).'&nbsp;'
               .strLinkView_Location($lLocID, 'View location record', true).'
            </td>
            <td class="enpRpt">'
               .$strLinkActInAct.'
            </td>
            <td class="enpRpt" style="text-align: center;">'
               .$strDelLink.'
            </td>
            <td class="enpRpt" style="width: 140pt; color: '.$strColor.';"><b>'
               .htmlspecialchars($loc->strLocationName).'</b><br><i>'
               .htmlspecialchars($loc->strBannerTagLine).'</i><br>
               <table style="width: 100%;">
                  <tr><td style="width: 56pt;"># Patients:  </td><td>'.number_format($loc->lNumPatients).'</td></tr>
                  <tr><td style="width: 56pt;"># Vol Mgrs.: </td><td>'.number_format($loc->lNumVolMgrs) .'</td></tr>
                  <tr><td style="width: 56pt;"># Vols:      </td><td>'.number_format($loc->lNumVols)    .'</td></tr>
               </table>
            </td>
            <td class="enpRpt" style="width: 120pt; color: '.$strColor.';">'
               .$loc->strAddress.'
            </td>
            <td class="enpRpt" style="width: 140pt; color: '.$strColor.';">
               <table style="width: 100%;">
                  <tr><td style="width: 50pt;"><b>phone: </b></td><td>'.htmlspecialchars($loc->strPhone).'</td></tr>
                  <tr><td style="width: 50pt;"><b>fax: </b></td><td>'.htmlspecialchars($loc->strFax).'</td></tr>
                  <tr><td style="width: 50pt;"><b>email: </b></td><td>'.htmlspecialchars($loc->strEmail).'</td></tr>
                  <tr><td style="width: 50pt;"><b>web: </b></td><td>'.htmlspecialchars($loc->strWebSite).'</td></tr>
               </table>
            </td>
            <td class="enpRpt" style="width: 200pt; color: '.$strColor.';">'
               .nl2br(htmlspecialchars($loc->strNotes)).'
            </td>
         </tr>');
   }

   echoT('</table>');




