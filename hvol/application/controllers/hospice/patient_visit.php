<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class patient_visit extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   public function pAssoc(){
   //-------------------------------------------------------------------------
   //
   //-------------------------------------------------------------------------
      global $glUserID, $glVolID, $gbDateFormatUS, $glChapterID;

      $displayData = array();
      $displayData['pageTitle'] = 'Patient Visit | Select Patient';
      $displayData['title']          = CS_PROGNAME.' | Volunteers';
      $displayData['nav']            = $this->mnav_brain_jar->navData();

         //-------------------------------------
         // models / helpers / libraries
         //-------------------------------------
      $this->load->model('vols/mvol', 'clsVol');

         // load volunteer/client associations
         // view based on number of associations
      $this->clsVol->loadVolClientAssocViaVolID($glVolID, $displayData['volClient'], false);
      $lNumAssoc = count($displayData['volClient']);

      if ($lNumAssoc == 0){
         $displayData['mainTemplate']   = 'hospice/vols/vol_patient_no_assoc_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }elseif ($lNumAssoc == 1){
         redirect('hospice/patient_visit/addEditPVSelected/'.$displayData['volClient'][0]->lClientID);
      }else {
         $displayData['mainTemplate']   = 'hospice/vols/vol_patient_select_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }
   }

   function addEditPVSelected($lPatientID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glVolID;

      $displayData = array();
      $displayData['pageTitle'] = 'Patient Visit';
      $displayData['title']     = CS_PROGNAME.' | Volunteers';
      $displayData['nav']       = $this->mnav_brain_jar->navData();

      redirect('hospice/patient_visit/addEditPatientVisit/'.$glVolID.'/0/'.$lPatientID.'/true');
   }

   function visitRecView($lPVRecID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glVolID, $gbVolMgr, $glChapterID;
      
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lPVRecID, 'patientVisit ID');

      $displayData = array();
      $displayData['js'] = '';

         //-------------------------------------
         // models / helpers / libraries
         //-------------------------------------
      $this->load->model  ('util/mlist_generic',      'cList');
      $this->load->model  ('hospice/mhospice_pvisit', 'cPVisit');
      $this->load->helper ('dl_util/web_layout');
      $this->load->helper ('dl_util/time_date');
      $this->load->helper ('hospice/patient_visit');
      $this->load->helper ('hospice/link_hospice');
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);
      
         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;      

      $this->load->helper ('js/div_hide_show');
      $displayData['js'] .= showHideDiv();

         // load patient visit record
      $this->cPVisit->loadPVisitsViaVisitID($lPVRecID, $lNumPVRecs, $pVisits);
      $displayData['pVisit'] = $pVisit = &$pVisits[0];

            //--------------------------
            // breadcrumbs
            //--------------------------
      $displayData['pageTitle']      = 'Patient Visit';

      $displayData['title']          = CS_PROGNAME.' | Review';
      $displayData['nav']            = $this->mnav_brain_jar->navData();

      $displayData['mainTemplate']   = 'hospice/patient_visit_record_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }

   public function addEditPatientVisit($lVolID, $lPVRecID=0, $lPatientID=0){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID, $gbVolMgr, $gbDateFormatUS, $gstrFormatDatePicker;

      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lPatientID, 'patient ID');
      verifyID($glChapterID, $lVolID, 'volunteer ID');
      if ($lPVRecID != 0) verifyID($glChapterID, $lPVRecID, 'patientVisit ID');

      $displayData = array();
      $displayData['formData'] = new stdClass;
      $displayData['lVolID']     = $lVolID     = (integer)$lVolID;
      $displayData['lPVRecID']   = $lPVRecID   = (integer)$lPVRecID;
      $displayData['lPatientID'] = $lPatientID = (integer)$lPatientID;

      $displayData['bNew'] = $bNew = $lPVRecID <= 0;

         //----------------------------------------------
         // models / helpers
         //----------------------------------------------
      $this->load->library('util/dl_date_time', '',  'clsDateTime');
      $this->load->model  ('patients/mpatients',     'cPatients');
      $this->load->model  ('vols/mvol', 'cVol');
      $this->load->model  ('util/mlist_generic',      'cList');
      $this->load->model  ('hospice/mhospice_pvisit', 'cPVisit');
      $this->load->helper ('dl_util/web_layout');
      $this->load->helper ('dl_util/time_date');
      $this->load->helper ('hospice/patient_visit');
      $this->load->helper('hospice/hospice_util');

      $this->cVol->loadVolClientAssocViaVolID($lVolID, $volClients, false);
      if (!hospiceUtil\bVerifyVolClientAssoc($lVolID, $lPatientID, $volClients, $lVCIDX)){
         $this->session->set_flashdata('error', 'Invalid volunteer/patient association. Please contact your volunteer manager.');
         redirect('hospice/hospice_error/error');
         return;
      }

         // load patient record
      $this->cPatients->loadPatientsViaPatientID($lPatientID);
      $displayData['patient'] = &$this->cPatients->patients[0];

         // load volunteer record
      $this->cVol->loadVolRecsViaVolID($lVolID, false);
      $displayData['volRec'] = $volRec = &$this->cVol->volRecs[0];

         // load patient visit record
      $this->cPVisit->loadPVisitsViaVisitID($lPVRecID, $lNumPVRecs, $pVisits);
      $displayData['pVisit'] = $pVisit = &$pVisits[0];

         // validation rules
      $this->form_validation->set_error_delimiters('<div class="formError">', '</div>');
      $this->form_validation->set_rules('txtMedRecNum',      '<b>Medical Record Number</b>',  'trim|required');
      $this->form_validation->set_rules('ddlDuration',      '',  'trim|callback_verifyDurationDDL');
      $this->form_validation->set_rules('ddlStart',         '',  'trim|callback_verifyStartTimeDDL');
      $this->form_validation->set_rules('txtDateOfVisit', '<b>Visit Date</b>', 'trim|required|callback_verifyVisitDate');

         // person served
      $this->form_validation->set_rules('chkPS_Patient');
      $this->form_validation->set_rules('chkPS_Caregiver');
      $this->form_validation->set_rules('chkPS_Bereaved');
      $this->form_validation->set_rules('chkPS_Other');
      $this->form_validation->set_rules('txtPS_Notes', '', 'trim|callback_verifyPS');

         // location
      $this->form_validation->set_rules('ddlLocation',      '', 'trim|callback_verifyLocation');
      $this->form_validation->set_rules('txtLocationNotes', '', 'trim|callback_verifyLocationNotes');

         // Activity
      $this->form_validation->set_rules('ddlActivity',      '', 'trim|callback_verifyActivity');
      $this->form_validation->set_rules('txtActivityNotes', '', 'trim|callback_verifyActivityNotes');

         // Interventions
      $this->form_validation->set_rules('chkI_Companionship');
      $this->form_validation->set_rules('chkI_CaregiverRelief');
      $this->form_validation->set_rules('chkI_EmotionalSupport');
      $this->form_validation->set_rules('chkI_Socialization');
      $this->form_validation->set_rules('chkI_Bereavement');
      $this->form_validation->set_rules('chkI_TelephoneCall');
      $this->form_validation->set_rules('chkI_ExcursionErrands');
      $this->form_validation->set_rules('chkI_MusicPetArtSupport');
      $this->form_validation->set_rules('chkI_FoodPreparation');
      $this->form_validation->set_rules('chkI_HouseholdChores');
      $this->form_validation->set_rules('chkI_OtherIntervention');
      $this->form_validation->set_rules('txtI_Notes', '', 'trim|callback_verifyIntervention');

                  // Visit Info
      $this->form_validation->set_rules('ddlM_PatientStatus',      '', 'callback_verifyPatientStatus');
      $this->form_validation->set_rules('ddlM_VisitTasks',         '', 'callback_verifyVisitTasks');
      $this->form_validation->set_rules('txtVisitNotes',           '', 'trim|callback_verifyVisitNotes');
      $this->form_validation->set_rules('chkTSK_Visitors');
      $this->form_validation->set_rules('txtTSKPatientComfort', '<b>Patient Comfort</b>', 'trim|required');
      $this->form_validation->set_rules('txtTSKPatientPain');
      $this->form_validation->set_rules('txtTSKPatientConcerns');

      if ($this->form_validation->run() == FALSE){
         $matchIDs_PStatus = array();
         $matchIDs_VTasks  = array();

         $displayData['js'] = '';
         $this->load->library('generic_form');

         if (validation_errors()==''){
            if ($bNew){
               $displayData['formData']->txtDateOfVisit =
               $displayData['formData']->txtMedRecNum   = '';
               $displayData['formData']->ddlDuration    = pvisit\strDurationDDL(-1, true, 'ddlDuration', 'dur');
               $displayData['formData']->ddlStart       = pvisit\strTimeDDL    (-1, true, 'ddlStart',    'start');

                  // person served
               $displayData['formData']->ps_bPatient   =
               $displayData['formData']->ps_bCaregiver =
               $displayData['formData']->ps_bBereaved  =
               $displayData['formData']->ps_bOther     = false;
               $displayData['formData']->ps_txtNotes   = '';

                  // location
               $this->cList->enumListType = CENUM_LISTTYPE_PV_LOCATIONS;
               $displayData['formData']->ddlLocation = $this->cList->strLoadListDDL($glChapterID, 'ddlLocation', true, -1);
               $displayData['formData']->txtLocationNotes   = '';

                  // Activity
               $this->cList->enumListType = CENUM_LISTTYPE_PV_ACTIVITIES;
               $displayData['formData']->ddlActivity = $this->cList->strLoadListDDL($glChapterID, 'ddlActivity', true, -1);
               $displayData['formData']->txtActivityNotes   = '';

                  // Interventions
               $displayData['formData']->i_bCompanionship      =
               $displayData['formData']->i_bCaregiverRelief    =
               $displayData['formData']->i_bEmotionalSupport   =
               $displayData['formData']->i_bSocialization      =
               $displayData['formData']->i_bBereavement        =
               $displayData['formData']->i_bTelephoneCall      =
               $displayData['formData']->i_bExcursionErrands   =
               $displayData['formData']->i_bMusicPetArtSupport =
               $displayData['formData']->i_bFoodPreparation    =
               $displayData['formData']->i_bHouseholdChores    =
               $displayData['formData']->i_bOtherIntervention  = false;
               $displayData['formData']->txtI_Notes = '';

                  // Visit Info
               $this->cList->enumListType = CENUM_LISTTYPE_PV_PSTATUS;
               $displayData['formData']->ddlM_PatientStatus =
                     $this->cList->strLoadListMultiDDL($glChapterID, 'ddlM_PatientStatus', 5, true, $matchIDs_PStatus);
               $this->cList->enumListType = CENUM_LISTTYPE_PV_VISITTASKS;
               $displayData['formData']->ddlM_VisitTasks =
                     $this->cList->strLoadListMultiDDL($glChapterID, 'ddlM_VisitTasks', 5, true, $matchIDs_VTasks);
               $displayData['formData']->txtVisitNotes        = '';
               $displayData['formData']->TSK_bVisitors        = false;
               $displayData['formData']->txtTSKPatientComfort = '';
               $displayData['formData']->txtTSKPatientPain    = '';
               $displayData['formData']->txtTSKPatientConcerns    = '';

            }else {
               $displayData['formData']->txtDateOfVisit = strNumericDateViaMysqlDate($pVisit->mdteVisit, $gbDateFormatUS);
               $displayData['formData']->txtMedRecNum   = htmlspecialchars($pVisit->strMedRec);
               $displayData['formData']->ddlDuration    = pvisit\strDurationDDL($pVisit->lDuration,  true, 'ddlDuration', 'dur');
               $displayData['formData']->ddlStart       = pvisit\strTimeDDL    ($pVisit->lStartTime, true, 'ddlStart',    'start');

                  // person served
               $displayData['formData']->ps_bPatient   = $pVisit->ps_bPatient;
               $displayData['formData']->ps_bCaregiver = $pVisit->ps_bCaregiver;
               $displayData['formData']->ps_bBereaved  = $pVisit->ps_bBereaved;
               $displayData['formData']->ps_bOther     = $pVisit->ps_bOther;
               $displayData['formData']->ps_txtNotes   = htmlspecialchars($pVisit->ps_strNotes);

                  // location
               $this->cList->enumListType = CENUM_LISTTYPE_PV_LOCATIONS;
               $displayData['formData']->ddlLocation = $this->cList->strLoadListDDL($glChapterID, 'ddlLocation', true, $pVisit->loc_lLocationID);
               $displayData['formData']->txtLocationNotes   = htmlspecialchars($pVisit->loc_strNotes);

                  // Activity
               $this->cList->enumListType = CENUM_LISTTYPE_PV_ACTIVITIES;
               $displayData['formData']->ddlActivity = $this->cList->strLoadListDDL($glChapterID, 'ddlActivity', true, $pVisit->act_lActivityID);
               $displayData['formData']->txtActivityNotes   = htmlspecialchars($pVisit->act_strNotes);

                  // Interventions
               $displayData['formData']->i_bCompanionship      = $pVisit->in_bCompanionship;
               $displayData['formData']->i_bCaregiverRelief    = $pVisit->in_bCaregiverRelief;
               $displayData['formData']->i_bEmotionalSupport   = $pVisit->in_bEmotionalSupport;
               $displayData['formData']->i_bSocialization      = $pVisit->in_bSocialization;
               $displayData['formData']->i_bBereavement        = $pVisit->in_bBereavement;
               $displayData['formData']->i_bTelephoneCall      = $pVisit->in_bTelephoneCall;
               $displayData['formData']->i_bExcursionErrands   = $pVisit->in_bExcursionErrands;
               $displayData['formData']->i_bMusicPetArtSupport = $pVisit->in_bMusicPetArt;
               $displayData['formData']->i_bFoodPreparation    = $pVisit->in_bFoodPrep;
               $displayData['formData']->i_bHouseholdChores    = $pVisit->in_bHouseholdChores;
               $displayData['formData']->i_bOtherIntervention  = $pVisit->in_bOther;
               $displayData['formData']->txtI_Notes = htmlspecialchars($pVisit->in_strNotes);

                  // Visit Info
               $this->cList->enumListType = CENUM_LISTTYPE_PV_PSTATUS;
               $displayData['formData']->ddlM_PatientStatus =
                     $this->cList->strLoadListMultiDDL($glChapterID, 'ddlM_PatientStatus', 5, true, $pVisit->status->IDs);
               $this->cList->enumListType = CENUM_LISTTYPE_PV_VISITTASKS;
               $displayData['formData']->ddlM_VisitTasks =
                     $this->cList->strLoadListMultiDDL($glChapterID, 'ddlM_VisitTasks', 5, true, $pVisit->tasks->IDs);
               $displayData['formData']->txtVisitNotes         = htmlspecialchars($pVisit->tsk_strOtherNotes);
               $displayData['formData']->TSK_bVisitors         = $pVisit->tsk_bVisitors;
               $displayData['formData']->txtTSKPatientComfort  = htmlspecialchars($pVisit->tsk_strPatientComfort);
               $displayData['formData']->txtTSKPatientPain     = htmlspecialchars($pVisit->tsk_strPatientPain);
               $displayData['formData']->txtTSKPatientConcerns = htmlspecialchars($pVisit->tsk_strChangesConcerns);
            }
         }else {
            setOnFormError($displayData);
            $displayData['formData']->txtDateOfVisit = set_value('txtDateOfVisit');
            $displayData['formData']->txtMedRecNum   = set_value('txtMedRecNum');
            $displayData['formData']->ddlDuration    = pvisit\strDurationDDL(set_value('ddlDuration'), true, 'ddlDuration', 'dur');
            $displayData['formData']->ddlStart       = pvisit\strTimeDDL    (set_value('ddlStart'),    true, 'ddlStart',    'start');

                  // person served
            $displayData['formData']->ps_bPatient   = set_value('chkPS_Patient')  == 'TRUE';
            $displayData['formData']->ps_bCaregiver = set_value('chkPS_Caregiver')== 'TRUE';
            $displayData['formData']->ps_bBereaved  = set_value('chkPS_Bereaved') == 'TRUE';
            $displayData['formData']->ps_bOther     = set_value('chkPS_Other')    == 'TRUE';
            $displayData['formData']->ps_txtNotes   = set_value('txtPS_Notes');

                  // location
            $this->cList->enumListType = CENUM_LISTTYPE_PV_LOCATIONS;
            $displayData['formData']->ddlLocation = $this->cList->strLoadListDDL($glChapterID, 'ddlLocation', true, (int)@$_POST['ddlLocation']);
            $displayData['formData']->txtLocationNotes   = set_value('txtLocationNotes');

               // Activity
            $this->cList->enumListType = CENUM_LISTTYPE_PV_ACTIVITIES;
            $displayData['formData']->ddlActivity = $this->cList->strLoadListDDL($glChapterID, 'ddlActivity', true, (int)@$_POST['ddlActivity']);
            $displayData['formData']->txtActivityNotes   = set_value('txtActivityNotes');

               // Interventions
            $displayData['formData']->i_bCompanionship      = set_value('chkI_Companionship')      =='TRUE';
            $displayData['formData']->i_bCaregiverRelief    = set_value('chkI_CaregiverRelief')    =='TRUE';
            $displayData['formData']->i_bEmotionalSupport   = set_value('chkI_EmotionalSupport')   =='TRUE';
            $displayData['formData']->i_bSocialization      = set_value('chkI_Socialization')      =='TRUE';
            $displayData['formData']->i_bBereavement        = set_value('chkI_Bereavement')        =='TRUE';
            $displayData['formData']->i_bTelephoneCall      = set_value('chkI_TelephoneCall')      =='TRUE';
            $displayData['formData']->i_bExcursionErrands   = set_value('chkI_ExcursionErrands')   =='TRUE';
            $displayData['formData']->i_bMusicPetArtSupport = set_value('chkI_MusicPetArtSupport') =='TRUE';
            $displayData['formData']->i_bFoodPreparation    = set_value('chkI_FoodPreparation')    =='TRUE';
            $displayData['formData']->i_bHouseholdChores    = set_value('chkI_HouseholdChores')    =='TRUE';
            $displayData['formData']->i_bOtherIntervention  = set_value('chkI_OtherIntervention')  =='TRUE';
            $displayData['formData']->txtI_Notes = set_value('txtI_Notes');

               // Visit Info
            $this->cList->enumListType = CENUM_LISTTYPE_PV_PSTATUS;
            $this->loadMultiIDs('ddlM_PatientStatus', $matchIDs_PStatus);
            $displayData['formData']->ddlM_PatientStatus =
                  $this->cList->strLoadListMultiDDL($glChapterID, 'ddlM_PatientStatus', 5, true, $matchIDs_PStatus);

            $this->cList->enumListType = CENUM_LISTTYPE_PV_VISITTASKS;
            $this->loadMultiIDs('ddlM_VisitTasks', $matchIDs_VTasks);
            $displayData['formData']->ddlM_VisitTasks =
                  $this->cList->strLoadListMultiDDL($glChapterID, 'ddlM_VisitTasks', 5, true, $matchIDs_VTasks);
            $displayData['formData']->txtVisitNotes         = set_value('txtVisitNotes');
            $displayData['formData']->TSK_bVisitors         = set_value('chkTSK_Visitors') == 'TRUE';
            $displayData['formData']->txtTSKPatientComfort  = set_value('txtTSKPatientComfort');
            $displayData['formData']->txtTSKPatientPain     = set_value('txtTSKPatientPain');
            $displayData['formData']->txtTSKPatientConcerns = set_value('txtTSKPatientConcerns');
         }

            //--------------------------
            // breadcrumbs
            //--------------------------
         $displayData['pageTitle']  = ' Patient Visit';

         $displayData['title']          = CS_PROGNAME.' | Patient Visit';
         $displayData['nav']            = $this->mnav_brain_jar->navData();

         $displayData['mainTemplate']   = 'hospice/patient_visit_add_edit_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $pVisit->lChapterID             = $glChapterID;
         $pVisit->lPatientID             = $lPatientID;
         $pVisit->lVolID                 = $lVolID;

         $strDate = trim($_POST['txtDateOfVisit']);
         MDY_ViaUserForm($strDate, $lMon, $lDay, $lYear, $gbDateFormatUS);
         $pVisit->dteVisit = mktime(0, 0, 0, $lMon, $lDay, $lYear);

         $pVisit->lStartTime             = (int)$_POST['ddlStart'];
         $pVisit->lDuration              = (int)$_POST['ddlDuration'];
         $pVisit->strMedRec              = $_POST['txtMedRecNum'];

         $pVisit->ps_bPatient            = @$_POST['chkPS_Patient']   == 'TRUE';
         $pVisit->ps_bCaregiver          = @$_POST['chkPS_Caregiver'] == 'TRUE';
         $pVisit->ps_bBereaved           = @$_POST['chkPS_Bereaved']  == 'TRUE';
         $pVisit->ps_bOther              = @$_POST['chkPS_Other']     == 'TRUE';
         $pVisit->ps_strNotes            = $_POST['txtPS_Notes'];

         $pVisit->act_lActivityID        = (int)$_POST['ddlActivity'];
         $pVisit->act_strNotes           = $_POST['txtActivityNotes'];

         $pVisit->loc_lLocationID        = (int)$_POST['ddlLocation'];
         $pVisit->loc_strNotes           = $_POST['txtLocationNotes'];

         $pVisit->in_bCompanionship      = @$_POST['chkI_Companionship']      == 'TRUE';
         $pVisit->in_bCaregiverRelief    = @$_POST['chkI_CaregiverRelief']    == 'TRUE';
         $pVisit->in_bEmotionalSupport   = @$_POST['chkI_EmotionalSupport']   == 'TRUE';
         $pVisit->in_bSocialization      = @$_POST['chkI_Socialization']      == 'TRUE';
         $pVisit->in_bBereavement        = @$_POST['chkI_Bereavement']        == 'TRUE';
         $pVisit->in_bTelephoneCall      = @$_POST['chkI_TelephoneCall']      == 'TRUE';
         $pVisit->in_bExcursionErrands   = @$_POST['chkI_ExcursionErrands']   == 'TRUE';
         $pVisit->in_bMusicPetArt        = @$_POST['chkI_MusicPetArtSupport'] == 'TRUE';
         $pVisit->in_bFoodPrep           = @$_POST['chkI_FoodPreparation']    == 'TRUE';
         $pVisit->in_bHouseholdChores    = @$_POST['chkI_HouseholdChores']    == 'TRUE';
         $pVisit->in_bOther              = @$_POST['chkI_OtherIntervention']  == 'TRUE';
         $pVisit->in_strNotes            = $_POST['txtI_Notes'];

         $pVisit->tsk_strOtherNotes      = $_POST['txtVisitNotes'];
         $pVisit->tsk_bVisitors          = @$_POST['chkTSK_Visitors']  == 'TRUE';
         $pVisit->tsk_strPatientComfort  = $_POST['txtTSKPatientComfort'];
         $pVisit->tsk_strPatientPain     = $_POST['txtTSKPatientPain'];
         $pVisit->tsk_strChangesConcerns = $_POST['txtTSKPatientConcerns'];

            // multi-select DDLs
         $pVisit->status = new stdClass;
         $pVisit->status->IDs = arrayCopy($_POST['ddlM_PatientStatus']);
         $pVisit->status->lNumInList = count($pVisit->status->IDs);

         $pVisit->tasks = new stdClass;
         $pVisit->tasks->IDs = arrayCopy($_POST['ddlM_VisitTasks']);
         $pVisit->tasks->lNumInList = count($pVisit->tasks->IDs);

         if ($bNew){
            $lPVRecID = $this->cPVisit->lAddNewPVisit($pVisit);
            $this->session->set_flashdata('msg', 'The patient visit record was added.');
         }else {
            $this->cPVisit->updatePVisit($lPVRecID, $pVisit);
            $this->session->set_flashdata('msg', 'The patient visit record was updated.');
         }
         redirect('hospice/patient_visit/visitRecView/'.$lPVRecID);
      }
   }

   function loadMultiIDs($strDDL, &$matchIDs){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $matchIDs = array();
      if (isset($_POST[$strDDL])){
         foreach ($_POST[$strDDL] as $ID){
            $ID = (int)$ID;
            if ($ID > 0) $matchIDs[] = $ID;
         }
      }
   }

   function verifyVisitTasks($status){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->loadMultiIDs('ddlM_VisitTasks', $IDs);
      $lNum = count($IDs);
      if ($lNum==0){
         $this->form_validation->set_message('verifyVisitTasks', 'Please select one or more entries.');
         return(false);
      }else {
         return(true);
      }
   }

   function verifyPatientStatus($status){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->loadMultiIDs('ddlM_PatientStatus', $IDs);
      $lNum = count($IDs);
      if ($lNum==0){
         $this->form_validation->set_message('verifyPatientStatus', 'Please select one or more entries.');
         return(false);
      }else {
         return(true);
      }
   }

   function verifyVisitDate($strVisitDate){
      if (!bValidVerifyDate($strVisitDate)){
         $this->form_validation->set_message('verifyVisitDate', 'The <b>Visit Date</b> is not valid.');
         return(false);
      }
      if (!bValidVerifyNotFuture($strVisitDate)){
         $this->form_validation->set_message('verifyVisitDate', 'The <b>Visit Date</b> is in the future!.');
         return(false);
      }
      return(true);
   }

   function verifyPS($strNotes){
      $bPatient   = @$_POST['chkPS_Patient']   == 'TRUE';
      $bCaregiver = @$_POST['chkPS_Caregiver'] == 'TRUE';
      $bBereaved  = @$_POST['chkPS_Bereaved']  == 'TRUE';
      $bOther     = @$_POST['chkPS_Other']     == 'TRUE';

      if ($bOther && $strNotes==''){
         $this->form_validation->set_message('verifyPS', 'Please add <b>notes</b> to describe the person served.');
         return(false);
      }
      if (!($bPatient || $bCaregiver || $bBereaved || $bOther)){
         $this->form_validation->set_message('verifyPS', 'Please check one or more boxes for <b>Person Served</b>.');
         return(false);
      }
      return(true);
   }

   function verifyIntervention($strNotes){
      $bCompanionship               = @$_POST['chkI_Companionship']      == 'TRUE';
      $bCaregiverRelief             = @$_POST['chkI_CaregiverRelief']    == 'TRUE';
      $bEmotionalSupport            = @$_POST['chkI_EmotionalSupport']   == 'TRUE';
      $bSocialization               = @$_POST['chkI_Socialization']      == 'TRUE';
      $bBereavement                 = @$_POST['chkI_Bereavement']        == 'TRUE';
      $bTelephoneCall               = @$_POST['chkI_TelephoneCall']      == 'TRUE';
      $bExcursionErrands            = @$_POST['chkI_ExcursionErrands']   == 'TRUE';
      $bMusicPetArtSupport          = @$_POST['chkI_MusicPetArtSupport'] == 'TRUE';
      $bFoodPreparation             = @$_POST['chkI_FoodPreparation']    == 'TRUE';
      $bHouseholdChores             = @$_POST['chkI_HouseholdChores']    == 'TRUE';
      $bOtherIntervention           = @$_POST['chkI_OtherIntervention']  == 'TRUE';

      if ($bOtherIntervention && $strNotes==''){
         $this->form_validation->set_message('verifyIntervention', 'Please add <b>notes</b> to describe the other interventions.');
         return(false);
      }
      if (!(
            $bCompanionship       ||
            $bCaregiverRelief     ||
            $bEmotionalSupport    ||
            $bSocialization       ||
            $bBereavement         ||
            $bTelephoneCall       ||
            $bExcursionErrands    ||
            $bMusicPetArtSupport  ||
            $bFoodPreparation     ||
            $bHouseholdChores     ||
            $bOtherIntervention)){
         $this->form_validation->set_message('verifyIntervention', 'Please check one or more boxes for <b>Interventions</b>.');
         return(false);
      }
      return(true);
   }

   function verifyLocation($lLocationID){
      $lLocationID = (int)$lLocationID;
      if ($lLocationID <= 0){
         $this->form_validation->set_message('verifyLocation', 'Please select a <b>location</b>.');
         return(false);
      }
      return(true);
   }

   function verifyActivity($ID){
      $ID = (int)$ID;
      if ($ID <= 0){
         $this->form_validation->set_message('verifyActivity', 'Please select an <b>activity</b>.');
         return(false);
      }
      return(true);
   }

   function verifyActivityNotes($strNotes){
      global $glChapterID;
      $lOtherID = $this->cList->lListItemIDViaTypeName($glChapterID, CENUM_LISTTYPE_PV_ACTIVITIES, '(Other - please specify in notes)');
      if ($lOtherID > 0){
         if (((int)$_POST['ddlActivity']==$lOtherID) && ($strNotes=='')){
            $this->form_validation->set_message('verifyActivityNotes', 'Please provide notes for the <b>activity</b>.');
            return(false);
         }
      }
      return(true);
   }

   function verifyLocationNotes($strNotes){
      global $glChapterID;
      $lOtherID = $this->cList->lListItemIDViaTypeName($glChapterID, CENUM_LISTTYPE_PV_LOCATIONS, '(Other - please specify in notes)');
      if ($lOtherID > 0){
         if (((int)$_POST['ddlLocation']==$lOtherID) && ($strNotes=='')){
            $this->form_validation->set_message('verifyLocationNotes', 'Please provide notes for the <b>location</b>.');
            return(false);
         }
      }
      return(true);
   }

   function verifyVisitNotes($strNotes){
      global $glChapterID;
      $lOtherID = $this->cList->lListItemIDViaTypeName($glChapterID, CENUM_LISTTYPE_PV_VISITTASKS, '(Other - please specify in notes)');
      if ($lOtherID > 0){
         $this->loadMultiIDs('ddlM_VisitTasks', $IDs);

         if (in_array($lOtherID, $IDs) && ($strNotes=='')){
            $this->form_validation->set_message('verifyVisitNotes', 'Please provide notes for the <b>Other Visit Activities</b>.');
            return(false);
         }
      }
      return(true);
   }

   function verifyDurationDDL($ID){
      $ID = (int)$ID;
      if ($ID <= 0){
         $this->form_validation->set_message('verifyDurationDDL', 'Please select a <b>duration</b>.');
         return(false);
      }
      return(true);
   }

   function verifyStartTimeDDL($ID){
      $ID = (int)$ID;
      if ($ID <= 0){
         $this->form_validation->set_message('verifyStartTimeDDL', 'Please select a <b>start time</b>.');
         return(false);
      }
      return(true);
   }

   function removeRecord($lVolID, $lPVRecID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID, $gbVolMgr;

      if (!bTestForURLHack('volMgr')) return;

      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lVolID,   'volunteer ID');
      verifyID($glChapterID, $lPVRecID, 'patientVisit ID');

         //----------------------------------------------
         // models / helpers
         //----------------------------------------------
      $this->load->model  ('vols/mvol', 'cVol');
      $this->load->model  ('util/mlist_generic',      'cList');
      $this->load->model  ('hospice/mhospice_pvisit', 'cPVisit');
      $this->load->helper('hospice/hospice_util');

         // load patient visit record
      $this->cPVisit->loadPVisitsViaVisitID($lPVRecID, $lNumPVRecs, $pVisits);
      $pVisit = &$pVisits[0];
      $lPatientID = $pVisit->lPatientID;

      $this->cVol->loadVolClientAssocViaVolID($lVolID, $volClients, true);
      if (!hospiceUtil\bVerifyVolClientAssoc($lVolID, $lPatientID, $volClients, $lVCIDX)){
         $this->session->set_flashdata('error', 'Invalid volunteer/patient association. Please contact your volunteer manager.');
         redirect('hospice/hospice_error/error');
         return;
      }

      $this->cPVisit->retirePVisitsViaVisitID($lPVRecID);

      $this->session->set_flashdata('msg', 'The patient visit record was removed.');
      redirect('hospice/review/reviewHours/'.$lVolID);
   }



}




