<?php
/*---------------------------------------------------------------------
// Hospice Volunteer Solutions!
// copyright (c) 2015 Database Austin
//
// author: John Zimmerman
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
  ---------------------------------------------------------------------
      $this->load->library('util/dl_date_time', '', 'clsDateTime');
      $this->load->model('patients/mpatients', 'cPatients');
---------------------------------------------------------------------*/


class mpatients extends CI_Model{

   public
      $lPatientID, $strClientID,
      $strFName, $strMName, $strLName, $strNickname, $strSafeName,
      $mdteBirth,  $strDeath, $objBirth,                                         // mysql date format
      $strAgeBDay, $lBDayMonth, $lBDayDay, $lBDayYear,
      $lMaxAllowedSponsors, $lVocID,
      $dteEnrolled,
      $strBio,   $enumGender, $lCountryID, $strCountry,
      $lLocationID, $strLocation, $lSubFacEntryID, $strSubLocation,
      $lSponsorCatID,
      $lOriginID, $lLastUpdateID, $dteOrigin, $dteLastUpdate;

   public $sponsors, $lNumSponsors;

   public $bRetired;

   public $strDefaultImageFile_LR, $strDefaultImageFile_MR, $strDefaultImageFile_HR;

   public
      $strExtraClientWhere, $strClientLimit, $strClientOrder, $strInnerExtra,
      $lNumPatients,         $patients;

   public
      $bDebug;

