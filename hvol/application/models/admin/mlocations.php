<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
   Hospice Volunteer Solutions!

   copyright (c) 2015 by Database Austin
   Austin, Texas

   This software is provided under the GPL.
   Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------
      $this->load->model('admin/mlocations', 'cLoc');
---------------------------------------------------------------------*/

//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class mlocations extends CI_Model{
   var $lLocationID, $locRec;

   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();

      $this->lLocationID  = null;

      $this->clearLocationVars();
   }

   function clearLocationVars(){
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
       $this->lLocationID =
       $this->locRec = null;
   }

   function loadLocationViaChapterID($lChapterID, &$lNumLocs, &$locations){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere = "AND ch_lKeyID=$lChapterID ";
      $this->loadLocationInfo($sqlWhere, $lNumLocs, $lNumActive, $locations);
   }

   function loadLocationInfo($sqlWhere, &$lNumLocs, &$lNumActive, &$locations){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $locations = array();
      $lNumActive = 0;

      $sqlStr =
         "SELECT
             ch_lKeyID, ch_bActive,
             ch_strChapterName, ch_strAddress1, ch_strAddress2,
             ch_strCity, ch_strState, ch_strCountry, ch_strZip,
             ch_strFax, ch_strPhone, ch_strBannerTagLine, ch_strNotes,
             ch_strEmail, ch_strWebSite,
             ch_strDefAreaCode, ch_strDefState, ch_strDefCountry,
             ch_lPW_MinLen, ch_bPW_UpperLower, ch_bPW_Number,
             ch_bRetired,

             ch_lOrigID, ch_lLastUpdateID,

             usersC.us_strFirstName AS strCFName, usersC.us_strLastName AS strCLName,
             usersL.us_strFirstName AS strLFName, usersL.us_strLastName AS strLLName,
             UNIX_TIMESTAMP(ch_dteOrigin) AS dteOrigin,
             UNIX_TIMESTAMP(ch_dteLastUpdate) AS dteLastUpdate

          FROM admin_chapters
            INNER JOIN admin_users AS usersC ON ch_lOrigID       = usersC.us_lKeyID
            INNER JOIN admin_users AS usersL ON ch_lLastUpdateID = usersL.us_lKeyID

          WHERE NOT ch_bRetired $sqlWhere
          ORDER BY ch_strChapterName, ch_lKeyID;";

      $query = $this->db->query($sqlStr);
      $lNumLocs = $query->num_rows();

      if ($lNumLocs==0) {
         $locations[0] = new stdClass;
         $loc = &$locations[0];

         $loc->lKeyID               =
         $loc->bActive              =
         $loc->strLocationName      =
         $loc->strSafeLocationName  =
         $loc->strBannerTagLine     =
         $loc->strNotes             =

         $loc->strAddress1          =
         $loc->strAddress2          =
         $loc->strCity              =
         $loc->strState             =
         $loc->strCountry           =
         $loc->strZip               =
         $loc->strAddress           = null;

         $loc->strFax               =
         $loc->strPhone             =
         $loc->strEmail             =
         $loc->strEmailCalDistLists =
         $loc->strWebSite           =

         $loc->bRetired             =

         $loc->strStaffCFName       =
         $loc->strStaffCLName       =
         $loc->strStaffLFName       =
         $loc->strStaffLLName       =

         $loc->dteOrigin            =
         $loc->dteLastUpdate        = null;
      }else {
         $idx = 0;
         foreach ($query->result() as $row){
            $locations[$idx] = new stdClass;
            $loc = &$locations[$idx];

            $loc->lKeyID               = (int)$row->ch_lKeyID;
            $loc->bActive              = $bActive = (bool)$row->ch_bActive;
            if ($bActive) ++$lNumActive;
            $loc->strLocationName      = $row->ch_strChapterName;
            $loc->strSafeLocationName  = htmlspecialchars($row->ch_strChapterName);
            $loc->strBannerTagLine     = $row->ch_strBannerTagLine;
            $loc->strNotes             = $row->ch_strNotes;

            $loc->strAddress1          = $row->ch_strAddress1;
            $loc->strAddress2          = $row->ch_strAddress2;
            $loc->strCity              = $row->ch_strCity;
            $loc->strState             = $row->ch_strState;
            $loc->strCountry           = $row->ch_strCountry;
            $loc->strZip               = $row->ch_strZip;
            $loc->strAddress           =
                        strBuildAddress(
                           $loc->strAddress1, $loc->strAddress2, $loc->strCity,
                           $loc->strState,    $loc->strCountry,  $loc->strZip,
                           true);

            $loc->strFax               = $row->ch_strFax;
            $loc->strPhone             = $row->ch_strPhone;
            $loc->strEmail             = $row->ch_strEmail;
            $loc->strWebSite           = $row->ch_strWebSite;

            $loc->bRetired             = (boolean)$row->ch_bRetired;

            $loc->strStaffCFName       = $row->strCFName;
            $loc->strStaffCLName       = $row->strCLName;
            $loc->strStaffLFName       = $row->strLFName;
            $loc->strStaffLLName       = $row->strLLName;

            $loc->dteOrigin            = $row->dteOrigin;
            $loc->dteLastUpdate        = $row->dteLastUpdate;

            ++$idx;
         }
      }
   }

   function lAddNewLocation(&$locRec){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;
      $sqlStr =
          'INSERT INTO admin_chapters
           SET '.$this->strSQLCommon($locRec).",
               ch_bActive          = 1,
               ch_bRetired         = 0,
               ch_lOrigID          = $glUserID,
               ch_dteOrigin        = NOW();";
      $query = $this->db->query($sqlStr);
      $lLocID = $this->db->insert_id();

         // pre-fill a couple lists
      $clist = new mlist_generic;
      $clist->strListTable     = 'lists_generic';
      $clist->strListItemFN    = 'lgen_strListItem';
      $clist->strQualFN        = 'lgen_enumListType';
      $clist->strFieldPrefix   = 'lgen_';

      $clist->enumListQual = CENUM_LISTTYPE_ATTRIB;
      $clist->lInsertNewListItem($lLocID, '(other)');
      $clist->lInsertNewListItem($lLocID, '(unknown)');
      $clist->lInsertNewListItem($lLocID, 'Internet');
      $clist->lInsertNewListItem($lLocID, 'Staff Member');
      $clist->lInsertNewListItem($lLocID, 'Web Site');

      $clist->enumListQual = CENUM_LISTTYPE_VOLACT;
      $clist->lInsertNewListItem($lLocID, '(Other)');
      $clist->lInsertNewListItem($lLocID, 'Accounting/Bookkeeping');
      $clist->lInsertNewListItem($lLocID, 'Administrative Support');
      $clist->lInsertNewListItem($lLocID, 'Data Entry');
      $clist->lInsertNewListItem($lLocID, 'Errands');
      $clist->lInsertNewListItem($lLocID, 'Event Planning');
      $clist->lInsertNewListItem($lLocID, 'Facilities Management');
      $clist->lInsertNewListItem($lLocID, 'Landscaping');
      $clist->lInsertNewListItem($lLocID, 'Office Support');
      $clist->lInsertNewListItem($lLocID, 'Software/Database/Computers');
      $clist->lInsertNewListItem($lLocID, 'Tuck-In');
      $clist->lInsertNewListItem($lLocID, 'Web Design/Update');

      $clist->enumListQual = CENUM_LISTTYPE_VOLJOBCODES;
      $clist->lInsertNewListItem($lLocID, '2000 Administrative Support');
      $clist->lInsertNewListItem($lLocID, '2010 Event Planning');
      $clist->lInsertNewListItem($lLocID, '2020 Office Support');
      $clist->lInsertNewListItem($lLocID, '5000 Tuck-In');
      $clist->lInsertNewListItem($lLocID, '6000 Data Entry');
      $clist->lInsertNewListItem($lLocID, '6010 Database/Software');
      $clist->lInsertNewListItem($lLocID, '6020 Web Design/Updates');

      $clist->enumListQual = CENUM_LISTTYPE_VOLTRAINING;
      $clist->lInsertNewListItem($lLocID, '(other)');
      $clist->lInsertNewListItem($lLocID, 'Annual Refresher');
      $clist->lInsertNewListItem($lLocID, 'Orientation');

      $clist->enumListQual = CENUM_LISTTYPE_VOLTRAININGBY;
      $clist->lInsertNewListItem($lLocID, '(other)');
      $clist->lInsertNewListItem($lLocID, 'Contracted Facilitator');
      $clist->lInsertNewListItem($lLocID, 'Staff Member');
      $clist->lInsertNewListItem($lLocID, 'Volunteer Coordinator');

      $clist->enumListQual = CENUM_LISTTYPE_PV_ACTIVITIES;
      $clist->lInsertNewListItem($lLocID, '(Other - please specify in notes)');
      $clist->lInsertNewListItem($lLocID, 'Bereavement');
      $clist->lInsertNewListItem($lLocID, 'Telephone Call');
      $clist->lInsertNewListItem($lLocID, 'Visit');

      $clist->enumListQual = CENUM_LISTTYPE_PV_LOCATIONS;
      $clist->lInsertNewListItem($lLocID, '(Other - please specify in notes)');
      $clist->lInsertNewListItem($lLocID, 'Assisted Living Facility');
      $clist->lInsertNewListItem($lLocID, 'Group Home');
      $clist->lInsertNewListItem($lLocID, 'Home');
      $clist->lInsertNewListItem($lLocID, 'Hospital');
      $clist->lInsertNewListItem($lLocID, 'Nursing Home');

      $clist->enumListQual = CENUM_LISTTYPE_PV_PSTATUS;
      $clist->lInsertNewListItem($lLocID, '(Does not apply)');
      $clist->lInsertNewListItem($lLocID, 'Alert');
      $clist->lInsertNewListItem($lLocID, 'Appeared calm');
      $clist->lInsertNewListItem($lLocID, 'Appeared cheerful');
      $clist->lInsertNewListItem($lLocID, 'Appeared confused');
      $clist->lInsertNewListItem($lLocID, 'Appeared sad');
      $clist->lInsertNewListItem($lLocID, 'Awake');
      $clist->lInsertNewListItem($lLocID, 'Drowsy');
      $clist->lInsertNewListItem($lLocID, 'In bed');
      $clist->lInsertNewListItem($lLocID, 'In wheelchair');
      $clist->lInsertNewListItem($lLocID, 'Sleeping');
      $clist->lInsertNewListItem($lLocID, 'Up in a chair');

      $clist->enumListQual = CENUM_LISTTYPE_PV_VISITTASKS;
      $clist->lInsertNewListItem($lLocID, '(Does not apply)');
      $clist->lInsertNewListItem($lLocID, '(Other - please specify in notes)');
      $clist->lInsertNewListItem($lLocID, 'Confimed patient\'s emotional reactions');
      $clist->lInsertNewListItem($lLocID, 'Did light housekeeping');
      $clist->lInsertNewListItem($lLocID, 'Listened to music with patient');
      $clist->lInsertNewListItem($lLocID, 'Looked at pictures with patient');
      $clist->lInsertNewListItem($lLocID, 'Read to patient');
      $clist->lInsertNewListItem($lLocID, 'Socialized with patient during volunteer visit');
      $clist->lInsertNewListItem($lLocID, 'Talked to patient');
      $clist->lInsertNewListItem($lLocID, 'Took patient to activities');
      $clist->lInsertNewListItem($lLocID, 'Walked along side of patient');

      $clist->enumListQual = CENUM_LISTTYPE_PCON_RELATION;
      $clist->lInsertNewListItem($lLocID, '(other)');
      $clist->lInsertNewListItem($lLocID, 'Adult Child');
      $clist->lInsertNewListItem($lLocID, 'Brother');
      $clist->lInsertNewListItem($lLocID, 'Child');
      $clist->lInsertNewListItem($lLocID, 'Daughter');
      $clist->lInsertNewListItem($lLocID, 'Father');
      $clist->lInsertNewListItem($lLocID, 'Friend');
      $clist->lInsertNewListItem($lLocID, 'Husband');
      $clist->lInsertNewListItem($lLocID, 'Mother');
      $clist->lInsertNewListItem($lLocID, 'Other Family Member');
      $clist->lInsertNewListItem($lLocID, 'Sister');
      $clist->lInsertNewListItem($lLocID, 'Son');
      $clist->lInsertNewListItem($lLocID, 'Wife');

      return($lLocID);
   }

   function updateLocation($lLocationID, &$locRec){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbAdmin, $glUserID;

      $sqlStr =
         'UPDATE admin_chapters
          SET '.$this->strSQLCommon($locRec)."
          WHERE ch_lKeyID=$lLocationID;";

      $query = $this->db->query($sqlStr);
   }

   private function strSQLCommon(&$locRec){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;
//      $cRec = $this->locRec;
      return('
            ch_strChapterName   = '.strPrepStr($locRec->strLocationName)  .',
            ch_strBannerTagLine = '.strPrepStr($locRec->strBannerTagLine) .',
            ch_strAddress1      = '.strPrepStr($locRec->strAddress1)      .',
            ch_strAddress2      = '.strPrepStr($locRec->strAddress2)      .',
            ch_strCity          = '.strPrepStr($locRec->strCity)          .',
            ch_strState         = '.strPrepStr($locRec->strState)         .',
            ch_strCountry       = '.strPrepStr($locRec->strCountry)       .',
            ch_strZip           = '.strPrepStr($locRec->strZip)           .',

            ch_strFax           = '.strPrepStr($locRec->strFax)           .',
            ch_strPhone         = '.strPrepStr($locRec->strPhone)         .',
            ch_strEmail         = '.strPrepStr($locRec->strEmail)         .',
            ch_strWebSite       = '.strPrepStr($locRec->strWebSite)       .',

            ch_strNotes         = '.strPrepStr($locRec->strNotes)         .",

            ch_lLastUpdateID    = $glUserID ");
   }

   public function strLocationHTMLSummary(){
   //-----------------------------------------------------------------------
   // assumes user has called $this->loadLocationInfo();
   //-----------------------------------------------------------------------
      global $genumDateFormat;

      $params = array('enumStyle' => 'terse');
      $clsRpt = new generic_rpt($params);
      $clsRpt->setEntrySummary();

      $chapter    = &$this->locRec;
      $lLocationID = $chapter->lKeyID;
      $strOut =
          $clsRpt->openReport('', '')
         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Organization:')
         .$clsRpt->writeCell ($chapter->strSafeLocationName)
         .$clsRpt->closeRow  ()

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Organization ID:')
         .$clsRpt->writeCell (
                               str_pad($lLocationID, 5, '0', STR_PAD_LEFT).'&nbsp;'
                              .strLinkView_OrganizationRecord($lLocationID, 'View organization record', true))
         .$clsRpt->closeRow  ()


         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Address:')
         .$clsRpt->writeCell ($chapter->strAddress)
         .$clsRpt->closeRow  ()

         .$clsRpt->closeReport('<br>');

      return($strOut);
   }

/*
   public function strDefaultDateFormatRadio($strDDLName, $bMatchUS){
      $strOut = "\n"
         .'<input type="radio" name="'.$strDDLName.'" value="US" '.($bMatchUS ? 'checked' : '').'>US (m / d / Y)&nbsp;'."\n"
         .'<input type="radio" name="'.$strDDLName.'" value="EU" '.($bMatchUS ? '' : 'checked').'>Europe/India (d / m / Y)&nbsp;'."\n";
      return($strOut);
   }
*/

   function changeLocActiveState($lLocID, $bSetToActive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;

      $sqlStr =
         "UPDATE admin_chapters
          SET
             ch_bActive = ".($bSetToActive ? '1' : '0').",
             ch_dteLastUpdate   = NOW(),
             ch_lLastUpdateID   = $glUserID
          WHERE ch_lKeyID=$lLocID;";

      $query = $this->db->query($sqlStr);
   }

   function lNumPatientsViaLocID($lLocID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT COUNT(*) AS lNumRec
         FROM patient_records
         WHERE
            cr_lChapterID=$lLocID
            AND NOT cr_bRetired;";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRec);
   }

   function lNumVolMgrsViaLocID($lLocID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT COUNT(*) AS lNumRec
         FROM admin_users
         WHERE
            us_lChapterID=$lLocID
            AND us_bUserVolManager;";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRec);
   }

   function lNumVolsViaLocID($lLocID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT COUNT(*) AS lNumRec
         FROM admin_users
         WHERE
            us_lChapterID=$lLocID
            AND us_bVolAccount;";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRec);
   }

   function removeLocation($lLocID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;

      $sqlStr =
        "UPDATE admin_chapters
         SET ch_bRetired=1, ch_lLastUpdateID=$glUserID
         WHERE ch_lKeyID=$lLocID;";
      $this->db->query($sqlStr);
   }

}

?>