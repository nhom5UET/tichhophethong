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
      $this->load->model('vols/mvol', 'cVol');
---------------------------------------------------------------------*/


//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class mvol extends CI_Model{
   public
       $lVolID, $lPeopleID, $volRecs, $lNumVolRecs,
       $strWhereExtra, $strOrderExtra, $sqlLimitExtra;


   public function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
      $this->lVolID = $this->lPeopleID = $this->volRecs = $this->lNumVolRecs = null;
      $this->strWhereExtra = $this->strOrderExtra = $this->sqlLimitExtra = '';
   }

   public function lNumVols($enumType, $strWhereExtra=''){
   //---------------------------------------------------------------------
   // $enumType: active / inactive / all
   //---------------------------------------------------------------------
      switch ($enumType){
         case 'active':
            $strWhere = 'AND NOT vol_bInactive ';
            break;
         case 'inactive':
            $strWhere = 'AND vol_bInactive ';
            break;
         case 'all':
            $strWhere = '';
            break;
         default:
            screamForHelp($enumType.': invalid type<br>error on line '.__LINE__.',<br>file '.__FILE__.',<br>function '.__FUNCTION__);
            break;
      }
      $sqlStr =
        "SELECT COUNT(*) AS lNumVols
         FROM `volunteers`
         WHERE
            NOT `vol_bRetired`
            $strWhere $strWhereExtra;";
      $query = $this->db->query($sqlStr);
      if ($query->num_rows() == 0){
         return(0);
      }else {
         $row = $query->row();
         return((integer)$row->lNumVols);
      }
   }

   public function loadVolRecsViaVolID($lVolID, $bIncludeInactive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (is_array($lVolID)){
         $this->strWhereExtra = ' AND vol_lKeyID IN ('.implode(',', $lVolID).') ';
      }else {
         $this->strWhereExtra = " AND vol_lKeyID = $lVolID ";
      }
      if (!$bIncludeInactive){
         $this->strWhereExtra .= ' AND NOT vol_bInactive ';
      }
      $this->loadVolRecs();
   }

   public function loadVolRecs(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $this->volRecs = array();

      if ($this->strOrderExtra.'' == ''){
         $this->strOrderExtra = ' ORDER BY vol_strLName, vol_strFName, vol_strMName, vol_lKeyID ';
      }

      $sqlStr =
        "SELECT
            vol_lKeyID, vol_lChapterID, ch_strChapterName,
            userAcct.us_lKeyID AS lAcctID, vol_bInactive,
            vol_strNotes, vol_bRetired, vol_lOriginID, vol_lLastUpdateID,
            UNIX_TIMESTAMP(vol_dteInactive) AS dteInactive,

            vol_strLName, vol_strFName,
            vol_strMName, vol_bRetired,
            vol_strPreferredName, vol_strTitle,
            vol_strAddr1, vol_strAddr2,
            vol_strCity,  vol_strState,
            vol_strZip,   vol_strCountry,
            vol_strEmail, vol_strPhone, vol_strCell,
            vol_dteBirthDate,

            vol_lAttributedTo, Attrib.lgen_strListItem AS strAttrib,

            UNIX_TIMESTAMP(vol_dteOrigin)     AS dteOrigin,
            UNIX_TIMESTAMP(vol_dteLastUpdate) AS dteLastUpdate,
            uc.us_strFirstName AS strUCFName, uc.us_strLastName AS strUCLName,
            ul.us_strFirstName AS strULFName, ul.us_strLastName AS strULLName

         FROM volunteers
            INNER JOIN admin_chapters      ON ch_lKeyID      = vol_lChapterID
            INNER JOIN admin_users   AS uc ON uc.us_lKeyID   = vol_lOriginID
            INNER JOIN admin_users   AS ul ON ul.us_lKeyID   = vol_lLastUpdateID
            LEFT  JOIN lists_generic AS Attrib   ON vol_lAttributedTo = Attrib.lgen_lKeyID
            LEFT  JOIN admin_users   AS userAcct ON vol_lKeyID = userAcct.us_lVolID

         WHERE
            NOT vol_bRetired
            $this->strWhereExtra
         $this->strOrderExtra
         $this->sqlLimitExtra;";

      $query = $this->db->query($sqlStr);
      $this->lNumVolRecs = $numRows = $query->num_rows();

      if ($numRows==0) {
         $this->volRecs[0] = new stdClass;
         $vRec = &$this->volRecs[0];

         $vRec->lKeyID         =
         $vRec->lPeopleID      =
         $vRec->lHouseholdID   =
         $vRec->bInactive      =
         $vRec->strNotes       =
         $vRec->bRetired       =
         $vRec->dteInactive    =

         $vRec->strLName       =
         $vRec->strFName       =
         $vRec->strMName       =
         $vRec->strSafeNameFL  =

         $vRec->bRetired       =
         $vRec->strAddr1       =
         $vRec->strAddr2       =
         $vRec->strCity        =
         $vRec->strState       =
         $vRec->strZip         =
         $vRec->strCountry     =
         $vRec->strEmail       =
         $vRec->strPhone       =
         $vRec->strCell        =

         $vRec->lOriginID      =
         $vRec->lLastUpdateID  =
         $vRec->dteOrigin      =
         $vRec->dteLastUpdate  =
         $vRec->strUCFName     =
         $vRec->strUCLName     =
         $vRec->strULFName     =
         $vRec->strULLName     = null;
      }else {
         $idx = 0;
         foreach ($query->result() as $row) {

            $this->volRecs[$idx] = new stdClass;
            $vRec = &$this->volRecs[$idx];

            $vRec->lKeyID           = (int)$row->vol_lKeyID;
            $vRec->lAcctID          = (int)$row->lAcctID;

            $vRec->lChapterID       = (int)$row->vol_lChapterID;
            $vRec->strChapterName   = $row->ch_strChapterName;

            $vRec->bInactive        = (bool)$row->vol_bInactive;
            $vRec->bActive          = !$vRec->bInactive;
            $vRec->strNotes         = $row->vol_strNotes;
            $vRec->dteInactive      = $row->dteInactive;

            $vRec->strLName         = $strLName = $row->vol_strLName;
            $vRec->strFName         = $strFName = $row->vol_strFName;
            $vRec->strMName         = $strMName = $row->vol_strMName;
            $vRec->strTitle         = $strTitle = $row->vol_strTitle;
            $vRec->strPreferred     = $strPreferred = $row->vol_strPreferredName;

            $vRec->strSafeName      = $vRec->strSafeNameFL =
                                         htmlspecialchars(
                                                            strBuildName(false, $strTitle, $strPreferred,
                                                                            $strFName, $strLName, $strMName));
            $vRec->strSafeNameLF    = htmlspecialchars(
                                                         strBuildName(true, $strTitle, $strPreferred,
                                                                         $strFName, $strLName, $strMName));

            $vRec->bRetired          = (bool)$row->vol_bRetired;
            $vRec->strAddr1          = $row->vol_strAddr1;
            $vRec->strAddr2          = $row->vol_strAddr2;
            $vRec->strCity           = $row->vol_strCity;
            $vRec->strState          = $row->vol_strState;
            $vRec->strZip            = $row->vol_strZip;
            $vRec->strCountry        = $row->vol_strCountry;
            $vRec->strEmail          = $strEmail = $row->vol_strEmail;
            $vRec->strEmailFormatted = strBuildEmailLink($strEmail, '', false, '');
            $vRec->strNotes          = $row->vol_strNotes;
            $vRec->mdteBirthDate     = $row->vol_dteBirthDate;

            $vRec->strPhone         = $row->vol_strPhone;
            $vRec->strCell          = $row->vol_strCell;
            $vRec->strAddress       =
                     strBuildAddress(
                              $vRec->strAddr1, $vRec->strAddr2,   $vRec->strCity,
                              $vRec->strState, $vRec->strCountry, $vRec->strZip,
                              true);

            $vRec->lAttributedTo    = $row->vol_lAttributedTo;
            $vRec->strAttrib        = $row->strAttrib;

            $vRec->lOriginID        = $row->vol_lOriginID;
            $vRec->lLastUpdateID    = $row->vol_lLastUpdateID;
            $vRec->dteOrigin        = $row->dteOrigin;
            $vRec->dteLastUpdate    = $row->dteLastUpdate;
            $vRec->strUCFName       = $row->strUCFName;
            $vRec->strUCLName       = $row->strUCLName;
            $vRec->strULFName       = $row->strULFName;
            $vRec->strULLName       = $row->strULLName;

            ++$idx;
         }
      }
   }

   public function lAddNewVolunteer(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $glUserID, $glChapterID;

      $strRegFormID = 'null';

      $sqlStr =
           'INSERT INTO volunteers
            SET '.$this->strVolSQLCommon().",
               vol_bInactive     = 0,
               vol_dteInactive   = NULL,
               vol_bRetired      = 0,
               vol_lChapterID    = $glChapterID,
               vol_lOriginID     = $glUserID,
               vol_dteOrigin     = NOW();";

      $this->db->query($sqlStr);
      $this->volRecs[0]->lKeyID = $lKeyID = $this->db->insert_id();

      return($lKeyID);
   }

   function updateVolunteerRec($lVolID){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $glUserID, $glChapterID;

      $sqlStr =
           'UPDATE volunteers
            SET '.$this->strVolSQLCommon()."
            WHERE vol_lKeyID=$lVolID;";

      $this->db->query($sqlStr);
   }

   private function strVolSQLCommon(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $glUserID;

      $vol = &$this->volRecs[0];

      if (is_null($vol->lAttributedTo)){
         $strAttrib = 'null';
      }else {
         $strAttrib = (integer)$vol->lAttributedTo;
      }
      return('
             vol_strTitle         = '.strPrepStr($vol->strTitle, 80).',

             vol_strFName         = '.strPrepStr($vol->strFName, 80).',
             vol_strMName         = '.strPrepStr($vol->strMName, 80).',
             vol_strLName         = '.strPrepStr($vol->strLName, 80).',

             vol_strPreferredName = '.strPrepStr($vol->strPreferredName, 80).',
             vol_strAddr1         = '.strPrepStr($vol->strAddr1, 80).',

             vol_strAddr2         = '.strPrepStr($vol->strAddr2, 80).',
             vol_strCity          = '.strPrepStr($vol->strCity, 80).',
             vol_strState         = '.strPrepStr($vol->strState, 80).',

             vol_strCountry       = '.strPrepStr($vol->strCountry, 80).',
             vol_strZip           = '.strPrepStr($vol->strZip, 40).',
             vol_strPhone         = '.strPrepStr($vol->strPhone, 40).',
             vol_strCell          = '.strPrepStr($vol->strCell, 40).',
             vol_strNotes         = '.strPrepStr($vol->strNotes).',

             vol_strEmail         = '.strPrepStr($vol->strEmail, 120).",
             vol_lAttributedTo    = $strAttrib,

             vol_lLastUpdateID    = $glUserID,

             vol_dteBirthDate     = ".strDBValueConvert_String($vol->dteMysqlBirthDate).' ');
   }


   function bVolStatusViaPID($lPID, &$lVolID, &$bInactive, &$dteInactive, &$dteVolStart){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $lVolID = $bInactive = $dteInactive = null;
      $sqlStr =
        "SELECT
            vol_lKeyID, vol_bInactive,
            UNIX_TIMESTAMP(vol_dteInactive) AS dteInactive,
            UNIX_TIMESTAMP(vol_dteOrigin)   AS dteOrigin
         FROM volunteers
         WHERE
            NOT vol_bRetired
            AND vol_lPeopleID=$lPID;";

      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();
      if ($numRows==0) {
         return(false);
      }else {
         $row = $query->row();
         $lVolID      = (int)$row->vol_lKeyID;
         $bInactive   = (boolean)$row->vol_bInactive;
         $dteInactive = $row->dteInactive;
         $dteVolStart = $row->dteOrigin;
         return(true);
      }
   }

   public function activateDeactivateVolunteer($lVolID, $bActivate){
      global $glUserID;

      if ($bActivate){
         $strDateIn = '';
      }else {
         $strDateIn = ', vol_dteInactive=NOW() ';
      }
      $sqlStr =
           'UPDATE volunteers
            SET
               vol_bInactive     = '.($bActivate ? '0': '1').",
               vol_lLastUpdateID = $glUserID
               $strDateIn
            WHERE vol_lKeyID=$lVolID;";

      $this->db->query($sqlStr);
   }

   public function volHTMLSummary($idx){
   //-----------------------------------------------------------------------
   // assumes user has called $clsVol->loadVolRecs(...
   //-----------------------------------------------------------------------
      global $gdteNow, $genumDateFormat;

      $strOut = '';
      $params = array('enumStyle' => 'terse');
      $clsRpt = new generic_rpt($params);
      $clsRpt->setEntrySummary();

      $lVolID = $this->volRecs[$idx]->lKeyID;
      $volRec = &$this->volRecs[$idx];
      
      $strOut .=
          $clsRpt->openReport('', '')

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Name:')
         .$clsRpt->writeCell ($volRec->strSafeName)
         .$clsRpt->closeRow  ()

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Volunteer ID:')
         .$clsRpt->writeCell (str_pad($lVolID, 5, '0', STR_PAD_LEFT).'&nbsp;'
                             .strLinkView_VolRecord($lVolID, 'View Volunteer Record', true))
         .$clsRpt->closeRow  ();

      if ($volRec->bInactive){
         $strVol = '<i>Inactive since '.date($genumDateFormat, $volRec->dteInactive);
      }else {
         $strVol = 'Active';
      }

      $strOut .=
          $clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Volunteer Status:')
         .$clsRpt->writeCell ($strVol)
         .$clsRpt->closeRow  ()

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Location:')
         .$clsRpt->writeCell (htmlspecialchars($volRec->strChapterName))
         .$clsRpt->closeRow  ()

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Address:')
         .$clsRpt->writeCell ($volRec->strAddress)
         .$clsRpt->closeRow  ()

         .$clsRpt->closeReport('');
      return($strOut);
   }

   function loadVolDirectoryPage($strWhereExtra, $lStartRec, $lRecsPerPage){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->sqlLimitExtra = " LIMIT $lStartRec, $lRecsPerPage ";
      $this->strWhereExtra = $strWhereExtra;
      if ($this->strOrderExtra == ''){
         $this->strOrderExtra = 'ORDER BY vol_strLName, vol_strFName, vol_strMName, vol_lKeyID ';
      }
      $this->loadVolRecs();
   }

   function loadVolClientAssocViaVolID($lVolID, &$volClient, $bShowInactive=false){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere = " AND vca_lVolID=$lVolID ";
      if (!$bShowInactive) $sqlWhere .= ' AND vca_bActive ';
      $this->loadVolClientAssoc($sqlWhere, $volClient);
   }

   function loadVolClientAssocViaPatientID($lPatientID, &$volClient){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere = " AND cr_lKeyID=$lPatientID ";
      $this->loadVolClientAssoc($sqlWhere, $volClient);
   }

   function loadVolClientAssoc($sqlWhere, &$volClient){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gstrPassPhrase;

      $volClient = array();

      $strOrder = '
           AES_DECRYPT(cr_strLName, SHA2('.strPrepStr($gstrPassPhrase).',256)),
           AES_DECRYPT(cr_strFName, SHA2('.strPrepStr($gstrPassPhrase).',256)),
           AES_DECRYPT(cr_strMName, SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_lKeyID ';

      $sqlStr =
        'SELECT
            vca_lKeyID, vca_lVolID, vca_lClientID, vca_strNotes,
            vca_bActive, vca_dteInactive, vca_bRetired,
            vca_lOriginID, vca_lLastUpdateID, vca_dteOrigin, vca_dteLastUpdate,

            vol_strLName, vol_strFName, vol_strMName, vol_bRetired,
            vol_strPreferredName, vol_strTitle,
            vol_strAddr1, vol_strAddr2, vol_strCity,  vol_strState,
            vol_strZip,   vol_strCountry, vol_strEmail, vol_strPhone, vol_strCell,
            vol_dteBirthDate,

            AES_DECRYPT(cr_dteBirth,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS dtePBirth,
            AES_DECRYPT(cr_dteDeath,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS dtePDeath,
            AES_DECRYPT(cr_strTitle,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPTitle,
            AES_DECRYPT(cr_strFName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPFName,
            AES_DECRYPT(cr_strMName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPMName,
            AES_DECRYPT(cr_strLName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPLName,
            AES_DECRYPT(cr_strAddr1,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPAddr1,
            AES_DECRYPT(cr_strAddr2,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPAddr2,
            AES_DECRYPT(cr_strCity,      SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPCity,
            AES_DECRYPT(cr_strState,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPState,
            AES_DECRYPT(cr_strCountry,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPCountry,
            AES_DECRYPT(cr_strZip,       SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPZip,
            AES_DECRYPT(cr_strPhone,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPPhone,
            AES_DECRYPT(cr_strCell,      SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPCell,
            AES_DECRYPT(cr_strEmail,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPEmail,
            AES_DECRYPT(cr_strBio,       SHA2('.strPrepStr($gstrPassPhrase).",256)) AS strPBio,
            cr_enumGender
         FROM vol_client_association
            INNER JOIN patient_records ON vca_lClientID = cr_lKeyID
            INNER JOIN volunteers      ON vca_lVolID    = vol_lKeyID

         WHERE NOT vca_bRetired
            $sqlWhere
            AND NOT cr_bRetired
         ORDER BY $strOrder;";

      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();

      if ($numRows > 0) {
         $idx = 0;
         foreach ($query->result() as $row) {
            $volClient[$idx] = new stdClass;
            $vca = &$volClient[$idx];

            $vca->lKeyID                     = (int)$row->vca_lKeyID;
            $vca->lVolID                     = (int)$row->vca_lVolID;
            $vca->lPatientID                 = (int)$row->vca_lClientID;
            $vca->strNotes                   = $row->vca_strNotes;
            $vca->bActive                    = (bool)$row->vca_bActive;
            $vca->dteInactive                = $row->vca_dteInactive;
            $vca->bRetired                   = (bool)$row->vca_bRetired;
            $vca->lOriginID                  = (int)$row->vca_lOriginID;
            $vca->lLastUpdateID              = (int)$row->vca_lLastUpdateID;
            $vca->dteOrigin                  = $row->vca_dteOrigin;
            $vca->dteLastUpdate              = $row->vca_dteLastUpdate;

            $vca->vol = new stdClass;
            $vca->vol->strFName              = $row->vol_strFName;
            $vca->vol->strMName              = $row->vol_strMName;
            $vca->vol->strLName              = $row->vol_strLName;
            $vca->vol->dteBirth              = $row->vol_dteBirthDate;
//            $vca->vol->enumGender            = $row->vol_enumGender;
            $vca->vol->strAddr1              = $row->vol_strAddr1;
            $vca->vol->strAddr2              = $row->vol_strAddr2;
            $vca->vol->strCity               = $row->vol_strCity;
            $vca->vol->strState              = $row->vol_strState;
            $vca->vol->strCountry            = $row->vol_strCountry;
            $vca->vol->strZip                = $row->vol_strZip;
            $vca->vol->strPhone              = $row->vol_strPhone;
            $vca->vol->strCell               = $row->vol_strCell;
            $vca->vol->strEmail              = $row->vol_strEmail;
            $vca->vol->strAddress            =
                     strBuildAddress(
                              $vca->vol->strAddr1,  $vca->vol->strAddr2,   $vca->vol->strCity,
                              $vca->vol->strState,  $vca->vol->strCountry, $vca->vol->strZip,
                              true);

            $vca->patient = new stdClass;
            $vca->patient->strFName          = $row->strPFName;

            $vca->patient->strMName          = $row->strPMName;
            $vca->patient->strLName          = $row->strPLName;
            $vca->patient->dteBirth          = $row->dtePBirth;

            $vca->patient->enumGender        = $row->cr_enumGender;
            $vca->patient->strAddr1          = $row->strPAddr1;
            $vca->patient->strAddr2          = $row->strPAddr2;

            $vca->patient->strCity           = $row->strPCity;
            $vca->patient->strState          = $row->strPState;
            $vca->patient->strCountry        = $row->strPCountry;
            $vca->patient->strZip            = $row->strPZip;
            $vca->patient->strPhone          = $row->strPPhone;
            $vca->patient->strCell           = $row->strPCell;
            $vca->patient->strEmail          = $row->strPEmail;



            ++$idx;
         }
      }
   }

   function addVolAssociation($va){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;

      $sqlStr =
        "INSERT INTO vol_client_association
         SET
            vca_lVolID        = $va->lVolID,
            vca_bActive       = 1,
            vca_lClientID     = $va->lPatientID,
            vca_lOriginID     = $glUserID,
            vca_lLastUpdateID = $glUserID,
            vca_strNotes      = ".strPrepStr($va->strNotes).',
            vca_bRetired      = 0,
            vca_dteOrigin     = NOW(),
            vca_dteLastUpdate = NOW();';
      $this->db->query($sqlStr);
   }

   function removeVolClientAssoc($lVAID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;

      $sqlStr =
        "DELETE FROM vol_client_association
         WHERE
            vca_lKeyID        = $lVAID;";
      $this->db->query($sqlStr);
   }

   function changeVolActiveState($lVolID, $bSetActive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;

      if ($bSetActive){
         $strDteInactive = ' vol_dteInactive = NULL ';
      }else {
         $strDteInactive = ' vol_dteInactive = NOW() ';
      }

      $sqlStr =
        'UPDATE volunteers
         SET vol_bInactive='.($bSetActive ? '0' : '1').",
            vol_lLastUpdateID = $glUserID,
            $strDteInactive
         WHERE
            vol_lKeyID = $lVolID;";
      $this->db->query($sqlStr);
   }

   function changeActiveAssocState($lAssocID, $bSetActive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;

      $sqlStr =
        'UPDATE vol_client_association
         SET vca_bActive='.($bSetActive ? '1' : '0').",
            vca_lLastUpdateID = $glUserID
         WHERE
            vca_lKeyID = $lAssocID;";
      $this->db->query($sqlStr);
   }

   function strWhereByLetter($strLetter, $strFieldPrefix=''){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($strLetter=='#'){
         $sqlWhere = "AND ( (LEFT(".$strFieldPrefix."vol_strLName, 1) > 'Z')
                        OR ((LEFT(".$strFieldPrefix."vol_strLName, 1) < 'A'))) ";
      }elseif ($strLetter=='' || $strLetter=='*'){
         $sqlWhere = '';
      }else {
         $sqlWhere = 'AND (LEFT('.$strFieldPrefix.'vol_strLName, 1)='.strPrepStr($strLetter).' ) ';
      }
      return($sqlWhere);
   }

}



?>