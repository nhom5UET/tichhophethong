<?php
   global $gbVolMgr;

   $params = array('enumStyle' => 'terse', 'clsRpt');
   $clsRpt = new generic_rpt($params);
   $clsRpt->strWidthLabel = '130pt';

   $attributes = new stdClass;
   $attributes->lTableWidth      = 900;
   $attributes->lUnderscoreWidth = 350;
   $attributes->bStartOpen       = true;

   $lVolID     = $pVisit->lVolID;
   $lPVRecID   = $pVisit->lKeyID;
   $lPatientID = $pVisit->lPatientID;

   if ($gbVolMgr){
      $strLinkRem =
              '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
             .strLinkRem_PVisit($lVolID, $lPVRecID, 'Remove', true,  true).'&nbsp;'
             .strLinkRem_PVisit($lVolID, $lPVRecID, 'Remove', false, true);
      $strLinkEdit =
                 strLinkEdit_PVisit($lVolID, $lPVRecID, $lPatientID, true,  'Edit record', ' id="editURec_' .$lPVRecID.'" ').'&nbsp;'
                .strLinkEdit_PVisit($lVolID, $lPVRecID, $lPatientID, false, 'Edit record', ' id="editURec1_'.$lPVRecID.'" ');
   }else {
      $strLinkRem = $strLinkEdit = '';
   }

   openBlock('Patient Visit', $strLinkEdit.$strLinkRem);

   showGeneralPVisitInfo($attributes, $clsRpt, $pVisit);
   showPersonServed     ($attributes, $clsRpt, $pVisit);
   showLocation         ($attributes, $clsRpt, $pVisit);
   showActivity         ($attributes, $clsRpt, $pVisit);
   showInterventions    ($attributes, $clsRpt, $pVisit);
   showVisitDetails     ($attributes, $clsRpt, $pVisit);
   showPVisitStats      ($attributes, $clsRpt, $pVisit);

   closeBlock();

   function showVisitDetails($attributes, $clsRpt, $pVisit){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pVDet';
      $attributes->divImageID   = 'pVDetDivImg';
      openBlock('Visit Details', '', $attributes);

      echoT(
          $clsRpt->openReport());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('For this Visit, the Patient Was:')
         .$clsRpt->writeCell (strMultiDDL2UL($pVisit->status))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('During the Visit, the Volunteer:')
         .$clsRpt->writeCell (strMultiDDL2UL($pVisit->tasks))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Other Activities:')
         .$clsRpt->writeCell (nl2br(htmlspecialchars($pVisit->tsk_strOtherNotes)))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('The Patient had Visitors:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->tsk_bVisitors ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Patient Comfort:')
         .$clsRpt->writeCell (nl2br(htmlspecialchars($pVisit->tsk_strPatientComfort)))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Patient Pain:')
         .$clsRpt->writeCell (nl2br(htmlspecialchars($pVisit->tsk_strPatientPain)))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Concerns / Changes:')
         .$clsRpt->writeCell (nl2br(htmlspecialchars($pVisit->tsk_strChangesConcerns)))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->closeReport());

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showInterventions($attributes, $clsRpt, $pVisit){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pVInt';
      $attributes->divImageID   = 'pVIntDivImg';
      openBlock('Interventions', '', $attributes);

      echoT(
          $clsRpt->openReport());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Companionship:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->in_bCompanionship ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Emotional Support:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->in_bEmotionalSupport ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Socialization:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->in_bSocialization ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Bereavement:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->in_bBereavement ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Telephone Call:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->in_bTelephoneCall ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Excursion / Errands:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->in_bExcursionErrands ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Music / Pet / Art:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->in_bMusicPetArt ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Food Preparation:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->in_bFoodPrep ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Household Chores:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->in_bHouseholdChores ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Other:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->in_bOther ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Notes:')
         .$clsRpt->writeCell (nl2br(htmlspecialchars($pVisit->in_strNotes)))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->closeReport());

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showActivity($attributes, $clsRpt, $pVisit){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pVAct';
      $attributes->divImageID   = 'pVActDivImg';
      openBlock('Type of Activity', '', $attributes);

      echoT(
          $clsRpt->openReport());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Activity:')
         .$clsRpt->writeCell (htmlspecialchars($pVisit->strActivity))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Notes:')
         .$clsRpt->writeCell (nl2br(htmlspecialchars($pVisit->act_strNotes)))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->closeReport());

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showLocation($attributes, $clsRpt, $pVisit){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pVLoc';
      $attributes->divImageID   = 'pVLocDivImg';
      openBlock('Location', '', $attributes);

      echoT(
          $clsRpt->openReport());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Location:')
         .$clsRpt->writeCell (htmlspecialchars($pVisit->strLocation))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Notes:')
         .$clsRpt->writeCell (nl2br(htmlspecialchars($pVisit->loc_strNotes)))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->closeReport());

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showPersonServed($attributes, $clsRpt, $pVisit){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pVPS';
      $attributes->divImageID   = 'pVPSDivImg';
      openBlock('Person Served', '', $attributes);

      echoT(
          $clsRpt->openReport());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Patient:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->ps_bPatient ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Caregiver:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->ps_bCaregiver ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Bereaved:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->ps_bBereaved ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Other:')
         .$clsRpt->writeCell ('<img src="'.($pVisit->ps_bOther ? IMGLINK_CHECKON : IMGLINK_CHECKOFF).'">')
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Notes:')
         .$clsRpt->writeCell (nl2br(htmlspecialchars($pVisit->ps_strNotes)))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->closeReport());

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showGeneralPVisitInfo($attributes, $clsRpt, $pVisit){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr;
      
      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pVGen';
      $attributes->divImageID   = 'pVGenDivImg';
      openBlock('Visit', '', $attributes);

      echoT(
          $clsRpt->openReport());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Visit ID:')
         .$clsRpt->writeCell (str_pad($pVisit->lKeyID, 5, '0', STR_PAD_LEFT))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Organization:')
         .$clsRpt->writeCell (htmlspecialchars($pVisit->strChapterName))
         .$clsRpt->closeRow  ());

      if ($gbVolMgr){
         $strViewPRec = strLinkView_PatientRecord($pVisit->lPatientID, 'View patient record', true);
         $strViewVRec = strLinkView_VolRecord($pVisit->lVolID, 'View volunteer record', true);
      }else {
         $strViewVRec = $strViewPRec = '';
      }
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Patient:')
         .$clsRpt->writeCell (htmlspecialchars($pVisit->strPatientLName.', '.$pVisit->strPatientFName).'&nbsp;'
                      .$strViewPRec)
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Volunteer:')
         .$clsRpt->writeCell (htmlspecialchars($pVisit->strVolLName.', '.$pVisit->strVolFName).'&nbsp;'
                      .$strViewVRec)
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Date of Visit:')
         .$clsRpt->writeCell (date('l, F jS, Y', $pVisit->dteVisit))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Time/Duration:')
         .$clsRpt->writeCell (date('g:i A', $pVisit->lStartTime).'&nbsp;/&nbsp;'.pvisit\strMinutesToHoursMin($pVisit->lDuration))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Medical Record #:')
         .$clsRpt->writeCell (htmlspecialchars($pVisit->strMedRec))
         .$clsRpt->closeRow  ());

      echoT(
          $clsRpt->closeReport());

      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function showPVisitStats($attributes, $clsRpt, $pVisit){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $attributes->bCloseDiv    = false;
      $attributes->divID        = 'pVStats';
      $attributes->divImageID   = 'pVStatsDivImg';
      openBlock('Record Information', '', $attributes);
      echoT(
         $clsRpt->showRecordStats($pVisit->dteOrigin,
                               $pVisit->ucstrFName.' '.$pVisit->ucstrLName,
                               $pVisit->dteLastUpdate,
                               $pVisit->ulstrFName.' '.$pVisit->ulstrLName,
                               $clsRpt->strWidthLabel));
      $attributes->bCloseDiv = true;
      closeBlock($attributes);
   }

   function strMultiDDL2UL($fMulti){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($fMulti->lNumInList == 0){
         $strOut = '<i>(no entry selected)</i>'."\n";
      }else {
         $strOut = '<ul style="margin-top: 0px; ">'."\n";
         foreach ($fMulti->listItems as $entry){
            $strOut .= '<li style="margin-left: -20px;">'.htmlspecialchars($entry->strListItem).'</li>'."\n";
         }
         $strOut .= '</ul>'."\n";
      }
      return($strOut);
   }

