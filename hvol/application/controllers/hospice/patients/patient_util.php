<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class patient_util extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function setActiveState($lPatientID, $bSetToActive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;

      global $gbVolMgr, $glChapterID;

      if (!bTestForURLHack('volMgr')) return;
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lPatientID, 'patient ID');

      $lPatientID = (int)$lPatientID;
      $bSetToActive = $bSetToActive == 'true';

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('patients/mpatients', 'cPatients');

         // load patient record
      $this->cPatients->loadPatientsViaPatientID($lPatientID);
      $pRec = &$this->cPatients->patients[0];
      $strDirLetter = strtoupper(substr($pRec->strLName, 0, 1));

      $this->cPatients->updateActiveStatus($lPatientID, $bSetToActive);

      $this->session->set_flashdata('msg', 'The patient record for <b>'
                  .htmlspecialchars($pRec->strFName.' '.$pRec->strLName)
                  .'</b> was set to <b>'.($bSetToActive ? 'active' : 'inactive').'</b>.');

      redirect('hospice/patients/patient_directory/view/Y/'.$strDirLetter);
   }

}

