<?php
   global $glVolID;

   openBlock(($bNew ? 'Add New ' : 'Edit ')
       .' Volunteer Trainging for '.$volRec->strSafeNameFL, '');

   $attributes = array('name' => 'frmTraining');
   echoT(form_open('hospice/vols/vol_training/addEditVolTraining/'.$lTrainingID.'/'.$lVolID, $attributes));

   $clsForm  = new generic_form;
   $clsForm->strLabelClass      = $clsForm->strLabelRowLabelClass = $clsForm->strLabelClassRequired = 'enpViewLabel';
   $clsForm->strEntryClass      = 'enpView';
   $clsForm->strStyleExtraLabel = 'width: 100pt; padding-top: 4px;';
   $clsForm->bValueEscapeHTML   = false;

   echoT('<table>');

      //----------------------
      // Training date
      //----------------------
   echoT(strDatePicker('datepicker1', false, 2000));
   $clsForm->strExtraFieldText = form_error('txtDate');
   echoT($clsForm->strGenericDatePicker(
                      'Date of Training', 'txtDate',     true,
                      $formData->txtDate, 'frmTraining', 'datepicker1'));


      /*-------------------------------
         Duration
      -------------------------------*/
      $clsForm->strExtraFieldText = form_error('ddlDuration');
      echoT($clsForm->strLabelRow('Duration',  $formData->ddlDuration, 1));

      /*-------------------------------
         Training Type
      -------------------------------*/
   $clsForm->strExtraFieldText = form_error('ddlTraining');
   echoT($clsForm->strLabelRow('Training Type', $formData->strTrainingType, 1));

      /*-------------------------------
         Conducted By
      -------------------------------*/
   $clsForm->strExtraFieldText = form_error('ddlTrainingBy');
   echoT($clsForm->strLabelRow('Conducted By', $formData->strTrainingBy, 1));

      /*-------------------------------
         Notes
      -------------------------------*/
   $clsForm->strStyleExtraLabel = 'vertical-align: top; padding-top: 2pt; ';
   $clsForm->strExtraFieldText = form_error('txtNotes');
   echoT($clsForm->strNotesEntry('Notes', 'txtNotes', false, $formData->strNotes, 3, 34));


   echoT($clsForm->strSubmitEntry('Save', 2, 'cmdSubmit', ' width: 75pt;'));
   echoT('</table></form>');

   closeBlock();
