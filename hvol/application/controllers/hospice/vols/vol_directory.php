<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class vol_directory extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function view($strShowInactive="false", $strLookupLetter='A', $lStartRec=0, $lRecsPerPage=50){
   //------------------------------------------------------------------------------
   //
   //------------------------------------------------------------------------------
      $this->view_generic($strShowInactive, $strLookupLetter, $lStartRec, $lRecsPerPage);
   }
   
   function view_generic($strShowInactive='true',$strLookupLetter='A', $lStartRec=0, $lRecsPerPage=50){
   //------------------------------------------------------------------------------
   //
   //------------------------------------------------------------------------------
      global $glChapterID;
   
      if (!bTestForURLHack('volMgr')) return;

      $strLookupLetter = urldecode($strLookupLetter);
      $displayData = array();
      $displayData['bShowInactive'] = $bShowInactive = strtoupper($strShowInactive)=='TRUE';
      $displayData['js'] = '';

         //------------------------------------------------
         // models / libraries / helpers
         //------------------------------------------------
      $this->load->helper('people/people');
      $this->load->helper('people/people_display');
      $this->load->model ('vols/mvol',        'clsVol');
      $this->load->model ('vols/mvol_skills', 'clsVolSkills');
      $this->load->helper('vols/vol');
      $this->load->helper('dl_util/time_duration_helper');
      $this->load->helper('dl_util/directory');
      $this->load->helper('dl_util/rs_navigate');
      $this->load->helper('hospice/link_hospice');
      $this->load->helper('dl_util/record_view');
      $this->load->helper('img_docs/link_img_docs');

      $params = array('enumStyle' => 'terse');
      $this->load->library('generic_rpt', $params);
      $this->load->library('util/dl_date_time', '', 'clsDateTime');

         //------------------------------------------------
         // sanitize the lookup letter
         //------------------------------------------------
      $displayData['strDirLetter'] = $strLookupLetter = strSanitizeLetter($strLookupLetter);
      
         // the toggle-a-tizer
      $strLabelToggle = ($bShowInactive ? '<b>Hide</b>' : '<b>Show</b> active and ').' inactive volunteers';

      $strLinkEnd = $lStartRec.'/'.$lRecsPerPage;
      $displayData['strToggleLink'] =
             anchor('hospice/vols/vol_directory/view/'
                     .($bShowInactive ? 'false' : 'true').'/'
                     .($strLookupLetter=='*' ? '%2A' : $strLookupLetter).'/'.$strLinkEnd, $strLabelToggle);
      
         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;

         //------------------------------------------------
         // define columns to display
         //------------------------------------------------
      initVolReportDisplay($displayData);
      $displayData['showFields']->bSkills = true;

         //------------------------------------------------
         // set up directory display
         //------------------------------------------------
      $displayData['strRptTitle']  = 'Volunteer Directory <span style="font-weight: normal;">('.($bShowInactive ? 'Active and Inactive' : 'Active Only').')</span>';
      $displayData['strLinkBase']  = $strLinkBase = 'hospice/vols/vol_directory/view/'.($bShowInactive ? 'true' : 'false').'/';
      $strWhereExtraReg = " AND vol_lChapterID=$glChapterID ";

      $displayData['strDirLetter'] = $strLookupLetter;
      $displayData['strDirTitle']  = strDisplayDirectory(
                                         $strLinkBase, ' class="directoryLetters" ', $strLookupLetter,
                                         true, $lStartRec, $lRecsPerPage);

         //------------------------------------------------
         // total # people for this letter
         //------------------------------------------------
      $displayData['lNumRecsTot']   = $lNumRecsTot = 
                  lNumVolRecsViaLetter($glChapterID,
                                       $strLookupLetter, CENUM_CONTEXT_VOLUNTEER, $bShowInactive, $strWhereExtraReg);
      $displayData['lNumVols']      = $lNumRecsTot;
      $displayData['strPeopleType'] = 'volunteer';

         //------------------------------------------------
         // load volunteer directory page
         //------------------------------------------------
      $strWhereExtra = $this->clsVol->strWhereByLetter($strLookupLetter).$strWhereExtraReg;
      if (!$bShowInactive){
         $strWhereExtra .= ' AND NOT vol_bInactive ';
      }

      $this->clsVol->loadVolDirectoryPage($strWhereExtra, $lStartRec, $lRecsPerPage);
      
      $displayData['lNumDisplayRows']      = $lNumVols = $this->clsVol->lNumVolRecs;
      $displayData['directoryRecsPerPage'] = $lRecsPerPage;
      $displayData['directoryStartRec']    = $lStartRec;
      if ($lNumVols){
         foreach ($this->clsVol->volRecs as $volRec){
            $this->clsVolSkills->lVolID = $lVolID = $volRec->lKeyID;
            $this->clsVolSkills->loadSingleVolSkills();
            $volRec->lNumJobSkills = $lNumSkills = $this->clsVolSkills->lNumSingleVolSkills;
            if ($lNumSkills > 0) {
               $volRec->volSkills     = arrayCopy($this->clsVolSkills->singleVolSkills);
            }

            $this->clsVol->loadVolClientAssocViaVolID($lVolID, $volRec->volClient, true);
         }
      }
      
      $displayData['vols'] = &$this->clsVol->volRecs;

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = array('hospice/vols/vol_directory_view', 'hospice/vols/rpt_generic_vol_list');
      $displayData['pageTitle']    = 'Volunteer Directory';

      $displayData['title']        = CS_PROGNAME.' | Volunteers';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }


}


