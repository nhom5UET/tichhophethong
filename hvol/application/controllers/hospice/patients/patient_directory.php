<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class patient_directory extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function view($strIncludeInactive='N', $strLookupLetter='A', $lStartRec=0, $lRecsPerPage=50){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;

      if (!bTestForURLHack('volMgr')) return;
      $_SESSION[CS_NAMESPACE.'clientLastDir'] = 'name';
      $strLookupLetter = urldecode($strLookupLetter);
      $displayData = array();
      $displayData['js'] = '';

      $displayData['bIncludeInactive'] = $bIncludeInactive = $strIncludeInactive=='Y';
      $displayData['bViaLocation'] = false;
      $displayData['bViaSponProg'] = false;

         //--------------------------------------
         // models, helpers, libraries
         //--------------------------------------
      $this->load->helper('dl_util/directory');
      $this->load->helper('dl_util/rs_navigate');
      $this->load->helper('clients/client');
      $this->load->helper('clients/client_sponsor');
      $this->load->model('vols/mvol',                   'cVols');
      $this->load->model ('patients/mpatients',         'cPatients');
      $this->load->model ('patients/mpatient_contacts', 'cPCons');
      $this->load->library('util/dl_date_time', '',     'clsDataTime');
      $this->load->helper('hospice/link_hospice');

      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);

         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;      
      
      $displayData['strRptTitle']  = 'Patient Directory';
      $strWhereExtra = '';

         //------------------------------------------------
         // sanitize the lookup letter
         //------------------------------------------------
      $displayData['strDirLetter'] = $strLookupLetter = strSanitizeLetter($strLookupLetter);
      initClientReportDisplay($displayData);

      $displayData['strDirLetter'] = $strLookupLetter;
      $strLinkEnd = $lStartRec.'/'.$lRecsPerPage;
      $strLabelToggle = ($bIncludeInactive ? '<b>Hide</b>' : '<b>Show</b> active and ').' inactive patients';

      $displayData['strLinkBase']  = $strLinkBase = 'hospice/patients/patient_directory/view/'
                              .($bIncludeInactive ? 'Y' : 'N').'/';
      $displayData['strToggleLink'] =
             anchor('hospice/patients/patient_directory/view/'
                     .($bIncludeInactive ? 'N' : 'Y').'/'
                     .($strLookupLetter=='*' ? '%2A' : $strLookupLetter).'/'.$strLinkEnd, $strLabelToggle);

      $displayData['strDirTitle']  = strDisplayDirectory(
                                         $strLinkBase, ' class="directoryLetters" ', $strLookupLetter,
                                         true, $lStartRec, $lRecsPerPage);

         //------------------------------------------------
         // total # clients for this letter
         //------------------------------------------------
      $displayData['lNumRecsTot'] = $lNumRecsTot =
                        $this->cPatients->lNumPatientsViaLetter($glChapterID, $strLookupLetter, $bIncludeInactive, $strWhereExtra);
      $displayData['lNumPatients'] = $lNumRecsTot;

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = array('hospice/patients/directory_view', 'hospice/patients/rpt_patient_list');
      $displayData['pageTitle']    = 'Patient Directory';

      $displayData['title']        = CS_PROGNAME.' | Patients';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

         //------------------------------------------------
         // load client directory page
         //------------------------------------------------
      $strWhereExtra .= $this->cPatients->strWhereByLetter($strLookupLetter, $bIncludeInactive);
      $this->cPatients->loadPatientDirectoryPage($glChapterID, $strWhereExtra, $lStartRec, $lRecsPerPage);
      $displayData['lNumDisplayRows']      = $lNumP = $this->cPatients->lNumPatients;
      $displayData['directoryRecsPerPage'] = $lRecsPerPage;
      $displayData['directoryStartRec']    = $lStartRec;

         // load associated volunteers and contacts
      if ($lNumP > 0){
         foreach ($this->cPatients->patients as $pRec){
            $lPatientID = $pRec->lKeyID;
            $this->cVols->loadVolClientAssocViaPatientID($lPatientID, $pRec->volClient);
            $this->cPCons->loadPContactsViaPatientID($lPatientID, $lDummy, $pRec->pContacts);
         }
      }

      $displayData['patientInfo'] = $pi = &$this->cPatients->patients;

      $this->load->vars($displayData);
      $this->load->view('template');
   }


}
