<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class review extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   public function reviewHours($lVolID=0){
   //-------------------------------------------------------------------------
   //
   //-------------------------------------------------------------------------
      global $glVolID, $gbVolMgr;

      $displayData = array();
      $displayData['js'] = '';
      if ($gbVolMgr){
         $lVolID = (int)$lVolID;
      }else {
         $lVolID = $glVolID;
      }
      $displayData['lVolID'] = $lVolID;

         //--------------------------------
         // Models & Helpers
         //--------------------------------
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);
      $this->load->model('vols/mvol_event_hours',   'clsVolHours');
      $this->load->model('vols/mvol',               'clsVol');
//      $this->load->model('people/mpeople',          'clsPeople');
      $this->load->model('hospice/mhospice_pvisit', 'cPVisit');
      $this->load->model('admin/mpermissions',      'perms');
      $this->load->model('util/mlist_generic',      'clsList');
//      $this->load->model('personalization/muser_fields',         'clsUF');
//      $this->load->model('personalization/muser_fields_display', 'clsUFD');

//      $this->load->model('personalization/muser_schema');
      $this->load->helper('dl_util/time_date');
      $this->load->helper('reports/report_util');
      $this->load->helper('hospice/link_hospice');
      $this->load->helper('hospice/patient_visit');

         //----------------------------------
         // stripes
         //----------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;

      $lStartRec = $lRecsPerPage = null;
      $sRpt = new stdClass;
      $sRpt->bScheduled = false;
      $sRpt->lVolID     = $lVolID;
      $sRpt->reportID   = '';
      $displayData['unscheduled'] = $this->clsVolHours->strHoursViaVIDReport(
                                                $sRpt,
                                                true,  $lStartRec,    $lRecsPerPage,
                                                'date');

         // patient visits
      $this->clsVol->loadVolRecsViaVolID($lVolID, false);
      $displayData['strVolSafeName'] = htmlspecialchars($this->clsVol->volRecs[0]->strFName.' '.$this->clsVol->volRecs[0]->strLName);
         
      $this->cPVisit->loadPVisitsViaVolID($lVolID, $displayData['lNumPVisitRecs'], $displayData['pVisits']); // $displayData['lNumPVisitRecs'], $displayData['pVisits'], $displayData['displayFields']);
      
      $displayData['contextSummary'] = $this->clsVol->volHTMLSummary(0);

            //--------------------------
            // breadcrumbs
            //--------------------------
      $strCrumb = 'Review volunteer hours';
      $displayData['pageTitle']      = $strCrumb;

      $displayData['title']          = CS_PROGNAME.' | Reports';
      $displayData['nav']            = $this->mnav_brain_jar->navData();

      $displayData['mainTemplate']   = 'hospice/vols/vol_hours_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }



}