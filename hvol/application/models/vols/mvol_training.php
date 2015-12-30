<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
   Hospice Volunteer Solutions!

   copyright (c) 2015 by Database Austin
   Austin, Texas

   This software is provided under the GPL.
   Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------
      $this->load->model('vols/mvol_training', 'cvt');
---------------------------------------------------------------------*/

//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class mvol_training extends CI_Model{
   var $lLocationID, $locRec;

   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
   }

   function loadVolTrainingViaTID($lTrainingID, &$lNumTraining, &$training){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere = " AND vt_lKeyID = $lTrainingID ";
      $this->loadVolTraining($sqlWhere, $lNumTraining, $training);
   }

   function loadVolTrainingViaVID($lVolID, &$lNumTraining, &$training){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere = " AND vt_lVolID = $lVolID ";
      $this->loadVolTraining($sqlWhere, $lNumTraining, $training);
   }

   function loadVolTraining($sqlWhere, &$lNumTraining, &$training){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT
            vt_lKeyID, vt_lVolID,
            vt_dteDate, UNIX_TIMESTAMP(vt_dteDate) AS dteTraining, vt_lDuration,
            vt_lTrainingID, vt_lTrainingByID, vt_strNotes,

            vol_lChapterID, vol_strFName, vol_strLName,
            ch_strChapterName,

            lt.lgen_strListItem AS strTrainingType,
            tb.lgen_strListItem AS strTrainingBy,
            vt_lOriginID, vt_lLastUpdateID,

            usersC.us_strFirstName AS strCFName, usersC.us_strLastName AS strCLName,
            usersL.us_strFirstName AS strLFName, usersL.us_strLastName AS strLLName,
            UNIX_TIMESTAMP(vt_dteOrigin) AS dteOrigin,
            UNIX_TIMESTAMP(vt_dteLastUpdate) AS dteLastUpdate

         FROM vol_training
            INNER JOIN volunteers     ON vt_lVolID      = vol_lKeyID
            INNER JOIN admin_chapters ON vol_lChapterID = ch_lKeyID
            INNER JOIN lists_generic AS lt   ON vt_lTrainingID   = lt.lgen_lKeyID
            INNER JOIN lists_generic AS tb   ON vt_lTrainingByID = tb.lgen_lKeyID
            INNER JOIN admin_users AS usersC ON vt_lOriginID     = usersC.us_lKeyID
            INNER JOIN admin_users AS usersL ON vt_lLastUpdateID = usersL.us_lKeyID

         WHERE NOT vt_bRetired $sqlWhere
         ORDER BY ch_strChapterName, vol_strLName, vol_strFName, vt_lVolID, vt_dteDate, vt_lKeyID;";

      $query = $this->db->query($sqlStr);
      $lNumTraining = $query->num_rows();

      if ($lNumTraining==0) {
         $training[0] = new stdClass;
         $train = &$training[0];

         $train->lKeyID          =

         $train->lVolID          =
         $train->dteTraining     =
         $train->mysqlDteTrain   =
         $train->lDuration       =
         $train->dHoursTrained   =
         $train->lTrainingID     =
         $train->strTrainingType =
         $train->lTrainingByID   =
         $train->strTrainingBy   =
         $train->strNotes        =
         $train->strFName        =
         $train->strLName        =
         $train->lChapterID      =
         $train->strChapterName  =
         $train->lOriginID       =
         $train->lLastUpdateID   =
         $train->lOriginID       =
         $train->lLastUpdateID   =

         $train->strStaffCFName  =
         $train->strStaffCLName  =
         $train->strStaffLFName  =
         $train->strStaffLLName  =

         $train->dteOrigin       =
         $train->dteLastUpdate   = null;
      }else {
         $idx = 0;
         foreach ($query->result() as $row){
            $training[$idx] = new stdClass;
            $train = &$training[$idx];
            $train->lKeyID          = (int)$row->vt_lKeyID;

            $train->lVolID          = (int)$row->vt_lVolID;
            $train->dteTraining     = (int)$row->dteTraining;
            $train->mysqlDteTrain   = $row->vt_dteDate;
            $train->lDuration       = (int)$row->vt_lDuration;
            $train->dHoursTrained   = $train->lDuration / 60.0;

            $train->lTrainingID     = (int)$row->vt_lTrainingID;
            $train->strTrainingType = $row->strTrainingType;

            $train->lTrainingByID   = (int)$row->vt_lTrainingByID;
            $train->strTrainingBy   = $row->strTrainingBy;

            $train->strNotes        = $row->vt_strNotes;
            $train->strFName        = $row->vol_strFName;
            $train->strLName        = $row->vol_strLName;
            $train->lChapterID      = (int)$row->vol_lChapterID;
            $train->strChapterName  = $row->ch_strChapterName;
            $train->lOriginID       = (int)$row->vt_lOriginID;
            $train->lLastUpdateID   = (int)$row->vt_lLastUpdateID;
            $train->lOriginID       = (int)$row->vt_lOriginID;
            $train->lLastUpdateID   = (int)$row->vt_lLastUpdateID;

            $train->strStaffCFName  = $row->strCFName;
            $train->strStaffCLName  = $row->strCLName;
            $train->strStaffLFName  = $row->strLFName;
            $train->strStaffLLName  = $row->strLLName;

            $train->dteOrigin       = $row->dteOrigin;
            $train->dteLastUpdate   = $row->dteLastUpdate;

            ++$idx;
         }
      }
   }

   public function lAddVolTraining($train){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID, $glChapterID;

      $sqlStr = '
         INSERT INTO vol_training
         SET '.$this->sqlTrainingCommon($train).",
            vt_lVolID     = $train->lVolID,
            vt_lChapterID = $glChapterID, 
            vt_bRetired   = 0,
            vt_lOriginID  = $glUserID,
            vt_dteOrigin  = NOW();";
      $this->db->query($sqlStr);
      return($this->db->insert_id());
   }
   
   function updateVolTraining($lTrainingID, $train){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr = '
         UPDATE vol_training
         SET '.$this->sqlTrainingCommon($train)."
         WHERE vt_lKeyID=$lTrainingID;";
      $this->db->query($sqlStr);
   }

   function sqlTrainingCommon($train){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;

      return(
         'vt_dteDate       = '.strPrepStr($train->mysqlDteTrain).',
          vt_lDuration     = '.(int)$train->lDuration.',
          vt_lTrainingID   = '.(int)$train->lTrainingID.',
          vt_lTrainingByID = '.(int)$train->lTrainingByID.',
          vt_strNotes      = '.strPrepStr($train->strNotes).",
          vt_lLastUpdateID = $glUserID,
          vt_dteLastUpdate = NOW() ");
   }

}

