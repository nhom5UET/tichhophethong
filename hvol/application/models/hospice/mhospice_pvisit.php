<?php
/*---------------------------------------------------------------------
// Hospice Volunteer Solutions!
//
// copyright (c) 2015 by Database Austin
// Austin, Texas
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//
---------------------------------------------------------------------
      $this->load->model('hospice/mhospice_pvisit', 'cPVisit');
---------------------------------------------------------------------*/


//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class mhospice_pvisit extends CI_Model{
   public
       $lVolID, $lPatientID;


   public function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
      $this->lVolID = $this->lPatientID = null;
   }

   function loadPVisitsViaVolID($lVolID, &$lNumRecs, &$pVisits){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere = " AND pv_lVolID = $lVolID ";
      $this->loadPVisits($sqlWhere, '', '', $lNumRecs, $pVisits);
   }

   function loadPVisitsViaPatientID($lPatientID, &$lNumRecs, &$pVisits){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere = " AND pv_lPatientID = $lPatientID ";
      $this->loadPVisits($sqlWhere, '', '', $lNumRecs, $pVisits);
   }

   function loadPVisitsViaVisitID($lVisitID, &$lNumRecs, &$pVisits){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere = " AND pv_lKeyID = $lVisitID ";
      $this->loadPVisits($sqlWhere, '', '', $lNumRecs, $pVisits);
   }

   function loadPVisits($sqlWhereExtra, $strOrder, $strLimit, &$lNumRecs, &$pVisits){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gstrPassPhrase;

      if ($strOrder == ''){
         $strOrder = '
              AES_DECRYPT(cr_strLName, SHA2('.strPrepStr($gstrPassPhrase).',256)),
              AES_DECRYPT(cr_strFName, SHA2('.strPrepStr($gstrPassPhrase).',256)),
              AES_DECRYPT(cr_strMName, SHA2('.strPrepStr($gstrPassPhrase).',256)),
              cr_lKeyID ';
      }

      $sqlStr =
        'SELECT
            pv_lKeyID, pv_lChapterID, pv_lPatientID, pv_lVolID,
            pv_dteVisit, pv_lStartTime, pv_lDuration, pv_strMedRec,
            pv_ps_bPatient, pv_ps_bCaregiver, pv_ps_bBereaved, pv_ps_bOther, pv_ps_strNotes,
            pv_act_lActivityID, pv_act_strNotes,
            pv_loc_lLocationID, pv_loc_strNotes,
            pv_in_bCompanionship, pv_in_bCaregiverRelief, pv_in_bEmotionalSupport,
            pv_in_bSocialization, pv_in_bBereavement, pv_in_bTelephoneCall,
            pv_in_bExcursionErrands, pv_in_bMusicPetArt, pv_in_bFoodPrep,
            pv_in_bHouseholdChores, pv_in_bOther, pv_in_strNotes,
            pv_tsk_strOtherNotes, pv_tsk_bVisitors, pv_tsk_strPatientComfort,
            pv_tsk_strPatientPain, pv_tsk_strChangesConcerns,
            pv_bRetired, pv_lOriginID, pv_lLastUpdateID, pv_dteOrigin, pv_dteLastUpdate,

            vol_strFName, vol_strLName, vol_strAddr1, vol_strAddr2,
            vol_strCity, vol_strState, vol_strCountry, vol_strZip,
            vol_strPhone, vol_strCell, vol_strEmail, vol_lKeyID,

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
            AES_DECRYPT(cr_strEmail,     SHA2('.strPrepStr($gstrPassPhrase).",256)) AS strPatientEmail,
            cr_lKeyID,

            ch_strChapterName,

            listLoc.lgen_strListItem AS strLocation,
            listAct.lgen_strListItem AS strActivity,

            uc.us_strFirstName AS strUCFName, uc.us_strLastName AS strUCLName,
            ul.us_strFirstName AS strULFName, ul.us_strLastName AS strULLName

         FROM patient_visit
            INNER JOIN patient_records ON pv_lPatientID = cr_lKeyID
            INNER JOIN volunteers     ON pv_lVolID     = vol_lKeyID
--            INNER JOIN people_names   ON vol_lKeyID     = vol_lPeopleID
            INNER JOIN admin_chapters ON pv_lChapterID = ch_lKeyID

            INNER JOIN lists_generic AS listLoc ON listLoc.lgen_lKeyID = pv_loc_lLocationID
            INNER JOIN lists_generic AS listAct ON listAct.lgen_lKeyID = pv_act_lActivityID

            INNER JOIN admin_users  AS uc ON uc.us_lKeyID=pv_lOriginID
            INNER JOIN admin_users  AS ul ON ul.us_lKeyID=pv_lLastUpdateID
         WHERE NOT pv_bRetired $sqlWhereExtra
         ORDER BY $strOrder
         $strLimit;";

      $query = $this->db->query($sqlStr);
      $lNumRecs = $query->num_rows();
      $pVisits = array();
      if ($lNumRecs==0) {
         $pVisits[0] = new stdClass;
         $pVisit = &$pVisits[0];
         $pVisit->lKeyID                        = null;

      }else {
         $idx = 0;
         $cLists = new mlist_generic;
         foreach ($query->result() as $row){
            $pVisits[$idx] = new stdClass;
            $pVisit = &$pVisits[$idx];

            $this->loadVisitInfo  ($cLists, $pVisit, $row);
            $this->loadPeopleInfo ($pVisit, $row);
            $this->loadPatientInfo($pVisit, $row);

            ++$idx;
         }
      }
   }

   function strHTMLSummaryPatientVol($lPatientID, $lVolID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $cVol = new mvol;
      $cPatient = new mclients;

      $cVol->loadVolRecsViaVolID($lVolID, true);
      $cPatient->loadClientsViaClientID($lPatientID);

      $strOut = '';

      $patient = &$cPatient->clients[0];
      $vRec    = &$cVol->volRecs[0];

      $strOut =
        '<table border="0" class="entrySummary">
            <tr >
               <td class="entrySummaryLabel"  style="font-size: 10pt;">Patient Name:</td>
               <td class="entrySummary" style="font-size: 10pt;">'
                  .$patient->strSafeName.'&nbsp;<span style="font-size: 8pt;">(patientID: '.str_pad($lPatientID, 5, '0', STR_PAD_LEFT).')</span>
               </td>
            <tr >
               <td class="entrySummaryLabel"  style="font-size: 10pt;">Volunteeer:</td>
               <td class="entrySummary" style="font-size: 10pt;">'
                  .$vRec->strSafeNameFL.'&nbsp;<span style="font-size: 8pt;">(volID: '.str_pad($lVolID, 5, '0', STR_PAD_LEFT).')</span>
               </td>
            </tr>
         </table><br>';

      return($strOut);
   }

   function loadVisitInfo(&$cList, &$pRec, &$row){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $pRec->lKeyID                 = $lRecID = (int)$row->pv_lKeyID;
      $pRec->lChapterID             = (int)$row->pv_lChapterID;
      $pRec->lPatientID             = (int)$row->pv_lPatientID;
      $pRec->lVolID                 = (int)$row->pv_lVolID;
      $pRec->strChapterName         = $row->ch_strChapterName;
      $pRec->dteVisit               = strtotime($row->pv_dteVisit);
      $pRec->mdteVisit              = $row->pv_dteVisit;
      $pRec->lStartTime             = (int)$row->pv_lStartTime;
      $pRec->lDuration              = (int)$row->pv_lDuration;
      $pRec->strMedRec              = $row->pv_strMedRec;
      $pRec->ps_bPatient            = (bool)$row->pv_ps_bPatient;
      $pRec->ps_bCaregiver          = (bool)$row->pv_ps_bCaregiver;
      $pRec->ps_bBereaved           = (bool)$row->pv_ps_bBereaved;
      $pRec->ps_bOther              = (bool)$row->pv_ps_bOther;
      $pRec->ps_strNotes            = $row->pv_ps_strNotes;
      $pRec->act_lActivityID        = (int)$row->pv_act_lActivityID;
      $pRec->strActivity            = $row->strActivity;
      $pRec->act_strNotes           = $row->pv_act_strNotes;
      $pRec->loc_lLocationID        = (int)$row->pv_loc_lLocationID;
      $pRec->strLocation            = $row->strLocation;
      $pRec->loc_strNotes           = $row->pv_loc_strNotes;
      $pRec->in_bCompanionship      = (bool)$row->pv_in_bCompanionship;
      $pRec->in_bCaregiverRelief    = (bool)$row->pv_in_bCaregiverRelief;
      $pRec->in_bEmotionalSupport   = (bool)$row->pv_in_bEmotionalSupport;
      $pRec->in_bSocialization      = (bool)$row->pv_in_bSocialization;
      $pRec->in_bBereavement        = (bool)$row->pv_in_bBereavement;
      $pRec->in_bTelephoneCall      = (bool)$row->pv_in_bTelephoneCall;
      $pRec->in_bExcursionErrands   = (bool)$row->pv_in_bExcursionErrands;
      $pRec->in_bMusicPetArt        = (bool)$row->pv_in_bMusicPetArt;
      $pRec->in_bFoodPrep           = (bool)$row->pv_in_bFoodPrep;
      $pRec->in_bHouseholdChores    = (bool)$row->pv_in_bHouseholdChores;
      $pRec->in_bOther              = (bool)$row->pv_in_bOther;
      $pRec->in_strNotes            = $row->pv_in_strNotes;
      $pRec->tsk_strOtherNotes      = $row->pv_tsk_strOtherNotes;
      $pRec->tsk_bVisitors          = (bool)$row->pv_tsk_bVisitors;
      $pRec->tsk_strPatientComfort  = $row->pv_tsk_strPatientComfort;
      $pRec->tsk_strPatientPain     = $row->pv_tsk_strPatientPain;
      $pRec->tsk_strChangesConcerns = $row->pv_tsk_strChangesConcerns;

      $pRec->ucstrFName             = $row->strUCFName;
      $pRec->ucstrLName             = $row->strUCLName;
      $pRec->ulstrFName             = $row->strULFName;
      $pRec->ulstrLName             = $row->strULLName;
      $pRec->bRetired               = (bool)$row->pv_bRetired;
      $pRec->lOriginID              = (int)$row->pv_lOriginID;
      $pRec->lLastUpdateID          = (int)$row->pv_lLastUpdateID;
      $pRec->dteOrigin              = strtotime($row->pv_dteOrigin);
      $pRec->dteLastUpdate          = strtotime($row->pv_dteLastUpdate);

         // multi-select DDLs
      $pRec->status = new stdClass;
      $cList->loadDDLM_SelectedItems(CENUM_LISTTYPE_PV_PSTATUS, $lRecID,
                   $pRec->status->lNumInList, $pRec->status->IDs, $pRec->status->listItems);

      $pRec->tasks = new stdClass;
      $cList->loadDDLM_SelectedItems(CENUM_LISTTYPE_PV_VISITTASKS, $lRecID,
                   $pRec->tasks->lNumInList, $pRec->tasks->IDs, $pRec->tasks->listItems);
   }

   function loadPatientInfo(&$pRec, $row){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $pRec->lCID              = (int)$row->cr_lKeyID;
      $pRec->strPatientFName   = $row->strPatientFName;
      $pRec->strPatientLName   = $row->strPatientLName;
      $pRec->strPatientAddr1   = $row->strPatientAddr1;
      $pRec->strPatientAddr2   = $row->strPatientAddr2;
      $pRec->strPatientCity    = $row->strPatientCity;
      $pRec->strPatientState   = $row->strPatientState;
      $pRec->strPatientCountry = $row->strPatientCountry;
      $pRec->strPatientZip     = $row->strPatientZip;
      $pRec->strPatientPhone   = $row->strPatientPhone;
      $pRec->strPatientCell    = $row->strPatientCell;
      $pRec->strPatientEmail   = $row->strPatientEmail;

      $pRec->strPatientAddress =
               strBuildAddress(
                        $pRec->strPatientAddr1, $pRec->strPatientAddr2,   $pRec->strPatientCity,
                        $pRec->strPatientState, $pRec->strPatientCountry, $pRec->strPatientZip,
                        true);
   }

   function loadPeopleInfo(&$pRec, $row){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $pRec->lPID          = (int)$row->vol_lKeyID;
      $pRec->lVID          = (int)$row->vol_lKeyID;
      $pRec->strVolFName   = $row->vol_strFName;
      $pRec->strVolLName   = $row->vol_strLName;
      $pRec->strVolAddr1   = $row->vol_strAddr1;
      $pRec->strVolAddr2   = $row->vol_strAddr2;
      $pRec->strVolCity    = $row->vol_strCity;
      $pRec->strVolState   = $row->vol_strState;
      $pRec->strVolCountry = $row->vol_strCountry;
      $pRec->strVolZip     = $row->vol_strZip;
      $pRec->strVolPhone   = $row->vol_strPhone;
      $pRec->strVolCell    = $row->vol_strCell;
      $pRec->strVolEmail   = $row->vol_strEmail;

      $pRec->strVolAddress =
               strBuildAddress(
                        $pRec->strVolAddr1, $pRec->strVolAddr2,   $pRec->strVolCity,
                        $pRec->strVolState, $pRec->strVolCountry, $pRec->strVolZip,
                        true);

   }

   function lAddNewPVisit(&$pVisit){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $gdteNow, $glUserID;

      $sqlCommon = $this->strCommonPVisitSQL($pVisit);
      $sqlStr =
          "INSERT INTO patient_visit
           SET $sqlCommon,
             pv_lChapterID   = $pVisit->lChapterID,
             pv_lOriginID    = $glUserID,
             pv_bRetired     = 0,
             pv_dteOrigin    = NOW();";

      $query = $this->db->query($sqlStr);
      $lPVRecID = $this->db->insert_id();   //mysql_insert_id();

         // add multi-ddl fields
      $cList = new mlist_generic;
      $cList->addMDDLSelections(CENUM_LISTTYPE_PV_PSTATUS,    $lPVRecID, $pVisit->status->IDs);
      $cList->addMDDLSelections(CENUM_LISTTYPE_PV_VISITTASKS, $lPVRecID, $pVisit->tasks->IDs);

      return($lPVRecID);
   }

   function updatePVisit($lPVRecID, &$pVisit){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $gdteNow, $glUserID;

      $sqlCommon = $this->strCommonPVisitSQL($pVisit);
      $sqlStr =
          "UPDATE patient_visit
           SET $sqlCommon
           WHERE pv_lKeyID=$lPVRecID;";

      $this->db->query($sqlStr);

         // add multi-ddl fields
      $cList = new mlist_generic;
      $cList->addMDDLSelections(CENUM_LISTTYPE_PV_PSTATUS,    $lPVRecID, $pVisit->status->IDs);
      $cList->addMDDLSelections(CENUM_LISTTYPE_PV_VISITTASKS, $lPVRecID, $pVisit->tasks->IDs);
   }

   private function strCommonPVisitSQL(&$pVisit){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gdteNow, $glUserID;

      $sqlOut =
        "pv_lPatientID                  = $pVisit->lPatientID,
         pv_lVolID                      = $pVisit->lVolID,
         pv_lStartTime                  = $pVisit->lStartTime,
         pv_lDuration                   = $pVisit->lDuration,
         pv_loc_lLocationID             = $pVisit->loc_lLocationID,
         pv_act_lActivityID             = $pVisit->act_lActivityID, \n";

      $sqlOut .=
        'pv_dteVisit                    = '.strPrepDate($pVisit->dteVisit).',

         pv_strMedRec                   = '.strPrepStr($pVisit->strMedRec).',
         pv_ps_strNotes                 = '.strPrepStr($pVisit->ps_strNotes).',
         pv_act_strNotes                = '.strPrepStr($pVisit->act_strNotes).',
         pv_loc_strNotes                = '.strPrepStr($pVisit->loc_strNotes).',
         pv_in_strNotes                 = '.strPrepStr($pVisit->in_strNotes).',
         pv_tsk_strOtherNotes           = '.strPrepStr($pVisit->tsk_strOtherNotes).',
         pv_tsk_strPatientComfort       = '.strPrepStr($pVisit->tsk_strPatientComfort).',
         pv_tsk_strPatientPain          = '.strPrepStr($pVisit->tsk_strPatientPain).',
         pv_tsk_strChangesConcerns      = '.strPrepStr($pVisit->tsk_strChangesConcerns ).",\n";

      $sqlOut .=
        'pv_ps_bPatient                 = '.($pVisit->ps_bPatient          ? '1' : '0').',
         pv_ps_bCaregiver               = '.($pVisit->ps_bCaregiver        ? '1' : '0').',
         pv_ps_bBereaved                = '.($pVisit->ps_bBereaved         ? '1' : '0').',
         pv_ps_bOther                   = '.($pVisit->ps_bOther            ? '1' : '0').',
         pv_in_bCompanionship           = '.($pVisit->in_bCompanionship    ? '1' : '0').',
         pv_in_bCaregiverRelief         = '.($pVisit->in_bCaregiverRelief  ? '1' : '0').',
         pv_in_bEmotionalSupport        = '.($pVisit->in_bEmotionalSupport ? '1' : '0').',
         pv_in_bSocialization           = '.($pVisit->in_bSocialization    ? '1' : '0').',
         pv_in_bBereavement             = '.($pVisit->in_bBereavement      ? '1' : '0').',
         pv_in_bTelephoneCall           = '.($pVisit->in_bTelephoneCall    ? '1' : '0').',
         pv_in_bExcursionErrands        = '.($pVisit->in_bExcursionErrands ? '1' : '0').',
         pv_in_bMusicPetArt             = '.($pVisit->in_bMusicPetArt      ? '1' : '0').',
         pv_in_bFoodPrep                = '.($pVisit->in_bFoodPrep         ? '1' : '0').',
         pv_in_bHouseholdChores         = '.($pVisit->in_bHouseholdChores  ? '1' : '0').',
         pv_in_bOther                   = '.($pVisit->in_bOther            ? '1' : '0').',
         pv_tsk_bVisitors               = '.($pVisit->tsk_bVisitors        ? '1' : '0').",
         pv_lLastUpdateID               = $glUserID,
         pv_dteLastUpdate               = NOW() ";

      return($sqlOut);
   }

   function retirePVisitsViaVisitID($lPVRecID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gdteNow, $glUserID;

      $sqlStr =
          "UPDATE patient_visit
           SET pv_bRetired = 1, pv_lLastUpdateID=$glUserID
           WHERE pv_lKeyID=$lPVRecID;";

      $this->db->query($sqlStr);
   }

   function loadVolActivityStats($lVolID, &$stats){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $stats = new stdClass;
      
      $stats->lNumPVisit = $this->lNumPVisitsViaVolID($lVolID, $stats->pvHrs);
      $stats->lNumNonPVisit = $this->lNumNonPVisitActivities($lVolID, $stats->nonPVHrs);
// lHrsPV, &$lHrsNonPV, &$lNumPServed
   }

   function lNumPVisitsViaVolID($lVolID, &$pvHrs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs, SUM(pv_lDuration) AS lPVMinutes
         FROM patient_visit
         WHERE NOT pv_bRetired
            AND pv_lVolID=$lVolID;";

      $query = $this->db->query($sqlStr);
      $row = $query->row();
      $pvHrs = ((int)$row->lPVMinutes)/60.0;
      return((int)$row->lNumRecs);
   }

   function lNumNonPVisitActivities($lVolID, &$nonPVHrs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs, SUM(vsa_dHoursWorked) AS hrsWorked
         FROM vol_events_dates_shifts_assign 
         WHERE 
            vsa_lVolID=$lVolID
            AND NOT vsa_bRetired;";

      $query = $this->db->query($sqlStr);
      $row = $query->row();
      $nonPVHrs = (float)$row->hrsWorked;
      return((int)$row->lNumRecs);
   }


}

