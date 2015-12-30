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
      $this->load->model('hospice/mhospice_su_reports', 'cHSURpt');
---------------------------------------------------------------------*/


//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class mhospice_su_reports extends CI_Model{


   public function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
      $this->lVolID = $this->lClientID = null;
   }

   function lLogInCounts($sqlWhereExtra){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM admin_usage_log
         WHERE 1 $sqlWhereExtra;";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRecs);
   }

   function lLogInCountsViaUserRole($enumRole, $sqlWhereExtra){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      switch ($enumRole){
         case 'SuperUser':
            $strRoleFN = 'us_bSuperUser';
            break;
         case 'VolMgr':
            $strRoleFN = 'us_bUserVolManager';
            break;
         case 'Vol':
            $strRoleFN = 'us_bVolAccount';
            break;
         default:
            screamForHelp($enumRole.': invalid user role<br>error on line  <b> -- '.__LINE__.' --</b>,<br>file '.__FILE__.',<br>function '.__FUNCTION__);
            break;
      }

      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM admin_usage_log
            INNER JOIN admin_users ON el_lUserID=us_lKeyID
         WHERE el_bLoginSuccessful AND $strRoleFN $sqlWhereExtra;";
         
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRecs);
   }

   function lNumRecs_PVisit($lLocID, $lYear, $lMonth, $bViaVolMgr){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (is_null($lLocID)){
         $strQualLoc = '';
      }else {
         $strQualLoc = " AND pv_lChapterID=$lLocID ";
      }
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM patient_visit
            INNER JOIN admin_users ON pv_lOriginID=us_lKeyID
         WHERE NOT pv_bRetired
            $strQualLoc
            AND YEAR(pv_dteOrigin)  = $lYear
            AND MONTH(pv_dteOrigin) = $lMonth
            AND ".($bViaVolMgr ? 'us_bUserVolManager' : 'us_bVolAccount').';';
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRecs);
   }

   function lNumRecs_OtherVolAct($lLocID, $lYear, $lMonth, $bViaVolMgr){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (is_null($lLocID)){
         $strQualLoc = '';
      }else {
         $strQualLoc = " AND vsa_lChapterID=$lLocID ";
      }
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM vol_events_dates_shifts_assign
            INNER JOIN admin_users ON vsa_lOriginID=us_lKeyID
         WHERE NOT vsa_bRetired
            $strQualLoc
            AND YEAR(vsa_dteOrigin)  = $lYear
            AND MONTH(vsa_dteOrigin) = $lMonth
            AND ".($bViaVolMgr ? 'us_bUserVolManager' : 'us_bVolAccount').';';
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRecs);
   }

}