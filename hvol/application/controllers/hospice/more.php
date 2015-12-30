<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class more extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function help(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbSuperUser, $gbVolMgr, $gbVolLogin, $glChapterID;
      
         //-------------------------------------
         // models / helpers / libraries
         //-------------------------------------
      $this->load->model  ('admin/mpermissions', 'perms');
      $this->load->model  ('admin/muser_accts',  'cusers');
      $this->load->model  ('admin/mlocations',   'cLoc');
      $this->load->helper ('dl_util/web_layout');
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);
      
      $displayData['versionInfo'] = null;
      if ($gbSuperUser){
//         $displayData['strDBVersion'] = $this->cusers->strLoadDBLevel();
         $this->cusers->versionLevel();
         $displayData['versionInfo'] = &$this->cusers->versionInfo;
      }elseif ($gbVolMgr){
         $this->cusers->loadSuperUsers($lNumSU, $displayData['superUsers']);
      }else {
         $this->cusers->loadVolMgrsViaLoc($glChapterID, $lNumVM, $displayData['volMgrs']);
      }
      
      if ($gbVolMgr || $gbVolLogin){
         $this->cLoc->loadLocationViaChapterID($glChapterID, $lNumLocs, $locations);
         $displayData['location'] = &$locations[0];
      }else {
         $displayData['location'] = null;
      }      
            //--------------------------
            // breadcrumbs
            //--------------------------
      $displayData['pageTitle']      = 'Help';

      $displayData['title']          = CS_PROGNAME.' | Help';
      $displayData['nav']            = $this->mnav_brain_jar->navData();

      $displayData['mainTemplate']   = 'hospice/help_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }

}
