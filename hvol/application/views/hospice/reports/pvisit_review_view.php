<?php

   if ($lNumYearlyPV == 0){
      echoT('<br><i>There are no patient visits for '.$lYear.'.</i>');
      return;
   }
   
   $params = array('enumStyle' => 'terse', 'clsRpt');
   $clsRpt = new generic_rpt($params);
   $clsRpt->strWidthLabel = '110pt';   

   $attributes = new stdClass;
   $attributes->lTableWidth      = 900;
   $attributes->lUnderscoreWidth = 350;
   $attributes->bStartOpen       = false;

   showPVisitReview($clsRpt, 'For the year '.$lYear, $yearly, false, $attributes, null);
   
   for ($idx=1; $idx<=12; ++$idx){
      showPVisitReview($clsRpt, strXlateMonth($idx).' '.$lYear, $visitMonth[$idx], true, $attributes, $idx);
   }
   
   
   function showPVisitReview($clsRpt, $strLabel, $visitInfo, $bUseAtts, $attributes, $lMonth){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($bUseAtts){
         $attributes->bCloseDiv  = false;
         $attributes->divID      = 'group_'.$lMonth.'_Div';
         $attributes->divImageID = 'group_'.$lMonth.'_DivImg';
         openBlock($strLabel, '', $attributes);
      }else {
         openBlock($strLabel, '');
      }
      
      echoT(
          $clsRpt->openReport());

      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('# Patient Visits:')
         .$clsRpt->writeCell(number_format($visitInfo->lNumVisits))
         .$clsRpt->closeRow  ());
      
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Hours:')
         .$clsRpt->writeCell(number_format($visitInfo->sngHrsMins, 2).' hrs')
         .$clsRpt->closeRow  ());
      
         // those served
      $strURServed = 
          '<ul style="margin-top: 0px; margin-left: -20px; margin-bottom: 0px;">
             <li>Patient: '  .number_format($visitInfo->lPatientServed).'</li>
             <li>Caregiver: '.number_format($visitInfo->lCaregiverServed).'</li>
             <li>Bereaved: ' .number_format($visitInfo->lBereavedServed).'</li>
             <li>Other: '    .number_format($visitInfo->lOtherServed).'</li>
          </ul>';
      
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Those Served:')
         .$clsRpt->writeCell($strURServed)
         .$clsRpt->closeRow  ());
            
         // activities
      $strURActivity = 
          '<ul style="margin-top: 0px; margin-left: -20px; margin-bottom: 0px;">'."\n";
      foreach ($visitInfo->activities as $act){
         $strURActivity .= 
             '<li>'.htmlspecialchars($act->strActivity).': '  .number_format($act->lNumActs).'</li>'."\n";         
      }
      $strURActivity .= '</ul>';
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Activities:')
         .$clsRpt->writeCell($strURActivity)
         .$clsRpt->closeRow  ());
      
         // Interventions
      $strULInt = 
          '<ul style="margin-top: 0px; margin-left: -20px; margin-bottom: 0px;">
             <li>Companionship: '    .number_format($visitInfo->interventions->lCompanionship   ).'</li>
             <li>Caregiver Relief: ' .number_format($visitInfo->interventions->lCaregiverRelief ).'</li>
             <li>Emotional Support: '.number_format($visitInfo->interventions->lEmotionalSupport).'</li>
             <li>Socialization: '    .number_format($visitInfo->interventions->lSocialization   ).'</li>
             <li>Bereavement: '      .number_format($visitInfo->interventions->lBereavement     ).'</li>
             <li>Telephone Call: '   .number_format($visitInfo->interventions->lTelephoneCall   ).'</li>
             <li>Excursion/Errands: '.number_format($visitInfo->interventions->lExcursionErrands).'</li>
             <li>Music/Pet/Art: '    .number_format($visitInfo->interventions->lMusicPetArt     ).'</li>
             <li>Food Preparation: ' .number_format($visitInfo->interventions->lFoodPrep        ).'</li>
             <li>Household Chores: ' .number_format($visitInfo->interventions->lHouseholdChores ).'</li>
             <li>Other: '            .number_format($visitInfo->interventions->lOther           ).'</li>
          </ul><br>
          <i>Note: intervention total may exceed total visits, since <br>
             multiple interventions may occur with each visit.</i>';
      
      echoT(
          $clsRpt->openRow   ()
         .$clsRpt->writeLabel('Interventions:')
         .$clsRpt->writeCell($strULInt)
         .$clsRpt->closeRow  ());
      
      
      echoT($clsRpt->closeReport());
   
      if ($bUseAtts){
         $attributes->bCloseDiv = true;
         closeBlock($attributes);
      }else {
         closeBlock();
      }
   }