<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class account_rec extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }
   
   function addEditSuper(){
   //---------------------------------------------------------------------
   // 
   //---------------------------------------------------------------------   
      $this->addEditAcct(0, 'true');
   }
   
   function addEditVolMgr(){
   //---------------------------------------------------------------------
   // 
   //---------------------------------------------------------------------   
      $this->addEditAcct(0, 'false');
   }

   function addEditAcct($lAcctID, $bNewAsSuperUser='false'){
   //---------------------------------------------------------------------
   // only for super user and vol mgr accounts
   //---------------------------------------------------------------------
      global $gbDateFormatUS, $glChapterID, $glUserID, $gbVolMgr;
      
      $bVolMgrUpdate = $gbVolMgr && ($lAcctID==$glUserID);

      if (!$bVolMgrUpdate) {
         if (!bTestForURLHack('superUser')) return;
      }
      $this->load->helper('dl_util/verify_id');
      if ((int)$lAcctID > 0) verifyID($glChapterID, $lAcctID, 'user ID');
      
      $bNewAsSuperUser = $bNewAsSuperUser=='true';

      $displayData = array();
      $displayData['lAcctID'] = $lAcctID = (int)$lAcctID;
      $displayData['bNew']   = $bNew = $lAcctID <= 0;

      $displayData['js'] = '';
      $displayData['formData'] = new stdClass;
      $displayData['bShowLocDDL'] = false;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model('admin/mpermissions', 'perms');
      $this->load->model('admin/muser_accts',  'cusers');
      $this->load->helper ('dl_util/web_layout');
      $this->load->helper ('dl_util/time_date');
      $this->load->library('util/dl_date_time', '', 'clsDateTime');

         // load account record
      $this->cusers->loadSingleUserRecord($lAcctID);
      $displayData['uRec'] = $uRec = &$this->cusers->userRec[0];
      
      if ($bNew){
         $displayData['bSuperUser'] = $bSuperUser = $bNewAsSuperUser;
         
            // specify location for new volunteer manager
         if (!$bSuperUser){
            $this->load->model('admin/mlocations', 'cLoc');
            $this->cLoc->loadLocationInfo(' AND ch_bActive ', $lNumLocs, $lNumActive, $locations);
            $displayData['bShowLocDDL'] = true;
         }
      }else {
         $displayData['bSuperUser'] = $bSuperUser = $uRec->us_bSuperUser;
      }

         // validation rules
      $this->form_validation->set_error_delimiters('<div class="formError">', '</div>');
      $this->form_validation->set_rules('txtFName',     '<b>First Name</b>',  'trim|required');
      $this->form_validation->set_rules('txtLName',     '<b>Last Name</b>',   'trim|required');
      $this->form_validation->set_rules('txtUserName',  '<b>User Name</b>',   'trim|required|callback_verifyUniqueUserName['.$lAcctID.']');
      $this->form_validation->set_rules('txtNotes',     '',   'trim');

      $this->form_validation->set_rules('txtPhone',      'Phone',  'trim');
      $this->form_validation->set_rules('txtCell',       'Cell',   'trim');
      $this->form_validation->set_rules('txtEmail',      '<b>EMail</b>',  'trim|required|valid_email');
      
      if ($bNew && !$bSuperUser){
         $this->form_validation->set_rules('ddlLoc',  '<b>Location</b>', 'trim|required|callback_verifyDDLSelected');
      }

      $this->form_validation->set_rules('txtAddr1',      '', 'trim');
      $this->form_validation->set_rules('txtAddr2',      '', 'trim');
      $this->form_validation->set_rules('txtCity',       '', 'trim');
      $this->form_validation->set_rules('txtState',      '', 'trim');
      $this->form_validation->set_rules('txtZip',        '', 'trim');
      $this->form_validation->set_rules('txtCountry',    '', 'trim');
      $this->form_validation->set_rules('txtNotes',      '', 'trim');
      
      if ($bNew){
         $this->form_validation->set_rules('txtPWord1',       'Password',          'trim|required');
         $this->form_validation->set_rules('txtPWord2',       'Password (again)',  'trim|required|callback_verifyPWordMatch');
      }      

      if ($this->form_validation->run() == FALSE){
         $this->load->library('generic_form');

         if (validation_errors()==''){
            if ($bNew){
               if (!$bSuperUser) $displayData['strLocDDL'] = $this->strBuildLocDDL($locations, -1);

               $displayData['formData']->txtUserName = 
               $displayData['formData']->txtFName    = 
               $displayData['formData']->txtLName    = 

               $displayData['formData']->txtPhone    = 
               $displayData['formData']->txtCell     = 
               $displayData['formData']->txtEmail    = '';

               $displayData['formData']->txtAddr1    = 
               $displayData['formData']->txtAddr2    = 
               $displayData['formData']->txtCity     = 
               $displayData['formData']->txtState    = 
               $displayData['formData']->txtZip      = 
               $displayData['formData']->txtCountry  = 

               $displayData['formData']->txtNotes    = '';
            }else {
               $displayData['formData']->txtUserName = htmlspecialchars($uRec->us_strUserName);
               $displayData['formData']->txtFName    = htmlspecialchars($uRec->us_strFirstName);
               $displayData['formData']->txtLName    = htmlspecialchars($uRec->us_strLastName);

               $displayData['formData']->txtPhone    = htmlspecialchars($uRec->us_strPhone);
               $displayData['formData']->txtCell     = htmlspecialchars($uRec->us_strCell);
               $displayData['formData']->txtEmail    = htmlspecialchars($uRec->us_strEmail);

               $displayData['formData']->txtAddr1    = htmlspecialchars($uRec->us_strAddr1);
               $displayData['formData']->txtAddr2    = htmlspecialchars($uRec->us_strAddr2);
               $displayData['formData']->txtCity     = htmlspecialchars($uRec->us_strCity);
               $displayData['formData']->txtState    = htmlspecialchars($uRec->us_strState);
               $displayData['formData']->txtZip      = htmlspecialchars($uRec->us_strZip);
               $displayData['formData']->txtCountry  = htmlspecialchars($uRec->us_strCountry);

               $displayData['formData']->txtNotes    = htmlspecialchars($uRec->us_strNotes);
            }
         }else {
            setOnFormError($displayData);
            if ($bNew && !$bSuperUser) $displayData['strLocDDL'] = $this->strBuildLocDDL($locations, set_value('ddlLoc'));
            
            $displayData['formData']->txtUserName = set_value('txtUserName');
            $displayData['formData']->txtFName    = set_value('txtFName');
            $displayData['formData']->txtLName    = set_value('txtLName');

            $displayData['formData']->txtPhone    = set_value('txtPhone');
            $displayData['formData']->txtCell     = set_value('txtCell');
            $displayData['formData']->txtEmail    = set_value('txtEmail');

            $displayData['formData']->txtAddr1    = set_value('txtAddr1');
            $displayData['formData']->txtAddr2    = set_value('txtAddr2');
            $displayData['formData']->txtCity     = set_value('txtCity');
            $displayData['formData']->txtState    = set_value('txtState');
            $displayData['formData']->txtZip      = set_value('txtZip');
            $displayData['formData']->txtCountry  = set_value('txtCountry');

            $displayData['formData']->txtNotes    = set_value('txtNotes');
         }

            //--------------------------
            // breadcrumbs
            //--------------------------
         $params = array('enumStyle' => 'terse');
         $this->load->library('generic_rpt', $params, 'generic_rpt');

         $displayData['pageTitle']  = 'Account';

         $displayData['title']          = CS_PROGNAME.' | Account';
         $displayData['nav']            = $this->mnav_brain_jar->navData();

         $displayData['mainTemplate']   = 'hospice/super/acct_add_edit_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $uRec->us_strUserName    = $_POST['txtUserName'];
         $uRec->us_strFirstName   = $_POST['txtFName'];
         $uRec->us_strLastName    = $_POST['txtLName'];
        
         $uRec->us_strAddr1       = $_POST['txtAddr1'];
         $uRec->us_strAddr2       = $_POST['txtAddr2'];
         $uRec->us_strCity        = $_POST['txtCity'];
         $uRec->us_strState       = $_POST['txtState'];
         $uRec->us_strCountry     = $_POST['txtCountry'];
         $uRec->us_strZip         = $_POST['txtZip'];
         $uRec->us_strPhone       = $_POST['txtPhone'];
         $uRec->us_strCell        = $_POST['txtCell'];
         $uRec->us_strEmail       = $_POST['txtEmail'];
         $uRec->us_strNotes       = $_POST['txtNotes'];

         if ($bNew){
            $uRec->lVolID = null;
            $uRec->bSuperUser      = $bSuperUser;
            $uRec->bUserVolManager = !$bSuperUser;
            $uRec->bVolAccount     = false;
            if (!$bSuperUser) $uRec->lChapterID = (int)$_POST['ddlLoc'];
            $uRec->us_strUserPWord = trim($_POST['txtPWord1']);
            
            $lAcctID = $this->cusers->addUserAccount();
            $this->session->set_flashdata('msg', 'The new <b>'.($bSuperUser ? 'Super User' : 'Volunteer Manager').'</b> account was added.');
         }else {
            $uRec->us_lKeyID = $lAcctID;
            $uRec->us_strUserPWord = '';
            $this->cusers->updateUserAccount();
            $this->session->set_flashdata('msg', 'The account record was updated.');
         }
         if ($bVolMgrUpdate){
            redirect('more/user_acct/acctUpdated');
         }else {
            redirect('hospice/super/accounts/superVolMgr');
         }
      }
   }
   
   function strBuildLocDDL($locations, $lMatchID){
   //---------------------------------------------------------------------
   // 
   //---------------------------------------------------------------------
      $strOut =
      '<select name="ddlLoc">
         <option value="-1">&nbsp;</option>'."\n";
      foreach ($locations as $loc){
         $strSel = $loc->lKeyID == $lMatchID ? 'SELECTED' : '';
         $strOut .= '<option value="'.$loc->lKeyID.'" '.$strSel.'>'.$loc->strSafeLocationName.'</option>'."\n";
      }
      $strOut .= '</select>'."\n";
      return($strOut);
   }
   
   function verifyDDLSelected($strDummy){
      $id = (int)@$_POST['ddlLoc'];
      if ($id <= 0){
         $this->form_validation->set_message('verifyDDLSelected',
                        'Please select a <b>location</b>.');
         return(false);
      }else {
         return(true);
      }
   }
   
   function verifyUniqueUserName($strUserName, $lAcctID){
      $id = (int)$lAcctID;
      $strUserName = xss_clean(trim($strUserName));
      $this->load->model('util/mverify_unique', 'clsUnique');
      if (!$this->clsUnique->bVerifyUniqueText(
                $strUserName, 'us_strUserName',
                $id,   'us_lKeyID',
                false, null,
                false, null, null,
                false, null, null,
                'admin_users')){
         $this->form_validation->set_message('verifyUniqueUserName',
                        'This <b>User Name</b> is already being used.');
         return(false);
      }else {
         return(true);
      }
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