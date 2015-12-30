<?php
   $attributes =
       array(
            'name'     => 'frmAcctLoc',
            'id'       => 'acctOpts'
            );

   echoT(form_open('hospice/super/accounts/locSelect',  $attributes));

   openBlock('Accounts by Location', '');

   $clsForm = new generic_form;
   $clsForm->strLabelClass = $clsForm->strLabelRowLabelClass = $clsForm->strLabelClassRequired = 'enpViewLabel';
   $clsForm->strTitleClass = 'enpViewTitle';
   $clsForm->strEntryClass = 'enpView';
   $clsForm->bValueEscapeHTML = false;
   $clsForm->strStyleExtraLabel = 'width: 80pt;';
   echoT('<table width="500" border="0">');

/*   
      //------------------------
      // Year
      //------------------------
   $strYearDDL = '<select name="ddlYear">'."\n";
   $lYear = (int)date('Y');
   for ($idx=1; $idx<=20; ++$idx){
      $strYearDDL .= '<option value="'.$lYear.'">'.$lYear.'</option>'."\n";
      --$lYear;
   }
   $strYearDDL .= '</select>'."\n";   
   echoT($clsForm->strLabelRow('For the year', $strYearDDL, 1, ''));
*/
      //-----------------------------
      // Location
      //-----------------------------
   echoT($clsForm->strLabelRow('Location', $ddlLocation, 1, ''));

//   $clsForm->strStyleExtraLabel = 'text-align: left; width: 100pt;';
   echoT($clsForm->strSubmitEntry('View Accounts', 1, 'cmdSubmit', ''));
   echoT('</table>'.form_close('<br>'));

   closeblock();

