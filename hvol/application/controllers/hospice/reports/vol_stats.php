<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class vol_stats extends CI_Controller {

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
      $this->load->helper ('dl_util/web_layout');

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/vol_stats_options_view';
      $displayData['pageTitle']    = 'Volunteer Stats / Options';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function runVolStats(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lYear = (int)$_POST['ddlYear'];
      redirect('hospice/reports/vol_stats/runVolStatsViaYear/'.$lYear);
   }

   function runVolStatsViaYear($lYear){
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
      $this->load->model('hospice/mhospice_pvisit',  'cPVisit');
      $this->load->model('hospice/mhospice_reports', 'cHRpt');
      $this->load->model('vols/mvol',                'cVol');
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
      $sqlWhereNewVol      = " AND vol_lChapterID = $glChapterID AND YEAR(vol_dteOrigin)       = $lYear ";
      $sqlWhereInactiveVol = " AND vol_lChapterID = $glChapterID AND YEAR(vol_dteInactive)     = $lYear ";
      $sqlWherePVisit      = " AND pv_lChapterID  = $glChapterID AND YEAR(pv_dteVisit)         = $lYear ";
      $sqlWhereOtherAct    = " AND vsa_lChapterID = $glChapterID AND YEAR(vsa_dteActivityDate) = $lYear ";
      $sqlWhereVolTraining = " AND vt_lChapterID  = $glChapterID AND YEAR(vt_dteDate)          = $lYear ";
      
      $displayData['yearStats'] = new stdClass;
      $displayData['yearStats']->lNewVols      = $this->cVol->lNumVols('active',   $sqlWhereNewVol);
      $displayData['yearStats']->lInactiveVols = $this->cVol->lNumVols('inactive', $sqlWhereInactiveVol);
      $this->cHRpt->hrsPatientVisits($sqlWherePVisit,      $displayData['yearStats']->sngPVisitHrs);
      $this->cHRpt->hrsVolNonPatient($sqlWhereOtherAct,    $displayData['yearStats']->sngNonPVHrs);
      $this->cHRpt->hrsVolTraining  ($sqlWhereVolTraining, $displayData['yearStats']->sngVolTrainingHrs, $displayData['yearStats']->lNumTrainingSessions);

         // monthly stats
      $displayData['volMonth'] = array();
      for ($idx=1; $idx<=12; ++$idx){
         $displayData['volMonth'][$idx] = new stdClass;
         $vMo = &$displayData['volMonth'][$idx];
         $vMo->lNewVols      = $this->cVol->lNumVols('active',   $sqlWhereNewVol." AND MONTH(vol_dteOrigin)=$idx");
         $vMo->lInactiveVols = $this->cVol->lNumVols('inactive', $sqlWhereInactiveVol." AND MONTH(vol_dteInactive)=$idx");
         $this->cHRpt->hrsPatientVisits($sqlWherePVisit  ." AND MONTH(pv_dteVisit)=$idx",          $vMo->sngPVisitHrs);
         $this->cHRpt->hrsVolNonPatient($sqlWhereOtherAct." AND MONTH(vsa_dteActivityDate)=$idx ", $vMo->sngNonPVHrs);
         $this->cHRpt->hrsVolTraining  ($sqlWhereVolTraining." AND MONTH(vt_dteDate)=$idx ", $vMo->sngVolTrainingHrs, $vMo->lNumTrainingSessions);
      }
      
         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/vol_stats_view';
      $displayData['pageTitle']    =
                    anchor('hospice/reports/vol_stats/opts', 'Volunteer Stats / Options', 'class="breadcrumb"')
                  .' | Report';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');

   }
}