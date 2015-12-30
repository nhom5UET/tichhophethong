<?php
   // only for super user and vol mgr accounts

   echoT(strDatePicker('datepicker1', false));

   $clsForm = new generic_form;
   $clsForm->strLabelClass = $clsForm->strLabelRowLabelClass = $clsForm->strLabelClassRequired = 'enpViewLabel';
   $clsForm->strTitleClass = 'enpViewTitle';
   $clsForm->strEntryClass = 'enpView';
   $clsForm->bValueEscapeHTML = false;


   $attributes = array('name' => 'frmAddEditAcct', 'id' => 'frmAddEdit');
   echoT(form_open('hospice/super/account_rec/addEditAcct/'.$lAcctID.'/'.($bSuperUser ? 'true' : 'false'), $attributes));

   if ($bNew){
      $strTitle  = "Add New Account";
      $strButton = "Add Account";
   }else {
      $strTitle  = "Update Account";
      $strButton = "Update";
   }

   if ($bNew){
      $strAID = '<i>new</i>';
   }else {
      $strAID = str_pad($lAcctID, 5, '0', STR_PAD_LEFT);
   }

   openBlock('Name', '');  echoT('<table class="enpView" >');
   $clsForm->strStyleExtraLabel = 'width: 70pt; padding-top: 2px;';

      //------------------------
      // Name
      //------------------------
   echoT($clsForm->strLabelRow('Account Type',  ($bSuperUser ? '<b>Super User</b>' : 'Volunteer Manager'), 1));
   echoT($clsForm->strLabelRow('account ID', $strAID, 1));

   if ($bShowLocDDL){
      $clsForm->strExtraFieldText = form_error('ddlLoc');
      echoT($clsForm->strLabelRow('Location', $strLocDDL, 1));
   }elseif (!$bSuperUser){
      echoT($clsForm->strLabelRow('Location', htmlspecialchars($uRec->strChapterName), 1));
   }
   
   $clsForm->strStyleExtraLabel = 'width: 70pt; padding-top: 6px;';
   $clsForm->strExtraFieldText = form_error('txtFName');
   echoT($clsForm->strGenericTextEntry('First Name',     'txtFName', true,  $formData->txtFName, 40, 80));
   $clsForm->strExtraFieldText = form_error('txtLName');
   echoT($clsForm->strGenericTextEntry('Last Name',      'txtLName', true,  $formData->txtLName, 40, 80));

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
   echoT($clsForm->strGenericTextEntry('Phone',       'txtPhone',   false,  $formData->txtPhone,    20,  40));
   echoT($clsForm->strGenericTextEntry('Cell',        'txtCell',    false,  $formData->txtCell,     20,  40));

   $clsForm->strExtraFieldText = form_error('txtEmail');
   echoT($clsForm->strGenericTextEntry('Email',     'txtEmail', true,   $formData->txtEmail, 40, 120));

   echoT('</table>'); closeBlock();


   openBlock('Account Info', '');  echoT('<table class="enpView" >');
   $clsForm->strExtraFieldText = form_error('txtUserName');
   echoT($clsForm->strGenericTextEntry('User Name',      'txtUserName',  true,  $formData->txtUserName,  20,  40));

   if ($bNew){
      $clsForm->strExtraFieldText = form_error('txtPWord1');
      $clsForm->bAddLabelColon = false;
      $strLabel = 'Password:';

      $clsForm->bPassword = true;
      echoT($clsForm->strGenericTextEntry('Password:',
                                          'txtPWord1', true, '', 20, 20));

      $clsForm->strExtraFieldText = ' <small>(again)</small>'.form_error('txtPWord2');
      $clsForm->bAddLabelColon = true;
      $clsForm->bPassword = true;
      echoT($clsForm->strGenericTextEntry('Password',
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
      //------------------------
      // Birthdate
      //------------------------
   $clsForm->strStyleExtraLabel = 'padding-top: 8px;';
   $clsForm->strExtraFieldText = form_error('txtBDate');
   echoT($clsForm->strGenericDatePicker(
                      'Birthdate', 'txtBDate',      false,
                      $formData->strBDay,    'frmAddNewVol', 'datepicker1'));
*/

      //-------------------------------
      // Notes
      //-------------------------------
   echoT($clsForm->strNotesEntry('Notes', 'txtNotes', false, $formData->txtNotes, 3, 40));

   echoT('</table>'); closeBlock();

   echoT('<br>');
   echoT($clsForm->strSubmitEntry($strButton, 1, 'cmdSubmit', 'text-align: center; width: 100pt;'));
   echoT(form_close('<br>'));
   echoT('<script type="text/javascript">frmAddEdit.addEditEntry.focus();</script>');


