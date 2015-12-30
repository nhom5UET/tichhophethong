<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class db extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function dbBackupOpts(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (!bTestForURLHack('superUser')) return;
      $displayData = array();

         //------------------------------------------------
         // libraries and utilities
         //------------------------------------------------
      $this->load->helper('dl_util/web_layout');
      $this->load->library('generic_form');

         //--------------------------
         // breadcrumbs
         //--------------------------
      $displayData['pageTitle']      = 'Database Backup';

      $displayData['title']          = CS_PROGNAME.' | Database Backup';
      $displayData['nav']            = $this->mnav_brain_jar->navData();

      $displayData['mainTemplate']   = 'hospice/super/db_backup_opts_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }
   
   function backupRun(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (!bTestForURLHack('superUser')) return;

      $this->load->dbutil();

      $strBackupType = trim($_POST['rdoType']);
      $bIncludeDrop  = @$_POST['chkDrop']=='true';
      $strDB         = $this->db->database;

      $this->genericDBBackup($strBackupType, $strDB, $bIncludeDrop);
   }

   private function genericDBBackup($strBackupType, $strDB, $bIncludeDrop){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (!bTestForURLHack('superUser')) return;
      
      set_time_limit (120);
      $this->load->helper('download');
      $this->load->model('admin/mdb_backup', 'cDBBackup');

      $prefs = array(
                'format'      => $strBackupType,    // gzip, zip, txt
                'filename'    => $strDB.'.sql',     // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => $bIncludeDrop,     // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'blockSize'   => 100,               // number of VALUES entries per statement
                'newline'     => "\n"               // Newline character used in backup file
              );
      $strBackup = $this->cDBBackup->strBackup($prefs);

      force_download($strDB.'.'.$strBackupType, $strBackup);
   }
   
   
   
   
   
   
   
   
   
   
}