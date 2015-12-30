<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hospice_error extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   public function error(){
   //-------------------------------------------------------------------------
   //
   //-------------------------------------------------------------------------
      $displayData = array();
      
      $displayData['pageTitle']    = 'Error';
      $displayData['title']        = CS_PROGNAME.' | Error';
      $displayData['nav']          = $this->mnav_brain_jar->navData();
      $displayData['mainTemplate'] = 'hospice/access_error_view';
      $this->load->vars($displayData);
      $this->load->view('template');
   }
   
}
   
