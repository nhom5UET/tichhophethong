<?php
/*---------------------------------------------------------------------
// Hospice Volunteer Solutions!
//
// copyright (c) 2015 by Database Austin
// Austin, Texas
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------
      $this->load->model('util/mlist_generic', 'cList');
---------------------------------------------------------------------

   __construct           ()
   initializeListManager ($strTopListType, $strListType)
   loadList              ()
   strRetrieveListItem   ($lListID)
   strSqlNewListItem     ($strListItemName, $lUserID)
   strSqlUpdateListItem  ($bRetired, $lListItemID, $strListItemName, $lUserID)
   setAddEditTableText   ()
   lListCnt              ()
   genericLoadList       ()
   strLoadListDDL        ($strDDLName, $bAddBlank, $lMatchID)

*/

class mlist_generic extends CI_Model{

   public
      $strTopListType, $strListType, $lChapterID;

      //------------------------------------------
      // text associated with the add/edit table
      //------------------------------------------
   public
       $strAddEditTableTitle,        $strAddEditTableItemLabel,
       $strAddEditTableButtonAddNew, $strAddEditTableButtonUpdate,
       $strDBLookupEmpty,            $strListTableTitle,
       $strPageTitle
       ;

      //------------------------------------------
      // database table and field variables
      //------------------------------------------
   public
       $strListTable, $strKeyIDFN,   $strListItemFN,  $strFieldPrefix,
       $enumListQual, $strQualFN,
       $lForeignID,   $strForeignID, $strForeignIDFN, $strForeignIDKeyFN,
       $strForeignTable,
       $strSQL_ExtraInner, $strSQL_ExtraWhere, $strExtraInsert;

   public
      $strBlankDDLName;

   function __construct(){
   //-----------------------------------------------------------------
   // Constructor
   //-----------------------------------------------------------------
		parent::__construct();

      $this->strTopListType    = $this->strListType       =
      $this->enumListQual      = $this->strQualFN         =
      $this->strForeignTable   = $this->strForeignIDFN    = $this->strForeignIDKeyFN = null;
      $this->strSQL_ExtraInner = $this->strSQL_ExtraWhere = $this->strExtraInsert    = '';

      $this->strBlankDDLName   = '&nbsp;';
   }

