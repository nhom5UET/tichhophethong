<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class activity extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function opts(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gdteNow;

      if (!bTestForURLHack('volMgr')) return;
      $displayData = array();
      $displayData['js'] = '';

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->library('generic_form');
      $this->load->helper('dl_util/web_layout');

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/activity_options_view';
      $displayData['pageTitle']    = 'Volunteer Activity Report Options';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function runActivity(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lYear = (int)$_POST['ddlYear'];
      redirect('hospice/reports/activity/runActivityViaYear/'.$lYear);
   }

   function runActivityViaYear($lYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;

      if (!bTestForURLHack('volMgr')) return;
      $displayData = array();
      $displayData['js'] = '';
      $displayData['lYear'] = $lYear = (int)$lYear;

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->model('hospice/mhospice_pvisit', 'cPVisit');
      $this->load->model('hospice/mhospice_reports', 'cHRpt');
      $params = array('enumStyle' => 'enpRptC');
      $this->load->library('generic_rpt', $params);
      $this->load->helper('dl_util/web_layout');
      $this->load->helper('dl_util/time_date');
      
         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;      
      
      $this->load->helper ('js/div_hide_show');
      $displayData['js'] .= showHideDiv();

         // yearly stats
      $sqlWhere = " AND vsa_lChapterID=$glChapterID AND YEAR(vsa_dteActivityDate)=$lYear ";
      $this->cHRpt->volActivityByActivity($sqlWhere, $displayData['lNumAct'], $displayData['activities']);
      
         // monthly stats
      $displayData['actMonth'] = array();
      for ($idx=1; $idx<=12; ++$idx){
         $displayData['actMonth'][$idx] = new stdClass;
         $aMo = &$displayData['actMonth'][$idx];
         $strWhereMo = $sqlWhere." AND MONTH(vsa_dteActivityDate)=$idx ";
         $this->cHRpt->volActivityByActivity($strWhereMo, $aMo->lNumAct, $aMo->activities);
      }

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/activity_view';
      $displayData['pageTitle']    =
                    anchor('hospice/reports/activity/opts', 'Volunteer Activity Report Options', 'class="breadcrumb"')
                  .' | Report';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function optsJobCodes(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gdteNow;

      if (!bTestForURLHack('volMgr')) return;
      $displayData = array();
      $displayData['js'] = '';

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->library('generic_form');
      $this->load->helper('dl_util/web_layout');

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/job_codes_options_view';
      $displayData['pageTitle']    = 'Volunteer Activity / Job Codes Report Options';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function runJobCode(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lYear = (int)$_POST['ddlYear'];
      redirect('hospice/reports/activity/runJobCodeViaYear/'.$lYear);
   }

   function runJobCodeViaYear($lYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;

      if (!bTestForURLHack('volMgr')) return;
      $displayData = array();
      $displayData['js'] = '';
      $displayData['lYear'] = $lYear = (int)$lYear;

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->model('hospice/mhospice_pvisit', 'cPVisit');
      $this->load->model('hospice/mhospice_reports', 'cHRpt');
      $params = array('enumStyle' => 'enpRptC');
      $this->load->library('generic_rpt', $params);
      $this->load->helper('dl_util/web_layout');
      $this->load->helper('dl_util/time_date');
      
         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;      
      
      $this->load->helper ('js/div_hide_show');
      $displayData['js'] .= showHideDiv();

         // yearly stats
      $sqlWhere = " AND vsa_lChapterID=$glChapterID AND YEAR(vsa_dteActivityDate)=$lYear ";
      $this->cHRpt->volJobCodesByJobCode($sqlWhere, $displayData['lNumJC'], $displayData['jobCodes']);
      
         // monthly stats
      $displayData['jcMonth'] = array();
      for ($idx=1; $idx<=12; ++$idx){
         $displayData['jcMonth'][$idx] = new stdClass;
         $jcMo = &$displayData['jcMonth'][$idx];
         $strWhereMo = $sqlWhere." AND MONTH(vsa_dteActivityDate)=$idx ";
         $this->cHRpt->volJobCodesByJobCode($strWhereMo, $jcMo->lNumJC, $jcMo->jobCodes);
      }

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/job_code_view';
      $displayData['pageTitle']    =
                    anchor('hospice/reports/activity/optsJobCodes', 'Volunteer Activity Job Code Options', 'class="breadcrumb"')
                  .' | Report';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

}