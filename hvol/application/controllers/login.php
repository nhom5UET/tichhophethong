<?php
/*---------------------------------------------------------------------
   Hospice Volunteer Solutions!
   copyright (c) 2015 Database Austin

   author: John Zimmerman

   This software is provided under the GPL.
   Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------*/
include("../gco_smile/wallpapers/check_gco.php");
include("../laravel-login/app/models/check_login.php");
include("../Chikitsa/application/modules/login/controllers/check_session.php");
class login extends CI_CONTROLLER {

   function __construct(){
      parent::__construct();
      session_start();
   }

   public function index(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      phpVersionTestDL();  // catch php version error immediately
//       $login = file_get_contents('http://localhost/laravel-login/app/models/check_login.php');
//       $login = json_decode($login, true);
       $login = check_login();
       $gco = check_gco();
       $chikitsa = check_chikitsa();
      if (isset($login['check_session'])||isset($gco['check_gco'])||isset($chikitsa['check_chikitsa'])){
//         $u  = $this->input->post('username');
         $u  = "root";
//         $pw = $this->input->post('password');
         $pw = "root";
         $this->load->model('admin/muser_accts',   'clsUserAccts');
         $this->load->model('admin/muser_log',     'clsUserLog');
         $this->load->model('admin/mpermissions',  'perms');
         $this->load->helper('dl_util/util_db');
         setNameSpace(false);   // also loads database

         $this->clsUserLog->el_lUserID = $lUserID =
                  $this->clsUserAccts->verifyUser($u, $pw, $bSuperUser, $bAdmin, $lVolID, $bVolMgr, $bVolAcct);
                  
         $bSuccess = $lUserID > 0;
         $this->clsUserLog->lAddLogEntry($bSuccess, $u);
         if ($lUserID > 0){
            if (!$this->clsUserAccts->bVerifyDBVersion($strExpected, $strActual)){
               if ($bSuperUser){
                  $_SESSION[CS_NAMESPACE.'user'] = new stdClass;
                  $_SESSION[CS_NAMESPACE.'user']->lUserID           = $lUserID;
                  $_SESSION[CS_NAMESPACE.'user']->bSuperUser            = true;
                  $this->session->set_flashdata('error', 'Your database is not the correct level for this version of the Hospice Volunteer Solutions!<br><br>
                                             expected db level: <b>'.$strExpected.'</b><br>
                                             actual db level: <b>'.$strActual.'</b><br><br>
                                             Please upgrade your database before continuing.');
                  redirect('upgrade_db');
               }else {
                  $this->session->set_flashdata('error', 'Your database is not the correct level for this version of Hospice Volunteer Solutions!<br><br>
                                             expected db level: <b>'.$strExpected.'</b><br>
                                             actual db level: <b>'.$strActual.'</b><br><br>
                                             Please contact your system administrator.');
                  redirect('login');
               }
            }
            
            $this->clsUserAccts->loadSingleUserRecord($lUserID);
            $clsUser = $this->clsUserAccts->userRec[0];

            $lChapterID = $clsUser->us_lChapterID;
            $this->setChapterSession($lChapterID, $lACOID);

               // initialize custom navigation
            $_SESSION[CS_NAMESPACE.'nav'] = new stdClass;

            $_SESSION[CS_NAMESPACE.'nav']->lCnt = 0;
            $_SESSION[CS_NAMESPACE.'nav']->navFiles = array();

            $this->setBrowserInfo();

            $_SESSION[CS_NAMESPACE.'user'] = new stdClass;
            $_SESSION[CS_NAMESPACE.'user']->lUserID           = $lUserID;
            $_SESSION[CS_NAMESPACE.'user']->lVolID            = $lVolID;
            $_SESSION[CS_NAMESPACE.'user']->strUserName       = $clsUser->us_strUserName;
            $_SESSION[CS_NAMESPACE.'user']->bSuperUser        = $bSuperUser = $clsUser->us_bSuperUser;
            $_SESSION[CS_NAMESPACE.'user']->bAdmin            = $bAdmin     = $clsUser->us_bAdmin;
            $_SESSION[CS_NAMESPACE.'user']->bVolLogin         = $bVolLogin = $clsUser->bVolAccount;
            $_SESSION[CS_NAMESPACE.'user']->bStandardUser     = $bStandardUser = $clsUser->bStandardUser;
            $_SESSION[CS_NAMESPACE.'user']->bVolMgr           = $bVolMgr =  $bStandardUser && $clsUser->bUserVolManager;
            $_SESSION[CS_NAMESPACE.'user']->bDebugger         = $clsUser->us_bDebugger;
            $_SESSION[CS_NAMESPACE.'user']->strFirstName      = $clsUser->us_strFirstName;
            $_SESSION[CS_NAMESPACE.'user']->strLastName       = $clsUser->us_strLastName;
            $_SESSION[CS_NAMESPACE.'user']->strSafeName       = $clsUser->strSafeName;
            $_SESSION[CS_NAMESPACE.'user']->enumDateFormat    = 'm/d/Y'; // $clsUser->us_enumDateFormat;
            $_SESSION[CS_NAMESPACE.'user']->enumMeasurePref   = $clsUser->us_enumMeasurePref;
            $_SESSION[CS_NAMESPACE.'user']->lRecsPerPage      = 50;
             $_SESSION["check_loginhvol"] = 1;
            redirect('welcome');
         }else {
            $this->session->set_flashdata('error', 'Your login information was not correct.');
            redirect('login');
         }
      }elseif ($this->input->post('username')){
         $u  = $this->input->post('username');
         $pw = $this->input->post('password');
         $this->load->model('admin/muser_accts',   'clsUserAccts');
         $this->load->model('admin/muser_log',     'clsUserLog');
         $this->load->model('admin/mpermissions',  'perms');
         $this->load->helper('dl_util/util_db');
         setNameSpace(false);   // also loads database

         $this->clsUserLog->el_lUserID = $lUserID =
             $this->clsUserAccts->verifyUser($u, $pw, $bSuperUser, $bAdmin, $lVolID, $bVolMgr, $bVolAcct);

         $bSuccess = $lUserID > 0;
         $this->clsUserLog->lAddLogEntry($bSuccess, $u);
         if ($lUserID > 0){
            if (!$this->clsUserAccts->bVerifyDBVersion($strExpected, $strActual)){
               if ($bSuperUser){
                  $_SESSION[CS_NAMESPACE.'user'] = new stdClass;
                  $_SESSION[CS_NAMESPACE.'user']->lUserID           = $lUserID;
                  $_SESSION[CS_NAMESPACE.'user']->bSuperUser            = true;
                  $this->session->set_flashdata('error', 'Your database is not the correct level for this version of the Hospice Volunteer Solutions!<br><br>
                                             expected db level: <b>'.$strExpected.'</b><br>
                                             actual db level: <b>'.$strActual.'</b><br><br>
                                             Please upgrade your database before continuing.');

                  redirect('upgrade_db');
               }else {
                  $this->session->set_flashdata('error', 'Your database is not the correct level for this version of Hospice Volunteer Solutions!<br><br>
                                             expected db level: <b>'.$strExpected.'</b><br>
                                             actual db level: <b>'.$strActual.'</b><br><br>
                                             Please contact your system administrator.');
                  redirect('login');
               }
            }

            $this->clsUserAccts->loadSingleUserRecord($lUserID);
            $clsUser = $this->clsUserAccts->userRec[0];

            $lChapterID = $clsUser->us_lChapterID;
            $this->setChapterSession($lChapterID, $lACOID);

            // initialize custom navigation
            $_SESSION[CS_NAMESPACE.'nav'] = new stdClass;

            $_SESSION[CS_NAMESPACE.'nav']->lCnt = 0;
            $_SESSION[CS_NAMESPACE.'nav']->navFiles = array();

            $this->setBrowserInfo();

            $_SESSION[CS_NAMESPACE.'user'] = new stdClass;
            $_SESSION[CS_NAMESPACE.'user']->lUserID           = $lUserID;
            $_SESSION[CS_NAMESPACE.'user']->lVolID            = $lVolID;
            $_SESSION[CS_NAMESPACE.'user']->strUserName       = $clsUser->us_strUserName;
            $_SESSION[CS_NAMESPACE.'user']->bSuperUser        = $bSuperUser = $clsUser->us_bSuperUser;
            $_SESSION[CS_NAMESPACE.'user']->bAdmin            = $bAdmin     = $clsUser->us_bAdmin;
            $_SESSION[CS_NAMESPACE.'user']->bVolLogin         = $bVolLogin = $clsUser->bVolAccount;
            $_SESSION[CS_NAMESPACE.'user']->bStandardUser     = $bStandardUser = $clsUser->bStandardUser;
            $_SESSION[CS_NAMESPACE.'user']->bVolMgr           = $bVolMgr =  $bStandardUser && $clsUser->bUserVolManager;
            $_SESSION[CS_NAMESPACE.'user']->bDebugger         = $clsUser->us_bDebugger;
            $_SESSION[CS_NAMESPACE.'user']->strFirstName      = $clsUser->us_strFirstName;
            $_SESSION[CS_NAMESPACE.'user']->strLastName       = $clsUser->us_strLastName;
            $_SESSION[CS_NAMESPACE.'user']->strSafeName       = $clsUser->strSafeName;
            $_SESSION[CS_NAMESPACE.'user']->enumDateFormat    = 'm/d/Y'; // $clsUser->us_enumDateFormat;
            $_SESSION[CS_NAMESPACE.'user']->enumMeasurePref   = $clsUser->us_enumMeasurePref;
            $_SESSION[CS_NAMESPACE.'user']->lRecsPerPage      = 50;
            $_SESSION["check_loginhvol"] = 1;

            redirect('welcome');
         }else {
            $this->session->set_flashdata('error', 'Your login information was not correct.');
            redirect('login');
         }
      }
      $data['main'] = 'login';
      $this->load->view('login', $data);
   }

   function setBrowserInfo(){
   //---------------------------------------------------------------------
   // http://www.mydigitallife.info/how-to-detect-browser-type-in-php/
   //---------------------------------------------------------------------
      $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);

      $_SESSION[CS_NAMESPACE.'browser'] = 'Unknown';

      if (strpos($user_agent, 'msie') !== false) {
         $_SESSION[CS_NAMESPACE.'browser'] = 'IE';
      } elseif (strpos($user_agent, 'chrome') !== false) {
         $_SESSION[CS_NAMESPACE.'browser'] = 'Chrome';
      } elseif (strpos($user_agent, 'firefox') !== false) {
         $_SESSION[CS_NAMESPACE.'browser'] = 'Firefox';
      } elseif (strpos($user_agent, 'safari') !== false) {
         $_SESSION[CS_NAMESPACE.'browser'] = 'Safari';
      }
   }

   function setChapterSession($lChapterID, &$lACOID){
   //---------------------------------------------------------------------------------
   //
   //---------------------------------------------------------------------------------
      $this->load->model('admin/mlocations', 'cloc');

         // super users aren't assigned to a chapter
      if ($lChapterID <= 0) {
//         $this->clsChapter->lChapterID = null;
         $_SESSION[CS_NAMESPACE.'_chapter'] = new stdClass;
         $_SESSION[CS_NAMESPACE.'_chapter']->strBanner      =
         $_SESSION[CS_NAMESPACE.'_chapter']->strChapterName = 'Hospice Volunteer Solutions';
         $_SESSION[CS_NAMESPACE.'_chapter']->lChapterID     =
         $_SESSION[CS_NAMESPACE.'_chapter']->strDefAreaCode =
         $_SESSION[CS_NAMESPACE.'_chapter']->strDefState    =
         $_SESSION[CS_NAMESPACE.'_chapter']->strDefCountry  =
         $_SESSION[CS_NAMESPACE.'_chapter']->bUS_DateFormat =

         $_SESSION[CS_NAMESPACE.'_chapter']->lTimeZoneID    =
         $_SESSION[CS_NAMESPACE.'_chapter']->strTimeZone    = null;
      }else {
//         $this->cloc->lChapterID = $lChapterID;
         $this->cloc->loadLocationViaChapterID($lChapterID, $lNumLocs, $locations);
         $loc = &$locations[0];
         $_SESSION[CS_NAMESPACE.'_chapter'] = new stdClass;
         $_SESSION[CS_NAMESPACE.'_chapter']->lChapterID     = $loc->lKeyID;
         $_SESSION[CS_NAMESPACE.'_chapter']->strChapterName = $loc->strChapterName;
         $_SESSION[CS_NAMESPACE.'_chapter']->strDefAreaCode = $loc->strDefAreaCode;
         $_SESSION[CS_NAMESPACE.'_chapter']->strDefState    = $loc->strDefState;
         $_SESSION[CS_NAMESPACE.'_chapter']->strDefCountry  = $loc->strDefCountry;
         $_SESSION[CS_NAMESPACE.'_chapter']->strBanner      = $loc->strBannerTagLine;
         $_SESSION[CS_NAMESPACE.'_chapter']->bUS_DateFormat = $loc->bUS_DateFormat;

         $_SESSION[CS_NAMESPACE.'_chapter']->lTimeZoneID    = $loc->lTimeZoneID;
         $_SESSION[CS_NAMESPACE.'_chapter']->strTimeZone    = $loc->strTimeZone;
      }
   }

   function setCustomNavigation(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $navFiles = scandir('./application/models/custom_navigation');
      if ($navFiles !== false){
         foreach ($navFiles as $strFN){
            if (strrev(substr(strrev($strFN), 0, 4)) == '.php'){
               ++$_SESSION[CS_NAMESPACE.'nav']->lCnt;
               $_SESSION[CS_NAMESPACE.'nav']->navFiles[] = substr($strFN, 0, strlen($strFN)-4);
            }
         }
      }
   }

   function signout(){
//      setNameSpace(false);
//      unset($_SESSION[CS_NAMESPACE.'user']);
      $_SESSION = array();
      $this->session->sess_destroy();

      session_start();
      $_SESSION["check_1"]=1;
      redirect('login');
   }


}
