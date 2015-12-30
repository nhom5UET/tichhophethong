<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
   Hospice Volunteer Solutions!

   copyright (c) 2015 by Database Austin
   Austin, Texas

   This software is provided under the GPL.
   Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------*/

class org extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function orgRecView($lChapterID = null){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID;
      if (!bTestForURLHack('volMgr')) return;

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
      $this->load->helper ('img_docs/img_doc_tags');
      $this->load->helper ('dl_util/directory');
      $this->load->helper ('dl_util/rs_navigate');
      $this->load->model  ('admin/mlocations', 'cLoc');
//      $this->load->helper ('img_docs/link_img_docs');
      $this->load->helper ('js/div_hide_show');
      $this->load->helper ('dl_util/web_layout');
      $this->load->helper ('dl_util/record_view');
      $this->load->helper ('img_docs/link_img_docs');
      $displayData['js'] .= showHideDiv();

//      $this->clsChapter->lChapterID = $lChapterID;
      $this->cLoc->loadLocationViaChapterID($lChapterID, $lNumLocs, $locations);
      $displayData['chapterRec'] = &$locations[0];

         //-------------------------------
         // images and documents
         //-------------------------------
//      loadImgDocRecView($displayData, CENUM_CONTEXT_ORGANIZATION, $lChapterID);

