<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class su_monthly extends CI_Controller {

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
      
      if (!bTestForURLHack('superUser')) return;
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

         $displayData['mainTemplate'] = 'hospice/reports/su_monthly_options_view';
         $displayData['pageTitle']    = 'Monthly Administrative Report Options';

         $displayData['title']        = CS_PROGNAME.' | Reports';
         $displayData['nav']          = $this->mnav_brain_jar->navData();

         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $moYr = explode('/', $_POST['txtMonth']);
         $lMonth = (integer)$moYr[0];
         $lYear  = (integer)$moYr[1];

         redirect('hospice/reports/su_monthly/runMonthlyReport/'.$lMonth.'/'.$lYear);
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
      $lMonth = (int)$lMonth;
      $lYear  = (int)$lYear;
      redirect('hospice/reports/su_db_stats/run/'.$lYear.'/'.$lMonth);
   }
/*   
      global $glChapterID;
   
      if (!bTestForURLHack('superUser')) return;
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
      
      
         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/su_monthly_report_view';
      $displayData['pageTitle']    =
                             anchor('hospice/reports/su_monthly/opts', 'Monthly Volunteer Report Options', 'class="breadcrumb"')
                            .' | Report';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }
*/
   
   
}   