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

class vol_training extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }


   function addEditVolTraining($lTrainingID, $lVolID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glVolID, $gbVolMgr, $gbDateFormatUS, $glChapterID;

      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lVolID, 'volunteer ID');
      if ((int)$lTrainingID > 0) verifyID($glChapterID, $lTrainingID, 'vol training ID');

      $displayData = array();
      $displayData['formData'] = new stdClass;

      $displayData['lTrainingID'] = $lTrainingID  = (int)$lTrainingID;
      $displayData['lVolID']      = $lVolID       = (int)$lVolID;


      $displayData['bNew'] = $bNew = $lTrainingID <= 0;

         //-------------------------------------
         // models / helpers / libraries
         //-------------------------------------
      $this->load->model ('vols/mvol',             'clsVol');
      $this->load->model ('vols/mvol_training',     'cvt');
      $this->load->model ('util/mlist_generic',    'clsList');
      $this->load->helper('dl_util/time_date');  // for date verification
      $this->load->helper('hospice/link_hospice');
      $this->load->helper('hospice/patient_visit');
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);
      $this->load->helper('dl_util/web_layout');

         //--------------------------
         // load training record
         //--------------------------
      $this->cvt->loadVolTrainingViaTID($lTrainingID, $lNumTraining, $training);
      $train = &$training[0];

      $this->clsVol->loadVolRecsViaVolID($lVolID, true);
      $displayData['volRec'] = $volRec = &$this->clsVol->volRecs[0];

         //-------------------------
         // validation rules
         //-------------------------
      $this->form_validation->set_error_delimiters('<div class="formError">', '</div>');
		$this->form_validation->set_rules('ddlDuration',   'Duration',     'trim|callback_vtVerifyDuration');
		$this->form_validation->set_rules('ddlTraining',   'Training',     'trim|callback_vtVerifyType');
		$this->form_validation->set_rules('ddlTrainingBy', 'Conducted By', 'trim|callback_vtVerifyTrainingBy');
      $this->form_validation->set_rules('txtDate',       'Date of Training',  'trim|required'
                                                                    .'|callback_verifyDateValid');
		$this->form_validation->set_rules('txtNotes',    'Notes', 'trim');

		if ($this->form_validation->run() == FALSE){
//         $this->clsVol->loadVolRecsViaVolID($lVolID, true);
         $displayData['contextSummary'] = $this->clsVol->volHTMLSummary(0);
         $displayData['volRec'] = &$this->clsVol->volRecs[0];         
         
         $displayData['formData'] = new stdClass;
         $this->load->library('generic_form');

            // first time displayed, no user data entry errors
         if (validation_errors()==''){
            if (is_null($train->dteTraining)){
               $displayData['formData']->txtDate = '';
            }else {
               $displayData['formData']->txtDate = strNumericDateViaMysqlDate($train->mysqlDteTrain, $gbDateFormatUS);
            }

            $displayData['formData']->strNotes     = htmlspecialchars($train->strNotes);
            $displayData['formData']->ddlDuration  = pvisit\strDurationDDL($train->lDuration, true, 'ddlDuration', 'dur');

               // training type generic list
            $this->clsList->strBlankDDLName = '&nbsp;';
            $this->clsList->enumListType = CENUM_LISTTYPE_VOLTRAINING;
            $displayData['formData']->strTrainingType  =
                            $this->clsList->strLoadListDDL($glChapterID, 'ddlTraining', true, $train->lTrainingID);

               // training conducted by generic list
            $this->clsList->enumListType = CENUM_LISTTYPE_VOLTRAININGBY;
            $displayData['formData']->strTrainingBy  =
                            $this->clsList->strLoadListDDL($glChapterID, 'ddlTrainingBy', true, $train->lTrainingByID);

         }else {
            setOnFormError($displayData);
            $displayData['formData']->txtDate      = set_value('txtDate');
            $displayData['formData']->strNotes     = set_value('txtNotes');
            $displayData['formData']->ddlDuration  = pvisit\strDurationDDL(set_value('ddlDuration'), true, 'ddlDuration', 'dur');

               // training type generic list
            $this->clsList->strBlankDDLName = '&nbsp;';
            $this->clsList->enumListType = CENUM_LISTTYPE_VOLTRAINING;
            $displayData['formData']->strTrainingType =
                            $this->clsList->strLoadListDDL($glChapterID, 'ddlTraining', true, set_value('ddlTraining'));
                            
               // training conducted by generic list
            $this->clsList->enumListType = CENUM_LISTTYPE_VOLTRAININGBY;
            $displayData['formData']->strTrainingBy =
                            $this->clsList->strLoadListDDL($glChapterID, 'ddlTrainingBy', true, set_value('ddlTrainingBy'));
         }

            //--------------------------
            // breadcrumbs
            //--------------------------
         $displayData['pageTitle'] = 'Log Volunteer Training';

         $displayData['title']          = CS_PROGNAME.' | Volunteers';
         $displayData['nav']            = $this->mnav_brain_jar->navData();
         $displayData['mainTemplate']   = 'hospice/vols/training_add_edit_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $train->lVolID        = $lVolID;
         $train->strNotes      = trim($_POST['txtNotes']);
         $train->lTrainingID   = (int)trim($_POST['ddlTraining']);
         $train->lTrainingByID = (int)trim($_POST['ddlTrainingBy']);
         $train->lDuration     = (int)trim($_POST['ddlDuration']);

         $strDate              = trim($_POST['txtDate']);
         MDY_ViaUserForm($strDate, $lMon, $lDay, $lYear, $gbDateFormatUS);
         $train->mysqlDteTrain = strMoDaYr2MySQLDate($lMon, $lDay, $lYear);

            //------------------------------------
            // update db tables and return
            //------------------------------------
         if ($bNew){
            $lTrainingID = $this->cvt->lAddVolTraining($training[0]);
            $this->session->set_flashdata('msg', 'Volunteer training was recorded for '.$volRec->strSafeNameFL.'.');
         }else {
            $this->cvt->updateVolTraining($lTrainingID, $training[0]);
            $this->session->set_flashdata('msg', 'Training record updated');
         }
         redirect('hospice/vols/vol_training/volTrainingLog/'.$lVolID);
//         redirect('hospice/vols/vol_directory/view/false/'.strtoupper(substr($volRec->strLName, 0, 1)));
      }
   }

      //-----------------------------
      // verification routines
      //-----------------------------
   function verifyDateValid($strDate){
      if (!(bValidVerifyDate($strDate))){
         $this->form_validation->set_message('verifyDateValid', 'The <b>training date</b> is not valid.');
         return(false);
      }else {
         return(true);
      }
   }

   function vtVerifyDuration($lDDLSel){
      if (((int)$lDDLSel) <= 0){
         $this->form_validation->set_message('vtVerifyDuration', 'Please select a <b>training duration</b>.');
         return(false);
      }else {
         return(true);
      }
   }

   function vtVerifyTrainingBy($lDDLSel){
      if (((int)$lDDLSel) <= 0){
         $this->form_validation->set_message('vtVerifyTrainingBy', 'Please select <b>who conducted the training</b>.');
         return(false);
      }else {
         return(true);
      }
   }
   
   function vtVerifyType($lDDLSel){
      if (((int)$lDDLSel) <= 0){
         $this->form_validation->set_message('vtVerifyType', 'Please select a <b>training type</b>.');
         return(false);
      }else {
         return(true);
      }
   }


   function volTrainingLog($lVolID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glVolID, $gbVolMgr, $gbDateFormatUS, $glChapterID;

      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lVolID, 'volunteer ID');

      $displayData = array();
      $displayData['js'] = '';

      $displayData['lVolID']      = $lVolID       = (int)$lVolID;

         //-------------------------------------
         // models / helpers / libraries
         //-------------------------------------
      $this->load->model ('vols/mvol',             'clsVol');
      $this->load->model ('vols/mvol_training',    'cvt');
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);
      $this->load->helper('dl_util/web_layout');
      $this->load->helper('hospice/link_hospice');
      
         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;      
      
      $this->clsVol->loadVolRecsViaVolID($lVolID, true);
      $displayData['contextSummary'] = $this->clsVol->volHTMLSummary(0);
      $displayData['volRec'] = &$this->clsVol->volRecs[0];
      
      $this->cvt->loadVolTrainingViaVID($lVolID, $displayData['lNumTraining'], $displayData['training']);
      
         //-----------------------------
         // breadcrumbs & page setup
         //-----------------------------
      $displayData['title']        = CS_PROGNAME.' | Volunteers';
      $displayData['pageTitle']    = 'Volunteer Training Log';

      $displayData['mainTemplate'] = 'hospice/vols/vol_training_log_view';
      $displayData['nav'] = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
      
   }


}
