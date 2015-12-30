<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class locations extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function locDir(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbSuperUser;

      if (!bTestForURLHack('superUser')) return;

      $displayData = array();
      $displayData['js'] = '';

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model('admin/mlocations', 'cLoc');
      $this->load->helper('hospice/link_hospice');

         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;

      $this->cLoc->loadLocationInfo('', $displayData['lNumLocs'], $displayData['lNumActive'], $displayData['locations']);
      foreach ($displayData['locations'] as $loc){
         $lLocID = $loc->lKeyID;
         $loc->lNumPatients = $this->cLoc->lNumPatientsViaLocID($lLocID);
         $loc->lNumVolMgrs  = $this->cLoc->lNumVolMgrsViaLocID($lLocID);
         $loc->lNumVols     = $this->cLoc->lNumVolsViaLocID($lLocID);
      }

         //--------------------------
         // breadcrumbs
         //--------------------------
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params, 'generic_rpt');
      $displayData['clsRpt'] = $this->generic_rpt;

      $displayData['pageTitle']  = 'Locations';

      $displayData['title']          = CS_PROGNAME.' | Locations';
      $displayData['nav']            = $this->mnav_brain_jar->navData();

      $displayData['mainTemplate']   = 'hospice/super/location_directory_view';
      $this->load->vars($displayData);
      $this->load->view('template');

   }

   function setActiveStateLoc($lLocID, $bSetActive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (!bTestForURLHack('superUser')) return;
      $bSetActive = $bSetActive=='true';
      $lLocID = (int)$lLocID;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model('admin/mlocations', 'cLoc');
      $this->cLoc->changeLocActiveState($lLocID, $bSetActive);

      $this->session->set_flashdata('msg', 'The selected location was set to '.($bSetActive ? '<b>Active</b>' : '<b>Inactive</b>').'.');
      redirect('hospice/super/locations/locDir');
   }



}
