<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_acct extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function verifyPWordsMatch($strPWord2){
      $strPWord1 =  trim($_POST['txtPWord1']);
      return($strPWord1==$strPWord2);
   }

   function pw($lAcctID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID, $glChapterID, $gbVolLogin, $gbVolMgr, $gbSuperUser;

         /*
            3 types of password changes
            acct           limits                   requires current pword?
            ======         ======                   =======================
            Super User     - none -                 no

            Vol Mgr        own password             yes
                           any vol at location      no

            Volunteer      own password             yes
         */

      $this->load->helper('dl_util/verify_id');
      verifyID(null, $lAcctID, 'user ID');

      $displayData = array();
      $displayData['lAcctID'] = $lAcctID = (int)$lAcctID;

      $displayData['bRequireCurrent'] = true;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model('admin/mpermissions', 'perms');
      $this->load->model('admin/muser_accts', 'cusers');
      $this->load->helper('dl_util/web_layout');
      $this->load->library('generic_form');

         // load user record
      $this->cusers->loadSingleUserRecord($lAcctID);
      $displayData['uRec'] = $uRec = &$this->cusers->userRec[0];

      if ($gbSuperUser){
         $displayData['bRequireCurrent'] = false;
      }elseif ($gbVolMgr){
         if ($glUserID != $lAcctID){
            $displayData['bRequireCurrent'] = false;
            if (!(($uRec->us_lChapterID == $glChapterID) && $uRec->bVolAccount)){
               verifyID(-999, $lAcctID, 'user ID');
            }
         }
      }elseif ($glUserID != $lAcctID){
         verifyID(-999, $lAcctID, 'user ID');
      }

      if ($uRec->us_bSuperUser){
         $displayData['strAcctType'] = 'Super User';
      }elseif ($uRec->bUserVolManager){
         $displayData['strAcctType'] = 'Volunteer Manager';
      }else {
         $displayData['strAcctType'] = 'Volunteer';
      }

      $bRequireCurrent = $displayData['bRequireCurrent'];


         //--------------------------
         // validation rules
         //--------------------------
      $this->form_validation->set_error_delimiters('<div class="formError">', '</div>');
      if ($bRequireCurrent){
         $this->form_validation->set_rules('txtPWord',  'Current Password',   'trim|required|callback_verifyGoodPW['.$lAcctID.']');
      }
      $this->form_validation->set_rules('txtPWord1', 'Password',           'trim|required|callback_verifyPWordMatch');
      $this->form_validation->set_rules('txtPWord2', 'Password (again)',   'trim');

      if ($this->form_validation->run() == FALSE){
         if (validation_errors()==''){
         }else {
            setOnFormError($displayData);
         }

            //--------------------------
            // breadcrumbs
            //--------------------------
         if ($gbVolLogin){
            $displayData['pageTitle']    = 'Change Password';
         }else {
            $displayData['pageTitle']    = 'Change Password';
         }

         $displayData['title']          = CS_PROGNAME.' | More';
         $displayData['nav']            = $this->mnav_brain_jar->navData();

         $displayData['mainTemplate']   = 'more/change_password_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $strPWord = trim($_POST['txtPWord1']);
         $this->cusers->changePWord($lAcctID, $strPWord);
         $this->session->set_flashdata('msg', 'Your password was changed.');

         if ($gbSuperUser){
            redirect('hospice/super/accounts/superVolMgr');
         }elseif ($gbVolLogin){
            redirect('more/user_acct/pwChanged');
         }else {
            redirect('more/user_acct/pwChanged');
         }
      }
   }

   function verifyGoodPW($strPW, $lAcctID){
      $lAcctID = (int)$lAcctID;
      return($this->cusers->bPWValid($lAcctID, $strPW));
   }

   function verifyPWordMatch($strPW1){
      return($_POST['txtPWord1'] == $_POST['txtPWord2']);
   }
   
   function acctUpdated(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
         //--------------------------
         // breadcrumbs
         //--------------------------
      $displayData = array();
      $displayData['pageTitle']    = 'Contact info updated';

      $displayData['title']          = CS_PROGNAME.' | Contact';
      $displayData['nav']            = $this->mnav_brain_jar->navData();
      $displayData['mainTemplate']   = 'hospice/blank_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }


   function pwChanged(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
         //--------------------------
         // breadcrumbs
         //--------------------------
      $displayData = array();
      $displayData['pageTitle']    = 'Password Changed';

      $displayData['title']          = CS_PROGNAME.' | Password';
      $displayData['nav']            = $this->mnav_brain_jar->navData();
      $displayData['mainTemplate']   = 'hospice/blank_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }

}
