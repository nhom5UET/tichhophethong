<?php
   global $gbDateFormatUS, $gstrFormatDatePicker;

   $strPatientID = str_pad($lPatientID, 5, '0', STR_PAD_LEFT);

   $attributes = array('name' => 'frmEditPVisit', 'id' => 'frmAddEdit');
   echoT(form_open('hospice/patient_visit/addEditPatientVisit/'.$lVolID.'/'.$lPVRecID.'/'.$lPatientID, $attributes));

   $clsForm = new generic_form;
   $clsForm->strLabelClass = $clsForm->strLabelRowLabelClass = $clsForm->strLabelClassRequired = 'enpViewLabel';
   $clsForm->strTitleClass = 'enpViewTitle';
   $clsForm->strEntryClass = 'enpView';
   $clsForm->bValueEscapeHTML = false;

   openBlock(($bNew ? 'New ' : 'Update ').'Patient Visit', '');
   echoT('<table class="enpView">');

   echoT($clsForm->strLabelRow('patientID',  $strPatientID, 1));
   echoT($clsForm->strLabelRow('Patient',    $patient->strSafeName, 1));
   echoT($clsForm->strLabelRow('Visited By', $volRec->strSafeNameFL, 1));

   showVisitBase    ($clsForm, $formData);
   showPersonServed ($clsForm, $formData);
   showLocation     ($clsForm, $formData);
   showActivity     ($clsForm, $formData);
   showInterventions($clsForm, $formData);
   showVisitInfo    ($clsForm, $formData);


   echoT($clsForm->strSubmitEntry('Save', 1, 'cmdSubmit', 'text-align: center; width: 80pt;'));

   echoT('</table>'.form_close());

   closeBlock();

   function showVisitInfo(&$clsForm, &$formData){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      echoT($clsForm->strTitleRow('Visit Information: <span style="font-size: 9pt;"><i>Check all that apply</i></span>', 2, 'font-size: 13pt; border-bottom: 2px solid #000; padding-top: 10px;'));
      $clsForm->strStyleExtraLabel = 'padding-top: 4px;';

         // Patient Status
      $clsForm->strExtraFieldText =
                  '</td><td style="vertical-align: top;">When you made your visit,<br>the patient was...</td></tr></table>'
                 .'<span style="font-size: 8pt;"><i>CTRL-Click to select more than one entry</span></i>'
                 .form_error('ddlM_PatientStatus');
      echoT($clsForm->strLabelRow('Patient Status', '<table border="0"><tr><td>'.$formData->ddlM_PatientStatus, 1));

         // Visit Tasks
      $clsForm->strExtraFieldText =
                  '</td><td style="vertical-align: top;">During your visit, you...</td></tr></table>'
                 .'<span style="font-size: 8pt;"><i>CTRL-Click to select more than one entry</span></i>'
                 .form_error('ddlM_VisitTasks');
      echoT($clsForm->strLabelRow('Visit Activities', '<table border="0"><tr><td>'.$formData->ddlM_VisitTasks, 1));

         // Notes for "Other Tasks"
      $clsForm->strExtraFieldText = form_error('txtVisitNotes');
      echoT($clsForm->strNotesEntry('Notes', 'txtVisitNotes', false, $formData->txtVisitNotes, 3, 50));
      
      $clsForm->strExtraFieldText = ' <i>Check if the patient had visitors</i>';      
      echoT($clsForm->strGenericCheckEntry('Visitors?',     'chkTSK_Visitors',     'TRUE', false, $formData->TSK_bVisitors));

         // Patient Comfort
      $clsForm->strExtraFieldText = 
                    '<br><i>Did the patient appear comfortable at the time of your visit?</i>'
                   .form_error('txtTSKPatientComfort');
      echoT($clsForm->strNotesEntry('Patient Comfort', 'txtTSKPatientComfort', true, $formData->txtTSKPatientComfort, 3, 50));
      
         // Patient Pain
      $clsForm->strExtraFieldText = 
                    '<br><i>Who did you notify if the patient reported pain to you?</i>';
      echoT($clsForm->strNotesEntry('Patient Pain', 'txtTSKPatientPain', false, $formData->txtTSKPatientPain, 3, 50));
      
         // Patient Concerns
      $clsForm->strExtraFieldText = 
                    '<br><i>Did you notify manager of Volunteer Services of changes in patient or family concerns?</i>';
      echoT($clsForm->strNotesEntry('Patient Concerns', 'txtTSKPatientConcerns', false, $formData->txtTSKPatientConcerns, 3, 50));
      
   }

   function showInterventions(&$clsForm, &$formData){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      echoT($clsForm->strTitleRow('Interventions: <span style="font-size: 9pt;"><i>Check all that apply</i></span>', 2, 'font-size: 13pt; border-bottom: 2px solid #000; padding-top: 10px;'));
      $clsForm->strStyleExtraLabel = 'padding-top: 4px;';

      echoT($clsForm->strGenericCheckEntry('Companionship',                'chkI_Companionship',      'TRUE', false, $formData->i_bCompanionship));
      echoT($clsForm->strGenericCheckEntry('Caregiver Relief',             'chkI_CaregiverRelief',    'TRUE', false, $formData->i_bCaregiverRelief));
      echoT($clsForm->strGenericCheckEntry('Emotional Support',            'chkI_EmotionalSupport',   'TRUE', false, $formData->i_bEmotionalSupport));
      echoT($clsForm->strGenericCheckEntry('Socialization',                'chkI_Socialization',      'TRUE', false, $formData->i_bSocialization));
      echoT($clsForm->strGenericCheckEntry('Bereavement',                  'chkI_Bereavement',        'TRUE', false, $formData->i_bBereavement));
      echoT($clsForm->strGenericCheckEntry('Telephone Call',               'chkI_TelephoneCall',      'TRUE', false, $formData->i_bTelephoneCall));
      echoT($clsForm->strGenericCheckEntry('Excursion / Errands',          'chkI_ExcursionErrands',   'TRUE', false, $formData->i_bExcursionErrands));
      echoT($clsForm->strGenericCheckEntry('Music / Pet / Art / Support',  'chkI_MusicPetArtSupport', 'TRUE', false, $formData->i_bMusicPetArtSupport));
      echoT($clsForm->strGenericCheckEntry('Food Preparation',             'chkI_FoodPreparation',    'TRUE', false, $formData->i_bFoodPreparation));
      echoT($clsForm->strGenericCheckEntry('Household Chores',             'chkI_HouseholdChores',    'TRUE', false, $formData->i_bHouseholdChores));

      $clsForm->strExtraFieldText = '<i>(please specify in notes)</i>';
      echoT($clsForm->strGenericCheckEntry('Other Intervention',           'chkI_OtherIntervention',  'TRUE', false, $formData->i_bOtherIntervention));

      $clsForm->strExtraFieldText = form_error('txtI_Notes');
      echoT($clsForm->strNotesEntry('Notes', 'txtI_Notes', false, $formData->txtI_Notes, 3, 50));
   }

   function showLocation(&$clsForm, &$formData){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      echoT($clsForm->strTitleRow('Location', 2, 'font-size: 13pt; border-bottom: 2px solid #000; padding-top: 10px;'));
      $clsForm->strStyleExtraLabel = 'padding-top: 4px;';

         // Location
      $clsForm->strExtraFieldText = form_error('ddlLocation');
      echoT($clsForm->strLabelRow('Location', $formData->ddlLocation, 1));
      $clsForm->strExtraFieldText = form_error('txtLocationNotes');
      echoT($clsForm->strNotesEntry('Notes', 'txtLocationNotes', false, $formData->txtLocationNotes, 3, 50));
   }

   function showActivity(&$clsForm, &$formData){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      echoT($clsForm->strTitleRow('Type of Activity', 2, 'font-size: 13pt; border-bottom: 2px solid #000; padding-top: 10px;'));
      $clsForm->strStyleExtraLabel = 'padding-top: 4px;';

         // Activity
      $clsForm->strExtraFieldText = form_error('ddlActivity');
      echoT($clsForm->strLabelRow('Activity', $formData->ddlActivity, 1));
      $clsForm->strExtraFieldText = form_error('txtActivityNotes');
      echoT($clsForm->strNotesEntry('Notes', 'txtActivityNotes', false, $formData->txtActivityNotes, 3, 50));
   }

   function showPersonServed(&$clsForm, &$formData){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      echoT($clsForm->strTitleRow('Person Served', 2, 'font-size: 13pt; border-bottom: 2px solid #000; padding-top: 10px;'));
      $clsForm->strStyleExtraLabel = 'padding-top: 4px;';

      echoT($clsForm->strGenericCheckEntry('Patient',   'chkPS_Patient',   'TRUE', false, $formData->ps_bPatient));
      echoT($clsForm->strGenericCheckEntry('Caregiver', 'chkPS_Caregiver', 'TRUE', false, $formData->ps_bCaregiver));
      echoT($clsForm->strGenericCheckEntry('Bereaved',  'chkPS_Bereaved',  'TRUE', false, $formData->ps_bBereaved));

      $clsForm->strExtraFieldText = '<i>(please specify in notes)</i>';
      echoT($clsForm->strGenericCheckEntry('Other',     'chkPS_Other',     'TRUE', false, $formData->ps_bOther));

      $clsForm->strExtraFieldText = form_error('txtPS_Notes');
      echoT($clsForm->strNotesEntry('Notes', 'txtPS_Notes', false, $formData->ps_txtNotes, 3, 50));
   }

   function showVisitBase(&$clsForm, &$formData){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      echoT($clsForm->strTitleRow('Patient Visit', 2, 'font-size: 13pt; border-bottom: 2px solid #000; padding-top: 10px;'));
      $clsForm->strStyleExtraLabel = 'padding-top: 4px;';

         //----------------------
         // Date of visit
         //----------------------
      echoT(strDatePicker('datepicker1', false));
      $clsForm->strExtraFieldText = form_error('txtDateOfVisit');
      echoT($clsForm->strGenericDatePicker(
                         'Patient Visit Date', 'txtDateOfVisit', true,
                         $formData->txtDateOfVisit,  'frmEditPVisit', 'datepicker1'));

         // medical record #
      $clsForm->strExtraFieldText = form_error('txtMedRecNum');
      echoT($clsForm->strGenericTextEntry('Medical Record #',  'txtMedRecNum', true,  $formData->txtMedRecNum, 20, 30));

         // Start Time
      $clsForm->strExtraFieldText = form_error('ddlStart');
      echoT($clsForm->strLabelRow('Start Time',  $formData->ddlStart, 1));

         // Duration
      $clsForm->strExtraFieldText = form_error('ddlDuration');
      echoT($clsForm->strLabelRow('Duration',  $formData->ddlDuration, 1));


//      echoT('</table>');
//      closeBlock();
   }


