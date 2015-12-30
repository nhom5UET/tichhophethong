<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class location_rec extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function addEditLoc($lLocID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbDateFormatUS, $glChapterID;

      if (!bTestForURLHack('superUser')) return;
      $this->load->helper('dl_util/verify_id');
      if ((int)$lLocID > 0) verifyID($glChapterID, $lLocID, 'organization ID');

      $displayData = array();
      $displayData['lLocID'] = $lLocID = (int)$lLocID;
      $displayData['bNew']   = $bNew = $lLocID <= 0;

      $displayData['js'] = '';
      $displayData['formData'] = new stdClass;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model  ('admin/mlocations', 'cLoc');
      $this->load->helper ('dl_util/web_layout');
      $this->load->helper ('dl_util/time_date');
      $this->load->library('util/dl_date_time', '', 'clsDateTime');

         // load location record
      $this->cLoc->loadLocationViaChapterID($lLocID, $lNumLocs, $locations);
      $displayData['locRec'] = $locRec = &$locations[0];

         // validation rules
      $this->form_validation->set_error_delimiters('<div class="formError">', '</div>');
      $this->form_validation->set_rules('txtLocName',      '<b>Location Name</b>',   'trim|required|callback_verifyUniqueLoc['.$lLocID.']');
      $this->form_validation->set_rules('txtLocBannerTag', '<b>Banner Tag Line</b>', 'trim|required');
      $this->form_validation->set_rules('txtNotes',        '',   'trim');

      $this->form_validation->set_rules('txtPhone',      'Phone',  'trim');
      $this->form_validation->set_rules('txtFax',        'Fax',    'trim');
      $this->form_validation->set_rules('txtWeb',        'Web Address',   'trim');
      $this->form_validation->set_rules('txtEmail',      '<b>EMail</b>',  'trim|valid_email');

      $this->form_validation->set_rules('txtAddr1',      '', 'trim');
      $this->form_validation->set_rules('txtAddr2',      '', 'trim');
      $this->form_validation->set_rules('txtCity',       '', 'trim');
      $this->form_validation->set_rules('txtState',      '', 'trim');
      $this->form_validation->set_rules('txtZip',        '', 'trim');
      $this->form_validation->set_rules('txtCountry',    '', 'trim');

      if ($this->form_validation->run() == FALSE){
         $this->load->library('generic_form');

         if (validation_errors()==''){
            if ($bNew){
               $displayData['formData']->txtLocName      =
               $displayData['formData']->txtLocBannerTag = '';

               $displayData['formData']->txtPhone    =
               $displayData['formData']->txtFax      =
               $displayData['formData']->txtWeb      =
               $displayData['formData']->txtEmail    = '';

               $displayData['formData']->txtAddr1    =
               $displayData['formData']->txtAddr2    =
               $displayData['formData']->txtCity     =
               $displayData['formData']->txtState    =
               $displayData['formData']->txtZip      =
               $displayData['formData']->txtCountry  = '';

               $displayData['formData']->txtNotes    = '';
            }else {
               $displayData['formData']->txtLocName      = htmlspecialchars($locRec->strLocationName);
               $displayData['formData']->txtLocBannerTag = htmlspecialchars($locRec->strBannerTagLine);

               $displayData['formData']->txtPhone    = htmlspecialchars($locRec->strPhone);
               $displayData['formData']->txtFax      = htmlspecialchars($locRec->strFax);
               $displayData['formData']->txtWeb      = htmlspecialchars($locRec->strWebSite);
               $displayData['formData']->txtEmail    = htmlspecialchars($locRec->strEmail);

               $displayData['formData']->txtAddr1    = htmlspecialchars($locRec->strAddress1);
               $displayData['formData']->txtAddr2    = htmlspecialchars($locRec->strAddress2);
               $displayData['formData']->txtCity     = htmlspecialchars($locRec->strCity);
               $displayData['formData']->txtState    = htmlspecialchars($locRec->strState);
               $displayData['formData']->txtZip      = htmlspecialchars($locRec->strZip);
               $displayData['formData']->txtCountry  = htmlspecialchars($locRec->strCountry);

               $displayData['formData']->txtNotes    = htmlspecialchars($locRec->strNotes);
            }
         }else {
            setOnFormError($displayData);

            $displayData['formData']->txtLocName      = set_value('txtLocName');
            $displayData['formData']->txtLocBannerTag = set_value('txtLocBannerTag');

            $displayData['formData']->txtPhone    = set_value('txtPhone');
            $displayData['formData']->txtFax      = set_value('txtFax');
            $displayData['formData']->txtWeb      = set_value('txtWeb');
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

         $displayData['pageTitle']  = 'Location';

         $displayData['title']          = CS_PROGNAME.' | Locations';
         $displayData['nav']            = $this->mnav_brain_jar->navData();

         $displayData['mainTemplate']   = 'hospice/super/location_add_edit_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $locRec->strLocationName  = $_POST['txtLocName'];
         $locRec->strBannerTagLine = $_POST['txtLocBannerTag'];

         $locRec->strAddress1      = $_POST['txtAddr1'];
         $locRec->strAddress2      = $_POST['txtAddr2'];
         $locRec->strCity          = $_POST['txtCity'];
         $locRec->strState         = $_POST['txtState'];
         $locRec->strCountry       = $_POST['txtCountry'];
         $locRec->strZip           = $_POST['txtZip'];
         $locRec->strPhone         = $_POST['txtPhone'];
         $locRec->strFax           = $_POST['txtFax'];
         $locRec->strEmail         = $_POST['txtEmail'];
         $locRec->strWebSite       = $_POST['txtWeb'];
         $locRec->strNotes         = $_POST['txtNotes'];

         if ($bNew){
            $this->load->model('util/mlist_generic');
            $lLocID = $this->cLoc->lAddNewLocation($locRec);
            $this->session->set_flashdata('msg', 'The new location record was added.<br><br>
                        Please add a volunteer manager account for this new location.');
         }else {
            $this->cLoc->updateLocation($lLocID, $locRec);
            $this->session->set_flashdata('msg', 'The location record was updated.');
         }
         redirect('hospice/super/location_rec/locationRecView/'.$lLocID);
      }
   }

   function verifyUniqueLoc($strLoc, $lLocID){
      $id = (int)$lLocID;
      $strLoc = xss_clean(trim($strLoc));
      $this->load->model('util/mverify_unique', 'clsUnique');
      if (!$this->clsUnique->bVerifyUniqueText(
                $strLoc, 'ch_strChapterName',
                $id,   'ch_lKeyID',
                true,  'ch_bRetired',
                false, null, null,
                false, null, null,
                'admin_chapters')){
         $this->form_validation->set_message('verifyUniqueLoc',
                        'This <b>location</b> is already being used.');
         return(false);
      }else {
         return(true);
      }
   }

   function locationRecView($lChapterID = null){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID, $gbSuperUser;

      if (!$gbSuperUser){
         if (!bTestForURLHack('volMgr')) return;
      }

      if (is_null($lChapterID)){
         $lChapterID = $glChapterID;
      }else {
         $lChapterID = (int)$lChapterID;
      }

      $displayData = array();
      $displayData['js'] = '';

         //-------------------------
         // models & helpers
         //-------------------------
      $this->load->helper ('dl_util/directory');
      $this->load->helper ('dl_util/rs_navigate');
      $this->load->helper ('hospice/link_hospice');
      $this->load->model  ('admin/mlocations', 'cLoc');
      $this->load->helper ('js/div_hide_show');
      $this->load->helper ('dl_util/web_layout');
      $this->load->helper ('dl_util/record_view');
      $this->load->helper ('img_docs/link_img_docs');
      $displayData['js'] .= showHideDiv();

      $this->cLoc->loadLocationViaChapterID($lChapterID, $lNumLocs, $locations);
      $displayData['locRec'] = &$locations[0];

      $this->load->library('generic_form');
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);

      $displayData['title']          = CS_PROGNAME.' | Your Location';
      $displayData['pageTitle']      = 'Your Location';
      $displayData['nav']            = $this->mnav_brain_jar->navData();
      $displayData['mainTemplate']   = 'hospice/super/location_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function removeLocation($lLocID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbDateFormatUS, $glChapterID;

      if (!bTestForURLHack('superUser')) return;
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $lLocID, 'organization ID');
      $lLocID = (int)$lLocID;
      
         //-------------------------
         // models & helpers
         //-------------------------
      $this->load->model  ('admin/mlocations', 'cLoc');
      
      $this->cLoc->removeLocation($lLocID);
      $this->session->set_flashdata('msg', 'The specified location was removed.');
      redirect('hospice/super/locations/locDir');
   }

}
