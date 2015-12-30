<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class accounts extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function superVolMgr(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gdteNow;
      if (!bTestForURLHack('superUser')) return;
      $displayData = array();
      $displayData['js'] = '';

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->model  ('admin/mpermissions', 'perms');
      $this->load->model  ('admin/muser_accts',  'cusers');
      $this->load->library('generic_form');
      $this->load->helper ('hospice/link_hospice');
      $this->load->helper ('hospice/link_hospice');
      $this->load->helper ('dl_util/web_layout');

      $this->load->helper ('js/div_hide_show');
      $displayData['js'] .= showHideDiv();

         //------------------------------------------------
         // stripes
         //------------------------------------------------
      $this->load->model('util/mbuild_on_ready', 'clsOnReady');
      $this->clsOnReady->addOnReadyTableStripes();
      $this->clsOnReady->closeOnReady();
      $displayData['js'] .= $this->clsOnReady->strOnReady;

         // load users
      $this->cusers->loadSuperUsers ($displayData['lNumSU'], $displayData['superUsers']);
      $this->cusers->loadVolMgrUsers($displayData['lNumVM'], $displayData['vmUsers']);

      $lNumSUActive = 0;
      foreach ($displayData['superUsers'] as $lAcct){
         if (!$lAcct->us_bInactive) ++$lNumSUActive;
      }
      $lNumVMActive = 0;
      foreach ($displayData['vmUsers'] as $lAcct){
         if (!$lAcct->us_bInactive) ++$lNumVMActive;
      }
      $displayData['lNumSUActive'] = $lNumSUActive;
      $displayData['lNumVMActive'] = $lNumVMActive;

         //------------------------------------------------
         // breadcrumbs / page setup
         //------------------------------------------------
      $displayData['mainTemplate'] = 'hospice/super/accounts_su_vol_view';
      $displayData['pageTitle']    = 'Super User / Volunteer Manager Accounts';

      $displayData['title']        = CS_PROGNAME.' | Accounts';
      $displayData['nav']          = $this->mnav_brain_jar->navData();

      $this->load->vars($displayData);
      $this->load->view('template');
   }

   function setActiveStateAcct($lAcctID, $bSetActive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (!bTestForURLHack('superUser')) return;
      $bSetActive = $bSetActive=='true';
      $lAcctID = (int)$lAcctID;

         //------------------------------------------------
         // models, libraries and utilities
         //------------------------------------------------
      $this->load->model('admin/mpermissions', 'perms');
      $this->load->model('admin/muser_accts',  'cusers');
      $this->cusers->actInactUserAccount($lAcctID, !$bSetActive);      

      $this->session->set_flashdata('msg', 'The selected account was set to '.($bSetActive ? '<b>Active</b>' : '<b>Inactive</b>').'.');
      redirect('hospice/super/accounts/superVolMgr');
   }



}
