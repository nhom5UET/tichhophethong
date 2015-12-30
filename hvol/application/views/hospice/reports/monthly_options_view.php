<?php
   $attributes =
       array(
            'name'     => 'frmCalEvents',
            'id'       => 'calEvents'
            );

   echoT(form_open('hospice/reports/monthly/opts',  $attributes));

   openBlock('Monthly Volunteer Report', '');

   $clsForm = new generic_form;
   $clsForm->strLabelClass = $clsForm->strLabelRowLabelClass = $clsForm->strLabelClassRequired = 'enpViewLabel';
   $clsForm->strTitleClass = 'enpViewTitle';
   $clsForm->strEntryClass = 'enpView';
   $clsForm->bValueEscapeHTML = false;
   echoT('<table width="500" border="0">');

      //------------------------
      // starting month
      //------------------------
   $clsForm->strExtraFieldText = form_error('txtMonth');
   echoT($clsForm->strLabelRow('For the month',
                      '<input type="text" value="'.$txtMonth.'" name="txtMonth" size="8" id="month1">', 1, ''));

   $clsForm->strStyleExtraLabel = 'text-align: left; width: 100pt;';
   echoT($clsForm->strSubmitEntry('View Report', 1, 'cmdSubmit', ''));
   echoT('</table>'.form_close('<br>'));
   echoT('<script type="text/javascript">skillsRpt.addEditEntry.focus();</script>');

   closeblock();



