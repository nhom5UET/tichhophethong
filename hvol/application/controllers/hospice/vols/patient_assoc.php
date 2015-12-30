<?php
/*---------------------------------------------------------------------
// Hospice Volunteer Solutions!
// copyright (c) 2015 Database Austin
//
// author: John Zimmerman
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------*/
class patient_assoc extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function addAssoc01($lVolID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;
   
      if (!bTestForURLHack('volMgr')) return;
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lVolID, 'volunteer ID');

      $displayData = array();
      $displayData['lVolID'] = $lVolID = (integer)$lVolID;

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);
      $this->load->library('util/dl_date_time', '',        'clsDateTime');
      $this->load->library('js_build/js_verify');
      $this->load->model  ('vols/mvol', 'clsVol');
      $this->load->model  ('util/msearch_single_generic', 'clsSearch');
      $this->load->helper('js/simple_search');
      $this->load->helper('hospice/link_hospice');

      $this->js_verify->clearEmbedOpts();
      $this->js_verify->bShow_bVerifyString    =
      $this->js_verify->bShow_trim             = true;
      $displayData['js']  = $this->js_verify->loadJavaVerify();
      $displayData['js'] .= simpleSearch();

      $this->clsVol->loadVolRecsViaVolID($lVolID, false);
      $displayData['contextSummary'] = $this->clsVol->volHTMLSummary(0);

         //-----------------------------
         // breadcrumbs & page setup
         //-----------------------------
      $displayData['title']        = CS_PROGNAME.' | Volunteers';
      $displayData['pageTitle']    = 'Add Volunteer/Client Association';

      $displayData['mainTemplate'] = 'hospice/vols/vol_patient_assoc_s1_view';
      $displayData['nav'] = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function addS2($lVolID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID, $gstrPassPhrase;
      
      if (!bTestForURLHack('volMgr')) return;
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lVolID, 'volunteer ID');

      $displayData = array();
      $displayData['lVolID'] = $lVolID = (integer)$lVolID;

      $this->load->helper('js/simple_search');

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->model('util/msearch_single_generic', 'clsSearch');
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);
      $this->load->library('util/dl_date_time', '',  'clsDateTime');
      $this->load->model  ('vols/mvol', 'clsVol');
      $this->load->helper ('reports/report_util');
      $this->load->helper('hospice/link_hospice');

      $this->clsVol->loadVolRecsViaVolID($lVolID, false);
      $displayData['contextSummary'] = $this->clsVol->volHTMLSummary(0);

      $this->clsSearch->strSearchTerm = $strSearch = trim($_POST['txtSearch']);

         //-----------------------------
         // search display setup
         //-----------------------------
      $this->clsSearch->enumSearchType      = CENUM_CONTEXT_CLIENT;
      $this->clsSearch->strSearchLabel      = 'Patient';
      $this->clsSearch->bShowKeyID          = true;
      $this->clsSearch->bShowSelect         = true;
      $this->clsSearch->bShowEnumSearchType = false;
      $this->clsSearch->strDisplayTitle     =
                '<br>Please select the patient associated with this volunteer</b><br>';

         // landing page for selection
      $this->clsSearch->strPathSelection  = 'hospice/vols/patient_assoc/clientAddEdit/'.$lVolID.'/';
      $this->clsSearch->strTitleSelection = 'Select patient';

         // landing page for "back"
      $this->clsSearch->strPathSearchAgain  = 'hospice/vols/patient_assoc/addAssoc01/'.$lVolID;
      $this->clsSearch->strTitleSearchAgain = 'Search again...';

         // exclude existing associations
      $this->clsVol->loadVolClientAssocViaVolID($lVolID, $volClient, true);

      $lLeftCnt = strlen($strSearch);
         // wow - a lot more complicated that initially thought!
      $this->clsSearch->strWhereExtra = 
               " AND (UPPER(LEFT(
                        CONVERT(
                              AES_DECRYPT(cr_strLName, SHA2(".strPrepStr($gstrPassPhrase).",256))
                              USING UTF8), $lLeftCnt)))=".strPrepStr(strtoupper($strSearch))."
                 AND cr_lChapterID=$glChapterID ";
      if (count($volClient) > 0) {
         $cIDs = array();
         foreach ($volClient as $vca) $cIDs[] = $vca->lPatientID;
         $this->clsSearch->strWhereExtra .= 
                    ' AND NOT (cr_lKeyID IN ('.implode(',', $cIDs).')) ';
      }

      $this->clsSearch->strIDLabel = 'patientID: ';
      $this->clsSearch->bShowLink  = false;

         // run search
      $displayData['strSearchLabel'] =
                          'Searching for '.$this->clsSearch->enumSearchType.' that begin with <b><i>"'
                          .htmlspecialchars($strSearch).'"</b></i><br>';
      $this->clsSearch->searchClients();
      
      $displayData['strHTMLSearchResults'] = $this->clsSearch->strHTML_SearchResults();

         //-----------------------------
         // breadcrumbs & page setup
         //-----------------------------
      $displayData['title']        = CS_PROGNAME.' | Volunteers';
      $displayData['pageTitle']    = 'Add Volunteer/Client Association';

      $displayData['mainTemplate'] = 'hospice/vols/vol_patient_assoc_s2_view';
      $displayData['nav'] = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function clientAddEdit($lVolID, $lPatientID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;
      
      if (!bTestForURLHack('volMgr')) return;
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lVolID, 'volunteer ID');
      verifyID($glChapterID, $lPatientID, 'patient ID');

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->model  ('vols/mvol', 'clsVol');

      $lPatientID = (integer)$lPatientID;
      $lVolID    = (integer)$lVolID;

      $va = new stdClass;
      $va->lVolID    = $lVolID;
      $va->lPatientID = $lPatientID;
      $va->strNotes  = '';
      $this->clsVol->addVolAssociation($va);
      $this->session->set_flashdata('msg', 'The volunteer/client association was added.');
      redirect('hospice/vols/vol_record/viewRec/'.$lVolID);
   }

   function remove($lVAID, $lVolID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lVAID = (integer)$lVAID;
      if (!bTestForURLHack('dataEntryPeopleBizVol')) return;
      if (!bTestForURLHack('showClients')) return;

      $this->load->helper('dl_util/verify_id');
      verifyID($this, $lVolID, 'volunteer ID');

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->model  ('vols/mvol', 'clsVol');

      $this->clsVol->removeVolClientAssoc($lVAID);

      $this->session->set_flashdata('msg', 'The volunteer/client association was removed.');
      redirect_Vol($lVolID);
   }

}
