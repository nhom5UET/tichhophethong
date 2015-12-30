<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class su_data_entry extends CI_Controller {

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
      $this->form_validation->set_rules('txtMonth', 'Report starting month', 'trim|required|callback_eventsStartMonth');

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

         $displayData['mainTemplate'] = 'hospice/reports/su_data_entry_options_view';
         $displayData['pageTitle']    = 'Data Entry Report Options';

         $displayData['title']        = CS_PROGNAME.' | Reports';
         $displayData['nav']          = $this->mnav_brain_jar->navData();

         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $moYr = explode('/', $_POST['txtMonth']);
         $lMonth = (integer)$moYr[0];
         $lYear  = (integer)$moYr[1];

         redirect('hospice/reports/su_data_entry/runDataEntry/'.$lMonth.'/'.$lYear);
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

   function runDataEntry($lMonth, $lYear){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (!bTestForURLHack('superUser')) return;
      $displayData = array();
      $displayData['js'] = '';

      $displayData['lMonth'] = $lMonth = (int)$lMonth;
      $displayData['lYear']  = $lYear  = (int)$lYear;

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->helper('dl_util/web_layout');
      $this->load->helper('dl_util/time_date');
      $this->load->model ('hospice/mhospice_su_reports', 'cHSURpt');
      $this->load->model ('admin/mlocations',            'cLoc');
      $params = array('enumStyle' => 'enpRptC');
      $this->load->library('generic_rpt', $params);

      $this->load->helper ('js/div_hide_show');
      $displayData['js'] .= showHideDiv();

      $this->cLoc->loadLocationInfo('', $lNumLocs, $lNumActive, $locations);

         // super-user level
      $displayData['deStats']  = new stdClass;

      $strLogInWhereDate = " AND YEAR(el_dteLogDate)=$lYear AND MONTH(el_dteLogDate)=$lMonth ";
      $displayData['deStats']->lLogInGood  = $this->cHSURpt->lLogInCounts($strLogInWhereDate.' AND el_bLoginSuccessful ');
      $displayData['deStats']->lLogInBad   = $this->cHSURpt->lLogInCounts($strLogInWhereDate.' AND NOT el_bLoginSuccessful ');
      $displayData['deStats']->lLogInsSU   = $this->cHSURpt->lLogInCountsViaUserRole('SuperUser', $strLogInWhereDate);
      $displayData['deStats']->lLogInsVM   = $this->cHSURpt->lLogInCountsViaUserRole('VolMgr',    $strLogInWhereDate);
      $displayData['deStats']->lLogInsVols = $this->cHSURpt->lLogInCountsViaUserRole('Vol',       $strLogInWhereDate);

      $displayData['deStats']->lPVRecsViaVM  = $this->cHSURpt->lNumRecs_PVisit(null, $lYear, $lMonth, true);
      $displayData['deStats']->lPVRecsViaVol = $this->cHSURpt->lNumRecs_PVisit(null, $lYear, $lMonth, false);

      $displayData['deStats']->lVolActViaVM  = $this->cHSURpt->lNumRecs_OtherVolAct(null, $lYear, $lMonth, true);
      $displayData['deStats']->lVolActViaVol = $this->cHSURpt->lNumRecs_OtherVolAct(null, $lYear, $lMonth, false);


      foreach ($locations as $loc){
         $lLocID = $loc->lKeyID;
         $strLogInWhereDateLoc = $strLogInWhereDate." AND us_lChapterID=$lLocID ";

         $loc->deStats = new stdClass;
         $loc->deStats->lLogInsVM   = $this->cHSURpt->lLogInCountsViaUserRole('VolMgr',    $strLogInWhereDate);
         $loc->deStats->lLogInsVols = $this->cHSURpt->lLogInCountsViaUserRole('Vol',       $strLogInWhereDate);

         $loc->deStats->lPVRecsViaVM  = $this->cHSURpt->lNumRecs_PVisit($lLocID, $lYear, $lMonth, true);
         $loc->deStats->lPVRecsViaVol = $this->cHSURpt->lNumRecs_PVisit($lLocID, $lYear, $lMonth, false);

         $loc->deStats->lVolActViaVM  = $this->cHSURpt->lNumRecs_OtherVolAct($lLocID, $lYear, $lMonth, true);
         $loc->deStats->lVolActViaVol = $this->cHSURpt->lNumRecs_OtherVolAct($lLocID, $lYear, $lMonth, false);
      }

      $displayData['locations'] = &$locations;

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/su_data_entry_view';
      $displayData['pageTitle']    =
                    anchor('hospice/reports/su_data_entry/opts', 'Data Entry Report Options', 'class="breadcrumb"')
                  .' | Report';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

}
