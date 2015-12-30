<?php
   $attributes =
       array(
            'name'     => 'frmCal',
            'id'       => 'calOpts'
            );

   echoT(form_open('hospice/reports/calendar_report/runCalReport',  $attributes));

   openBlock('Calendar Report', '');

   $clsForm = new generic_form;
   $clsForm->strLabelClass = $clsForm->strLabelRowLabelClass = $clsForm->strLabelClassRequired = 'enpViewLabel';
   $clsForm->strTitleClass = 'enpViewTitle';
   $clsForm->strEntryClass = 'enpView';
   $clsForm->bValueEscapeHTML = false;
   echoT('<table width="500" border="0">');

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

      //-----------------------------
      // Type of volunteer activity
      //-----------------------------
   $strActivityDDL = 
       '<select name="ddlActivity">
           <option value="patient" selected>Patient Visit</option>
           <option value="other">Non-Patient Volunteer Activity</option>
        </select>';
   echoT($clsForm->strLabelRow('Activity', $strActivityDDL, 1, ''));

   $clsForm->strStyleExtraLabel = 'text-align: left; width: 100pt;';
   echoT($clsForm->strSubmitEntry('View Report', 1, 'cmdSubmit', ''));
   echoT('</table>'.form_close('<br>'));

   closeblock();

