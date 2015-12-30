<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class su_db_stats extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function run($lYear = 0, $lMonth = 0){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gdteNow;

      if (!bTestForURLHack('superUser')) return;
      $displayData = array();
      $displayData['js'] = '';

      $displayData['lYear']    = $lYear    = (int)$lYear;
      $displayData['lMonth']   = $lMonth   = (int)$lMonth;
      $displayData['bByMonth'] = $bByMonth = ($lYear > 0 && $lMonth > 0);
      $displayData['bByYear']  = $bByYear  = ($lYear > 0 && $lMonth==0);

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->model  ('hospice/mhospice_pvisit',     'cPVisit');
      $this->load->model  ('hospice/mhospice_reports',    'cHRpt');
      $this->load->model  ('hospice/mhospice_su_reports', 'cHSURpt');
      $this->load->model  ('admin/mlocations',            'cLoc');
      $this->load->model  ('vols/mvol',                   'cVol');
      $this->load->library('generic_form');
      $this->load->helper ('dl_util/time_date');
      $this->load->helper ('dl_util/web_layout');
      $params = array('enumStyle' => 'enpRptC');
      $this->load->library('generic_rpt', $params);

      $this->load->helper ('js/div_hide_show');
      $displayData['js'] .= showHideDiv();

      $this->cLoc->loadLocationInfo('', $lNumLocs, $lNumActive, $locations);

      $displayData['orgStats'] = new stdClass;

      if ($bByYear || $bByMonth){
         $strWherePV_Year           = " AND YEAR(pv_dteVisit)=$lYear ";
         $strWherePat_Year          = " AND YEAR(cr_dteOrigin)=$lYear ";
         $strWherePatInactive_Year  = " AND YEAR(cr_dteInactive)=$lYear ";
         $strWherePCon_Year         = " AND YEAR(cc_dteOrigin)=$lYear ";
         $strWhereNonPV_Year        = " AND YEAR(vsa_dteActivityDate)=$lYear ";
         $strWhereVols_Year         = " AND YEAR(vol_dteOrigin)=$lYear ";
         $strWhereVolsInactive_Year = " AND YEAR(vol_dteInactive)=$lYear ";
      }else {
         $strWherePV_Year           =
         $strWherePat_Year          =
         $strWherePatInactive_Year  =
         $strWherePCon_Year         =
         $strWhereNonPV_Year        =
         $strWhereVols_Year         =
         $strWhereVolsInactive_Year = '';
      }

      if ($bByMonth){
         $strWherePV_Year           .= " AND MONTH(pv_dteVisit)        = $lMonth ";
         $strWherePat_Year          .= " AND MONTH(cr_dteOrigin)       = $lMonth ";
         $strWherePatInactive_Year  .= " AND MONTH(cr_dteInactive)     = $lMonth ";
         $strWherePCon_Year         .= " AND MONTH(cc_dteOrigin)       = $lMonth ";
         $strWhereNonPV_Year        .= " AND MONTH(vsa_dteActivityDate)= $lMonth ";
         $strWhereVols_Year         .= " AND MONTH(vol_dteOrigin)      = $lMonth ";
         $strWhereVolsInactive_Year .= " AND MONTH(vol_dteInactive)    = $lMonth ";
      }

      $this->cHRpt->patientsServed($strWherePV_Year,
                $displayData['orgStats']->lNumPatients,    $displayData['orgStats']->lNumPatientVisits);

      $displayData['orgStats']->lNumPRecsActive   = $this->cHRpt->lPRecCnt($strWherePat_Year, true);
      $displayData['orgStats']->lNumPRecsInactive = $this->cHRpt->lPRecCnt($strWherePatInactive_Year, false);

      $displayData['orgStats']->lNumPRConRecs = $this->cHRpt->lNumPatientContactRecs($strWherePCon_Year);
      $this->cHRpt->hrsPatientVisits($strWherePV_Year, $displayData['orgStats']->sngTotPVHrsMins);
      $this->cHRpt->hrsVolNonPatient($strWhereNonPV_Year, $displayData['orgStats']->sngTotNonPVHrsMins);

      $displayData['orgStats']->lNumVolsActive   = $this->cVol->lNumVols('active',   $strWhereVols_Year);
      $displayData['orgStats']->lNumVolsInactive = $this->cVol->lNumVols('inactive', $strWhereVolsInactive_Year);

      foreach ($locations as $loc){
         $lChapterID = $loc->lKeyID;
         $loc->stats = new stdClass;
         $this->cHRpt->patientsServed(" AND pv_lChapterID = $lChapterID ".$strWherePV_Year,
                          $loc->stats->lNumPatients,    $loc->stats->lNumPatientVisits);

         $loc->stats->lNumPRecsActive   =
                 $this->cHRpt->lPRecCnt(" AND cr_lChapterID = $lChapterID ".$strWherePat_Year, true);
         $loc->stats->lNumPRecsInactive =
                  $this->cHRpt->lPRecCnt(" AND cr_lChapterID = $lChapterID ".$strWherePatInactive_Year, false);

         $loc->stats->lNumPRConRecs =
                $this->cHRpt->lNumPatientContactRecs($strWherePCon_Year." AND cr_lChapterID = $lChapterID ");
         $this->cHRpt->hrsPatientVisits($strWherePV_Year." AND pv_lChapterID=$lChapterID ",     $loc->stats->sngTotPVHrsMins);
         $this->cHRpt->hrsVolNonPatient($strWhereNonPV_Year." AND vsa_lChapterID=$lChapterID ", $loc->stats->sngTotNonPVHrsMins);

         $loc->stats->lNumVolsActive   = $this->cVol->lNumVols('active', $strWhereVols_Year." AND vol_lChapterID=$lChapterID ");
         $loc->stats->lNumVolsInactive = $this->cVol->lNumVols('inactive', $strWhereVolsInactive_Year." AND vol_lChapterID=$lChapterID ");
      }

      $displayData['locations'] = &$locations;


         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/su_db_stats_view';
      if ($bByYear){
         $displayData['pageTitle']    =
                    anchor('hospice/reports/su_annual/opts', 'Annual Administrative Report Options', 'class="breadcrumb"')
                  .' | Report';
      }else {
         $displayData['pageTitle']    = 'Organizational Summary';
      }

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

}
