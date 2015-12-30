<?php

   $attributes = new stdClass;
   $attributes->lTableWidth      = '100%';   // set to null to avoid the dancing blocks
   $attributes->lUnderscoreWidth = 400;
   $attributes->bStartOpen       = true;
   $attributes->bAddTopBreak     = true;

   openShowAccts($attributes, 'Super User Accounts', 'su', true);
   foreach ($superUsers as $su){
      showAccts(true, $su);
   }
   closeShowAccts($attributes);

   if ($lNumVM == 0){
      echoT('<br><br><i>There are no <b>Volunteer Manager</b> accounts in your system.</i><br>');
   }else {
       $lLocGroup = -1;
       foreach ($vmUsers as $vmu){
         $lLocID = $vmu->us_lChapterID;
         if ($lLocGroup != $lLocID){
             if ($lLocGroup > 0) closeShowAccts($attributes);
             openShowAccts($attributes, 'Volunteer Managers / '.htmlspecialchars($vmu->strChapterName), 'vm_'.$lLocID, true);
             $lLocGroup = $lLocID;
         }
         showAccts(false, $vmu);

       }
       closeShowAccts($attributes);
   }

   function openShowAccts(&$attributes, $strLabel, $strDivID, $bSuper){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv  = false;
      $attributes->divID      = $strDivID.'Div';      // set to null for no hide/show
      $attributes->divImageID = $strDivID.'DivImg';   // set to null for no hide/show

      openBlock($strLabel, '', $attributes);

      echoT('<br>
         <table class="enpRpt">
            <tr>
               <td class="enpRptTitle" colspan="8">'
                  .$strLabel.'
               </td>
            </tr>');

      echoT('
         <tr>
            <td class="enpRptLabel">acct ID</td>
            <td class="enpRptLabel">Status</td>
            <td class="enpRptLabel">Password</td>
            <td class="enpRptLabel">User Name</td>
            <td class="enpRptLabel">Name</td>
            <td class="enpRptLabel">Address</td>
            <td class="enpRptLabel">Contact</td>'
            );
      if (!$bSuper){
         echoT('
            <td class="enpRptLabel">Location</td>');
      }
      echoT('</tr>');
   }

   function closeShowAccts(&$attributes){
      echoT('</table><br><br>');
      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showAccts($bSuper, $acct){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lAcctID = $acct->us_lKeyID;
      $bActive = !$acct->us_bInactive;

      if ($bActive){
         $strColor = ' color: #000; ';
         $strLinkActInAct = '<br>'.strLink_AcctActiveInactive($lAcctID, !$bActive, 'Inactivate account', true);
      }else {
         $strLinkActInAct = '<br>'.strLink_AcctActiveInactive($lAcctID, !$bActive, 'Activate account', true);
         $strColor = ' color: #999; ';
      }

      echoT('
      <tr class="makeStripe">
         <td class="enpRpt" style="text-align: center; '.$strColor.'" nowrap>'
            .strLinkEdit_Account($lAcctID, 'Edit account', true).'&nbsp;'
            .str_pad($lAcctID, 5, '0', STR_PAD_LEFT).'
         </td>
         <td class="enpRpt" style="text-align: center; '.$strColor.'">'
            .($bActive ? 'Active' : 'Inactive').'<br>'.$strLinkActInAct.'
         </td>

         <td class="enpRpt" style="text-align: center; '.$strColor.'">'
            .strLinkEdit_ResetPWord($lAcctID, true, 'Reset password').'&nbsp;'
            .strLinkEdit_ResetPWord($lAcctID, false, 'Reset').'
         </td>
         <td class="enpRpt" style=" '.$strColor.' width: 100pt;">'
            .htmlspecialchars($acct->us_strUserName).'
         </td>
         <td class="enpRpt" style=" '.$strColor.' width: 120pt;">'
            .$acct->strSafeNameLF.'
         </td>
         <td class="enpRpt" style=" '.$strColor.' width: 120pt;">'
            .$acct->strAddress.'
         </td>
         <td class="enpRpt" style="width: 160pt; '.$strColor.'">
            <table style="width: 100%;">
               <tr><td style="width: 26%; padding-top: 0px;padding-bottom: 0px;"><b>phone: </b></td><td>'.htmlspecialchars($acct->us_strPhone).'</td></tr>
               <tr><td style="width: 26%; padding-top: 0px;padding-bottom: 0px;"><b>cell: </b></td><td>'.htmlspecialchars($acct->us_strCell).'</td></tr>
               <tr><td style="width: 26%; padding-top: 0px;padding-bottom: 0px;"><b>email: </b></td><td>'.htmlspecialchars($acct->us_strEmail).'</td></tr>
            </table>
         </td>');
//      if (!$bSuper){
//         echoT('
//            <td class="enpRpt" style=" '.$strColor.' width: 200pt;">'
//               .htmlspecialchars($acct->strChapterName).'
//            </td>');
//      }
      echoT('</tr>');
   }