      //-------------------------
      // generic directory
      //-------------------------
   public
      $dir;

   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
      $this->initClientClass();
   }

   public function initClientClass() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------

      $this->clearClientFields();

      $this->strExtraClientWhere = $this->strClientLimit =
      $this->strClientOrder = $this->strInnerExtra = '';

      $this->lNumPatients = $this->patients = null;

      $this->bDebug = false;

      $this->dir = new stdClass;
   }

   public function clearClientFields(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $this->lPatientID           = $this->strFName      = $this->strMName       =
      $this->strLName            = $this->strNickname   = $this->strSafeName    =
      $this->mdteBirth           =
      $this->strDeath            = $this->objBirth      = $this->strAgeBDay     =
      $this->lBDayMonth          = $this->lBDayDay      = $this->lBDayYear      =
      $this->lMaxAllowedSponsors = $this->dteEnrolled   = $this->strBio         =
      $this->enumGender          = $this->strCountry    =
      $this->lLocationID         = $this->strLocation   = $this->lSubFacEntryID =
      $this->strSubLocation      = $this->lSponsorCatID = $this->lOriginID      =
      $this->lLastUpdateID       = $this->dteOrigin     = $this->dteLastUpdate  = null;

      $this->sponsors = $this->lNumSponsors = $this->bRetired = null;

      $this->v2_strPrivateBio =
      $this->v2_lCasteID      =
      $this->v2_lReligionID   = null;
   }

   private function strCommonClientSQL(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $glUserID, $gstrPassPhrase;

      $client = &$this->patients[0];
      $sqlCommon =
          'cr_strFName      =  AES_ENCRYPT('.strPrepStr($client->strFName   ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_strMName      =  AES_ENCRYPT('.strPrepStr($client->strMName   ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_strLName      =  AES_ENCRYPT('.strPrepStr($client->strLName   ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_strBio        =  AES_ENCRYPT('.strPrepStr($client->strBio     ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),

           cr_strAddr1      =  AES_ENCRYPT('.strPrepStr($client->strAddr1   ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_strAddr2      =  AES_ENCRYPT('.strPrepStr($client->strAddr2   ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_strCity       =  AES_ENCRYPT('.strPrepStr($client->strCity    ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_strState      =  AES_ENCRYPT('.strPrepStr($client->strState   ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_strCountry    =  AES_ENCRYPT('.strPrepStr($client->strCountry ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_strZip        =  AES_ENCRYPT('.strPrepStr($client->strZip     ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_strPhone      =  AES_ENCRYPT('.strPrepStr($client->strPhone   ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_strCell       =  AES_ENCRYPT('.strPrepStr($client->strCell    ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
           cr_strEmail      =  AES_ENCRYPT('.strPrepStr($client->strEmail   ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),

           cr_dteBirth      = '.strPrepStr ($client->dteBirth).',
           cr_dteEnrollment = '.strPrepDate($client->dteEnrollment).',
           cr_enumGender    = '.strPrepStr ($client->enumGender).',
           cr_lMaxSponsors  = '.$client->lMaxSponsors.',
           cr_lLocationID   = '.$client->lLocationID.',
           cr_lAttributedTo = '.(is_null($client->lAttribID) ? 'null' : $client->lAttribID).',
           cr_lVocID        = '.$client->lVocID.",
           cr_lLastUpdateID = $glUserID ";

      return($sqlCommon);
   }

   public function lAddNewClient(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $gdteNow, $glUserID;
      $clsUFC = new muser_fields_create;

      $sqlCommon = $this->strCommonClientSQL();
      $sqlStr =
          "INSERT INTO patient_records
           SET $sqlCommon,
             cr_lStatusCatID = ".$this->patients[0]->lStatusCatID.",
             cr_lOriginID    = $glUserID,
             cr_bRetired     = 0,
             cr_dteOrigin    = NOW();";
      $query = $this->db->query($sqlStr);
      $this->patients[0]->lKeyID = $lKeyID = $this->db->insert_id();   //mysql_insert_id();

         //--------------------------------------------------------
         // create blank/default records for all the personalized
         // client tables
         //--------------------------------------------------------
      $clsUFC->enumTType = CENUM_CONTEXT_CLIENT;
      $clsUFC->loadTablesViaTType();
      if ($clsUFC->lNumTables > 0){
         foreach ($clsUFC->userTables as $clsTable){
            $clsUFC->createSingleEmptyRec($clsTable, $lKeyID);
         }
      }

      return($lKeyID);
   }

   public function updateClientRec(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $gdteNow;

      $sqlCommon = $this->strCommonClientSQL();
      $sqlStr =
          "UPDATE patient_records
           SET $sqlCommon,
               cr_bRetired=".($this->patients[0]->bRetired ? '1' : '0').'
           WHERE cr_lKeyID='.$this->patients[0]->lKeyID.';';
      $query = $this->db->query($sqlStr);
   }

   public function removeClient($lPatientID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;
      $sqlStr =
          "UPDATE patient_records
           SET
              cr_lLastUpdateID = $glUserID,
              cr_bRetired = 1
           WHERE cr_lKeyID=$lPatientID;";
      $query = $this->db->query($sqlStr);

         // remove group membership
      $clsGroups = new mgroups;
      $clsGroups->removeMemFromAllGroups(CENUM_CONTEXT_CLIENT, $lPatientID);

         // delete client entries in personalized tables
      $uf = new muser_fields;
      $uf->deleteForeignViaUFTableType(CENUM_CONTEXT_CLIENT,      $lPatientID);
      $uf->deleteForeignViaUFTableType(CENUM_CONTEXT_CPROGENROLL, $lPatientID);
      $uf->deleteForeignViaUFTableType(CENUM_CONTEXT_CPROGATTEND, $lPatientID);
      $uf->deleteForeignViaUFTableType(CENUM_CONTEXT_CPREPOST,    $lPatientID);

   }

   public function strSafeName(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      return(htmlspecialchars($this->strFName.' '.$this->strMName.' '.$this->strLName));
   }

   public function lClientCountGeneric(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $sqlStr =
           "SELECT COUNT(*) AS lNumPatients
            FROM patient_records
               INNER JOIN client_location                    ON cr_lLocationID = cl_lKeyID

               INNER JOIN client_status                      ON csh_lPatientID   = cr_lKeyID
               INNER JOIN lists_client_status_entries        ON csh_lStatusID   = cst_lKeyID

            WHERE 1
               AND NOT cr_bRetired

                 -- ---------------------------------------
                 -- subquery to find most current status
                 -- ---------------------------------------
               AND csh_lKeyID=(SELECT csh_lKeyID
                               FROM client_status
                               WHERE csh_lPatientID=cr_lKeyID
                                  AND NOT csh_bRetired
                               ORDER BY csh_dteStatusDate DESC, csh_lKeyID DESC
                               LIMIT 0,1)

               $this->strExtraClientWhere;";

      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return($row->lNumPatients);
   }

   public function loadPatientsViaPatientID($lPID){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      if (is_array($lPID)){
         $this->strExtraClientWhere .= ' AND (cr_lKeyID IN ('.implode(',', $lPID).')) ';
      }else {
         $this->strExtraClientWhere .= " AND (cr_lKeyID=$lPID) ";
      }
      $this->loadPatientsGeneric();
   }

   public function loadPatientsGeneric(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $glclsDTDateFormat, $gstrPassPhrase;

      $strOrder = $this->strClientOrder;
      if ($strOrder == ''){
         $strOrder = ' 
              AES_DECRYPT(cr_strLName, SHA2('.strPrepStr($gstrPassPhrase).',256)), 
              AES_DECRYPT(cr_strFName, SHA2('.strPrepStr($gstrPassPhrase).',256)), 
              AES_DECRYPT(cr_strMName, SHA2('.strPrepStr($gstrPassPhrase).',256)), 
              cr_lKeyID ';
      }

      $sqlStr =
           'SELECT
               cr_lKeyID,
               cr_bActive, cr_dteInactive, cr_dteEnrollment,
               cr_enumGender,

               AES_DECRYPT(cr_dteBirth,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS dteBirth,
               AES_DECRYPT(cr_dteDeath,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS dteDeath,
               AES_DECRYPT(cr_strTitle,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strTitle,
               AES_DECRYPT(cr_strFName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strFName,
               AES_DECRYPT(cr_strMName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strMName,
               AES_DECRYPT(cr_strLName,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strLName,
               AES_DECRYPT(cr_strAddr1,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strAddr1,
               AES_DECRYPT(cr_strAddr2,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strAddr2,
               AES_DECRYPT(cr_strCity,      SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strCity,
               AES_DECRYPT(cr_strState,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strState,
               AES_DECRYPT(cr_strCountry,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strCountry,
               AES_DECRYPT(cr_strZip,       SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strZip,
               AES_DECRYPT(cr_strPhone,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPhone,
               AES_DECRYPT(cr_strCell,      SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strCell,
               AES_DECRYPT(cr_strEmail,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strEmail,
               AES_DECRYPT(cr_strBio,       SHA2('.strPrepStr($gstrPassPhrase).",256)) AS strBio,

               cr_bRetired, cr_lOriginID, cr_lLastUpdateID,
               UNIX_TIMESTAMP(cr_dteOrigin)     AS dteOrigin,
               UNIX_TIMESTAMP(cr_dteLastUpdate) AS dteLastUpdate,

               uc.us_strFirstName AS strUCFName, uc.us_strLastName AS strUCLName,
               ul.us_strFirstName AS strULFName, ul.us_strLastName AS strULLName

            FROM patient_records
               $this->strInnerExtra

               INNER JOIN admin_users  AS uc ON uc.us_lKeyID=cr_lOriginID
               INNER JOIN admin_users  AS ul ON ul.us_lKeyID=cr_lLastUpdateID

            WHERE 1
               AND NOT cr_bRetired

               $this->strExtraClientWhere
            ORDER BY $strOrder
            $this->strClientLimit;";

      $query = $this->db->query($sqlStr);
      $this->lNumPatients = $numRows = $query->num_rows();
      $this->patients = array();
      if ($numRows==0) {
         $this->patients[0] = new stdClass;
         $patient = &$this->patients[0];
         $patient->lKeyID                        =
         $patient->strTitle                      =
         $patient->strFName                      =
         $patient->strMName                      =
         $patient->strLName                      =
         $patient->dteEnrollment                 =
         $patient->dteBirth                      =
         $patient->dteDeath                      =
         $patient->enumGender                    =
         $patient->strBio                        =
         $patient->bRetired                      =
         $patient->lOriginID                     =
         $patient->lLastUpdateID                 =
         $patient->dteOrigin                     =
         $patient->dteLastUpdate                 =

         $patient->strAddr1                      =
         $patient->strAddr2                      =
         $patient->strCity                       =
         $patient->strState                      =
         $patient->strCountry                    =
         $patient->strZip                        =
         $patient->strPhone                      =
         $patient->strCell                       =
         $patient->strEmail                      =
         $patient->strAddress                    = null;
      }else {
         $idx = 0;
         foreach ($query->result() as $row){
            $this->patients[$idx] = new stdClass;
            $patient = &$this->patients[$idx];

            $patient->lKeyID            = (int)$row->cr_lKeyID;
            $patient->strTitle          = $row->strTitle;
            $patient->strFName          = $row->strFName;
            $patient->strMName          = $row->strMName;
            $patient->strLName          = $row->strLName;
            $patient->strSafeName       =
                          htmlspecialchars($row->strFName.' '.$row->strMName.' '.$row->strLName);
            $patient->strSafeNameLF     =
                          htmlspecialchars($row->strLName.', '.$row->strFName.' '.$row->strMName);
            $patient->dteEnrollment     = dteMySQLDate2Unix($row->cr_dteEnrollment);
            $patient->dteBirth          = $mySQLdteBirth = $row->dteBirth;
            $patient->dteDeath          = $row->dteDeath;
            $patient->enumGender        = $row->cr_enumGender;
            $patient->bActive           = (bool)$row->cr_bActive;
            $patient->mdteInactive      = $row->cr_dteInactive;

               //------------------------------
               // client address/contact
               //------------------------------
            $patient->strAddr1           = $row->strAddr1;
            $patient->strAddr2           = $row->strAddr2;
            $patient->strCity            = $row->strCity;
            $patient->strState           = $row->strState;
            $patient->strCountry         = $row->strCountry;
            $patient->strZip             = $row->strZip;
            $patient->strPhone           = $row->strPhone;
            $patient->strCell            = $row->strCell;
            $patient->strEmail           = $row->strEmail;
            $patient->strEmailFormatted  = strBuildEmailLink($patient->strEmail, '', false, '');
            $patient->strAddress         =
                        strBuildAddress(
                                 $patient->strAddr1, $patient->strAddr2,   $patient->strCity,
                                 $patient->strState, $patient->strCountry, $patient->strZip,
                                 true);
/*
               //------------------------------
               // client age/birth day info
               //------------------------------
            if (is_null($mySQLdteBirth)){
               $patient->objClientBirth = null;
               $patient->lAgeYears      = null;
               $patient->strClientAgeBDay = '(age n/a)';
            }else {
               $patient->objClientBirth = new dl_date_time;
               $patient->objClientBirth->setDateViaMySQL(0, $mySQLdteBirth);
               $patient->strClientAgeBDay =
                          $patient->objClientBirth->strPeopleAge(0, $mySQLdteBirth,
                               $patient->lAgeYears, $glclsDTDateFormat);
            }
*/            

            $patient->strBio                        = $row->strBio;
            $patient->bRetired                      = $row->cr_bRetired;
            $patient->lOriginID                     = $row->cr_lOriginID;
            $patient->lLastUpdateID                 = $row->cr_lLastUpdateID;

            $patient->dteOrigin                     = $row->dteOrigin;
            $patient->dteLastUpdate                 = $row->dteLastUpdate;
            $patient->ucstrFName                    = $row->strUCFName;
            $patient->ucstrLName                    = $row->strUCLName;
            $patient->ulstrFName                    = $row->strULFName;
            $patient->ulstrLName                    = $row->strULLName;

            ++$idx;
         }
      }
      if ($this->bDebug) $this->dumpClientRecs();
   }

   function dumpClientRecs(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      echoT('<font class="debug">'.__FILE__.': '.__LINE__.'<br><pre>');
      print_r($this->patients);
      echoT('</pre><br></font>');
   }

   public function strPatientHTMLSummary($idx){
   /*-----------------------------------------------------------------------
      assumes user has called $clsClient->loadClientsVia...()

      caller must include
            $this->load->helper ('img_docs/image_doc');
   -----------------------------------------------------------------------*/
      $strOut = '';
      $params = array('enumStyle' => 'terse');
      $clsRpt = new generic_rpt($params);
      $clsRpt->setEntrySummary();

      $clsC = $this->patients[$idx];
      $lCID = $clsC->lKeyID;

      $strOut .= $clsRpt->openReport('', '');
      $strOut .=
           $clsRpt->openRow   (false)
          .$clsRpt->writeLabel('Patient Name:')
          .$clsRpt->writeCell (
                          strLinkView_PatientRecord($lCID, 'View Client Record', true).'&nbsp;'
                         .$clsC->strSafeName.'&nbsp;&nbsp;(client ID: '
                         .str_pad($lCID, 5, '0', STR_PAD_LEFT).')'
                         )
          .$clsRpt->closeRow  ();

      $strOut .=
           $clsRpt->openRow   (false)
          .$clsRpt->writeLabel('Date of Birth:')
          .$clsRpt->writeCell ($clsC->dteBirth)
          .$clsRpt->closeRow  ();
/*
      $strOut .=
           $clsRpt->openRow   (false)
          .$clsRpt->writeLabel('Gender:')
          .$clsRpt->writeCell ($clsC->enumGender)
          .$clsRpt->closeRow  ();
*/          
      $strOut .=
         $clsRpt->closeReport('<br>');

      return($strOut);
   }

   function loadDefaultClientImage(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $sqlStr =
          "SELECT ic_strWebFN, ic_strCaption, ic_strWebFNExt, ic_strImageSubDir
           FROM tbl_image_catalog
           WHERE (NOT ic_bHidden) AND (NOT ic_bRetired)
               AND (ic_lForeignKey=$this->lPatientID)
               AND (ic_lImageGroup=".CL_IMG_GROUP_ClientS.')
               AND (ic_lImageSubGroup='.CL_IMG_SUBG_Client_BIO.')
           ORDER BY ic_bDefault DESC, ic_lKeyID DESC
           LIMIT 0,1;';
      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();

//      $result = mysql_query($sqlStr);
//      if (bSQLError('SQL error on line '.__LINE__.', file '.__FILE__.', function '.__FUNCTION__, $sqlStr) ) {
//         screamForHelp('Unexpected SQL error');
//      }else{
//         $numRows = mysql_num_rows($result);
      if ($numRows==0) {
         $this->strDefaultImageFile = '';
      }else {
//         $row = mysql_fetch_array($result);
         $row = $query->row();

         $strImageSubDir = $row->ic_strImageSubDir;
         $strWebFN       = $row->ic_strWebFN;
         $strWebFNExt    = $row->ic_strWebFNExt;
         $this->strDefaultImageFile_LR = CSTR_CLIENT_IMG_PATH.'/'.$strImageSubDir.'/'.$strWebFN.'_LR.'.$strWebFNExt;
         $this->strDefaultImageFile_MR = CSTR_CLIENT_IMG_PATH.'/'.$strImageSubDir.'/'.$strWebFN.'_MR.'.$strWebFNExt;
         $this->strDefaultImageFile_HR = CSTR_CLIENT_IMG_PATH.'/'.$strImageSubDir.'/'.$strWebFN.'_HR.'.$strWebFNExt;
      }
 //     }
   }

   function strXlateGender(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      switch ($this->enumGender){
         case 'M': return('boy');  break;
         case 'F': return('girl'); break;
         default:  return('(unknown'); break;
      }
   }

   public function clientDirectory(){
   //---------------------------------------------------------------------
   // assumes a call to $clsClient->loadClientInfo();
   //---------------------------------------------------------------------
      $strOut = '';
      $lNumCols = count($this->dir->cols);

      $strOut .= $this->clientDirectoryHeader($lNumCols);
      $strOut .= $this->clientDirectoryRows  ($lNumCols);
      $strOut .= $this->clientDirectoryClose ();
      return($strOut);
   }

   private function clientDirectoryHeader($lNumCols){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strOut = '
          <table '.$this->dir->strTableClassStyle.'>
            <tr>
               <td colspan="'.$lNumCols.'" '.$this->dir->strTitleClassStyle.'>'
                  .$this->dir->strTitle.'
            </tr>
            <tr>'."\n";

      foreach($this->dir->cols as $col){
         $strStyle = '';
         if ($col->width != ''){
            $strStyle .= 'width: '.$col->width.';';
         }
         if ($col->label=='Select Link'){
            $strLabel = '&nbsp;';
         }else {
            $strLabel = $col->label;
         }

         $strOut .= '
            <td '.$this->dir->strHeaderClass.' style="'.$strStyle.'">'
               .$strLabel.'
            </td>'."\n";
      }
      $strOut .= '</tr>'."\n";
      return($strOut);
   }

   private function clientDirectoryRows(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strOut = '';
      $clsSponProg = new msponsorship_programs;
      foreach ($this->patients as $client){
         $strOut .= '<tr '.$this->dir->strRowTRClass.' >'."\n";
         $lPatientID = $client->lKeyID;

         foreach($this->dir->cols as $col){
            $strOut .= $this->writeDirectoryRowCol($clsSponProg, $lPatientID, $client, $col);
         }
         $strOut .='</tr>'."\n";
      }
      return($strOut);
   }

   private function writeDirectoryRowCol($clsSponProg, $lPatientID, $client, $col){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strStyle = '';
      if ($col->width != ''){
         $strStyle .= 'width: '.$col->width.';';
      }
      $strOut = '<td '.$col->tdClass.' style="'.$strStyle.'">'."\n";
      switch ($col->label){
         case 'Client ID':
            $strCell =
                  strLinkView_ClientRecord($client->lKeyID, 'View client record', true).' '
                 .str_pad($client->lKeyID, 5, '0', STR_PAD_LEFT);
            break;

         case 'Name':
            $strCell = $client->strSafeNameLF;
            break;

         case 'Location':
            $strCell = htmlspecialchars($client->strLocation);
            break;

         case 'Birthday/Age':
            $strCell = $client->strClientAgeBDay;
            break;

         case 'Gender':
            $strCell = $client->enumGender;
            break;

         case 'Sponsorship Program':
            $clsSponProg->loadSponProgsViaClientID($lPatientID);
            if ($clsSponProg->lNumSponPrograms <= 0){
               $strCell = '<i>None</i>';
            }else {
               $strCell = '';
               foreach ($clsSponProg->sponProgs as $clsProg){
                  $strCell .= htmlspecialchars($clsProg->strProg).'<br>';
               }
            }
            break;

         case 'Select Link':
            $strCell = strImageLink($this->dir->clsSelLink->strLinkPath.'/'.$client->lKeyID,
                                    $this->dir->clsSelLink->strAnchorExtra,
                                    $this->dir->clsSelLink->bShowImage,
                                    $this->dir->clsSelLink->bShowText,
                                    $this->dir->clsSelLink->enumImage,
                                    $this->dir->clsSelLink->strLinkText);
            break;

         default:
            screamForHelp($col->label.': column not recognized<br>error on <b>line:</b> '.__LINE__.'<br><b>file: </b>'.__FILE__.'<br><b>function: </b>'.__FUNCTION__);
            break;
      }
      return($strOut.$strCell.'</td>'."\n");
   }

   private function clientDirectoryClose(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      return('</table>'."\n");
   }

   public function lNumPatientsViaLetter($lChapterID, $strLetter, $bIncludeInactive, $strWhereExtra=''){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strLetter = strtoupper($strLetter);
      $sqlWhere = $this->strWhereByLetter($strLetter, $bIncludeInactive);

      $strInner = '';
      if (!$bIncludeInactive){
         $sqlWhere .= ' AND cr_bActive ';
      }

      if (!is_null($lChapterID)){
         $sqlWhere .= " AND cr_lChapterID = $lChapterID ";
      }

      $sqlStr =
        "SELECT COUNT(*) AS lNumPatients
         FROM patient_records
            $strInner
            $this->strInnerExtra
         WHERE NOT cr_bRetired
            $sqlWhere $strWhereExtra ;";

      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((integer)$row->lNumPatients);
   }

   function strWhereByLetter($strLetter, $bIncludeInactive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gstrPassPhrase;

      $strLName = ' (AES_DECRYPT(cr_strLName,     SHA2('.strPrepStr($gstrPassPhrase).',256))) ';
      if ($strLetter=='*'){
         $sqlWhere = ' ';
      }
      elseif ($strLetter=='#'){
         $sqlWhere = "AND ( (LEFT($strLName, 1) > 'Z') OR ((LEFT($strLName, 1) < 'A'))) ";
      }elseif ($strLetter==''){
         $sqlWhere = '';
      }else {
         $sqlWhere = "AND (LEFT($strLName, 1)=".strPrepStr($strLetter).' ) ';
      }
      if (!$bIncludeInactive) $sqlWhere .= ' AND cr_bActive ';
      return($sqlWhere);
   }

   function loadPatientDirectoryPage($lChapterID, $strWhereExtra, $lStartRec, $lRecsPerPage){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gstrPassPhrase;

      $this->strClientLimit      = " LIMIT $lStartRec, $lRecsPerPage ";
      $this->strClientOrder      =
             ' (AES_DECRYPT(cr_strLName,     SHA2('.strPrepStr($gstrPassPhrase).',256))),
               (AES_DECRYPT(cr_strFName,     SHA2('.strPrepStr($gstrPassPhrase).',256))),
               (AES_DECRYPT(cr_strMName,     SHA2('.strPrepStr($gstrPassPhrase).',256))),
               cr_lKeyID ';
      $this->strExtraClientWhere = $strWhereExtra;
      if (!is_null($lChapterID)){
         $this->strExtraClientWhere .= " AND cr_lChapterID = $lChapterID ";
      }
      $this->loadPatientsGeneric();
   }

   public function bValidClientID($lPatientID){
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM patient_records
         WHERE cr_lKeyID=$lPatientID
            AND NOT cr_bRetired;";
      $query = $this->db->query($sqlStr);
      if ($query->num_rows() == 0) return(false);
      $row = $query->row();
      return($row->lNumRecs > 0);
   }

   public function lAddNewPatient($pRec){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID, $glChapterID, $gstrPassPhrase;

      $sqlStr =
          'INSERT INTO patient_records
           SET '.$this->sqlCommonAddEdit($pRec).",
              cr_bRetired      = 0,
              cr_bActive       = 1,
              cr_enumGender    = 'Unknown',
              cr_lChapterID    = $glChapterID,
              cr_lOriginID     = $glUserID,
              cr_dteEnrollment = NOW(),
              cr_dteOrigin     = NOW();";
      $this->db->query($sqlStr);
      return($this->db->insert_id());
   }
   
   function updatePatient($lPatientID, $pRec){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
          'UPDATE patient_records
           SET '.$this->sqlCommonAddEdit($pRec)."
           WHERE cr_lKeyID=$lPatientID;";
      $this->db->query($sqlStr);
   }

   function sqlCommonAddEdit(&$pRec){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID, $gstrPassPhrase;
      return(
        'cr_dteBirth   = AES_ENCRYPT('.strPrepStr($pRec->dteBirth  ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_dteDeath   = AES_ENCRYPT('.strPrepStr($pRec->dteDeath  ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strTitle   = AES_ENCRYPT('.strPrepStr($pRec->strTitle  ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strFName   = AES_ENCRYPT('.strPrepStr($pRec->strFName  ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strMName   = AES_ENCRYPT('.strPrepStr($pRec->strMName  ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strLName   = AES_ENCRYPT('.strPrepStr($pRec->strLName  ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strAddr1   = AES_ENCRYPT('.strPrepStr($pRec->strAddr1  ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strAddr2   = AES_ENCRYPT('.strPrepStr($pRec->strAddr2  ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strCity    = AES_ENCRYPT('.strPrepStr($pRec->strCity   ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strState   = AES_ENCRYPT('.strPrepStr($pRec->strState  ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strCountry = AES_ENCRYPT('.strPrepStr($pRec->strCountry).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strZip     = AES_ENCRYPT('.strPrepStr($pRec->strZip    ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strPhone   = AES_ENCRYPT('.strPrepStr($pRec->strPhone  ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strCell    = AES_ENCRYPT('.strPrepStr($pRec->strCell   ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strEmail   = AES_ENCRYPT('.strPrepStr($pRec->strEmail  ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_strBio     = AES_ENCRYPT('.strPrepStr($pRec->strBio    ).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
         cr_lLastUpdateID = '.$glUserID.' ');
   }

   function updateActiveStatus($lPatientID, $bSetToActive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;
      
      $sqlStr =
          'UPDATE patient_records
           SET cr_bActive      = '.($bSetToActive ? '1' : '0').'
              cr_dteInactive   = '.($bSetToActive ? 'NOW()' : 'NULL').",
              cr_lLastUpdateID = $glUserID
           WHERE cr_lKeyID=$lPatientID;";
      $this->db->query($sqlStr);
   }
   
}

?>