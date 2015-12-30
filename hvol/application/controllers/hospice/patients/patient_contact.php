<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class patient_contact extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function viewRec($lPConID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr, $glChapterID, $gbDateFormatUS;

      if (!bTestForURLHack('volMgr')) return;
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lPConID, 'patientContact ID');

      $displayData = array();
      $displayData['lPConID']    = $lPConID = (int)$lPConID;

      $displayData['js'] = '';
      $displayData['formData'] = new stdClass;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('patients/mpatient_contacts', 'cPCons');
      $this->load->model  ('patients/mpatients',         'cPatients');
      $this->load->library('util/dl_date_time', '', 'clsDateTime');
      $this->load->helper ('hospice/link_hospice');
      $this->load->helper ('dl_util/web_layout');

         // load the patient contact record
      $this->cPCons->loadPContactsViaPConID($lPConID, $lNumPCons, $pContacts);
      $displayData['pCon'] = $pCon = &$pContacts[0];

         // load patient record
      $displayData['lPatientID'] = $lPatientID = $pCon->lPatientID;
      $this->cPatients->loadPatientsViaPatientID($lPatientID);
      $displayData['patient'] = $patient = &$this->cPatients->patients[0];

         //--------------------------
         // breadcrumbs
         //--------------------------
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params, 'generic_rpt');
      $displayData['clsRpt'] = $this->generic_rpt;
      $displayData['contextSummary'] = $this->cPatients->strPatientHTMLSummary(0);

      $displayData['pageTitle']  = ' Patient Contact';

      $displayData['title']          = CS_PROGNAME.' | Patient Contact';
      $displayData['nav']            = $this->mnav_brain_jar->navData();

      $displayData['mainTemplate']   = 'hospice/patients/patient_contact_rec_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function addEditContact($lPConID, $lPatientID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr, $glChapterID, $gbDateFormatUS;

      if (!bTestForURLHack('volMgr')) return;
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lPatientID, 'patient ID');
      if ((int)$lPConID > 0) verifyID($glChapterID, $lPConID, 'patientContact ID');

      $displayData = array();
      $displayData['lPConID']    = $lPConID = (int)$lPConID;
      $displayData['lPatientID'] = $lPatientID = (int)$lPatientID;
      $displayData['bNew']       = $bNew = $lPConID <= 0;

      $displayData['js'] = '';
      $displayData['formData'] = new stdClass;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('patients/mpatient_contacts', 'cPCons');
      $this->load->model  ('patients/mpatients',         'cPatients');
      $this->load->model  ('util/mlist_generic',         'cList');
      $this->load->helper ('dl_util/web_layout');
      $this->load->helper ('hospice/link_hospice');
      $this->load->library('util/dl_date_time', '', 'clsDateTime');

         // load patient record
      $this->cPatients->loadPatientsViaPatientID($lPatientID);
      $displayData['patient'] = $patient = &$this->cPatients->patients[0];

         // load the patient contact record
      $this->cPCons->loadPContactsViaPConID($lPConID, $lNumPCons, $pContacts);
      $pCon = &$pContacts[0];

         // validation rules
      $this->form_validation->set_error_delimiters('<div class="formError">', '</div>');
      $this->form_validation->set_rules('txtTitle',        '<b>Title</b>',         'trim');
      $this->form_validation->set_rules('txtFName',        '<b>First Name</b>',    'trim|required');
      $this->form_validation->set_rules('txtMName',        '<b>Middle Name</b>',   'trim');
      $this->form_validation->set_rules('txtLName',        '<b>Last Name</b>',     'trim|required');
      $this->form_validation->set_rules('ddlRelationship', '<b>Relationship</b>',  'trim|callback_verifyRelationship');

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
            if ($bNew){
               $displayData['formData']->txtTitle =
               $displayData['formData']->txtFName =
               $displayData['formData']->txtMName =
               $displayData['formData']->txtLName = '';

               $this->cList->enumListType = CENUM_LISTTYPE_PCON_RELATION;
               $displayData['formData']->ddlRelationship = $this->cList->strLoadListDDL($glChapterID, 'ddlRelationship', true, -1);

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
               $displayData['formData']->txtTitle = htmlspecialchars($pCon->strPConTitle);
               $displayData['formData']->txtFName = htmlspecialchars($pCon->strPConFName);
               $displayData['formData']->txtMName = htmlspecialchars($pCon->strPConMName);
               $displayData['formData']->txtLName = htmlspecialchars($pCon->strPConLName);

               $this->cList->enumListType = CENUM_LISTTYPE_PCON_RELATION;
               $displayData['formData']->ddlRelationship = $this->cList->strLoadListDDL($glChapterID, 'ddlRelationship',
                                   true, $pCon->lRelationshipID);

               $displayData['formData']->txtPhone = htmlspecialchars($pCon->strPhone);
               $displayData['formData']->txtCell  = htmlspecialchars($pCon->strCell);
               $displayData['formData']->txtEmail = htmlspecialchars($pCon->strEmail);

               $displayData['formData']->txtAddr1    = htmlspecialchars($pCon->strAddr1);
               $displayData['formData']->txtAddr2    = htmlspecialchars($pCon->strAddr2);
               $displayData['formData']->txtCity     = htmlspecialchars($pCon->strCity);
               $displayData['formData']->txtState    = htmlspecialchars($pCon->strState);
               $displayData['formData']->txtZip      = htmlspecialchars($pCon->strZip);
               $displayData['formData']->txtCountry  = htmlspecialchars($pCon->strCountry);

               $displayData['formData']->txtNotes    = htmlspecialchars($pCon->strNotes);
            }
         }else {
            setOnFormError($displayData);
            $displayData['formData']->txtTitle = set_value('txtTitle');
            $displayData['formData']->txtFName = set_value('txtFName');
            $displayData['formData']->txtMName = set_value('txtMName');
            $displayData['formData']->txtLName = set_value('txtLName');

            $this->cList->enumListType = CENUM_LISTTYPE_PCON_RELATION;
            $displayData['formData']->ddlRelationship = $this->cList->strLoadListDDL($glChapterID, 'ddlRelationship',
                                   true, set_value('ddlRelationship'));

            $displayData['formData']->txtPhone = set_value('txtPhone');
            $displayData['formData']->txtCell  = set_value('txtCell');
            $displayData['formData']->txtEmail = set_value('txtEmail');

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
         $displayData['clsRpt'] = $this->generic_rpt;
         $displayData['contextSummary'] = $this->cPatients->strPatientHTMLSummary(0);

         $displayData['pageTitle']  = ' Patient Contact';

         $displayData['title']          = CS_PROGNAME.' | Patient Contact';
         $displayData['nav']            = $this->mnav_brain_jar->navData();

         $displayData['mainTemplate']   = 'hospice/patients/patient_contact_add_edit_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $pCon->strPConTitle    = $_POST['txtTitle'];
         $pCon->strPConFName    = $_POST['txtFName'];
         $pCon->strPConMName    = $_POST['txtMName'];
         $pCon->strPConLName    = $_POST['txtLName'];
         $pCon->lRelationshipID = (int)$_POST['ddlRelationship'];
         $pCon->strAddr1        = $_POST['txtAddr1'];
         $pCon->strAddr2        = $_POST['txtAddr2'];
         $pCon->strCity         = $_POST['txtCity'];
         $pCon->strState        = $_POST['txtState'];
         $pCon->strCountry      = $_POST['txtCountry'];
         $pCon->strZip          = $_POST['txtZip'];
         $pCon->strPhone        = $_POST['txtPhone'];
         $pCon->strCell         = $_POST['txtCell'];
         $pCon->strEmail        = $_POST['txtEmail'];
         $pCon->strNotes        = $_POST['txtNotes'];

         if ($bNew){
            $lPConID = $this->cPCons->lAddNewPatientContact($lPatientID, $pCon);
            $this->session->set_flashdata('msg', 'The patient contact record was added.');
         }else {
            $this->cPCons->updatePContact($lPConID, $pCon);
            $this->session->set_flashdata('msg', 'The patient contact record was updated.');
         }
         redirect('hospice/patients/patient_contact/viewRec/'.$lPConID);
      }
   }

   function verifyRelationship($ID){
      $ID = (int)$ID;
      if ($ID <= 0){
         $this->form_validation->set_message('verifyRelationship', 'Please select a <b>relationship</b>.');
         return(false);
      }
      return(true);
   }

   function removeRecord($lPConID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbVolMgr, $glChapterID;

      if (!bTestForURLHack('volMgr')) return;
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lPConID, 'patientContact ID');
      $lPConID = (int)$lPConID;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('patients/mpatient_contacts', 'cPCons');

         // load the patient contact record
      $this->cPCons->loadPContactsViaPConID($lPConID, $lNumPCons, $pContacts);
      $pCon = &$pContacts[0];
      $lPatientID = $pCon->lPatientID;

      $this->cPCons->removePConRec($lPConID);

      $this->session->set_flashdata('msg', 'The patient contact <b>'.
          htmlspecialchars($pCon->strPConFName.' '.$pCon->strPConLName).'</b> was removed.');
      redirect('hospice/patients/patient_rec/viewRec/'.$lPatientID);
   }

}
