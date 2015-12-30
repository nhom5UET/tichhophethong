<?php

   function patientVisit(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $bFormPassed = true;
      $CI =& get_instance();
      $cSchema = new muser_schema;
      $cSchema->loadUFSchemaViaAttachTypeUserTabName(CENUM_CONTEXT_VOLUNTEER, 'Patient Visit', $lTableID, true);
      $cSchema->loadDDLValues($lTableID);

      $bPassed = pvVerifyPersonServed ($CI, $cSchema, $lTableID); $bFormPassed = $bFormPassed && $bPassed;
      $bPassed = pvVerifyLocation     ($CI, $cSchema, $lTableID); $bFormPassed = $bFormPassed && $bPassed;
      $bPassed = pvVerifyActivity     ($CI, $cSchema, $lTableID); $bFormPassed = $bFormPassed && $bPassed;
      $bPassed = pvVerifyInterventions($CI, $cSchema, $lTableID); $bFormPassed = $bFormPassed && $bPassed;

      return($bFormPassed);
   }

   function pvVerifyActivity(&$CI, &$cSchema, $lTableID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
         // if "Other" is selected, notes are required
      $strLocationDDLFN = pvStrFieldInternalName('Activity', $lTableID, $cSchema);
      $lLocationIDX     = $cSchema->lFieldIDX_ViaUserFieldName($lTableID, 'Activity', true);
      $lLocID = $cSchema->lDDLItemIDViaUserName($lTableID, $lLocationIDX, 'Other (please specify in notes)', true);
      if ((int)@$_POST[$strLocationDDLFN] == $lLocID){
            // if "Other" is selected, notes are required
         $strOtherNotesFN = pvStrFieldInternalName('Notes (Activity)', $lTableID, $cSchema);
         if (trim($_POST[$strOtherNotesFN])==''){
            setCFormErrorMessage($strOtherNotesFN, 'Please provide notes about <b>Other Activity</b>.');
            return(false);
         }
      }
      return(true);
   }

   function pvVerifyLocation(&$CI, &$cSchema, $lTableID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
         // if "Other" is selected, notes are required
      $strLocationDDLFN = pvStrFieldInternalName('Location', $lTableID, $cSchema);
      $lLocationIDX     = $cSchema->lFieldIDX_ViaUserFieldName($lTableID, 'Location', true);
      $lLocID = $cSchema->lDDLItemIDViaUserName($lTableID, $lLocationIDX, 'Other (please specify in notes)', true);
      if ((int)@$_POST[$strLocationDDLFN] == $lLocID){
            // if "Other" is selected, notes are required
         $strOtherNotesFN = pvStrFieldInternalName('Notes (Location)', $lTableID, $cSchema);
         if (trim($_POST[$strOtherNotesFN])==''){
            setCFormErrorMessage($strOtherNotesFN, 'Please provide notes about <b>Other Location</b>.');
            return(false);
         }
      }
      return(true);
   }

   function pvVerifyPersonServed(&$CI, &$cSchema, $lTableID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $checkBoxes = array(
               'Patient'   => pvStrFieldInternalName('Patient',   $lTableID, $cSchema),
               'Caregiver' => pvStrFieldInternalName('Caregiver', $lTableID, $cSchema),
               'Bereaved'  => pvStrFieldInternalName('Bereaved',  $lTableID, $cSchema),
               'Other'     => pvStrFieldInternalName('Other',     $lTableID, $cSchema));

      $bAnyChecked = pvBAnyChecked($checkBoxes);
      if (!$bAnyChecked){
         setCFormErrorMessage($checkBoxes['Other'], 'Please indicate the <b>Person Served</b>.');
         return(false);
      }

         // if "Other" is checked, notes are required
      $strOtherNotesFN = pvStrFieldInternalName('Notes (Person Served)', $lTableID, $cSchema);
      if ((@$_POST[$checkBoxes['Other']]=='true') && (trim($_POST[$strOtherNotesFN])=='')){
         setCFormErrorMessage($strOtherNotesFN, 'Please provide notes about <b>Other Person Served</b>.');
         return(false);
      }

      return(true);
   }

   function pvVerifyInterventions(&$CI, &$cSchema, $lTableID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $checkBoxes = array(
            'Companionship'             => pvStrFieldInternalName('Companionship'            , $lTableID, $cSchema),
            'Caregiver Relief'          => pvStrFieldInternalName('Caregiver Relief'         , $lTableID, $cSchema),
            'Emotional Support'         => pvStrFieldInternalName('Emotional Support'        , $lTableID, $cSchema),
            'Socialization'             => pvStrFieldInternalName('Socialization'            , $lTableID, $cSchema),
            'Bereavement'               => pvStrFieldInternalName('Bereavement'              , $lTableID, $cSchema),
            'Telephone Call'            => pvStrFieldInternalName('Telephone Call'           , $lTableID, $cSchema),
            'Excursion / Errands'       => pvStrFieldInternalName('Excursion / Errands'      , $lTableID, $cSchema),
            'Music / Pet / Art Support' => pvStrFieldInternalName('Music / Pet / Art Support', $lTableID, $cSchema),
            'Food Preparation'          => pvStrFieldInternalName('Food Preparation'         , $lTableID, $cSchema),
            'Household Chores'          => pvStrFieldInternalName('Household Chores'         , $lTableID, $cSchema),
            'Other intervention'        => pvStrFieldInternalName('Other intervention'       , $lTableID, $cSchema));

      $bAnyChecked = pvBAnyChecked($checkBoxes);
      if (!$bAnyChecked){
         setCFormErrorMessage($checkBoxes['Other intervention'], 'Please indicate the <b>Intervention</b>.');
         return(false);
      }

         // if "Other" is checked, notes are required
      $strOtherNotesFN = pvStrFieldInternalName('Notes (Other intervention)', $lTableID, $cSchema);
      if ((@$_POST[$checkBoxes['Other intervention']]=='true') && (trim($_POST[$strOtherNotesFN])=='')){
         setCFormErrorMessage($strOtherNotesFN, 'Please provide notes about <b>Other Intervention</b>.');
         return(false);
      }
      return(true);
   }

   function pvStrFieldInternalName($strName, $lTableID, &$cSchema){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $cSchema->fieldInfoViaUserFieldName($lTableID, $strName, $fieldInfo, true);
/* -------------------------------------
echo('<font class="debug">'.substr(__FILE__, strrpos(__FILE__, '\\'))
   .': '.__LINE__.'<br>$fieldInfo   <pre>');
echo(htmlspecialchars( print_r($fieldInfo, true))); echo('</pre></font><br>');
die;
// ------------------------------------- */

      return($fieldInfo->strFieldNameInternal);
   }


   function pvBAnyChecked($checkBoxes){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      foreach ($checkBoxes as $strFN){
         if (@$_POST[$strFN]=='true') return(true);
      }
      return(false);
   }


