<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// Hospice Volunteer Solutions!
// copyright (c) 2015 Database Austin
//
// author: John Zimmerman
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------*/

class patient_rec extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function addEditPRec($lPatientID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr, $glChapterID, $gstrFormatDatePicker, $gbDateFormatUS;

      if (!bTestForURLHack('volMgr')) return;
      $this->load->helper('dl_util/verify_id');
      if ((int)$lPatientID > 0) verifyID($glChapterID, $lPatientID, 'patient ID');

      $displayData = array();
      $displayData['lPatientID'] = $lPatientID = (int)$lPatientID;
      $displayData['bNew']       = $bNew = $lPatientID <= 0;

      $displayData['js'] = '';
      $displayData['formData'] = new stdClass;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('patients/mpatients',         'cPatients');
      $this->load->helper ('dl_util/web_layout');
      $this->load->helper ('dl_util/time_date');
      $this->load->library('util/dl_date_time', '', 'clsDateTime');

         // load patient record
      $this->cPatients->loadPatientsViaPatientID($lPatientID);
      $displayData['patient'] = $pRec = &$this->cPatients->patients[0];

         // validation rules
      $this->form_validation->set_error_delimiters('<div class="formError">', '</div>');
      $this->form_validation->set_rules('txtTitle',        '<b>Title</b>',         'trim');
      $this->form_validation->set_rules('txtFName',        '<b>First Name</b>',    'trim|required');
      $this->form_validation->set_rules('txtMName',        '<b>Middle Name</b>',   'trim');
      $this->form_validation->set_rules('txtLName',        '<b>Last Name</b>',     'trim|required');

      $this->form_validation->set_rules('txtBDate',      '<b>Date of Birth</b>', 'trim|required|callback_patientRecVerifyBDateValid'
                                                                                   .'|callback_patientRecVerifyBDatePast');

      $this->form_validation->set_rules('txtPhone',      'Phone',  'trim');
      $this->form_validation->set_rules('txtCell',       'Cell',   'trim');
      $this->form_validation->set_rules('txtEmail',      '<b>EMail</b>',  'trim|valid_email');

      $this->form_validation->set_rules('txtAddr1',      '', 'trim');
      $this->form_validation->set_rules('txtAddr2',      '', 'trim');
      $this->form_validation->set_rules('txtCity',       '', 'trim');
      $this->form_validation->set_rules('txtState',      '', 'trim');
      $this->form_validation->set_rules('txtZip',        '', 'trim');
      $this->form_validation->set_rules('txtCountry',    '', 'trim');

      $this->form_validation->set_rules('txtNotes',      '', 'trim');

      if ($this->form_validation->run() == FALSE){
         $this->load->library('generic_form');

         if (validation_errors()==''){
            if (is_null($pRec->dteBirth)){
               $displayData['formData']->txtBDate = '';
            }else {
               $displayData['formData']->txtBDate = strNumericDateViaMysqlDate($pRec->dteBirth, $gbDateFormatUS);
            }

            if ($bNew){
               $displayData['formData']->txtTitle =
               $displayData['formData']->txtFName =
               $displayData['formData']->txtMName =
               $displayData['formData']->txtLName = '';

               $displayData['formData']->txtPhone =
               $displayData['formData']->txtCell  =
               $displayData['formData']->txtEmail = '';

               $displayData['formData']->txtAddr1    =
               $displayData['formData']->txtAddr2    =
               $displayData['formData']->txtCity     =
               $displayData['formData']->txtState    =
               $displayData['formData']->txtZip      =
               $displayData['formData']->txtCountry  = '';

               $displayData['formData']->txtNotes    = '';
            }else {
               $displayData['formData']->txtTitle    = htmlspecialchars($pRec->strTitle);
               $displayData['formData']->txtFName    = htmlspecialchars($pRec->strFName);
               $displayData['formData']->txtMName    = htmlspecialchars($pRec->strMName);
               $displayData['formData']->txtLName    = htmlspecialchars($pRec->strLName);

               $displayData['formData']->txtPhone    = htmlspecialchars($pRec->strPhone);
               $displayData['formData']->txtCell     = htmlspecialchars($pRec->strCell);
               $displayData['formData']->txtEmail    = htmlspecialchars($pRec->strEmail);

               $displayData['formData']->txtAddr1    = htmlspecialchars($pRec->strAddr1);
               $displayData['formData']->txtAddr2    = htmlspecialchars($pRec->strAddr2);
               $displayData['formData']->txtCity     = htmlspecialchars($pRec->strCity);
               $displayData['formData']->txtState    = htmlspecialchars($pRec->strState);
               $displayData['formData']->txtZip      = htmlspecialchars($pRec->strZip);
               $displayData['formData']->txtCountry  = htmlspecialchars($pRec->strCountry);

               $displayData['formData']->txtNotes    = htmlspecialchars($pRec->strBio);
            }
         }else {
            setOnFormError($displayData);
            $displayData['formData']->txtTitle    = set_value('txtTitle');
            $displayData['formData']->txtFName    = set_value('txtFName');
            $displayData['formData']->txtMName    = set_value('txtMName');
            $displayData['formData']->txtLName    = set_value('txtLName');

            $displayData['formData']->txtBDate    = set_value('txtBDate');

            $displayData['formData']->txtPhone    = set_value('txtPhone');
            $displayData['formData']->txtCell     = set_value('txtCell');
            $displayData['formData']->txtEmail    = set_value('txtEmail');

            $displayData['formData']->txtAddr1    = set_value('txtAddr1');
            $displayData['formData']->txtAddr2    = set_value('txtAddr2');
            $displayData['formData']->txtCity     = set_value('txtCity');
            $displayData['formData']->txtState    = set_value('txtState');
            $displayData['formData']->txtZip      = set_value('txtZip');
            $displayData['formData']->txtCountry  = set_value('txtCountry');

            $displayData['formData']->txtNotes    = set_value('txtNotes');
         }

            //--------------------------
            // breadcrumbs
            //--------------------------
         $params = array('enumStyle' => 'terse');
         $this->load->library('generic_rpt', $params, 'generic_rpt');

         $displayData['pageTitle']  = ' Patient Record';

         $displayData['title']          = CS_PROGNAME.' | Patient';
         $displayData['nav']            = $this->mnav_brain_jar->navData();

         $displayData['mainTemplate']   = 'hospice/patients/patient_add_edit_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $strBDate   = trim($_POST['txtBDate']);
         MDY_ViaUserForm($strBDate, $lMon, $lDay, $lYear, $gbDateFormatUS);
         $pRec->dteBirth = strMoDaYr2MySQLDate($lMon, $lDay, $lYear);

         $pRec->strTitle    = $_POST['txtTitle'];
         $pRec->strFName    = $_POST['txtFName'];
         $pRec->strMName    = $_POST['txtMName'];
         $pRec->strLName    = $_POST['txtLName'];

         $pRec->strAddr1    = $_POST['txtAddr1'];
         $pRec->strAddr2    = $_POST['txtAddr2'];
         $pRec->strCity     = $_POST['txtCity'];
         $pRec->strState    = $_POST['txtState'];
         $pRec->strCountry  = $_POST['txtCountry'];
         $pRec->strZip      = $_POST['txtZip'];
         $pRec->strPhone    = $_POST['txtPhone'];
         $pRec->strCell     = $_POST['txtCell'];
         $pRec->strEmail    = $_POST['txtEmail'];
         $pRec->strBio      = $_POST['txtNotes'];

         if ($bNew){
            $lPatientID = $this->cPatients->lAddNewPatient($pRec);
            $this->session->set_flashdata('msg', 'The patient record was added.');
         }else {
            $this->cPatients->updatePatient($lPatientID, $pRec);
            $this->session->set_flashdata('msg', 'The patient record was updated.');
         }
         redirect('hospice/patients/patient_rec/viewRec/'.$lPatientID);
      }
   }

      //-----------------------------
      // verification routines
      //-----------------------------
   function patientRecVerifyBDateValid($strBDate){
      if (!(bValidVerifyDate($strBDate))){
         $this->form_validation->set_message('patientRecVerifyBDateValid', 'The <b>date of birth</b> is not valid.');
         return(false);
      }else {
         return(true);
      }
   }

   function patientRecVerifyBDatePast($strBDate){
      if (!(bValidVerifyNotFuture($strBDate))){
         $this->form_validation->set_message('patientRecVerifyBDatePast', 'The <b>date of birth</b> is in the future!.');
         return(false);
      }else {
         return(true);
      }
   }

   function viewRec($lPatientID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr, $glChapterID, $gstrFormatDatePicker, $gbDateFormatUS;

      if (!bTestForURLHack('volMgr')) return;
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lPatientID, 'patient ID');

      $displayData = array();
      $displayData['lPatientID'] = $lPatientID = (int)$lPatientID;
      $displayData['bNew']       = $bNew = $lPatientID <= 0;

      $displayData['js'] = '';
      $displayData['formData'] = new stdClass;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('patients/mpatients',         'cPatients');
      $this->load->model  ('patients/mpatient_contacts', 'cPCons');
      $this->load->model  ('hospice/mhospice_pvisit',    'cPVisit');
      $this->load->model  ('util/mlist_generic',         'cList');
      $this->load->model  ('vols/mvol',                  'cVols');
      $this->load->helper ('dl_util/web_layout');
      $this->load->helper ('dl_util/time_date');
      $this->load->helper ('hospice/link_hospice');
      $this->load->library('util/dl_date_time', '', 'clsDateTime');
      
         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;            

      $this->load->helper ('js/div_hide_show');
      $displayData['js'] .= showHideDiv();

         // load patient record
      $this->cPatients->loadPatientsViaPatientID($lPatientID);
      $displayData['patient'] = $pRec = &$this->cPatients->patients[0];

         // load patient visits
      $this->cPVisit->loadPVisitsViaPatientID($lPatientID, $displayData['lNumPVRecs'], $displayData['pVisits']);

         // load patient contacts
      $this->cPCons->loadPContactsViaPatientID($lPatientID, $lNumPConPatients, $pContacts);
      if ($lNumPConPatients == 0){
         $displayData['lNumPCons'] = 0;
         $displayData['pCons'] = null;
      }else {
         $displayData['lNumPCons'] = $pContacts[0]->lNumContacts;
         $displayData['pCons'] = &$pContacts[0]->contacts;
      }
      
         // load volunteer/patient associations
      $this->cVols->loadVolClientAssocViaPatientID($lPatientID, $displayData['volClientAssoc']);

         //--------------------------
         // breadcrumbs
         //--------------------------
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params, 'generic_rpt');
      $displayData['clsRpt'] = $this->generic_rpt;

      $displayData['pageTitle']  = ' Patient Record';

      $displayData['title']          = CS_PROGNAME.' | Patient';
      $displayData['nav']            = $this->mnav_brain_jar->navData();

      $displayData['mainTemplate']   = 'hospice/patients/patient_rec_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }


}