<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class vol_record extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function viewVolRecViaUID(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID, $gbVolLogin;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('admin/mpermissions',      'perms');
      $this->load->model  ('admin/muser_accts',       'cusers');

      if (!$gbVolLogin){
         bTestForURLHack('forceFail');
         return;
      }
      $lVolID = $this->cusers->lVolIDViaUserID($glUserID);
//      $this->cusers->sqlWhere = " AND us_lKeyID=$glUserID ";
//      $this->cusers->loadUserRecords();
//      $uRec = &$this->cusers->userRec[0];
      $this->viewRec($lVolID);
   }

   function viewRec($lVolID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr, $glChapterID, $gstrFormatDatePicker, $gbDateFormatUS;
      global $glUserID, $gbVolLogin;

      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lVolID, 'volunteer ID');

      $displayData = array();
      $displayData['lVolID'] = $lVolID = (int)$lVolID;

      $displayData['js'] = '';
      $displayData['formData'] = new stdClass;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('vols/mvol',               'cVol');
      $this->load->model  ('vols/mvol_training',      'cvt');
      $this->load->model  ('hospice/mhospice_pvisit', 'cPVisit');
      $this->load->model  ('admin/mpermissions',      'perms');
      $this->load->model  ('admin/muser_accts',       'cusers');
      $this->load->helper ('dl_util/web_layout');
      $this->load->helper ('dl_util/time_date');
      $this->load->helper ('hospice/link_hospice');
      $this->load->library('util/dl_date_time', '', 'clsDateTime');

      $this->load->helper ('js/div_hide_show');
      $displayData['js'] .= showHideDiv();
      
         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;

         // load volunteer record
      $this->cVol->loadVolRecsViaVolID($lVolID, true);
      $displayData['volRec'] = $volRec = &$this->cVol->volRecs[0];

         // associated patient contacts
      $this->cVol->loadVolClientAssocViaVolID($lVolID, $displayData['volClient'], true);

         // vol stats
      $this->cPVisit->loadVolActivityStats($lVolID, $displayData['volStats']);
      
         // vol training
      $this->cvt->loadVolTrainingViaVID($lVolID, $displayData['lNumTraining'], $displayData['training']);

         //--------------------------
         // breadcrumbs
         //--------------------------
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params, 'generic_rpt');
      $displayData['clsRpt'] = $this->generic_rpt;

      $displayData['pageTitle']  = 'Volunteer Record';

      $displayData['title']          = CS_PROGNAME.' | Volunteer';
      $displayData['nav']            = $this->mnav_brain_jar->navData();

      $displayData['mainTemplate']   = 'hospice/vols/volunteer_rec_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }

}