      $this->load->library('generic_form');
      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);

      $displayData['title']          = CS_PROGNAME.' | Your Organization';
      $displayData['pageTitle']      = 'Your Organization';
      $displayData['nav']            = $this->mnav_brain_jar->navData();
      $displayData['mainTemplate']   = 'admin/organization_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function addEdit($id){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (!bTestForURLHack('volMgr')) return;

      $displayData = array();
      $displayData['clsChapter'] = new stdClass;

      $displayData['id'] = $lChapterID = (integer)$id;
      $displayData['bNew']    = $bNew    = $id <= 0;

         // load models
      $this->load->model('admin/morganization', 'clsChapter');
      $this->load->helper('dl_util/web_layout');

      $this->clsChapter->lChapterID = $id;
      $this->clsChapter->loadChapterInfo();
      $cRec = $this->clsChapter->chapterRec;

         // validation rules
      $this->form_validation->set_error_delimiters('<div class="formError">', '</div>');
      $this->form_validation->set_rules('txtChapter',  'Organization Name',   'trim|required');
      $this->form_validation->set_rules('txtBanner',   'Banner Tag Line',     'trim|required');
      $this->form_validation->set_rules('txtAddr1'    );
      $this->form_validation->set_rules('txtAddr2'    );
      $this->form_validation->set_rules('txtCity'     );
      $this->form_validation->set_rules('txtState'    );
      $this->form_validation->set_rules('txtCountry'  );
      $this->form_validation->set_rules('txtZip'      );
      $this->form_validation->set_rules('txtPhone'    );
      $this->form_validation->set_rules('txtFax'      );
      $this->form_validation->set_rules('txtEmail',    'EMail', 'trim|valid_email');
      $this->form_validation->set_rules('txtWebSite'  );

      if ($this->form_validation->run() == FALSE){

         $displayData['title']        = CS_PROGNAME.' | Your Organization';
         $displayData['pageTitle']    = anchor('main/menu/admin', 'Admin', 'class="breadcrumb"')
                                 .' | '.anchor('admin/org/orgRecView', 'Your Organization', 'class="breadcrumb"')
                                 .' |  Edit Organization';
         $displayData['nav']          = $this->mnav_brain_jar->navData();

         $this->load->library('generic_form');

         if (validation_errors()==''){
            $displayData['clsChapter']->strName          = htmlspecialchars($cRec->strChapterName);
            $displayData['clsChapter']->strBanner        = htmlspecialchars($cRec->strBannerTagLine);
            $displayData['clsChapter']->strPhone         = htmlspecialchars($cRec->strPhone);
            $displayData['clsChapter']->strFax           = htmlspecialchars($cRec->strFax);
            $displayData['clsChapter']->strEmail         = htmlspecialchars($cRec->strEmail);
            $displayData['clsChapter']->strAddr1         = htmlspecialchars($cRec->strAddress1);
            $displayData['clsChapter']->strAddr2         = htmlspecialchars($cRec->strAddress2);
            $displayData['clsChapter']->strCity          = htmlspecialchars($cRec->strCity);
            $displayData['clsChapter']->strState         = htmlspecialchars($cRec->strState);
            $displayData['clsChapter']->strCountry       = htmlspecialchars($cRec->strCountry);
            $displayData['clsChapter']->strZip           = htmlspecialchars($cRec->strZip);

            $displayData['clsChapter']->strWebSite       = htmlspecialchars($cRec->strWebSite);
            $displayData['clsChapter']->strEmail         = htmlspecialchars($cRec->strEmail);
         }else {
            setOnFormError($displayData);
            $displayData['clsChapter']->strName          = set_value('txtChapter');
            $displayData['clsChapter']->strBanner        = set_value('txtBanner');
            $displayData['clsChapter']->strPhone         = set_value('txtPhone');
            $displayData['clsChapter']->strFax           = set_value('txtFax');
            $displayData['clsChapter']->strEmail         = set_value('txtEmail');
            $displayData['clsChapter']->strAddr1         = set_value('txtAddr1');
            $displayData['clsChapter']->strAddr2         = set_value('txtAddr2');
            $displayData['clsChapter']->strCity          = set_value('txtCity');
            $displayData['clsChapter']->strState         = set_value('txtState');
            $displayData['clsChapter']->strCountry       = set_value('txtCountry');
            $displayData['clsChapter']->strZip           = set_value('txtZip');

            $displayData['clsChapter']->strWebSite       = set_value('txtWebSite');
            $displayData['clsChapter']->strEmail         = set_value('txtEmail');
         }
         $displayData['mainTemplate'] = 'admin/organization_add_edit_view';
         $this->load->vars($displayData);
         $this->load->view('template');
      }else {
         $cRec->strChapterName   = xss_clean(trim($_POST['txtChapter']));
         $cRec->strBannerTagLine = xss_clean(trim($_POST['txtBanner']));
         $cRec->strPhone         = xss_clean(trim($_POST['txtPhone']));
         $cRec->strFax           = xss_clean(trim($_POST['txtFax']));
         $cRec->strEmail         = xss_clean(trim($_POST['txtEmail']));
         $cRec->strAddress1      = xss_clean(trim($_POST['txtAddr1']));
         $cRec->strAddress2      = xss_clean(trim($_POST['txtAddr2']));
         $cRec->strCity          = xss_clean(trim($_POST['txtCity']));
         $cRec->strState         = xss_clean(trim($_POST['txtState']));
         $cRec->strCountry       = xss_clean(trim($_POST['txtCountry']));
         $cRec->strZip           = xss_clean(trim($_POST['txtZip']));
         $cRec->strWebSite       = xss_clean(trim($_POST['txtWebSite']));
         $cRec->strEmail         = xss_clean(trim($_POST['txtEmail']));

         $_SESSION[CS_NAMESPACE.'_chapter']->strBanner      = $cRec->strBannerTagLine;
         $_SESSION[CS_NAMESPACE.'_chapter']->strChapterName = $cRec->strChapterName;

         if ($bNew){
            $lNewChapterID = $this->clsChapter->insertChapter();
            $this->session->set_flashdata('msg', 'The organization information was added');
         }else {
            $this->clsChapter->updateChapter($lChapterID);
            $this->session->set_flashdata('msg', 'Your organization\'s information was updated');
         }
         redirect('admin/org/orgRecView');
      }
   }

   function verifyTimeZone($strValue){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lSelectID = (int)$strValue;
      if ($lSelectID <= 0){
         $this->form_validation->set_message('verifyTimeZone', 'Please select a time zone.');
         return(false);
      }else {
         return(true);
      }
   }

}