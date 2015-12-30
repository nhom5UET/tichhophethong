<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class visit_review extends CI_Controller {

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
      $displayData['mainTemplate'] = 'hospice/reports/visit_review_options_view';
      $displayData['pageTitle']    = 'Visit Review Options';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function runVisitReview(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lYear = (int)$_POST['ddlYear'];
      redirect('hospice/reports/visit_review/runVisitReviewViaYear/'.$lYear);
   }

   function runVisitReviewViaYear($lYear){
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
      $sqlWhere = " AND pv_lChapterID=$glChapterID AND YEAR(pv_dteVisit)=$lYear ";
      $displayData['yearly'] = new stdClass;
      $yearly = &$displayData['yearly'];
      $displayData['lNumYearlyPV'] = $yearly->lNumVisits = $this->cHRpt->lNumPatientVisits($sqlWhere);
      $this->cHRpt->hrsPatientVisits($sqlWhere, $yearly->sngHrsMins);
      $this->cHRpt->countPersonServed($sqlWhere, $yearly->lPatientServed, $yearly->lCaregiverServed,
                                     $yearly->lBereavedServed, $yearly->lOtherServed);
      $this->cHRpt->pVisitActivityByActivity($sqlWhere, $yearly->lNumActivities, $yearly->activities);
      $this->cHRpt->countInterventions($sqlWhere, $yearly->interventions);

         // monthly stats
      $displayData['visitMonth'] = array();
      for ($idx=1; $idx<=12; ++$idx){
         $sqlWhereMo = $sqlWhere." AND MONTH(pv_dteVisit)=$idx ";
         $displayData['visitMonth'][$idx] = new stdClass;
         $vMo = &$displayData['visitMonth'][$idx];

         $vMo->lNumVisits = $this->cHRpt->lNumPatientVisits($sqlWhereMo);
         $this->cHRpt->hrsPatientVisits($sqlWhereMo, $vMo->sngHrsMins);
         $this->cHRpt->countPersonServed($sqlWhereMo, $vMo->lPatientServed, $vMo->lCaregiverServed,
                                     $vMo->lBereavedServed, $vMo->lOtherServed);
         $this->cHRpt->pVisitActivityByActivity($sqlWhereMo, $vMo->lNumActivities, $vMo->activities);
         $this->cHRpt->countInterventions($sqlWhereMo, $vMo->interventions);

      }

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/pvisit_review_view';
      $displayData['pageTitle']    =
                    anchor('hospice/reports/visit_review/opts', 'Patient Visit Review / Report Options', 'class="breadcrumb"')
                  .' | Report';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }



}