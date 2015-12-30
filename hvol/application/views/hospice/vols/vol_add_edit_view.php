<?php
   global $gbDateFormatUS, $gstrFormatDatePicker;

   echoT(strDatePicker('datepicker1', false));

   $clsForm = new generic_form;
   $clsForm->strLabelClass = $clsForm->strLabelRowLabelClass = $clsForm->strLabelClassRequired = 'enpViewLabel';
   $clsForm->strTitleClass = 'enpViewTitle';
   $clsForm->strEntryClass = 'enpView';
   $clsForm->bValueEscapeHTML = false;

   $attributes = array('name' => 'frmAddNewVol', 'id' => 'frmAddEdit');
   echoT(form_open('hospice/vols/hospice_vol/addEditVol/'.$lVolID, $attributes));


   if ($bNew){
      $strTitle  = "Add New Volunteer";
      $strButton = "Add Volunteer";
   }else {
      $strTitle  = "Update Volunteer Record";
      $strButton = "Update";
   }

   $clsForm->strStyleExtraLabel = 'width: 90pt;';

   openBlock('Name', '');  echoT('<table class="enpView" >');


      //------------------------
      // Title
      //------------------------
   $clsForm->strStyleExtraLabel = 'width: 90pt; padding-top: 8px;';
   $clsForm->strExtraFieldText = form_error('txtTitle');
   $clsForm->strID = 'addEditEntry';
   echoT($clsForm->strGenericTextEntry('Title', 'txtTitle', false, $formData->txtTitle, 40, 50));

      //------------------------
      // Name
      //------------------------
   $clsForm->strExtraFieldText = form_error('txtFName');
   echoT($clsForm->strGenericTextEntry('First Name',     'txtFName', true,  $formData->txtFName, 40, 80));
   echoT($clsForm->strGenericTextEntry('Middle Name',    'txtMName', false, $formData->txtMName, 40, 80));
   $clsForm->strExtraFieldText = form_error('txtLName');
   echoT($clsForm->strGenericTextEntry('Last Name',      'txtLName', true,  $formData->txtLName, 40, 80));
   echoT($clsForm->strGenericTextEntry('Preferred Name', 'txtPName', false, $formData->txtPName, 40, 80));

   echoT('</table>'); closeBlock();


      //------------------------
      // Address
      //------------------------
   openBlock('Address / Phone', '');  echoT('<table class="enpView" >');
   echoT($clsForm->strGenericTextEntry('Address 1',   'txtAddr1',   false,  $formData->txtAddr1,    40, 80));
   echoT($clsForm->strGenericTextEntry('Address 2',   'txtAddr2',   false,  $formData->txtAddr2,    40, 80));
   echoT($clsForm->strGenericTextEntry('City',        'txtCity',    false,  $formData->txtCity,     40, 80));
   echoT($clsForm->strGenericTextEntry('State',       'txtState',   false,  $formData->txtState,    40, 80));
   echoT($clsForm->strGenericTextEntry('Zip',         'txtZip',     false,  $formData->txtZip,      20, 40));
   echoT($clsForm->strGenericTextEntry('Country',     'txtCountry', false,  $formData->txtCountry,  20, 80));
   echoT($clsForm->strGenericTextEntry('Phone',     'txtPhone', false,  $formData->txtPhone, 20,  40));
   echoT($clsForm->strGenericTextEntry('Cell',      'txtCell',  false,  $formData->txtCell,  20,  40));

   echoT('</table>'); closeBlock();

   openBlock('Account Info', '');  echoT('<table class="enpView" >');

      //------------------------
      // Account Info
      //------------------------
   $strExtraEmail = '<br><i>The volunteer\'s email address is used as the account log-in.</i>';

   $clsForm->strExtraFieldText = $strExtraEmail.form_error('txtEmail');
   echoT($clsForm->strGenericTextEntry('Email',     'txtEmail', true,   $formData->txtEmail, 40, 120));

   if ($bNew){
      $clsForm->strExtraFieldText = form_error('txtPWord1');
      $clsForm->bAddLabelColon = false;
      $strLabel = 'Password:';

      $clsForm->bPassword = true;
      echoT($clsForm->strGenericTextEntry('Password:',
                                          'txtPWord1', true, '', 20, 20));

      $clsForm->strExtraFieldText = form_error('txtPWord2');
      $clsForm->bAddLabelColon = true;
      $clsForm->bPassword = true;
      echoT($clsForm->strGenericTextEntry('Password <small>(again)</small>',
                                          'txtPWord2', true, '', 20, 20));
   }

   echoT('</table>'); closeBlock();

   openBlock('Miscellaneous', '');  echoT('<table class="enpView" >');
/*
      //------------------------
      // Gender
      //------------------------
   $clsForm->strStyleExtraLabel = 'width: 90pt; padding-top: 2px;';
   echoT($clsForm->strGenderRadioEntry('Gender', 'rdoGender', true, $formData->enumGender));
*/
      //------------------------
      // Birthdate
      //------------------------
   $clsForm->strStyleExtraLabel = 'padding-top: 8px;';
   $clsForm->strExtraFieldText = form_error('txtBDate');
   echoT($clsForm->strGenericDatePicker(
                      'Birthdate', 'txtBDate',      false,
                      $formData->txtBDate,    'frmAddNewVol', 'datepicker1'));

      //-------------------------------
      // Accounting country of Origin
      //-------------------------------
/*
   echoT('
         <tr>
            <td class="enpViewLabel" width="100" style="padding-top: 8px;">
               Accounting Country:
            </td>
            <td class="enpView">'
               .$formData->rdoACO.'
            </td>
         </tr>');
*/
      //-------------------------------
      // Notes
      //-------------------------------
   echoT($clsForm->strNotesEntry('Notes', 'txtNotes', false, $formData->txtNotes, 3, 40));

      //--------------------------
      // Attributed to
      //--------------------------
   $clsForm->strStyleExtraLabel = 'padding-top: 8px;';
   echoT($clsForm->strLabelRow('Attributed To', $strAttribDDL, false));

   echoT('</table>'); closeBlock();


   echoT($clsForm->strSubmitEntry($strButton, 1, 'cmdSubmit', 'text-align: center; width: 100pt;'));
   echoT(form_close('<br>'));
   echoT('<script type="text/javascript">frmAddEdit.addEditEntry.focus();</script>');


