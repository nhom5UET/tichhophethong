<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class monthly extends CI_Controller {

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
      $this->load->helper('dl_util/web_layout');
      $this->load->helper('dl_util/time_date');
      $this->load->helper('js/jq_month_picker');

         // validation rules
      $this->form_validation->set_error_delimiters('<div class="formError">', '</div>');
      $this->form_validation->set_rules('txtMonth',     'Report starting month', 'trim|required|callback_eventsStartMonth');
      $this->form_validation->set_rules('ddlDuration',  '# of months', 'trim');

		if ($this->form_validation->run() == FALSE){
         $this->load->library('generic_form');
         if (validation_errors()==''){
            $displayData['txtMonth']  = date('m/Y', $gdteNow);
         }else {
            setOnFormError($displayData);
            $displayData['txtMonth']  = set_value('txtMonth');
         }

            //------------------------------------------------
            // breadcrumbs / page setup
            //------------------------------------------------
         $displayData['js'] .= strMonthPicker(true);

         $displayData['mainTemplate'] = 'hospice/reports/monthly_options_view';
         $displayData['pageTitle']    = 'Monthly Volunteer Report Options';

         $displayData['title']        = CS_PROGNAME.' | Reports';
         $displayData['nav']          = $this->mnav_brain_jar->navData();

         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $moYr = explode('/', $_POST['txtMonth']);
         $lMonth = (integer)$moYr[0];
         $lYear  = (integer)$moYr[1];

         redirect('hospice/reports/monthly/runMonthlyReport/'.$lMonth.'/'.$lYear);
      }
   }

   function eventsStartMonth($strMonth){
      if (bValidPickerMonth($strMonth, $strErr)){
         return(true);
      }else {
         $this->form_validation->set_message('eventsStartMonth', $strErr);
         return(false);
      }
   }

   function runMonthlyReport($lMonth, $lYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;
   
      if (!bTestForURLHack('volMgr')) return;
      $displayData = array();
      $displayData['js'] = '';

      $displayData['lMonth'] = $lMonth = (int)$lMonth;
      $displayData['lYear']  = $lYear  = (int)$lYear;

         //------------------------------------------------
         // models/libraries/helpers
         //------------------------------------------------
      $this->load->model('hospice/mhospice_pvisit',      'cPVisit');
      $this->load->model('hospice/mhospice_reports',     'cHRpt');
      $params = array('enumStyle' => 'enpRptC');
      $this->load->library('generic_rpt', $params);

      $this->load->helper('dl_util/web_layout');
      $this->load->helper('dl_util/time_date');
      $this->load->helper('hospice/link_hospice');
      $this->load->helper('dl_util/time_duration_helper');

      $this->load->helper ('js/div_hide_show');
      $displayData['js'] .= showHideDiv();

      $this->cHRpt->initHReports();

         // patient visit hours for month
      $this->cHRpt->hrsPatientVisitsByMonth($glChapterID, $lMonth, $lYear, $displayData['sngHrsMins']);

         // non-patient visit volunteer hours for month
      $this->cHRpt->hrsVolNonPatientByMonth($glChapterID, $lMonth, $lYear, $displayData['sngNonPVHrs']);

         // # volunteers engaged
      $this->cHRpt->volCountByMonth($glChapterID, $lMonth, $lYear, $displayData['lNumVolsPV'],
                           $displayData['lNumVolsNonPV'], $displayData['lNumUniqueVolID']);

         // # patients served, # patient visits
      $this->cHRpt->patientsServedViaMonth($glChapterID, $lMonth, $lYear, 
                           $displayData['lNumPatients'], $displayData['lNumPatientVisits']);

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/monthly_report_view';
      $displayData['pageTitle']    =
                             anchor('hospice/reports/monthly/opts', 'Monthly Volunteer Report Options', 'class="breadcrumb"')
                            .' | Report';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function pVisitDetailViaMonth($lMonth, $lYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;
   
      if (!bTestForURLHack('volMgr')) return;
      $displayData = array();
      $displayData['js'] = '';

      $displayData['lMonth'] = $lMonth = (int)$lMonth;
      $displayData['lYear']  = $lYear  = (int)$lYear;

         //------------------------------------------------
         // models/libraries/helpers
         //------------------------------------------------
      $this->load->model('hospice/mhospice_pvisit',      'cPVisit');
      $this->load->model('hospice/mhospice_reports',     'cHRpt');
//      $this->load->model('personalization/muser_schema', 'cUFSchema');
      $params = array('enumStyle' => 'enpRptC');
      $this->load->library('generic_rpt', $params);

      $this->load->helper('dl_util/web_layout');
      $this->load->helper('dl_util/time_date');
      $this->load->helper('hospice/link_hospice');
      $this->load->helper('dl_util/time_duration_helper');
      $this->load->helper('hospice/patient_visit');

         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;
      $this->cHRpt->initHReports();
      $this->cHRpt->hrsPatientVisitsDetailsViaMonth($glChapterID, $lMonth, $lYear, $displayData['lNumPVRecs'], $displayData['pvInfo']);

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/monthly_pv_details_view';
      $displayData['pageTitle']    =
                             anchor('hospice/reports/monthly/opts', 'Monthly Volunteer Report Options', 'class="breadcrumb"')
                      .' | '.anchor('hospice/reports/monthly/runMonthlyReport/'.$lMonth.'/'.$lYear, 'Report', 'class="breadcrumb"')
                      .' | Details - Patient Visits';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function nonPVisitDetailViaMonth($lMonth, $lYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;
   
      if (!bTestForURLHack('volMgr')) return;
      $displayData = array();
      $displayData['js'] = '';

      $displayData['lMonth'] = $lMonth = (int)$lMonth;
      $displayData['lYear']  = $lYear  = (int)$lYear;

         //------------------------------------------------
         // models/libraries/helpers
         //------------------------------------------------
      $this->load->model('hospice/mhospice_pvisit',      'cPVisit');
      $this->load->model('hospice/mhospice_reports',     'cHRpt');
//      $this->load->model('personalization/muser_schema', 'cUFSchema');
      $params = array('enumStyle' => 'enpRptC');
      $this->load->library('generic_rpt', $params);

      $this->load->helper('dl_util/web_layout');
      $this->load->helper('dl_util/time_date');
      $this->load->helper('hospice/link_hospice');
      $this->load->helper('dl_util/time_duration_helper');

         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;

      $this->cHRpt->initHReports();
      $this->cHRpt->hrsNonPatientVisitsDetailsViaMonth($glChapterID, $lMonth, $lYear, $displayData['lNumNonPVRecs'], $displayData['nonPVInfo']);

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/monthly_nonpv_details_view';
      $displayData['pageTitle']    =
                             anchor('hospice/reports/monthly/opts', 'Monthly Volunteer Report Options', 'class="breadcrumb"')
                      .' | '.anchor('hospice/reports/monthly/runMonthlyReport/'.$lMonth.'/'.$lYear, 'Report', 'class="breadcrumb"')
                      .' | Details - Other Volunteer Activities';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function volCntPVisitDetailViaMonth($lMonth, $lYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (!bTestForURLHack('volMgr')) return;
      $displayData = array();
      $displayData['js'] = '';

      $displayData['lMonth'] = $lMonth = (int)$lMonth;
      $displayData['lYear']  = $lYear  = (int)$lYear;

         //------------------------------------------------
         // models/libraries/helpers
         //------------------------------------------------
      $this->load->model('hospice/mhospice_pvisit',      'cPVisit');
      $this->load->model('hospice/mhospice_reports',     'cHRpt');
//      $this->load->model('personalization/muser_schema', 'cUFSchema');
      $params = array('enumStyle' => 'enpRptC');
      $this->load->library('generic_rpt', $params);

      $this->load->helper('dl_util/web_layout');
      $this->load->helper('hospice/patient_visit');
      $this->load->helper('dl_util/time_date');
      $this->load->helper('hospice/link_hospice');
      $this->load->helper('dl_util/time_duration_helper');

         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;

      $this->cHRpt->initHReports();
      $this->cHRpt->patientVisitsViaVolDetailsViaMonth($lMonth, $lYear, $displayData['lNumVolRecs'], $displayData['volInfo']);

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/monthly_pvviavol_details_view';
      $displayData['pageTitle']    =
                             anchor('hospice/reports/monthly/opts', 'Monthly Volunteer Report Options', 'class="breadcrumb"')
                      .' | '.anchor('hospice/reports/monthly/runMonthlyReport/'.$lMonth.'/'.$lYear, 'Report', 'class="breadcrumb"')
                      .' | Details - Patient Visits';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function volCntNonPVisitDetailViaMonth($lMonth, $lYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;
   
      if (!bTestForURLHack('volMgr')) return;
      $displayData = array();
      $displayData['js'] = '';

      $displayData['lMonth'] = $lMonth = (int)$lMonth;
      $displayData['lYear']  = $lYear  = (int)$lYear;

         //------------------------------------------------
         // models/libraries/helpers
         //------------------------------------------------
      $this->load->model('hospice/mhospice_pvisit',      'cPVisit');
      $this->load->model('hospice/mhospice_reports',     'cHRpt');
//      $this->load->model('personalization/muser_schema', 'cUFSchema');
      $params = array('enumStyle' => 'enpRptC');
      $this->load->library('generic_rpt', $params);

      $this->load->helper('dl_util/web_layout');
      $this->load->helper('dl_util/time_date');
      $this->load->helper('hospice/link_hospice');
      $this->load->helper('dl_util/time_duration_helper');

         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;

      $this->cHRpt->initHReports();
      $this->cHRpt->nonPVisitsViaVolDetailsViaMonth($glChapterID, $lMonth, $lYear, $displayData['lNumVolRecs'], $displayData['volInfo']);

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/monthly_nonpvviavol_details_view';
      $displayData['pageTitle']    =
                             anchor('hospice/reports/monthly/opts', 'Monthly Volunteer Report Options', 'class="breadcrumb"')
                      .' | '.anchor('hospice/reports/monthly/runMonthlyReport/'.$lMonth.'/'.$lYear, 'Report', 'class="breadcrumb"')
                      .' | Details - Other Volunteer Activities';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function uniquePatientsDetailViaMonth($lMonth, $lYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;
   
      if (!bTestForURLHack('volMgr')) return;
      $displayData = array();
      $displayData['js'] = '';

      $displayData['lMonth'] = $lMonth = (int)$lMonth;
      $displayData['lYear']  = $lYear  = (int)$lYear;

         //------------------------------------------------
         // models/libraries/helpers
         //------------------------------------------------
      $this->load->model('hospice/mhospice_pvisit',      'cPVisit');
      $this->load->model('hospice/mhospice_reports',     'cHRpt');
//      $this->load->model('personalization/muser_schema', 'cUFSchema');
      $params = array('enumStyle' => 'enpRptC');
      $this->load->library('generic_rpt', $params);

      $this->load->helper('dl_util/web_layout');
      $this->load->helper('dl_util/time_date');
      $this->load->helper('hospice/link_hospice');
      $this->load->helper('dl_util/time_duration_helper');

         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;

      $this->cHRpt->initHReports();
      $this->cHRpt->patientVisitsViaPatientViaMonth($glChapterID, $lMonth, $lYear, $displayData['lNumPRecs'], $displayData['pInfo']);

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/monthly_patients_details_view';
      $displayData['pageTitle']    =
                             anchor('hospice/reports/monthly/opts', 'Monthly Volunteer Report Options', 'class="breadcrumb"')
                      .' | '.anchor('hospice/reports/monthly/runMonthlyReport/'.$lMonth.'/'.$lYear, 'Report', 'class="breadcrumb"')
                      .' | Details - Patients Served';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }
}