<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class vol_util extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function setActiveStateVAssoc($lVolID, $lAssocID, $bSetActive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr, $glChapterID;

      $bSetActive = $bSetActive=='true';

      if (!bTestForURLHack('volMgr')) return;
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lVolID, 'volunteer ID');
      verifyID($glChapterID, $lAssocID, 'vpAssoc ID');

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('vols/mvol', 'cVol');
      $this->cVol->changeActiveAssocState($lAssocID, $bSetActive);

      $this->session->set_flashdata('msg', 'The selected patient association was set to '.($bSetActive ? '<b>Active</b>' : '<b>Inactive</b>').'.');
      redirect('hospice/vols/vol_record/viewRec/'.$lVolID);
   }

   function setActiveStateVol($lVolID, $bSetActive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr, $glChapterID;

      $bSetActive = $bSetActive=='true';

      if (!bTestForURLHack('volMgr')) return;
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lVolID, 'volunteer ID');

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('vols/mvol', 'cVol');
      $this->cVol->changeVolActiveState($lVolID, $bSetActive);

      $this->session->set_flashdata('msg', 'The selected volunteer was set to '.($bSetActive ? '<b>Active</b>' : '<b>Inactive</b>').'.');
      redirect('hospice/vols/vol_record/viewRec/'.$lVolID);
   }


}
