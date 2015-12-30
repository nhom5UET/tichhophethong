<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class su_annual extends CI_Controller {

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
      $this->load->library('generic_form');
      $this->load->helper('dl_util/web_layout');

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/reports/su_annual_options_view';
      $displayData['pageTitle']    = 'Annual Administrative Report Options';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }
   
   function runAnnual(){
   //---------------------------------------------------------------------
   // 
   //---------------------------------------------------------------------
      $lYear = (int)$_POST['ddlYear'];   
      redirect('hospice/reports/su_db_stats/run/'.$lYear);
   }

/*   
   function runAnnualViaYear($lYear){
   //---------------------------------------------------------------------
   // 
   //---------------------------------------------------------------------
      if (!bTestForURLHack('superUser')) return;
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
      $displayData['mainTemplate'] = 'hospice/reports/su_annual_view';
      $displayData['pageTitle']    = 
                    anchor('hospice/reports/su_annual/opts', 'Annual Administrative Report Options', 'class="breadcrumb"')
                  .' | Report';

      $displayData['title']        = CS_PROGNAME.' | Reports';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template'); 
   }
*/
}