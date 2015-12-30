<?php
   global $gbDateFormatUS;

//   echoT(strDatePicker('datepicker1', false));

   $clsForm = new generic_form;
   $clsForm->strLabelClass = $clsForm->strLabelRowLabelClass = $clsForm->strLabelClassRequired = 'enpViewLabel';
   $clsForm->strTitleClass = 'enpViewTitle';
   $clsForm->strEntryClass = 'enpView';
   $clsForm->bValueEscapeHTML = false;

   if ($bNew){
      $strPID = '<i>new</i>';
   }else {
      $strPID = str_pad($lPatientID, 5, '0', STR_PAD_LEFT);
   }

   $attributes = array('name' => 'frmEditP', 'id' => 'frmEditP');
   echoT(form_open('hospice/patients/patient_rec/addEditPRec/'.$lPatientID, $attributes));


   if ($bNew){
      $strTitle  = "Add New Patient";
      $strButton = "Add Patient";
   }else {
      $strTitle  = "Update Patient Record";
      $strButton = "Update";
   }

   $clsForm->strStyleExtraLabel = 'width: 90pt;';

   openBlock('Name', '');  echoT('<table class="enpView" >');
   echoT($clsForm->strLabelRow('patientID',  $strPID, 1));


      // Title
   $clsForm->strStyleExtraLabel = 'width: 90pt; padding-top: 6px;';
   $clsForm->strExtraFieldText = form_error('txtTitle');
   echoT($clsForm->strGenericTextEntry('Title', 'txtTitle', false, $formData->txtTitle, 30, 30));

      // First name
   $clsForm->strExtraFieldText = form_error('txtFName');
   $clsForm->strID = 'addEditEntry';
   echoT($clsForm->strGenericTextEntry('First Name', 'txtFName', true, $formData->txtFName, 30, 30));

      // Middle name
   $clsForm->strExtraFieldText = form_error('txtMName');
   echoT($clsForm->strGenericTextEntry('Middle Name', 'txtMName', false, $formData->txtMName, 30, 30));

      // Last name
   $clsForm->strExtraFieldText = form_error('txtLName');
   echoT($clsForm->strGenericTextEntry('Last Name', 'txtLName', true, $formData->txtLName, 30, 30));

      //----------------------
      // birthdate
      //----------------------
   echoT(strDatePicker('datepicker1', false));
   $clsForm->strExtraFieldText = form_error('txtBDate');
   echoT($clsForm->strGenericDatePicker(
                      'Date of Birth', 'txtBDate',      true,
                      $formData->txtBDate, 'frmEditP', 'datepicker1'));

      // Address
   echoT($clsForm->strGenericTextEntry('Address 1',   'txtAddr1',   false,  $formData->txtAddr1,    40, 80));
   echoT($clsForm->strGenericTextEntry('Address 2',   'txtAddr2',   false,  $formData->txtAddr2,    40, 80));
   echoT($clsForm->strGenericTextEntry('City',        'txtCity',    false,  $formData->txtCity,     40, 80));
   echoT($clsForm->strGenericTextEntry('State',       'txtState',   false,  $formData->txtState,    40, 80));
   echoT($clsForm->strGenericTextEntry('Zip',         'txtZip',     false,  $formData->txtZip,      20, 40));
   echoT($clsForm->strGenericTextEntry('Country',     'txtCountry', false,  $formData->txtCountry,  20, 80));

      // Phone / Cell / Email
   $clsForm->strExtraFieldText = form_error('txtEmail');
   echoT($clsForm->strGenericTextEntry('Email',     'txtEmail', false,  $formData->txtEmail, 40, 120));
   echoT($clsForm->strGenericTextEntry('Phone',     'txtPhone', false,  $formData->txtPhone, 20,  40));
   echoT($clsForm->strGenericTextEntry('Cell',      'txtCell',  false,  $formData->txtCell,  20,  40));

         // Notes
   echoT($clsForm->strNotesEntry('Notes', 'txtNotes', false, $formData->txtNotes, 3, 50));

   echoT('</table>'); closeBlock();

   echoT($clsForm->strSubmitEntry($strButton, 1, 'cmdSubmit', 'text-align: center; width: 100pt;'));
   echoT(form_close('<br>'));
   echoT('<script type="text/javascript">frmEditP.addEditEntry.focus();</script>');




