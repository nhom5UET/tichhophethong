<?php

   if ($lNumPVisitRecs == 0){
      echoT('<i>There are no patient visit records for this volunteer.</i><br><br>');
   }else {
      displayPatientVisits($pVisits, $displayFields, $strVolSafeName);
   }

   echoT($unscheduled);

   function displayPatientVisits(&$pVisits, &$displayFields, $strVolSafeName){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------   
      echoT('<br>
         <table class="enpRptC">
            <tr>
               <td class="enpRptTitle" colspan="10">
                  Patient Visits by volunteer '.$strVolSafeName.'
               </td>
            </tr>
            <tr>
               <td class="enpRptLabel">&nbsp;</td>
               <td class="enpRptLabel">Patient</td>
               <td class="enpRptLabel">Date / Time of Visit</td>
               <td class="enpRptLabel">Person Served</td>
               <td class="enpRptLabel">Activity</td>
               <td class="enpRptLabel">Interventions</td>
               <td class="enpRptLabel">Visit Info</td>
            </tr>');
            
      foreach ($pVisits as $pV){
            // visit info
         $strVI =
             'For this visit, the patient was'.strMultiDDL2UL($pV->status)
            .'During my visit, I'.strMultiDDL2UL($pV->tasks)
            ;

         $lVisitID = $pV->lKeyID;
         $strDateOfVisit =
            date('l, F jS, Y', $pV->dteVisit).'<br>'
              .date('g:i A', $pV->lStartTime).' / '.pvisit\strMinutesToHoursMin($pV->lDuration);

         $strPS = '<ul style="margin-top: 0px; margin-left: -25px; margin-bottom: 0px;">'."\n";
         $strPS .= strAddListElement($pV->ps_bPatient,   'Patient');
         $strPS .= strAddListElement($pV->ps_bCaregiver, 'Caregiver');
         $strPS .= strAddListElement($pV->ps_bBereaved,  'Bereaved');
         $strPS .= strAddListElement($pV->ps_bOther,     'Other');
         $strPS .= '</ul>'."\n";
         if ($pV->ps_strNotes != '') $strPS .= nl2br(htmlspecialchars($pV->ps_strNotes));

            // activity
         $strAct = htmlspecialchars($pV->strActivity);
         if ($pV->act_strNotes != '') $strAct .= '<br>'.nl2br(htmlspecialchars($pV->act_strNotes));

            // intervention
         $strInt = '<ul style="margin-top: 0px; margin-left: -25px; margin-bottom: 0px;">'."\n";
         $strInt .= strAddListElement($pV->in_bCompanionship,     'Companionship');
         $strInt .= strAddListElement($pV->in_bCaregiverRelief,   'Caregiver Relief');
         $strInt .= strAddListElement($pV->in_bEmotionalSupport,  'Emotional Support');
         $strInt .= strAddListElement($pV->in_bSocialization,     'Socialization');
         $strInt .= strAddListElement($pV->in_bBereavement,       'Bereavement');
         $strInt .= strAddListElement($pV->in_bTelephoneCall,     'Telephone Call');
         $strInt .= strAddListElement($pV->in_bExcursionErrands,  'Excursions / Errands');
         $strInt .= strAddListElement($pV->in_bMusicPetArt,       'Music / Pet / Art');
         $strInt .= strAddListElement($pV->in_bFoodPrep,          'Food Preparation');
         $strInt .= strAddListElement($pV->in_bHouseholdChores,   'Household Chores');
         $strInt .= strAddListElement($pV->in_bOther,             'Other');

         $strInt .= '</ul>'."\n";
         if ($pV->in_strNotes != '') $strInt .= nl2br(htmlspecialchars($pV->in_strNotes));

         echoT('
            <tr class="makeStripe">
               <td class="enpRpt" style="text-align: center;">'
                  .str_pad($lVisitID, 5, '0', STR_PAD_LEFT).'&nbsp;'
                  .strLinkView_PVisit($lVisitID, 'View patient visit record', true, 'id="pv'.$lVisitID.'"').'
               </td>
               <td class="enpRpt" style="width: 100pt;">'
                  .htmlspecialchars($pV->strPatientLName.', '.$pV->strPatientFName).'
               </td>
               <td class="enpRpt">'.$strDateOfVisit.'</td>
               <td class="enpRpt">'.$strPS.'</td>
               <td class="enpRpt">'.$strAct.'</td>
               <td class="enpRpt">'.$strInt.'</td>
               <td class="enpRpt" style="width: 210pt;">'.$strVI.'</td>

         ');
      }
      echoT('</table><br><br>');
   }


   function strAddListElement($bTest, $strListItem){
      if ($bTest){
         return('<li>'.$strListItem.'</li>'."\n");
      }else {
         return('');
      }
   }

   function strMultiDDL2UL($fMulti){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($fMulti->lNumInList == 0){
         $strOut = '<i>(no entry selected)</i>'."\n";
      }else {
         $strOut = '<ul style="margin-top: 0px;">'."\n";
         foreach ($fMulti->listItems as $entry){
            $strOut .= '<li>'.htmlspecialchars($entry->strListItem).'</li>'."\n";
         }
         $strOut .= '</ul>'."\n";
      }
      return($strOut);
   }
