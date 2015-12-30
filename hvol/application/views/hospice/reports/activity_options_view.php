<?php
   global $gdteNow;

   $attributes =
       array(
            'name'     => 'frmActivity',
            'id'       => 'rptActivity'
            );

   echoT(form_open('hospice/reports/activity/runActivity',  $attributes));

   openBlock('Volunteer Activity Report (Non-Patient Visit)', '');
   
   $clsForm = new generic_form;
   $clsForm->strLabelClass = $clsForm->strLabelRowLabelClass = $clsForm->strLabelClassRequired = 'enpViewLabel';
   $clsForm->strTitleClass = 'enpViewTitle';
   $clsForm->strEntryClass = 'enpView';
   $clsForm->bValueEscapeHTML = false;
   echoT('<table width="500" border="0">');

      //------------------------
      // year ddl
      //------------------------
   $lYear = (int)date('Y', $gdteNow);
   $strDDL =
         '<select name="ddlYear" id="rptYear">'."\n";
   for ($idx = 0; $idx < 15; ++$idx){
      $strDDL .= '<option value="'.$lYear.'">'.$lYear.'</option>'."\n";
      --$lYear;
   }
   $strDDL .= '</select>';
      
   echoT($clsForm->strLabelRow('Year', $strDDL, 1, ''));

   $clsForm->strStyleExtraLabel = 'text-align: left; width: 50pt;';
   echoT($clsForm->strSubmitEntry('View Report', 1, 'cmdSubmit', ''));
   echoT('</table>'.form_close('<br>'));

   closeblock();