   public function initializeListManager($strTopListType, $strListType){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      $this->strTopListType = $strTopListType;
      $this->strListType    = $strListType;

      $this->strListTable      = 'lists_generic';
      $this->strKeyIDFN        = 'lgen_lKeyID';
      $this->strListItemFN     = 'lgen_strListItem';
      $this->strFieldPrefix    = 'lgen_';
      $this->strQualFN         = 'lgen_enumListType';

      switch ($this->strListType){

         case CENUM_LISTTYPE_ATTRIB:
            $this->strDBLookupEmpty =
                 'There are currently no <b>entries</b> in your list of '
                .'"Attributed To".<br><br>'."\n";
            $this->strListTableTitle = '"Attributed To" Entry';
            $this->strPageTitle      = 'List Manager: Volunteer recruitment attributed to...';
            $this->enumListQual      = 'attrib';
            break;

         case CENUM_LISTTYPE_VOLTRAINING:
            $this->strDBLookupEmpty =
                 'There are currently no <b>entries</b> in your list of '
                .'Volunteer Training.<br><br>'."\n";
            $this->strListTableTitle = 'Volunteer Training Entry';
            $this->strPageTitle      = 'List Manager: Volunteer Training';
            $this->enumListQual      = 'volTraining';
            break;

         case CENUM_LISTTYPE_VOLTRAININGBY:
            $this->strDBLookupEmpty =
                 'There are currently no <b>entries</b> in your list of '
                .'those who conduct Volunteer Training.<br><br>'."\n";
            $this->strListTableTitle = 'Volunteer Training Conducted By';
            $this->strPageTitle      = 'List Manager: Volunteer Training Conducted By';
            $this->enumListQual      = 'volTrainingBy';
            break;

         case CENUM_LISTTYPE_PV_ACTIVITIES:
            $this->strDBLookupEmpty =
                 'There are currently no <b>Patient Visit Activities</b> in your database.<br><br>'."\n";
            $this->strListTableTitle = 'Patient Visit Activities List';
            $this->strPageTitle      = 'List Manager: Patient Visit Activities';
            $this->enumListQual      = 'pvActivities';
            break;

         case CENUM_LISTTYPE_PV_LOCATIONS:
            $this->strDBLookupEmpty =
                 'There are currently no <b>Patient Visit Locations</b> in your database.<br><br>'."\n";
            $this->strListTableTitle = 'Patient Visit Locations List';
            $this->strPageTitle      = 'List Manager: Patient Visit Locations';
            $this->enumListQual      = 'pvLocations';
            break;

         case CENUM_LISTTYPE_PV_PSTATUS:
            $this->strDBLookupEmpty =
                 'There are currently no <b>Patient Status Items</b> in your database.<br><br>'."\n";
            $this->strListTableTitle = 'Patient Visit / Patient Status';
            $this->strPageTitle      = 'List Manager: Patient Visit / Patient Status';
            $this->enumListQual      = 'pvPStatus';
            break;

         case CENUM_LISTTYPE_PV_VISITTASKS:
            $this->strDBLookupEmpty =
                 'There are currently no <b>Patient Patient Visit / Visit Tasks</b> in your database.<br><br>'."\n";
            $this->strListTableTitle = 'Patient Visit / Visit Tasks';
            $this->strPageTitle      = 'List Manager: Patient Visit / Visit Tasks';
            $this->enumListQual      = 'pvVisitTasks';
            break;

         case CENUM_LISTTYPE_PCON_RELATION:
            $this->strDBLookupEmpty =
                 'There are currently no <b>Patient Contacts / Relationships</b> in your database.<br><br>'."\n";
            $this->strListTableTitle = 'Patient Contacts / Relationships';
            $this->strPageTitle      = 'List Manager: Patient Contacts / Relationships';
            $this->enumListQual      = 'patientContactRelation';
            break;


         case CENUM_LISTTYPE_VOLJOBCAT:
            $this->strDBLookupEmpty =
                 'There are currently no <b>Volunteer Job Categories</b> defined in your database.<br><br>'."\n";
            $this->strListTableTitle = 'Volunteer Job Categories';
            $this->strPageTitle      = 'List Manager: Volunteer Job Categories';
            $this->enumListQual      = 'volJobCat';
            break;

         case CENUM_LISTTYPE_VOLJOBCODES:
            $this->strDBLookupEmpty =
                 'There are currently no <b>Volunteer Shift Job Codes</b> defined in your database.<br><br>'."\n";
            $this->strListTableTitle = 'Volunteer Shift Job Codes';
            $this->strPageTitle      = 'List Manager: Volunteer Shift Job Codes';
            $this->enumListQual      = 'volShiftJobCodes';
            break;

         case CENUM_LISTTYPE_VOLACT:
            $this->strDBLookupEmpty =
                 'There are currently no <b>Volunteer Activities</b> defined in your database.<br><br>'."\n";
            $this->strListTableTitle = 'Volunteer Activities';
            $this->strPageTitle      = 'List Manager: Volunteer Activities';
            $this->enumListQual      = 'volActivities';
            break;

         case CENUM_LISTTYPE_VOLSKILLS:
            $this->strDBLookupEmpty =
                 'There are currently no <b>Volunteer Skills</b> defined in your database.<br><br>'."\n";
            $this->strListTableTitle = 'Skills the Volunteer Possesses';
            $this->strPageTitle      = 'List Manager: Volunteer Skills';
            $this->enumListQual      = 'volSkills';
            break;

         default:
            screamForHelp($this->strListType.': list type not defined<br>error on line '.__LINE__.',<br>file '.__FILE__.',<br>function '.__FUNCTION__);
            echoT('*** ERROR *** '.$this->strListType.': not defined<br>'); die;
            $this->strDBLookupEmpty =
                 'There are currently no records that match your search criteria.<br><br>'."\n";
            $this->strListTableTitle =
            $this->strPageTitle      =
            $this->strListTable      =
            $this->strKeyIDFN        =
            $this->strListItemFN     =
            $this->strFieldPrefix    =
                                        '### error ###';
            break;
      }
   }

