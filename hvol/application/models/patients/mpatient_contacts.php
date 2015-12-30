<?php
/*---------------------------------------------------------------------
// Hospice Volunteer Solutions
// copyright (c) 2015 Database Austin
//
// author: John Zimmerman
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
  ---------------------------------------------------------------------
      $this->load->model('patients/mpatient_contacts', 'cPCons');
---------------------------------------------------------------------*/

class mpatient_contacts extends CI_Model{


   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
   }


   public function loadPContactsViaPatientID($lPatientID, &$lNumPatients, &$pContacts){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere = " AND cr_lKeyID=$lPatientID ";
      $this->loadPContactsPatientTree($sqlWhere, '', $lNumPatients, $pContacts);
   }

   public function loadPContactsPatientTree($sqlWhereExtra, $sqlOrder, &$lNumPatients, &$pContacts){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gstrPassPhrase;

      $lNumPatients = 0;
      $pContacts = array();

      if ($sqlOrder == '') $sqlOrder = ' cr_strLName, cr_strFName, cr_lKeyID,  cc_strLName, cc_strFName, cc_lKeyID ';
      $sqlStr =
        'SELECT
            cr_lKeyID,
            cc_lKeyID, cc_lPatientID,
            lgRel.lgen_strListItem AS strRelationship,
            cc_lRelationshipID, cc_enumGender,

            AES_DECRYPT(cr_strFName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientFName,
            AES_DECRYPT(cr_strMName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientMName,
            AES_DECRYPT(cr_strLName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientLName,
            AES_DECRYPT(cc_strTitle,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPConTitle,
            AES_DECRYPT(cc_strFName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPConFName,
            AES_DECRYPT(cc_strMName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPConMName,
            AES_DECRYPT(cc_strLName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPConLName,
            AES_DECRYPT(cc_strAddr1,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strAddr1,
            AES_DECRYPT(cc_strAddr2,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strAddr2,
            AES_DECRYPT(cc_strCity,    SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strCity,
            AES_DECRYPT(cc_strState,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strState,
            AES_DECRYPT(cc_strCountry, SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strCountry,
            AES_DECRYPT(cc_strZip,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strZip,
            AES_DECRYPT(cc_strPhone,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPhone,
            AES_DECRYPT(cc_strCell,    SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strCell,
            AES_DECRYPT(cc_strEmail,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strEmail,
            AES_DECRYPT(cc_strNotes,   SHA2('.strPrepStr($gstrPassPhrase).",256)) AS strNotes,

            cc_lOriginID, cc_lLastUpdateID, cc_dteOrigin, cc_dteLastUpdate
         FROM patient_records
            INNER JOIN patient_contacts       ON cc_lPatientID     = cr_lKeyID
            INNER JOIN lists_generic AS lgRel ON lgRel.lgen_lKeyID = cc_lRelationshipID
         WHERE NOT cr_bRetired AND NOT cc_bRetired
            $sqlWhereExtra
         ORDER BY $sqlOrder;";

      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();
      if ($numRows > 0) {
         $patientIDs = array();
         $idx = 0;
         foreach ($query->result() as $row){
            $lPID = (int)$row->cr_lKeyID;
            if (!isset($patientIDs[$lPID])){
               $patientIDs[$lPID] = $idx;
               $pIDX = $idx;
               ++$idx;
               ++$lNumPatients;

               $pContacts[$pIDX] = new stdClass;
               $pc = &$pContacts[$pIDX];
               $pc->lNumContacts = 0;
               $pc->contacts = array();

               $pc->lPatientID      = (int)$row->cr_lKeyID;
               $pc->strPatientFName = $row->strPatientFName;
               $pc->strPatientMName = $row->strPatientMName;
               $pc->strPatientLName = $row->strPatientLName;
            }else {
               $pIDX = $patientIDs[$lPID];
            }
            $pc->contacts[$pc->lNumContacts] = new stdClass;
            $pcc = &$pc->contacts[$pc->lNumContacts];

            $pcc->lContactID      = $row->cc_lKeyID;
            $pcc->lPatientID      = $row->cc_lPatientID;
            $pcc->lRelationshipID = $row->cc_lRelationshipID;
            $pcc->enumGender      = $row->cc_enumGender;

            $pcc->strPConTitle    = $row->strPConTitle;
            $pcc->strFName        = $row->strPConFName;
            $pcc->strMName        = $row->strPConMName;
            $pcc->strLName        = $row->strPConLName;

            $pcc->strAddr1        = $row->strAddr1;
            $pcc->strAddr2        = $row->strAddr2;
            $pcc->strCity         = $row->strCity;
            $pcc->strState        = $row->strState;
            $pcc->strCountry      = $row->strCountry;
            $pcc->strZip          = $row->strZip;
            $pcc->strPhone        = $row->strPhone;
            $pcc->strCell         = $row->strCell;
            $pcc->strEmail        = $row->strEmail;
            $pcc->strNotes        = $row->strNotes;

            $pcc->strAddress         =
                        strBuildAddress(
                                 $pcc->strAddr1, $pcc->strAddr2,   $pcc->strCity,
                                 $pcc->strState, $pcc->strCountry, $pcc->strZip,
                                 true);

            $pcc->lOriginID       = $row->cc_lOriginID;
            $pcc->lLastUpdateID   = $row->cc_lLastUpdateID;
            $pcc->dteOrigin       = $row->cc_dteOrigin;
            $pcc->dteLastUpdate   = $row->cc_dteLastUpdate;
            $pcc->strRelationship = $row->strRelationship;

            ++$pc->lNumContacts;
         }
      }
   }

   public function loadPContactsViaPConID($lPConID, &$lNumPCons, &$pContacts){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlWhere = " AND cc_lKeyID=$lPConID ";
      $this->loadPContacts($sqlWhere, '', $lNumPCons, $pContacts);
   }

   public function loadPContacts($sqlWhereExtra, $sqlOrder, &$lNumPCons, &$pContacts){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gstrPassPhrase;

      $lNumPCons = 0;
      $pContacts = array();

      if ($sqlOrder == '') $sqlOrder = ' cr_strLName, cr_strFName, cr_lKeyID,  cc_strLName, cc_strFName, cc_lKeyID ';
      $sqlStr =
        'SELECT
            cr_lKeyID,
            cc_lKeyID, cc_lPatientID, cc_lRelationshipID, cc_enumGender,
            AES_DECRYPT(cr_strFName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientFName,
            AES_DECRYPT(cr_strMName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientMName,
            AES_DECRYPT(cr_strLName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPatientLName,
            AES_DECRYPT(cc_strTitle,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPConTitle,
            AES_DECRYPT(cc_strFName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPConFName,
            AES_DECRYPT(cc_strMName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPConMName,
            AES_DECRYPT(cc_strLName,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPConLName,
            AES_DECRYPT(cc_strAddr1,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strAddr1,
            AES_DECRYPT(cc_strAddr2,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strAddr2,
            AES_DECRYPT(cc_strCity,    SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strCity,
            AES_DECRYPT(cc_strState,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strState,
            AES_DECRYPT(cc_strCountry, SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strCountry,
            AES_DECRYPT(cc_strZip,     SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strZip,
            AES_DECRYPT(cc_strPhone,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strPhone,
            AES_DECRYPT(cc_strCell,    SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strCell,
            AES_DECRYPT(cc_strEmail,   SHA2('.strPrepStr($gstrPassPhrase).',256)) AS strEmail,
            AES_DECRYPT(cc_strNotes,   SHA2('.strPrepStr($gstrPassPhrase).",256)) AS strNotes,
            cc_lOriginID, cc_lLastUpdateID, cc_dteOrigin, cc_dteLastUpdate,
            lgRel.lgen_strListItem AS strRelationship
         FROM patient_records
            INNER JOIN patient_contacts       ON cc_lPatientID     = cr_lKeyID
            INNER JOIN lists_generic AS lgRel ON lgRel.lgen_lKeyID = cc_lRelationshipID
         WHERE NOT cr_bRetired AND NOT cc_bRetired
            $sqlWhereExtra
         ORDER BY $sqlOrder;";

      $query = $this->db->query($sqlStr);
      $lNumPCons = $query->num_rows();
      if ($lNumPCons == 0) {
            $pContacts[0] = new stdClass;
      }else {
         $idx = 0;
         foreach ($query->result() as $row){
            $pContacts[$idx] = new stdClass;
            $pc = &$pContacts[$idx];

            $pc->lPatientID      = (int)$row->cr_lKeyID;
            $pc->strPatientFName = $row->strPatientFName;
            $pc->strPatientMName = $row->strPatientMName;
            $pc->strPatientLName = $row->strPatientLName;

            $pc->lContactID      = $row->cc_lKeyID;
            $pc->strPConTitle    = $row->strPConTitle;
            $pc->strPConFName    = $row->strPConFName;
            $pc->strPConMName    = $row->strPConMName;
            $pc->strPConLName    = $row->strPConLName;
            $pc->lRelationshipID = $row->cc_lRelationshipID;
            $pc->strRelationship = $row->strRelationship;
//            $pc->enumGender      = $row->cc_enumGender;

            $pc->strAddr1        = $row->strAddr1;
            $pc->strAddr2        = $row->strAddr2;
            $pc->strCity         = $row->strCity;
            $pc->strState        = $row->strState;
            $pc->strCountry      = $row->strCountry;
            $pc->strZip          = $row->strZip;
            $pc->strPhone        = $row->strPhone;
            $pc->strCell         = $row->strCell;
            $pc->strEmail        = $row->strEmail;
            $pc->strNotes        = $row->strNotes;

            $pc->lOriginID       = $row->cc_lOriginID;
            $pc->lLastUpdateID   = $row->cc_lLastUpdateID;
            $pc->dteOrigin       = $row->cc_dteOrigin;
            $pc->dteLastUpdate   = $row->cc_dteLastUpdate;

            ++$idx;
         }
      }
   }

   function lAddNewPatientContact($lPatientID, &$pCon){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;
      $sqlStr =
          'INSERT INTO patient_contacts
           SET '.$this->sqlAddEditCommon($pCon).",
              cc_lPatientID=$lPatientID,
              cc_lOriginID=$glUserID,
              cc_dteOrigin=NOW();";

      $this->db->query($sqlStr);
      return($this->db->insert_id());
   }

   function updatePContact($lPConID, &$pCon){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;
      $sqlStr =
          'UPDATE patient_contacts
           SET '.$this->sqlAddEditCommon($pCon)."
           WHERE cc_lKeyID=$lPConID;";

      $this->db->query($sqlStr);
   }

   function sqlAddEditCommon(&$pCon){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------

//INSERT INTO t VALUES (1,AES_ENCRYPT('text', SHA2('My secret passphrase',512)));
      global $glUserID, $gstrPassPhrase;
      $strOut =
           'cc_strTitle        = AES_ENCRYPT('.strPrepStr($pCon->strPConTitle).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strFName        = AES_ENCRYPT('.strPrepStr($pCon->strPConFName).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strMName        = AES_ENCRYPT('.strPrepStr($pCon->strPConMName).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strLName        = AES_ENCRYPT('.strPrepStr($pCon->strPConLName).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_lRelationshipID = '.(int)$pCon->lRelationshipID.',

            cc_strAddr1         = AES_ENCRYPT('.strPrepStr($pCon->strAddr1).',   SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strAddr2         = AES_ENCRYPT('.strPrepStr($pCon->strAddr2).',   SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strCity          = AES_ENCRYPT('.strPrepStr($pCon->strCity).',    SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strState         = AES_ENCRYPT('.strPrepStr($pCon->strState).',   SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strCountry       = AES_ENCRYPT('.strPrepStr($pCon->strCountry).', SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strZip           = AES_ENCRYPT('.strPrepStr($pCon->strZip).',     SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strPhone         = AES_ENCRYPT('.strPrepStr($pCon->strPhone).',   SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strCell          = AES_ENCRYPT('.strPrepStr($pCon->strCell).',    SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strEmail         = AES_ENCRYPT('.strPrepStr($pCon->strEmail).',   SHA2('.strPrepStr($gstrPassPhrase).',256)),
            cc_strNotes         = AES_ENCRYPT('.strPrepStr($pCon->strNotes).',   SHA2('.strPrepStr($gstrPassPhrase).",256)),

            cc_lLastUpdateID    = $glUserID,
            cc_dteLastUpdate    = NOW() ";
      return($strOut);
   }

   function removePConRec($lPConID){
   //---------------------------------------------------------------------
   // 
   //---------------------------------------------------------------------    
      $sqlStr =
          "DELETE FROM patient_contacts
           WHERE cc_lKeyID=$lPConID;";

      $this->db->query($sqlStr);
   
   }
}


