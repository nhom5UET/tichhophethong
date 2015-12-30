<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class calendar_report extends CI_Controller {

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
      $displayData['mainTemplate'] = 'hospice/reports/calendar_options_view';
      $displayData['pageTitle']    = 'Calendar Report Options';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function runCalReport(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lYear = (int)@$_POST['ddlYear'];
      $bPatientVisit = @$_POST['ddlActivity']=='patient';
      redirect('hospice/reports/calendar_report/rCalReport/'.$lYear.'/'.($bPatientVisit ? 'T' : 'F'));
   }
   
   function rcalReport($lYear, $bPatientVisit){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;
   
      if (!bTestForURLHack('volMgr')) return;
      $displayData = array();
      $displayData['js'] = '';

      $displayData['lYear'] = $lYear = (int)$lYear;
      $displayData['bPatientVisit'] = $bPatientVisit = $bPatientVisit=='T';
      
         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->model('hospice/mhospice_pvisit', 'cPVisit');
      $this->load->model('hospice/mhospice_reports', 'cHRpt');      
//      $this->load->model('personalization/muser_schema', 'cUFSchema');
      $this->load->helper('hospice/link_hospice');
      
      $calYear = array();
      for ($idx=1; $idx<=12; ++$idx){
         $calYear[$idx] = new stdClass;
         $cY = &$calYear[$idx];
         $dteFOM = strtotime($idx.'/1/'.$lYear);
         $cY->lFirstDayOfMonth = date('w', $dteFOM);
         $cY->daysInMonth = $lDaysInMonth = date('t', $dteFOM);
         $cY->strMonth = date('F', $dteFOM);
         $cY->dayCount = array();
         for ($jIdx=1; $jIdx<=$lDaysInMonth; ++$jIdx){
            $cY->dayCount[$jIdx] = 0;
         }
      }
      
      if ($bPatientVisit){
         $strTitle = 'Volunteer Patient Visits - '.$lYear;
      }else {
         $strTitle = 'Non-Visit Volunteer Activities - '.$lYear;
      }
      
      $this->cHRpt->initHReports();
      $this->cHRpt->volActivityCountByYear($glChapterID, $lYear, $bPatientVisit, $calYear);
      $displayData['strCalendar'] = $this->cHRpt->strHTMLCalendar($lYear, $bPatientVisit, $strTitle, $calYear);

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/calendar_run_view';
      $displayData['pageTitle']    = 
                                 anchor('hospice/reports/calendar_report/opts', 'Calendar Report Options', 'class="breadcrumb"')
                            .' | Calendar Report';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
      
/* -------------------------------------
$zzzlPos = strrpos(__FILE__, '\\'); $zzzlLen=strlen(__FILE__); echo('<font class="debug">'.substr(__FILE__, strrpos(__FILE__, '\\',-(($zzzlLen-$zzzlPos)+1))) .': '.__LINE__
.":\$displayData[strCalendar] = ".$displayData['strCalendar']." <br></font>\n");
      
echo('<font class="debug">'.substr(__FILE__, strrpos(__FILE__, '\\'))
   .': '.__LINE__.'<br>$calYear   <pre>');
echo(htmlspecialchars( print_r($calYear, true))); echo('</pre></font><br>');
// ------------------------------------- */
      
   }

}