   public function loadList($lChapterID){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      $this->listItems = array();
      $sqlStr =
              "SELECT
                  $this->strKeyIDFN AS lListKeyID, $this->strListItemFN AS strListItem
               FROM $this->strListTable
                  $this->strSQL_ExtraInner
               WHERE
                  $this->strQualFN = ".strPrepStr($this->enumListQual).'
                  AND (NOT '.$this->strFieldPrefix.'bRetired)
                  AND ('.$this->strFieldPrefix."lChapterID=$lChapterID)
                  $this->strSQL_ExtraWhere
               ORDER BY $this->strListItemFN;";

      $query = $this->db->query($sqlStr);
      $this->lNumInList = $numRows = $query->num_rows();
      if ($numRows==0) {
      }else {
         $idx = 0;
         foreach ($query->result() as $row) {
            $this->listItems[$idx] = new stdClass;
            $this->listItems[$idx]->lKeyID      = $row->lListKeyID;
            $this->listItems[$idx]->strListItem = $row->strListItem;

            ++$idx;
         }
      }
   }

   public function strRetrieveListItem($lListID){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      $this->listItems = array();
      $sqlStr =
              "SELECT
                   $this->strListItemFN AS strListItem
               FROM $this->strListTable
               WHERE
                  $this->strKeyIDFN=$lListID
               ORDER BY $this->strListItemFN;";

      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();
      if ($numRows==0) {
         return('### error ###');
      }else {
         $row = $query->row();
         return($row->strListItem);
      }
   }

   public function genericLoadListItem($lListID){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      $sqlStr =
          "SELECT lgen_strListItem
           FROM lists_generic
           WHERE lgen_lKeyID=$lListID;";
      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();
      if ($numRows==0) {
         return('### error ###');
      }else {
         $row = $query->row();
         return($row->lgen_strListItem);
      }
   }

   public function lInsertNewListItem($lChapterID, $strItem){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      global $glUserID;
      $sqlStr = $this->strSqlNewListItem($lChapterID, $strItem, $glUserID);

      $this->db->query($sqlStr);
      return($this->db->insert_id());
   }

   function strSqlNewListItem($lChapterID, $strListItemName, $lUserID){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      $sqlStr =
              "INSERT INTO $this->strListTable
               SET
                   $this->strListItemFN = ".strPrepStr(xss_clean($strListItemName)).",
                   $this->strQualFN     = ".strPrepStr(xss_clean($this->enumListQual)).', '
                  .$this->strFieldPrefix.'bRetired      = 0, '
                  .$this->strFieldPrefix."lOriginID     = $lUserID, "
                  .$this->strFieldPrefix."lLastUpdateID = $lUserID, "
                  .$this->strFieldPrefix."lChapterID    = $lChapterID, "
                  .$this->strFieldPrefix."dteOrigin     = NOW()
                  $this->strExtraInsert;";
      return($sqlStr);
   }

   public function updateListItem($strItem, $id){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      global $glUserID;

      $sqlStr = $this->strSqlUpdateListItem(false, $id, $strItem, $glUserID);
      $query = $this->db->query($sqlStr);
   }

   function strSqlUpdateListItem($bRetired, $lListItemID, $strListItemName, $lUserID){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      $sqlStr =
           "UPDATE $this->strListTable
            SET
                 $this->strListItemFN=".strPrepStr(xss_clean($strListItemName)).", "
                 .$this->strFieldPrefix.'bRetired='.($bRetired ? '1':'0').", "
                 .$this->strFieldPrefix."lLastUpdateID=$lUserID
            WHERE ".$this->strFieldPrefix."lKeyID=$lListItemID;";

      return($sqlStr);
   }

   function removeListItem($lListID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;
      $sqlStr = "
           UPDATE lists_generic
           SET lgen_bRetired=1, lgen_lLastUpdateID=$glUserID
           WHERE lgen_lKeyID=$lListID;";
      $query = $this->db->query($sqlStr);
   }

   function setAddEditTableText(){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      switch ($this->strListType){

         case CENUM_LISTTYPE_ATTRIB:
            $this->strAddEditTableTitle =
                  'Volunteer recruitment attributed to:';
            $this->strAddEditTableItemLabel    = 'Entry: ';
            $this->strAddEditTableButtonAddNew = 'Add New Entry';
            $this->strAddEditTableButtonUpdate = 'Update Entry';
            break;

         case CENUM_LISTTYPE_VOLTRAINING:
            $this->strAddEditTableTitle =
                  'Volunteer Training:';
            $this->strAddEditTableItemLabel    = 'Training Activity ';
            $this->strAddEditTableButtonAddNew = 'Add New Entry';
            $this->strAddEditTableButtonUpdate = 'Update Entry';
            break;

         case CENUM_LISTTYPE_VOLTRAININGBY:
            $this->strAddEditTableTitle =
                  'Conducted By:';
            $this->strAddEditTableItemLabel    = 'Training Conducted By ';
            $this->strAddEditTableButtonAddNew = 'Add New Entry';
            $this->strAddEditTableButtonUpdate = 'Update Entry';
            break;

         case CENUM_LISTTYPE_PV_ACTIVITIES:
            $this->strAddEditTableTitle =
                  'Activities during a Patient Visit:';
            $this->strAddEditTableItemLabel    = 'Activity: ';
            $this->strAddEditTableButtonAddNew = 'Add New Activity';
            $this->strAddEditTableButtonUpdate = 'Update Activity';
            break;

         case CENUM_LISTTYPE_PV_LOCATIONS:
            $this->strAddEditTableTitle =
                  'Patient Visit Location:';
            $this->strAddEditTableItemLabel    = 'Location: ';
            $this->strAddEditTableButtonAddNew = 'Add New Location';
            $this->strAddEditTableButtonUpdate = 'Update Location';
            break;

         case CENUM_LISTTYPE_PV_PSTATUS:
            $this->strAddEditTableTitle =
                  'Patient Visit / Patient Status:';
            $this->strAddEditTableItemLabel    = 'Patient Status: ';
            $this->strAddEditTableButtonAddNew = 'Add New Status';
            $this->strAddEditTableButtonUpdate = 'Update Status';
            break;

         case CENUM_LISTTYPE_PV_VISITTASKS:
            $this->strAddEditTableTitle =
                  'Patient Visit / Visit Tasks:';
            $this->strAddEditTableItemLabel    = 'Visit Task: ';
            $this->strAddEditTableButtonAddNew = 'Add New Task';
            $this->strAddEditTableButtonUpdate = 'Update Task';
            break;

         case CENUM_LISTTYPE_PCON_RELATION:
            $this->strAddEditTableTitle =
                  'Patient Contact / Relationships:';
            $this->strAddEditTableItemLabel    = 'Relationship: ';
            $this->strAddEditTableButtonAddNew = 'Add New Relationship';
            $this->strAddEditTableButtonUpdate = 'Update Relationship';
            break;

         case CENUM_LISTTYPE_VOLJOBCAT:
            $this->strAddEditTableTitle        = 'Volunteer Job Categories';
            $this->strAddEditTableItemLabel    = 'Category: ';
            $this->strAddEditTableButtonAddNew = 'Add New Category';
            $this->strAddEditTableButtonUpdate = 'Update Category';
            break;

         case CENUM_LISTTYPE_VOLJOBCODES:
            $this->strAddEditTableTitle        = 'Volunteer Shift Job Codes';
            $this->strAddEditTableItemLabel    = 'Job Code: ';
            $this->strAddEditTableButtonAddNew = 'Add New Job Code';
            $this->strAddEditTableButtonUpdate = 'Update Job Code';
            break;

         case CENUM_LISTTYPE_VOLACT:
            $this->strAddEditTableTitle        = 'Volunteer Activities';
            $this->strAddEditTableItemLabel    = 'Activity: ';
            $this->strAddEditTableButtonAddNew = 'Add New Activity';
            $this->strAddEditTableButtonUpdate = 'Update Activity';
            break;

         case CENUM_LISTTYPE_VOLSKILLS:
            $this->strAddEditTableTitle        = 'Volunteer Skills';
            $this->strAddEditTableItemLabel    = 'Skill: ';
            $this->strAddEditTableButtonAddNew = 'Add New Skill';
            $this->strAddEditTableButtonUpdate = 'Update Skill List';
            break;

         default:
            screamForHelp($this->strListType.': Unrecognized list type<br>error on line '.__LINE__.',<br>file '.__FILE__.',<br>function '.__FUNCTION__);
            break;
      }
   }

   public function lListCnt(){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      if (is_null($this->enumListType)) screamForHelp('Class not initialized<br>error on line '.__LINE__.',<br>file '.__FILE__.',<br>function '.__FUNCTION__);

      $sqlStr =
        'SELECT COUNT(*) AS lNumRecs
         FROM lists_generic
         WHERE
            lgen_enumListType='.strPrepStr($this->enumListType).'
            AND (NOT lgen_bRetired);';
      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();

      if ($numRows==0) {
         return(0);
      }else {
         $row = $query->row();
         return((int)$row->lNumRecs);
      }
   }

   public function genericLoadList($lChapterID, $bIncludeRetired=false){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      if (is_null($this->enumListType)) screamForHelp('Class not initialized<br>error on line '.__LINE__.',<br>file '.__FILE__.',<br>function '.__FUNCTION__);

      $this->listItems = array();
      $sqlStr =
          'SELECT
              lgen_lKeyID, lgen_enumListType, lgen_strListItem, lgen_lSortIDX,
              lgen_bRetired
           FROM lists_generic
           WHERE
              lgen_enumListType='.strPrepStr($this->enumListType).' '
              .($bIncludeRetired ? '' : ' AND (NOT lgen_bRetired) ').'
              AND lgen_lChapterID='.$lChapterID.'
           ORDER BY lgen_enumListType, lgen_lSortIDX, lgen_strListItem, lgen_lKeyID;';
      $query = $this->db->query($sqlStr);
      $this->lNumInList = $numRows = $query->num_rows();

      $idx = 0;
      if ($numRows > 0){
         foreach ($query->result() as $row){
            $this->listItems[$idx] = new stdClass;
            $li = &$this->listItems[$idx];
            $li->lKeyID       = $row->lgen_lKeyID;
            $li->strListItem  = $row->lgen_strListItem;
            $li->lSortIDX     = $row->lgen_lSortIDX;
            $li->enumListType = $row->lgen_enumListType;
            $li->bRetired     = $row->lgen_bRetired;
            ++$idx;
         }
      }
   }

   public function strLoadListDDL($lChapterID, $strDDLName, $bAddBlank, $lMatchID){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      $strDDL = '<select name="'.$strDDLName.'">'."\n";
      if ($bAddBlank){
         $strDDL .= '<option value="-1">'
                    .$this->strBlankDDLName.'</option>'."\n";
      }

      $this->genericLoadList($lChapterID);

      foreach ($this->listItems as $clsItem){
         $lKeyID = $clsItem->lKeyID;
         $strSelect = $lKeyID == $lMatchID ? ' SELECTED ' : '';
         $strDDL .= '<option value="'.$lKeyID.'" '.$strSelect.'>'
                   .htmlspecialchars($clsItem->strListItem).'</option>'."\n";
      }

      $strDDL .= '</select>'."\n";
      return($strDDL);
   }

   public function strLoadListMultiDDL($lChapterID, $strDDLName, $lSize, $bAddBlank, $matchIDs){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      $strDDL = '<select multiple size='.$lSize.' name="'.$strDDLName.'[]">>'."\n";
      if ($bAddBlank){
         $strDDL .= '<option value="-1">'
                    .$this->strBlankDDLName.'</option>'."\n";
      }

      $this->genericLoadList($lChapterID);

      foreach ($this->listItems as $clsItem){
         $lKeyID = $clsItem->lKeyID;
         $strSelect = in_array($lKeyID, $matchIDs) ? ' SELECTED ' : '';
         $strDDL .= '<option value="'.$lKeyID.'" '.$strSelect.'>'
                   .htmlspecialchars($clsItem->strListItem).'</option>'."\n";
      }
      $strDDL .= '</select>'."\n";
      return($strDDL);
   }

   public function loadDDLM_SelectedItems($enumListType, $lFRecID, &$lNumInList, &$IDs, &$listItems){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $IDs = array(); $listItems = array();
      $sqlStr =
          'SELECT glm_lKeyID,
              lgen_lKeyID, lgen_strListItem, lgen_lSortIDX, lgen_enumListType, lgen_bRetired
           FROM lists_generic_multi
              INNER JOIN lists_generic ON glm_lListID=lgen_lKeyID
           WHERE glm_enumField='.strPrepStr($enumListType)."
              AND glm_lRecID=$lFRecID
           ORDER BY lgen_strListItem, lgen_lKeyID;";

      $query = $this->db->query($sqlStr);
      $lNumInList = $query->num_rows();

      $idx = 0;
      if ($lNumInList > 0){
         foreach ($query->result() as $row){
            $IDs[] = $lID = (int)$row->lgen_lKeyID;

            $listItems[$idx] = new stdClass;
            $li = &$listItems[$idx];
            $li->lKeyID       = $lID;
            $li->strListItem  = $row->lgen_strListItem;
            $li->lSortIDX     = (int)$row->lgen_lSortIDX;
            $li->enumListType = $row->lgen_enumListType;
            $li->bRetired     = (bool)$row->lgen_bRetired;
            ++$idx;
         }
      }
   }

   public function lListItemIDViaTypeName($lChapterID, $enumType, $strName){
   //-----------------------------------------------------------------
   //
   //-----------------------------------------------------------------
      $this->listItems = array();
      $sqlStr =
         'SELECT lgen_lKeyID
          FROM lists_generic
          WHERE lgen_enumListType='.strPrepStr($enumType).'
             AND lgen_strListItem='.strPrepStr($strName).'
             AND lgen_lChapterID='.$lChapterID.'
          LIMIT 0,1;';

      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();
      if ($numRows==0) {
         return(null);
      }else {
         $row = $query->row();
         return((int)$row->lgen_lKeyID);
      }
   }

   public function addMDDLSelections($enumType, $lFRecID, $IDs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
         // out with the old
      $sqlStr =
         'DELETE FROM lists_generic_multi
          WHERE glm_enumField = '.strPrepStr($enumType)." AND glm_lRecID=$lFRecID;";
      $this->db->query($sqlStr);

         // in with the new
      if (count($IDs) > 0){
         $sqlBase =
            'INSERT INTO lists_generic_multi
             SET
                glm_enumField = '.strPrepStr($enumType).",
                glm_lRecID    = $lFRecID,
                glm_lListID   = ";
         foreach ($IDs as $ID){
            $this->db->query($sqlBase.(int)$ID.';');
         }
      }
   }
}


?>