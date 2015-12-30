<?php
//---------------------------------------------------------------------
// Hospice Volunteer Solutions / Hospice Manager!
//
// copyright (c) 2015 by Database Austin
// Austin, Texas
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//
/*---------------------------------------------------------------------
      $this->load->helper('hospice/patient_visit');
---------------------------------------------------------------------*/

   namespace pvisit;

   function strDurationDDL($lMatch, $bAddBlank, $strDDLName, $strID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strOut =
         '<select name="'.$strDDLName.'" id="'.$strID.'">'."\n";
      if ($bAddBlank){
         $strOut .= '<option value="-1">&nbsp;</option>'."\n";
      }

      $strOut .=
         '<option value="15" '.($lMatch==15 ? 'SELECTED' : '').'>15 minutes</option>
          <option value="30" '.($lMatch==30 ? 'SELECTED' : '').'>30 minutes</option>
          <option value="45" '.($lMatch==45 ? 'SELECTED' : '').'>45 minutes</option>'."\n";
      $strOut .=
         '<option value="60" '.($lMatch==60 ? 'SELECTED' : '').'>1 hour</option>
          <option value="75" '.($lMatch==75 ? 'SELECTED' : '').'>1 hour 15 minutes</option>
          <option value="90" '.($lMatch==90 ? 'SELECTED' : '').'>1 hour 30 minutes</option>
          <option value="105"'.($lMatch==105? 'SELECTED' : '').'>1 hour 45 minutes</option>'."\n";

      $lMinutes = 120;
      for ($hour=2; $hour<24; ++$hour){
         $strOut .=
            '<option value="'.$lMinutes.'" '.($lMatch==$lMinutes ? 'SELECTED' : '').'>'.$hour.' hours</option>'."\n";
         $lMinutes += 15;
         for ($lQtr=1; $lQtr<4; ++$lQtr){
            $strOut .= '<option value="'.$lMinutes.'" '.($lMatch==$lMinutes ? 'SELECTED' : '').'>'
                 .       $hour.' hours '.($lQtr*15).' minutes</option>'."\n";
            $lMinutes += 15;
         }
      }
      $strOut .= '</select>'."\n";
      return($strOut);
   }

   function strTimeDDL($lMatchUTS, $bAddBlank, $strDDLName, $strID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lBaseTime = strtotime('2000-01-01 00:00:00');
      $lTimeInc = 15*60;
      $lMaxTime = $lBaseTime + 24*60*60;
      $strOut =
         '<select name="'.$strDDLName.'" id="'.$strID.'">'."\n";
      if ($bAddBlank){
         $strOut .= '<option value="-1">&nbsp;</option>'."\n";
      }
      for ($idx=$lBaseTime; $idx<$lMaxTime; $idx+=$lTimeInc){
         $strOut .= '<option value="'.$idx.'" '.($lMatchUTS==$idx ? 'SELECTED' : '').'>'
                 .       date('g:i A', $idx).'</option>'."\n";
      }
      $strOut .= '</select>'."\n";
      return($strOut);
   }

   function strMinutesToHoursMin($lMin){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strOut = '';
      $lHours = (int)($lMin/60);
      $lMin   = $lMin % 60;
      if ($lHours > 0){
         $strOut .= $lHours.' hour'.($lHours > 1 ? 's' : '').' ';
      }
      if ($lMin > 0) $strOut .= $lMin.' minutes';
      return($strOut);
   }

