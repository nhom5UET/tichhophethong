<?php
   global $gbDateFormatUS;

   $clsForm = new generic_form;
   $clsForm->strLabelClass = $clsForm->strLabelRowLabelClass = $clsForm->strLabelClassRequired = 'enpViewLabel';
   $clsForm->strTitleClass = 'enpViewTitle';
   $clsForm->strEntryClass = 'enpView';
   $clsForm->bValueEscapeHTML = false;

   if ($bNew){
      $strLID = '<i>new</i>';
   }else {
      $strLID = str_pad($lLocID, 5, '0', STR_PAD_LEFT);
   }

   $attributes = array('name' => 'frmEditP', 'id' => 'frmEditP');
   echoT(form_open('hospice/super/location_rec/addEditLoc/'.$lLocID, $attributes));


   if ($bNew){
      $strTitle  = "Add New Location";
      $strButton = "Add Location";
   }else {
      $strTitle  = "Update Location Record";
      $strButton = "Update";
   }

   $clsForm->strStyleExtraLabel = 'width: 80pt;';

   openBlock('Location', '');  echoT('<table class="enpView" >');
   echoT($clsForm->strLabelRow('locationID',  $strLID, 1));

      // Location name / banner name
   $clsForm->strExtraFieldText = form_error('txtLocName');
   $clsForm->strID = 'addEditEntry';
   echoT($clsForm->strGenericTextEntry  ('Location Name', 'txtLocName',       true,   $formData->txtLocName,   50, 80));
   $clsForm->strExtraFieldText = form_error('txtLocBannerTag');
   echoT($clsForm->strGenericTextEntry  ('Banner Tag Line',   'txtLocBannerTag',  true,   $formData->txtLocBannerTag, 50, 80));

      // Address
   echoT($clsForm->strGenericTextEntry('Address 1',   'txtAddr1',   false,  $formData->txtAddr1,    40, 80));
   echoT($clsForm->strGenericTextEntry('Address 2',   'txtAddr2',   false,  $formData->txtAddr2,    40, 80));
   echoT($clsForm->strGenericTextEntry('City',        'txtCity',    false,  $formData->txtCity,     40, 80));
   echoT($clsForm->strGenericTextEntry('State',       'txtState',   false,  $formData->txtState,    40, 80));
   echoT($clsForm->strGenericTextEntry('Zip',         'txtZip',     false,  $formData->txtZip,      20, 40));
   echoT($clsForm->strGenericTextEntry('Country',     'txtCountry', false,  $formData->txtCountry,  20, 80));

      // Phone / Fax / Email / Web
   echoT($clsForm->strGenericTextEntry('Phone',     'txtPhone', false,  $formData->txtPhone, 20,  40));
   echoT($clsForm->strGenericTextEntry('Fax',       'txtFax',   false,  $formData->txtFax,   20,  40));
   $clsForm->strExtraFieldText = form_error('txtEmail');
   echoT($clsForm->strGenericTextEntry('Email',     'txtEmail', false,  $formData->txtEmail, 40, 120));
   echoT($clsForm->strGenericTextEntry('Web',       'txtWeb',   false,  $formData->txtWeb, 40, 120));

         // Notes
   echoT($clsForm->strNotesEntry('Notes', 'txtNotes', false, $formData->txtNotes, 3, 50));

   echoT('</table>'); closeBlock();

   echoT($clsForm->strSubmitEntry($strButton, 1, 'cmdSubmit', 'text-align: center; width: 100pt;'));
   echoT(form_close('<br>'));
   echoT('<script type="text/javascript">frmEditP.addEditEntry.focus();</script>');




