<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// Hospice Volunteer Solutions!
// copyright (c) 2015 Database Austin
//
// author: John Zimmerman
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------*/

class hospice_vol extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   public function otherActivity($lActivityID=0, $lVolID=0){
   //-------------------------------------------------------------------------
   //
   //-------------------------------------------------------------------------
      global $glVolID, $gbVolMgr, $gbDateFormatUS, $glChapterID;

      if ($gbVolMgr){
         $lVolID = (int)$lVolID;
      }else {
         $lVolID = $glVolID;
      }
      
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lVolID, 'volunteer ID');      

      $displayData = array();
      $displayData['formData'] = new stdClass;
      $displayData['lActivityID'] = $lActivityID = (integer)$lActivityID;

      $displayData['bNew']   = $bNew = $lActivityID <= 0;
      $displayData['lVolID'] = $lVolID;

         //-------------------------------------
         // models / helpers / libraries
         //-------------------------------------
      $this->load->model ('vols/mvol',             'clsVol');
      $this->load->model ('vols/mvol_job_codes',   'cVJobCodes');
      $this->load->model ('vols/mvol_event_hours', 'clsVolHours');
      $this->load->model ('util/mlist_generic',    'clsList');
      $this->load->helper('dl_util/time_date');  // for date verification
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);
      $this->load->helper('dl_util/web_layout');

         //--------------------------
         // load activity record
         //--------------------------
      $this->clsVolHours->loadVolActivitiesViaID($lActivityID);
      $act = &$this->clsVolHours->unActivity[0];

      $this->clsVol->loadVolRecsViaVolID($lVolID, true);
      $displayData['volRec'] = $volRec = &$this->clsVol->volRecs[0];

         //-------------------------
         // validation rules
         //-------------------------
      $this->form_validation->set_error_delimiters('<div class="formError">', '</div>');
		$this->form_validation->set_rules('ddlStart',    'Start Time', 'trim|callback_vactVerifyStart');
		$this->form_validation->set_rules('ddlDuration', 'Duration',   'trim|callback_vactVerifyDuration');
		$this->form_validation->set_rules('ddlActivity', 'Activity',   'trim|callback_vactVerifyAct');
      $this->form_validation->set_rules('ddlJobCode',  'Job Code',   'trim');
      $this->form_validation->set_rules('txtDate',     'Date of Volunteer Activity',  'trim|required'
                                                                    .'|callback_verifyUnDateValid');
		$this->form_validation->set_rules('txtNotes',    'Notes', 'trim');

		if ($this->form_validation->run() == FALSE){
         $displayData['formData'] = new stdClass;
         $this->load->library('generic_form');

            // first time displayed, no user data entry errors
         if (validation_errors()==''){
            if (is_null($act->dteActivityDate)){
               $displayData['formData']->txtDate    = '';
               $displayData['formData']->lStartTime = strDisplayTimeDDL(null, true, true);
            }else {
               $displayData['formData']->txtDate    = strNumericDateViaMysqlDate($act->mysqlActivityDate, $gbDateFormatUS);
               $displayData['formData']->lStartTime = strDisplayTimeDDL($act->dteActivityDate, true, true);
            }

            $displayData['formData']->strNotes     = htmlspecialchars($act->strNotes);
            $displayData['formData']->enumDuration = strDurationDDL   (true, false,
                                                             lDurationHrsToQuarters($act->dHoursWorked), true);

               // activity generic list
            $this->clsList->strBlankDDLName = '&nbsp;';
            $this->clsList->enumListType = CENUM_LISTTYPE_VOLACT;
            $displayData['formData']->strVolActivity     =
                            $this->clsList->strLoadListDDL($glChapterID, 'ddlActivity', true, $act->lActivityID);

               // job code generic list
            $this->clsList->enumListType = CENUM_LISTTYPE_VOLJOBCODES;
            $this->clsList->strBlankDDLName = '(no job code)';
            $displayData['strDDLJobCode'] = $this->clsList->strLoadListDDL($glChapterID, 'ddlJobCode', true, $act->lJobCode);
         }else {
            setOnFormError($displayData);
            $displayData['formData']->txtDate      = set_value('txtDate');
            $displayData['formData']->lStartTime   = $lStartTime = strDisplayTimeDDL(set_value('ddlStart'), true, true);
            $displayData['formData']->strNotes     = set_value('txtNotes');
            $displayData['formData']->enumDuration = strDurationDDL(true, false, set_value('ddlDuration'), true);

               // activity generic list
            $this->clsList->strBlankDDLName = '&nbsp;';
            $this->clsList->enumListType = CENUM_LISTTYPE_VOLACT;
            $displayData['formData']->strVolActivity     =
                            $this->clsList->strLoadListDDL($glChapterID, 'ddlActivity', true, set_value('ddlActivity'));

               // job code generic list
            $this->clsList->enumListType = CENUM_LISTTYPE_VOLJOBCODES;
            $this->clsList->strBlankDDLName = '(no job code)';
            $displayData['strDDLJobCode'] = $this->clsList->strLoadListDDL($glChapterID, 'ddlJobCode', true, set_value('ddlJobCode'));
         }

         $this->clsVol->loadVolRecsViaVolID($lVolID, true);

            //--------------------------
            // breadcrumbs
            //--------------------------
         $displayData['pageTitle'] = 'Log Volunteer Hours';

         $displayData['title']          = CS_PROGNAME.' | Volunteers';
         $displayData['nav']            = $this->mnav_brain_jar->navData();
         $displayData['mainTemplate']   = 'hospice/vols/hrs_unscheduled_add_edit_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $act->lVolID       = $lVolID;
         $act->lChapterID   = $glChapterID;
         $act->strNotes     = trim($_POST['txtNotes']);
         $act->lActivityID  = (integer)trim($_POST['ddlActivity']);
         $act->dHoursWorked = ((integer)trim($_POST['ddlDuration']))/4;
         $strDate           = trim($_POST['txtDate']);
         MDY_ViaUserForm($strDate, $lMon, $lDay, $lYear, $gbDateFormatUS);

         $lDDLStart = (int)$_POST['ddlStart'];
         quartersToHrsMin($lDDLStart, $lHours, $lMinutes);

         $act->dteActivityDate = mktime($lHours, $lMinutes, 0, $lMon, $lDay, $lYear);

         $act->lJobCode = (integer)$_POST['ddlJobCode'];
         if ($act->lJobCode <= 0) $act->lJobCode = null;

            //------------------------------------
            // update db tables and return
            //------------------------------------
         if ($bNew){
            $lActivityID = $this->clsVolHours->addUnscheduledHrs();
            $this->session->set_flashdata('msg', 'Volunteer hours were recorded for '.$volRec->strSafeNameFL.'.');
         }else {
            $this->clsVolHours->updateUnscheduledHrs($lActivityID);
            $this->session->set_flashdata('msg', 'Record updated');
         }

         redirect('hospice/review/reviewHours/'.$lVolID);
      }
   }

      //-----------------------------
      // verification routines
      //-----------------------------
   function verifyUnDateValid($strDate){
      return(bValidVerifyDate($strDate));
   }
   function vactVerifyStart($lDDLSel){
      return(((integer)$lDDLSel) >= 0);
   }
   function vactVerifyDuration($lDDLSel){
      return(((integer)$lDDLSel) > 0);
   }
   function vactVerifyAct($lDDLSel){
      return(((integer)$lDDLSel) > 0);
   }

   function addEditVol($lVolID='0'){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr, $gbDateFormatUS, $glChapterID, $glUserID;
      global $gbVolLogin;

      if ($gbVolLogin){
         $this->load->model  ('admin/mpermissions',      'perms');
         $this->load->model  ('admin/muser_accts',       'cusers');
         if ($lVolID != $this->cusers->lVolIDViaUserID($glUserID)){
            bTestForURLHack('forceFail');
            return;
         }
      }elseif (!bTestForURLHack('volMgr')){
         return;
      }
      $this->load->helper('dl_util/verify_id');
      if ($lVolID != '0') verifyID($glChapterID, $lVolID, 'volunteer ID');

      $displayData = array();
      $displayData['js'] = '';
      $displayData['formData'] = new stdClass;
      $displayData['lVolID']   = $lVolID = (int)$lVolID;

      $displayData['bNew'] = $bNew = $lVolID <= 0;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('vols/mvol', 'cVol');
      $this->load->model  ('admin/mpermissions', 'perms');
      $this->load->model  ('admin/muser_accts',  'cusers');
      $this->load->helper ('dl_util/time_date');
      $this->load->helper ('dl_util/web_layout');
      $this->load->library('util/dl_date_time', '', 'clsDateTime');

         // load volunteer record
      $this->cVol->loadVolRecsViaVolID($lVolID,  true);
      $vRec = &$this->cVol->volRecs[0];

         // account ID
      if ($bNew){
         $lAcctID = -1;
      }else {
         $lAcctID = $this->cusers->lUserIDViaUserName($vRec->strEmail);
      }

         // validation rules
      $this->form_validation->set_error_delimiters('<div class="formError">', '</div>');
      $this->form_validation->set_rules('txtFName',      'First Name',  'trim|required');
      $this->form_validation->set_rules('txtTitle',      '',  'trim');
      $this->form_validation->set_rules('txtMName',      '',  'trim');
      $this->form_validation->set_rules('txtLName',      'Last Name',  'trim|required');
      $this->form_validation->set_rules('txtPName',      '',  'trim');
      $this->form_validation->set_rules('txtSal',        '',  'trim');

      $this->form_validation->set_rules('txtAddr1',      '',  'trim');
      $this->form_validation->set_rules('txtAddr2',      '',  'trim');
      $this->form_validation->set_rules('txtCity',       '',  'trim');
      $this->form_validation->set_rules('txtState',      '',  'trim');
      $this->form_validation->set_rules('txtZip',        '',  'trim');
      $this->form_validation->set_rules('txtCountry',    '',  'trim');
      $this->form_validation->set_rules('txtNotes',      '',  'trim');

      $this->form_validation->set_rules('txtPhone',      '',  'trim');
      $this->form_validation->set_rules('txtCell',       '',  'trim');

//      $this->form_validation->set_rules('rdoGender',      '',  'trim');
      $this->form_validation->set_rules('txtBDate',       '',  'trim|callback_peopleRecVerifyBDateValid'
                                                                 .'|callback_peopleRecVerifyBDatePast');
      $this->form_validation->set_rules('txtEmail',   'Email',  'trim|required|valid_email|callback_verifyUniqueAcct['.$lAcctID.']');
      $this->form_validation->set_rules('rdoACO',     '',  'trim');
      $this->form_validation->set_rules('ddlAttrib',  'Attributed to');

      if ($bNew){
         $this->form_validation->set_rules('txtPWord1',       'Password',          'trim|required');
         $this->form_validation->set_rules('txtPWord2',       'Password (again)',  'trim|required|callback_verifyPWordMatch');
      }

      if ($this->form_validation->run() == FALSE){
         $displayData['js'] = '';
         $this->load->library('generic_form');
         $this->load->model  ('util/mlist_generic',     'clsList');
         $this->clsList->enumListType = CENUM_LISTTYPE_ATTRIB;

         if (validation_errors()==''){
            if (!isset($vRec->mdteBirthDate)) $vRec->mdteBirthDate = null;
            if (is_null($vRec->mdteBirthDate)){
               $displayData['formData']->txtBDate = '';
            }else {
               $displayData['formData']->txtBDate = strNumericDateViaMysqlDate($vRec->mdteBirthDate, $gbDateFormatUS);
            }

            if ($bNew){
               $displayData['formData']->strBDay     =
               $displayData['formData']->txtTitle    =
               $displayData['formData']->txtFName    =
               $displayData['formData']->txtMName    =
               $displayData['formData']->txtLName    =
               $displayData['formData']->txtPName    =
               $displayData['formData']->txtSal      =
               $displayData['formData']->txtNotes    =

               $displayData['formData']->txtEmail    =
               $displayData['formData']->txtCell     = '';

//               $displayData['formData']->dteMysqlBirthDate = '';

               $displayData['formData']->txtAddr1    =
               $displayData['formData']->txtAddr2    =
               $displayData['formData']->txtCity     =
               $displayData['formData']->txtState    =
               $displayData['formData']->txtZip      =
               $displayData['formData']->txtCountry  =
               $displayData['formData']->txtPhone    = '';

               $displayData['strAttribDDL']          = $this->clsList->strLoadListDDL($glChapterID, 'ddlAttrib', true, -1);

               $displayData['formData']->txtPWord1   =
               $displayData['formData']->txtPWord2   =
               $displayData['formData']->txtAcct     = '';
            }else {
               $displayData['formData']->strBDay     = htmlspecialchars($vRec->mdteBirthDate);
               $displayData['formData']->txtTitle    = htmlspecialchars($vRec->strTitle);
               $displayData['formData']->txtFName    = htmlspecialchars($vRec->strFName);
               $displayData['formData']->txtMName    = htmlspecialchars($vRec->strMName);
               $displayData['formData']->txtLName    = htmlspecialchars($vRec->strLName);
               $displayData['formData']->txtPName    = htmlspecialchars($vRec->strPreferred);
               $displayData['formData']->txtNotes    = htmlspecialchars($vRec->strNotes);

               $displayData['formData']->txtEmail    =  htmlspecialchars($vRec->strEmail);
               $displayData['formData']->txtCell     =  htmlspecialchars($vRec->strCell);
               $displayData['formData']->txtPhone    =  htmlspecialchars($vRec->strPhone);

               $displayData['formData']->txtAddr1    =  htmlspecialchars($vRec->strAddr1);
               $displayData['formData']->txtAddr2    =  htmlspecialchars($vRec->strAddr2);
               $displayData['formData']->txtCity     =  htmlspecialchars($vRec->strCity);
               $displayData['formData']->txtState    =  htmlspecialchars($vRec->strState);
               $displayData['formData']->txtZip      =  htmlspecialchars($vRec->strZip);
               $displayData['formData']->txtCountry  =  htmlspecialchars($vRec->strCountry);

               $displayData['strAttribDDL']          = $this->clsList->strLoadListDDL($glChapterID, 'ddlAttrib', true, $vRec->lAttributedTo);

            }
         }else {
            setOnFormError($displayData);
            $displayData['formData']->txtTitle          = set_value('txtTitle');
            $displayData['formData']->txtFName          = set_value('txtFName');
            $displayData['formData']->txtMName          = set_value('txtMName');
            $displayData['formData']->txtLName          = set_value('txtLName');
            $displayData['formData']->txtPName          = set_value('txtPName');
            $displayData['formData']->txtSal            = set_value('txtSal');
            $displayData['formData']->txtNotes          = set_value('txtNotes');

            $displayData['formData']->txtAddr1          = set_value('txtAddr1');
            $displayData['formData']->txtAddr2          = set_value('txtAddr2');
            $displayData['formData']->txtCity           = set_value('txtCity');
            $displayData['formData']->txtState          = set_value('txtState');
            $displayData['formData']->txtZip            = set_value('txtZip');
            $displayData['formData']->txtCountry        = set_value('txtCountry');

            $displayData['formData']->txtEmail          = set_value('txtEmail');
            $displayData['formData']->txtPhone          = set_value('txtPhone');
            $displayData['formData']->txtCell           = set_value('txtCell');

//            $displayData['formData']->enumGender        = set_value('rdoGender');
            $displayData['formData']->txtBDate          = set_value('txtBDate');

            $displayData['strAttribDDL']                = $this->clsList->strLoadListDDL($glChapterID, 'ddlAttrib', true, set_value('ddlAttrib'));

            $displayData['formData']->txtPWord1   = set_value('txtPWord1');
            $displayData['formData']->txtPWord2   = set_value('txtPWord2');
            $displayData['formData']->txtAcct     = set_value('txtAcct');

         }

            //--------------------------
            // breadcrumbs
            //--------------------------
         $displayData['pageTitle']  = ($bNew ? 'Add New' : 'Update').' Volunteer Record';

         $displayData['title']          = CS_PROGNAME.' | Volunteers';
         $displayData['nav']            = $this->mnav_brain_jar->navData();

         $displayData['mainTemplate']   = 'hospice/vols/vol_add_edit_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $this->load->model('admin/mpermissions',                  'perms');
         $this->load->model('admin/muser_accts',                   'cusers');
         $this->load->helper('dl_util/util_db');

         $vRec->strTitle         = trim($_POST['txtTitle']);

         $vRec->strFName         = trim($_POST['txtFName']);
         $vRec->strMName         = trim($_POST['txtMName']);
         $vRec->strLName         = trim($_POST['txtLName']);
         $vRec->strPreferredName = trim($_POST['txtPName']);
         $vRec->strNotes         = trim($_POST['txtNotes']);
         if ($vRec->strPreferredName == '') $vRec->strPreferredName = $vRec->strFName;

         $vRec->strAddr1        = trim($_POST['txtAddr1']);
         $vRec->strAddr2        = trim($_POST['txtAddr2']);
         $vRec->strCity         = trim($_POST['txtCity']);
         $vRec->strState        = trim($_POST['txtState']);
         $vRec->strZip          = trim($_POST['txtZip']);
         $vRec->strCountry      = trim($_POST['txtCountry']);

         $vRec->strEmail        = trim($_POST['txtEmail']);
         $vRec->strPhone        = trim($_POST['txtPhone']);
         $vRec->strCell         = trim($_POST['txtCell']);
//         $vRec->enumGender      = trim($_POST['rdoGender']);

         $lAttrib = (integer)$_REQUEST['ddlAttrib'];
         if ($lAttrib <= 0){
            $vRec->lAttributedTo = null;
         }else {
            $vRec->lAttributedTo = $lAttrib;
         }

         $strBDate   = trim($_POST['txtBDate']);
         if ($strBDate==''){
            $vRec->dteMysqlBirthDate = null;
         }else {
            MDY_ViaUserForm($strBDate, $lMon, $lDay, $lYear, $gbDateFormatUS);
            $vRec->dteMysqlBirthDate = strMoDaYr2MySQLDate($lMon, $lDay, $lYear);
         }

         if ($bNew){
            $lVolID = $this->cVol->lAddNewVolunteer();
            $this->addVolAcct($lVolID, $vRec);
         }else {
            $this->cVol->updateVolunteerRec($lVolID);
            $this->cusers->updateUserNameViaID($lAcctID, $vRec->strEmail);
         }

         $this->session->set_flashdata('msg', 'The volunteer record was '.($bNew ? 'added' : 'updated'));
         redirect('hospice/vols/vol_record/viewRec/'.$lVolID);
      }
   }

   function addVolAcct($lVolID, $vRec){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;

         // add volunteer log-in
      $this->cusers->loadSingleUserRecord(-1);
      $uRec = &$this->cusers->userRec[0];
      $uRec->us_strUserPWord = trim($_POST['txtPWord1']);

      $uRec->us_bAdmin               =
      $uRec->bUserVolManager         =
      $uRec->bSuperUser              = false;

      $uRec->bVolAccount             =
      $uRec->bVolEditContact         =
      $uRec->bVolPassReset           = true;

      $uRec->lChapterID              = $glChapterID;

      $uRec->us_strNotes             = 'Auto-created as part of volunteer record';

      $uRec->us_strUserName          =
      $uRec->us_strEmail             = $vRec->strEmail;
      $uRec->us_strFirstName         = $vRec->strFName;
      $uRec->us_strLastName          = $vRec->strLName;
      $uRec->us_strTitle             = $vRec->strTitle;
      $uRec->us_strPhone             = $vRec->strPhone;
      $uRec->us_strCell              = $vRec->strCell;
      $uRec->us_strAddr1             = $vRec->strAddr1;
      $uRec->us_strAddr2             = $vRec->strAddr2;
      $uRec->us_strCity              = $vRec->strCity;
      $uRec->us_strState             = $vRec->strState;
      $uRec->us_strCountry           = $vRec->strCountry;
      $uRec->us_strZip               = $vRec->strZip;
      $uRec->us_enumDateFormat       = 'm/d/Y';
      $uRec->us_enumMeasurePref      = 'English';

      $uRec->lVolID                  = $lVolID;

      $this->cusers->addUserAccount();
   }

   function verifyUniqueAcct($strUserName, $lVolID){
      $id = (int)$lVolID;
      $strUserName = xss_clean(trim($strUserName));
      $this->load->model('util/mverify_unique', 'clsUnique');
      if (!$this->clsUnique->bVerifyUniqueText(
                $strUserName, 'us_strUserName',
                $id,   'us_lKeyID',
                true,  'us_bInactive',
                false, null, null,
                false, null, null,
                'admin_users')){
         $this->form_validation->set_message('verifyUniqueAcct',
                        'This <b>email address / volunteer log-in</b> is already being used.');
         return(false);
      }else {
         return(true);
      }
   }

   function peopleRecVerifyBDateValid($strBDate){
      if ($strBDate=='') return(true);
      return(bValidVerifyDate($strBDate));
   }

   function peopleRecVerifyBDatePast($strBDate){
      if ($strBDate=='') return(true);
      return(bValidVerifyNotFuture($strBDate));
   }

   function verifyPWordMatch($strPWord2){
      $strPWord1 = trim($_POST['txtPWord1']);
      if ($strPWord1==$strPWord2){
         return(true);
      }else {
         $this->form_validation->set_message('verifyPWordMatch',
                        'These <b>passwords</b> did not match.');
         return(false);
      }
   }


}