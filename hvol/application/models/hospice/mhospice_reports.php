<?php
/*---------------------------------------------------------------------
// Hospice Volunteer Manager
//
// copyright (c) 2015 by Database Austin
// Austin, Texas
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//
---------------------------------------------------------------------
      $this->load->model('hospice/mhospice_pvisit',  'cPVisit');
      $this->load->model('hospice/mhospice_reports', 'cHRpt');
---------------------------------------------------------------------*/

//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class mhospice_reports extends mhospice_pvisit{
   public
       $lTableID, $cSchema, $schema, $fieldInfo;


   public function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
      $this->lVolID = $this->lClientID = null;
   }

   function initHReports(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
   }

   function patientsServedViaMonth($lChapterID, $lMonth, $lYear, &$lNumPatients, &$lNumPatientVisits){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere =
          " AND YEAR(pv_dteVisit)=$lYear AND MONTH(pv_dteVisit)=$lMonth ";
      if (!is_null($lChapterID)) $sqlWhere .= " AND pv_lChapterID = $lChapterID ";
      $this->patientsServed($sqlWhere, $lNumPatients, $lNumPatientVisits);
   }

   function patientsServed($sqlWhereExtra, &$lNumPatients, &$lNumPatientVisits){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT COUNT(*) AS lNumPVisits
         FROM patient_visit
         WHERE NOT pv_bRetired
            $sqlWhereExtra ;";

      $query = $this->db->query($sqlStr);
      $row = $query->row();
      $lNumPatientVisits = (int)$row->lNumPVisits;

      $sqlStr =
        "SELECT DISTINCT pv_lPatientID
         FROM patient_visit
         WHERE NOT pv_bRetired
            $sqlWhereExtra
         ORDER BY pv_lPatientID;";

      $query = $this->db->query($sqlStr);
      $lNumPatients = (int)$query->num_rows();
   }

   function hrsPatientVisitsByMonth($lChapterID, $lMonth, $lYear, &$sngHrsMins){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere =
          " AND YEAR(pv_dteVisit)=$lYear AND MONTH(pv_dteVisit)=$lMonth ";
      if (!is_null($lChapterID)) $sqlWhere .= " AND pv_lChapterID = $lChapterID ";
      $this->hrsPatientVisits($sqlWhere, $sngHrsMins);
   }

   function hrsPatientVisits($sqlWhereExtra, &$sngHrsMins){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sngHrsMins = 0.0;
      $sqlStr =
        "SELECT SUM(pv_lDuration) AS lDurationMin
         FROM patient_visit
         WHERE NOT pv_bRetired
            $sqlWhereExtra ;";

      $query = $this->db->query($sqlStr);

      $lNumPVRecs = $query->num_rows();
      if ($lNumPVRecs > 0){
         $row = $query->row();
         $lMinutes = (int)$row->lDurationMin;
         $sngHrsMins = $lMinutes / 60.0;
      }
   }

   function lNumPatientVisits($sqlWhereExtra){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sngHrsMins = 0.0;
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM patient_visit
         WHERE NOT pv_bRetired
            $sqlWhereExtra ;";

      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRecs);
   }

   function countPersonServed($sqlWhereExtra, &$lPatient, &$lCaregiver, &$lBereaved, &$lOther){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lPatient   = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_ps_bPatient');
      $lCaregiver = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_ps_bCaregiver');
      $lBereaved  = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_ps_bBereaved');
      $lOther     = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_ps_bOther');
   }

   function countInterventions($sqlWhereExtra, &$interventions){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $interventions = new stdClass;
      
      $interventions->lCompanionship      = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_in_bCompanionship');
      $interventions->lCaregiverRelief    = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_in_bCaregiverRelief');
      $interventions->lEmotionalSupport   = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_in_bEmotionalSupport');
      $interventions->lSocialization      = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_in_bSocialization');
      $interventions->lBereavement        = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_in_bBereavement');
      $interventions->lTelephoneCall      = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_in_bTelephoneCall');
      $interventions->lExcursionErrands   = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_in_bExcursionErrands');
      $interventions->lMusicPetArt        = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_in_bMusicPetArt');
      $interventions->lFoodPrep           = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_in_bFoodPrep');
      $interventions->lHouseholdChores    = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_in_bHouseholdChores');
      $interventions->lOther              = $this->lPVCheckBoxCnt($sqlWhereExtra, 'pv_in_bOther');
   }

   function lPVCheckBoxCnt($sqlWhereExtra, $strFNCheckBox){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM patient_visit
         WHERE NOT pv_bRetired
            AND $strFNCheckBox $sqlWhereExtra;";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRecs);
   }

   function hrsVolNonPatientByMonth($lChapterID, $lMonth, $lYear, &$sngHrsMins){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere =
          " AND YEAR(vsa_dteActivityDate)=$lYear AND MONTH(vsa_dteActivityDate)=$lMonth ";
      if (!is_null($lChapterID)) $sqlWhere .= " AND vsa_lChapterID = $lChapterID ";
      $this->hrsVolNonPatient($sqlWhere, $sngHrsMins);
   }

   function hrsVolNonPatient($sqlWhereExtra, &$sngHrsMins){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT SUM(vsa_dHoursWorked) AS dNumHrs
         FROM vol_events_dates_shifts_assign
         WHERE vsa_lEventDateShiftID IS NULL
           $sqlWhereExtra
            AND NOT vsa_bRetired;";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      $sngHrsMins = (float)$row->dNumHrs;
   }

   function hrsVolTraining($sqlWhereExtra, &$sngHrsMins, &$lNumSessions){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT SUM(vt_lDuration) AS dNumHrs, COUNT(*) AS lNumSessions
         FROM vol_training
         WHERE NOT vt_bRetired
           $sqlWhereExtra;";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      $sngHrsMins   = (float)$row->dNumHrs/60.0;
      $lNumSessions = (int)$row->lNumSessions;
   }

   function volCountByMonth($lChapterID, $lMonth, $lYear, &$lNumVolsPV, &$lNumVolsNonPV, &$lNumUniqueVolID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $volIDs = array();
         // non-patient visit volunteer count
      $sqlWhere =
          " AND YEAR(vsa_dteActivityDate)=$lYear AND MONTH(vsa_dteActivityDate)=$lMonth ";
      if (!is_null($lChapterID)) $sqlWhere .= " AND vsa_lChapterID = $lChapterID ";
      $lNumVolsNonPV = $this->lVolCountNonPV($sqlWhere, $volIDs);

         // patient visit volunteer count
      $sqlWhere =
          " AND YEAR(pv_dteVisit)=$lYear AND MONTH(pv_dteVisit)=$lMonth ";
      if (!is_null($lChapterID)) $sqlWhere .= " AND pv_lChapterID = $lChapterID ";
      $lNumVolsPV = $this->lVolCountPV($sqlWhere, $volIDs);

      $lNumUniqueVolID = count($volIDs);
   }

   function lVolCountPV($sqlWhereExtra, &$volIDs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT DISTINCT pv_lVolID AS lVolID
         FROM patient_visit
         WHERE NOT pv_bRetired
            $sqlWhereExtra ;";

      $query = $this->db->query($sqlStr);
      $lNumRows = $query->num_rows();
      if ($lNumRows > 0) {
         foreach ($query->result() as $row) {
            $volIDs[(int)$row->lVolID] = true;
         }
      }
      return($lNumRows);
   }

   function lVolCountNonPV($sqlWhereExtra, &$volIDs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT DISTINCT vsa_lVolID AS lVolID
         FROM vol_events_dates_shifts_assign
         WHERE vsa_lEventDateShiftID IS NULL
           $sqlWhereExtra
            AND NOT vsa_bRetired;";
      $query = $this->db->query($sqlStr);
      $lNumRows = $query->num_rows();
      if ($lNumRows > 0) {
         foreach ($query->result() as $row) {
            $volIDs[(int)$row->lVolID] = true;
         }
      }
      return($lNumRows);
   }



      //----------------------------
      // details
      //----------------------------
   function hrsPatientVisitsDetailsViaMonth($lChapterID, $lMonth, $lYear, &$lNumPVRecs, &$pvInfo){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere =
          " AND YEAR(pv_dteVisit)=$lYear AND MONTH(pv_dteVisit)=$lMonth ";
      if (!is_null($lChapterID)) $sqlWhere .= " AND pv_lChapterID = $lChapterID ";
      $this->hrsPatientVisitsDetails($sqlWhere, '', $lNumPVRecs, $pvInfo);
   }

   function hrsPatientVisitsDetails($sqlWhereExtra, $strSort, &$lNumPVRecs, &$pvInfo){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gstrPassPhrase;

      $pvInfo = array();

      $sqlStr =
        'SELECT UNIX_TIMESTAMP(pv_dteVisit) AS dteDOV,
            pv_lKeyID AS pvRecID, vol_lKeyID,
            pv_lDuration,
            ddlLocation.lgen_strListItem AS strLocation,
            ddlActivity.lgen_strListItem AS strActivity,
            vol_lKeyID, vol_strFName, vol_strLName, vol_strAddr1, vol_strAddr2, vol_strCity,
            vol_strState, vol_strCountry, vol_strZip, vol_strPhone, vol_strCell, vol_strEmail,

            cr_lKeyID,
            AES_DECRYPT(cr_dteBirth,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS dtePatientBirth,
            AES_DECRYPT(cr_dteDeath,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS dtePatientDeath,
            AES_DECRYPT(cr_strTitle,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientTitle,
            AES_DECRYPT(cr_strFName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientFName,
            AES_DECRYPT(cr_strMName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientMName,
            AES_DECRYPT(cr_strLName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientLName,
            AES_DECRYPT(cr_strAddr1,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientAddr1,
            AES_DECRYPT(cr_strAddr2,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientAddr2,
            AES_DECRYPT(cr_strCity,      SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientCity,
            AES_DECRYPT(cr_strState,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientState,
            AES_DECRYPT(cr_strCountry,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientCountry,
            AES_DECRYPT(cr_strZip,       SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientZip,
            AES_DECRYPT(cr_strPhone,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientPhone,
            AES_DECRYPT(cr_strCell,      SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientCell,
            AES_DECRYPT(cr_strEmail,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientEmail
         FROM patient_visit
            INNER JOIN patient_records  ON pv_lPatientID = cr_lKeyID
            INNER JOIN volunteers      ON pv_lVolID     = vol_lKeyID
            INNER JOIN lists_generic AS ddlLocation ON pv_loc_lLocationID = ddlLocation.lgen_lKeyID
            INNER JOIN lists_generic AS ddlActivity ON pv_act_lActivityID = ddlActivity.lgen_lKeyID
         WHERE NOT pv_bRetired '.$sqlWhereExtra.'
         ORDER BY vol_strLName, vol_strFName, pv_dteVisit;';

      $query = $this->db->query($sqlStr);
      $lNumPVRecs = $query->num_rows();
      if ($lNumPVRecs > 0){
         $idx = 0;
         foreach ($query->result() as $row) {
            $pvInfo[$idx] = new stdClass;
            $pvRec = &$pvInfo[$idx];

            $pvRec->dteDOV            = $row->dteDOV;
            $pvRec->pvRecID           = (int)$row->pvRecID;
            $pvRec->lDuration         = (int)$row->pv_lDuration;
            $pvRec->strLocation       = $row->strLocation;
            $pvRec->strActivity       = $row->strActivity;

            $this->loadPeopleInfo($pvRec, $row);
            $this->loadPatientInfo($pvRec, $row);
            ++$idx;
         }
      }
   }

   function hrsNonPatientVisitsDetailsViaMonth($lChapterID, $lMonth, $lYear, &$lNumPVRecs, &$pvInfo){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere =
          " AND YEAR(vsa_dteActivityDate)=$lYear AND MONTH(vsa_dteActivityDate)=$lMonth ";
      if (!is_null($lChapterID)) $sqlWhere .= " AND vsa_lChapterID = $lChapterID ";
      $this->hrsNonPatientVisitsDetails($sqlWhere, '', $lNumPVRecs, $pvInfo);
   }

   function hrsNonPatientVisitsDetails($sqlWhereExtra, $strSort, &$lNumNonPVRecs, &$nonPVInfo){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $nonPVInfo = array();

      $sqlStr =
        'SELECT
             vsa_lKeyID, vsa_lVolID, vsa_strNotes, vsa_dHoursWorked,
             vsa_dteActivityDate,
             vsa_lActivityID, vsa_lJobCode,
             vol_lKeyID,
             vol_lKeyID, vol_strFName, vol_strLName, vol_strAddr1, vol_strAddr2,
             vol_strCity, vol_strState, vol_strCountry, vol_strZip, vol_strPhone, vol_strCell, vol_strEmail,
             tblActivity.lgen_strListItem AS strActivity,
             tblJobCodes.lgen_strListItem AS strJobCode
         FROM vol_events_dates_shifts_assign
            INNER JOIN volunteers                   ON vol_lKeyID      = vsa_lVolID
            INNER JOIN lists_generic AS tblActivity ON vsa_lActivityID = tblActivity.lgen_lKeyID
            LEFT  JOIN lists_generic AS tblJobCodes ON vsa_lJobCode    = tblJobCodes.lgen_lKeyID
         WHERE vsa_lEventDateShiftID IS NULL
            '.$sqlWhereExtra.'
            AND NOT vsa_bRetired
         ORDER BY vsa_dteActivityDate, vol_strLName, vol_strFName, vsa_lKeyID;';

      $query = $this->db->query($sqlStr);
      $lNumNonPVRecs = $query->num_rows();
      if ($lNumNonPVRecs > 0){
         $idx = 0;
         foreach ($query->result() as $row) {
            $nonPVInfo[$idx] = new stdClass;
            $nonPVRec = &$nonPVInfo[$idx];

            $nonPVRec->dteActivity       = $row->vsa_dteActivityDate;
            $nonPVRec->nonPVRecID        = (int)$row->vsa_lKeyID;
            $nonPVRec->dHoursWorked      = (float)$row->vsa_dHoursWorked;
            $nonPVRec->strJobCode        = $row->strJobCode;
            $nonPVRec->strActivity       = $row->strActivity;
            $nonPVRec->strNotes          = $row->vsa_strNotes;

            $this->loadPeopleInfo($nonPVRec, $row);
            $nonPVRec->lVolID            = (int)$row->vol_lKeyID;
            $nonPVRec->strVolSafeNameLF  = '<b>'.htmlspecialchars($row->vol_strLName).'</b>, '.htmlspecialchars($row->vol_strFName);
            ++$idx;
         }
      }
   }

   function volActivityCountByYear($lChapterID, $lYear, $bPatientVisit, &$calYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($bPatientVisit){
         $sqlStr =
            'SELECT COUNT(*) AS lCount, MONTH(pv_dteVisit) AS lMonth, DAYOFMONTH(pv_dteVisit) AS lDOM
             FROM patient_visit
             WHERE NOT pv_bRetired
                AND pv_lChapterID='.$lChapterID.'
                AND YEAR(pv_dteVisit) = '.$lYear.'
             GROUP BY MONTH(pv_dteVisit), DAYOFMONTH(pv_dteVisit)
             ORDER BY MONTH(pv_dteVisit)
                ;';
      }else {
         $sqlStr =
            'SELECT
                COUNT(*) AS lCount, MONTH(vsa_dteActivityDate) AS lMonth, DAYOFMONTH(vsa_dteActivityDate) AS lDOM
             FROM vol_events_dates_shifts_assign
             WHERE vsa_lEventDateShiftID IS NULL
                AND YEAR(vsa_dteActivityDate) = '.$lYear.'
                AND vsa_lChapterID = '.$lChapterID.'
                AND NOT vsa_bRetired
             GROUP BY MONTH(vsa_dteActivityDate), DAYOFMONTH(vsa_dteActivityDate)
             ORDER BY MONTH(vsa_dteActivityDate)
                   ;';
      }
      $query = $this->db->query($sqlStr);
      $lNumRecs = $query->num_rows();
      if ($lNumRecs > 0){
         foreach ($query->result() as $row) {
            $calYear[$row->lMonth]->dayCount[$row->lDOM] = (int)$row->lCount;
         }
      }
   }

   function strHTMLCalendar($lYear, $bPatientVisit, $strTitle, &$calYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lMoPerRow = 3;
      $strOut =
         '<table style="" border="0">
            <tr>
               <td colspan="'.$lMoPerRow.'" style="text-align:center; font-size: 16pt;">'
                  .$strTitle.'
               </td>
            </tr>';
      $colIDX = 1;
      for ($lMonth=1; $lMonth<=12; ++$lMonth){
         $calMonth = &$calYear[$lMonth];
         $lNumVol = $this->lCountInMonth($calMonth);
         if ($lNumVol > 0){
            if ($bPatientVisit){
               $strLink = '&nbsp;'.strLinkView_VMgrRptVolHrsPVViaMonth($lMonth, $lYear, 'View', true);
            }else {
               $strLink = '&nbsp;'.strLinkView_VMgrRptVolHrsNonPVViaMonth($lMonth, $lYear, 'View', true);
            }
         }else {
            $strLink = '';
         }
         if (($lMonth % $lMoPerRow) == 1){
            $strOut .= '<tr>'."\n";
         }
         $strOut .=
               '<td style="padding: 10px; vertical-align: top;">
                  <table class="enpRpt" style="margin-bottom: 25pt;">
                     <tr>
                        <td colspan="7" style="text-align: center; background-color: #9aa; font-size: 15pt;"><b>'
                           .$calMonth->strMonth.' '.$lYear.$strLink.'
                        </td>
                     </tr>';
         $lDayWidth = '34px';
         $strOut .=
           '<tr>
              <td class="calendarLabel">Sun</td>
              <td class="calendarLabel">Mon</td>
              <td class="calendarLabel">Tue</td>
              <td class="calendarLabel">Wed</td>
              <td class="calendarLabel">Thu</td>
              <td class="calendarLabel">Fri</td>
              <td class="calendarLabel">Sat</td>
            </tr>';

            // blanks for the empty days on first row
         $lDOWIDX = 1;
         if ($calMonth->lFirstDayOfMonth > 0){
            for ($blkIdx = 0; $blkIdx < $calMonth->lFirstDayOfMonth; ++$blkIdx){
               $strOut .= '<td style="background-color: #e3e8ef;">&nbsp;</td>'."\n";
               ++$lDOWIDX;
            }
         }

            // the monthly days
         for ($dIdx = 1; $dIdx <= $calMonth->daysInMonth; ++$dIdx){
            $lNumActivity = $calMonth->dayCount[$dIdx];
            if ($lNumActivity > 0){
               $strAct = '<br><span style="font-size: 11pt; color: red;"><b>('.$lNumActivity.')</span>';
            }else {
               $strAct = '';
            }
            $strOut .= '<td class="calendarDay">'.$dIdx.$strAct.'</td>'."\n";
            if ($lDOWIDX == 7){
               $strOut .= '</tr>'."\n";
               if ($dIdx != $calMonth->daysInMonth) $strOut .= '<tr>'."\n";
               $lDOWIDX = 0;
            }
            ++$lDOWIDX;
         }

            // blanks for the empty days at the end
         if ($lDOWIDX != 1){
            for ($blkIdx = $lDOWIDX; $blkIdx <= 7; ++$blkIdx){
               $strOut .= '<td style="background-color: #e3e8ef;">&nbsp;</td>'."\n";
            }
         }

         $strOut .= "</table>\n</td>\n";
         ++$colIDX;

         if (($lMonth % $lMoPerRow) == 0) $strOut .= '</tr>'."\n";
      }
      $strOut .= '</table>'."\n";
      return($strOut);
   }

   function lCountInMonth(&$calMonth){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lCnt = 0;
      foreach ($calMonth->dayCount as $lDay){
         $lCnt += $lDay;
      }
      return($lCnt);
   }

   function strSQLCommonPatientVisitDetails($sqlWhereExtra, $strSort){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gstrPassPhrase;

      $sqlStr =
        'SELECT UNIX_TIMESTAMP(pv_dteVisit) AS dteDOV,
            pv_lKeyID AS pvRecID, vol_lKeyID,
            pv_lDuration,
            ddlLocation.lgen_strListItem AS strLocation,
            ddlActivity.lgen_strListItem AS strActivity,
            vol_lKeyID, vol_strFName, vol_strLName, vol_strAddr1, vol_strAddr2, vol_strCity,
            vol_strState, vol_strCountry, vol_strZip, vol_strPhone, vol_strCell, vol_strEmail,

            cr_lKeyID,
            AES_DECRYPT(cr_dteBirth,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS dtePatientBirth,
            AES_DECRYPT(cr_dteDeath,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS dtePatientDeath,
            AES_DECRYPT(cr_strTitle,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientTitle,
            AES_DECRYPT(cr_strFName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientFName,
            AES_DECRYPT(cr_strMName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientMName,
            AES_DECRYPT(cr_strLName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientLName,
            AES_DECRYPT(cr_strAddr1,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientAddr1,
            AES_DECRYPT(cr_strAddr2,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientAddr2,
            AES_DECRYPT(cr_strCity,      SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientCity,
            AES_DECRYPT(cr_strState,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientState,
            AES_DECRYPT(cr_strCountry,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientCountry,
            AES_DECRYPT(cr_strZip,       SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientZip,
            AES_DECRYPT(cr_strPhone,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientPhone,
            AES_DECRYPT(cr_strCell,      SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientCell,
            AES_DECRYPT(cr_strEmail,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientEmail
         FROM patient_visit
            INNER JOIN patient_records ON pv_lPatientID = cr_lKeyID
            INNER JOIN volunteers     ON pv_lVolID     = vol_lKeyID
            INNER JOIN lists_generic AS ddlLocation ON pv_loc_lLocationID = ddlLocation.lgen_lKeyID
            INNER JOIN lists_generic AS ddlActivity ON pv_act_lActivityID = ddlActivity.lgen_lKeyID
         WHERE NOT pv_bRetired '."$sqlWhereExtra
         ORDER BY $strSort;";
      return($sqlStr);
   }

   function patientVisitsViaVolDetailsViaMonth($lMonth, $lYear, &$lNumVolRecs, &$volRecs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere =
          " AND YEAR(pv_dteVisit)=$lYear AND MONTH(pv_dteVisit)=$lMonth ";
      $this->patientVisitsViaVolDetails($sqlWhere, '', $lNumVolRecs, $volRecs);
   }

   function patientVisitsViaVolDetails($sqlWhereExtra, $strSort, &$lNumVolRecs, &$volRecs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $volRecs = array();
      $lNumVolRecs = 0;

      $strFNDOV = 'pv_dteVisit';
      $strSort  = " vol_strLName, vol_strFName, vol_lKeyID, $strFNDOV ";

      $sqlStr = $this->strSQLCommonPatientVisitDetails($sqlWhereExtra, $strSort);

      $query = $this->db->query($sqlStr);
      $numRecs = $query->num_rows();
      if ($numRecs > 0){
         foreach ($query->result() as $row) {
            $lVID = (int)$row->vol_lKeyID;
            if (!isset($volRecs[$lVID])){
               $volRecs[$lVID] = new stdClass;
               $this->loadPeopleInfo($volRecs[$lVID], $row);
               $volRecs[$lVID]->pVisits = array();
               ++$lNumVolRecs;
               $idx = 0;
            }
            $volRecs[$lVID]->pVisits[$idx] = new stdClass;
            $vRec = &$volRecs[$lVID]->pVisits[$idx];

            $vRec->dteDOV            = $row->dteDOV;
            $vRec->pvRecID           = (int)$row->pvRecID;
            $vRec->lDuration         = (int)$row->pv_lDuration;
            $vRec->strDuration       = pvisit\strMinutesToHoursMin($vRec->lDuration);
            $vRec->strLocation       = $row->strLocation;
            $vRec->strActivity       = $row->strActivity;
            $this->loadPatientInfo($vRec, $row);

            ++$idx;
         }
      }
   }

   function nonPVisitsViaVolDetailsViaMonth($lChapterID, $lMonth, $lYear, &$lNumVolRecs, &$volRecs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere =
          " AND YEAR(vsa_dteActivityDate)=$lYear AND MONTH(vsa_dteActivityDate)=$lMonth ";
      if (!is_null($lChapterID)) $sqlWhere .= " AND vsa_lChapterID = $lChapterID ";
      $this->nonPVisitsViaVolDetails($sqlWhere, '', $lNumVolRecs, $volRecs);
   }

   function nonPVisitsViaVolDetails($sqlWhereExtra, $strSort, &$lNumVolRecs, &$volRecs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $volRecs = array();
      $lNumVolRecs = 0;

      $sqlStr =
        'SELECT
             vsa_lKeyID, vsa_lVolID, vsa_strNotes, vsa_dHoursWorked,
             vsa_dteActivityDate,
             vsa_lActivityID, vsa_lJobCode,
             vol_lKeyID,
             vol_lKeyID, vol_strFName, vol_strLName, vol_strAddr1, vol_strAddr2,
             vol_strCity, vol_strState, vol_strCountry, vol_strZip, vol_strPhone, vol_strCell, vol_strEmail,
             tblActivity.lgen_strListItem AS strActivity,
             tblJobCodes.lgen_strListItem AS strJobCode
         FROM vol_events_dates_shifts_assign
            INNER JOIN volunteers                   ON vol_lKeyID      = vsa_lVolID
            INNER JOIN lists_generic AS tblActivity ON vsa_lActivityID = tblActivity.lgen_lKeyID
            LEFT  JOIN lists_generic AS tblJobCodes ON vsa_lJobCode    = tblJobCodes.lgen_lKeyID
         WHERE vsa_lEventDateShiftID IS NULL
            '.$sqlWhereExtra.'
            AND NOT vsa_bRetired
         ORDER BY vol_strLName, vol_strFName, vol_lKeyID, vsa_lKeyID, vsa_dteActivityDate;';

      $query = $this->db->query($sqlStr);
      $lNumVolRecs = $query->num_rows();
      if ($lNumVolRecs > 0){
         foreach ($query->result() as $row) {
            $lVID = (int)$row->vol_lKeyID;
            if (!isset($volRecs[$lVID])){
               $volRecs[$lVID] = new stdClass;
               $this->loadPeopleInfo($volRecs[$lVID], $row);
               $volRecs[$lVID]->pVisits = array();
               ++$lNumVolRecs;
               $idx = 0;
            }
            $volRecs[$lVID]->activities[$idx] = new stdClass;
            $aRec = &$volRecs[$lVID]->activities[$idx];

            $aRec->dteActivity       = $row->vsa_dteActivityDate;
            $aRec->nonPVRecID        = (int)$row->vsa_lKeyID;
            $aRec->dHoursWorked      = (float)$row->vsa_dHoursWorked;
            $aRec->strJobCode        = $row->strJobCode;
            $aRec->strActivity       = $row->strActivity;
            $aRec->strNotes          = $row->vsa_strNotes;
            ++$idx;
         }
      }
   }

   function patientVisitsViaPatientViaMonth($lChapterID, $lMonth, $lYear, &$lNumPatientRecs, &$patientRecs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere =
          " AND YEAR(pv_dteVisit)=$lYear AND MONTH(pv_dteVisit)=$lMonth ";
      if (!is_null($lChapterID)) $sqlWhere .= " AND pv_lChapterID = $lChapterID ";
      $this->patientVisitsViaPatient($sqlWhere, '', $lNumPatientRecs, $patientRecs);
   }

   function patientVisitsViaPatient($sqlWhereExtra, $strSort, &$lNumPatientRecs, &$patientRecs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $patientRecs = array();
      $lNumPatientRecs = 0;

      $strSort  = " cr_strLName, cr_strFName, cr_lKeyID, pv_dteVisit ";

      $sqlStr = $this->strSQLCommonPatientVisitDetails($sqlWhereExtra, $strSort);
      $query = $this->db->query($sqlStr);
      $numRecs = $query->num_rows();
      if ($numRecs > 0){
         foreach ($query->result() as $row) {
            $lCID = (int)$row->cr_lKeyID;
            if (!isset($patientRecs[$lCID])){
               $patientRecs[$lCID] = new stdClass;
               $this->loadPatientInfo($patientRecs[$lCID], $row);
               $patientRecs[$lCID]->pVisits = array();
               ++$lNumPatientRecs;
               $idx = 0;
            }
            $patientRecs[$lCID]->pVisits[$idx] = new stdClass;
            $pRec = &$patientRecs[$lCID]->pVisits[$idx];

            $pRec->dteDOV            = $row->dteDOV;
            $pRec->pvRecID           = (int)$row->pvRecID;
            $pRec->lDuration         = (int)$row->pv_lDuration;
            $pRec->strLocation       = $row->strLocation;
            $pRec->strActivity       = $row->strActivity;
            $this->loadPeopleInfo($pRec, $row);

            ++$idx;
         }
      }
   }

   function volJobCodesByJobCode($sqlWhereExtra, &$lNumJC, &$jobCodes){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lNumJC = 0;
      $jobCodes = array();

      $sqlStr =
        "SELECT vsa_lJobCode, lgen_strListItem,
         SUM(vsa_dHoursWorked) AS dHours, COUNT(*) AS lNumRecs

         FROM vol_events_dates_shifts_assign
            INNER JOIN lists_generic ON vsa_lJobCode=lgen_lKeyID

         WHERE NOT vsa_bRetired $sqlWhereExtra
         GROUP BY vsa_lJobCode
         ORDER BY lgen_strListItem;";

      $query = $this->db->query($sqlStr);
      $lNumJC = $query->num_rows();
      if ($lNumJC > 0){
         $idx = 0;
         foreach ($query->result() as $row) {
            $jobCodes[$idx] = new stdClass;
            $act = &$jobCodes[$idx];

            $act->lJobCodeID = (int)$row->vsa_lJobCode;
            $act->strActivity = $row->lgen_strListItem;
            $act->dHours      = (float)$row->dHours;
            $act->lNumActs    = (int)$row->lNumRecs;

            ++$idx;
         }
      }      
   }
   
   function volActivityByActivity($sqlWhereExtra, &$lNumAct, &$activities){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lNumAct = 0;
      $activities = array();

      $sqlStr =
        "SELECT vsa_lActivityID, lgen_strListItem,
         SUM(vsa_dHoursWorked) AS dHours, COUNT(*) AS lNumRecs

         FROM vol_events_dates_shifts_assign
            INNER JOIN lists_generic ON vsa_lActivityID=lgen_lKeyID

         WHERE NOT vsa_bRetired $sqlWhereExtra
         GROUP BY vsa_lActivityID
         ORDER BY lgen_strListItem;";

      $query = $this->db->query($sqlStr);
      $lNumAct = $query->num_rows();
      if ($lNumAct > 0){
         $idx = 0;
         foreach ($query->result() as $row) {
            $activities[$idx] = new stdClass;
            $act = &$activities[$idx];

            $act->lActivityID = (int)$row->vsa_lActivityID;
            $act->strActivity = $row->lgen_strListItem;
            $act->dHours      = (float)$row->dHours;
            $act->lNumActs    = (int)$row->lNumRecs;

            ++$idx;
         }
      }
   }

   function pVisitActivityByActivity($sqlWhereExtra, &$lNumAct, &$activities){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lNumAct = 0;
      $activities = array();

      $sqlStr =
        "SELECT pv_act_lActivityID, lgen_strListItem, COUNT(*) AS lNumRecs

         FROM patient_visit
            INNER JOIN lists_generic ON pv_act_lActivityID=lgen_lKeyID

         WHERE NOT pv_bRetired $sqlWhereExtra
         GROUP BY pv_act_lActivityID
         ORDER BY lgen_strListItem;";

      $query = $this->db->query($sqlStr);
      $lNumAct = $query->num_rows();
      if ($lNumAct > 0){
         $idx = 0;
         foreach ($query->result() as $row) {
            $activities[$idx] = new stdClass;
            $act = &$activities[$idx];

            $act->lActivityID = (int)$row->pv_act_lActivityID;
            $act->strActivity = $row->lgen_strListItem;
            $act->lNumActs    = (int)$row->lNumRecs;
            ++$idx;
         }
      }
   }

      //--------------------------------------
      //           db stats
      //--------------------------------------
   function numPatientRecs($sqlWhereExtra, &$lNumPRecsActive, &$lNumPRecsInactive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lNumPRecsActive   = $this->lPRecCnt($sqlWhereExtra, true);
      $lNumPRecsInactive = $this->lPRecCnt($sqlWhereExtra, false);
   }

   function lPRecCnt($sqlWhereExtra, $bActive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM patient_records
         WHERE NOT cr_bRetired
            $sqlWhereExtra
            AND ".($bActive ? '' : 'NOT').' cr_bActive;';
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRecs);
   }

   function lNumPatientContactRecs($sqlWhereExtra){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM patient_contacts
            INNER JOIN patient_records ON cc_lPatientID=cr_lKeyID
         WHERE NOT cc_bRetired
            $sqlWhereExtra";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRecs);
   }

}

