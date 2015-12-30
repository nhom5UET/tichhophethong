<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class account_dir extends CI_Controller {

   function __construct(){
      parent::__construct();
      session_start();
      setGlobals($this);
   }

   function userList($lLocID=null){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbSuperUser, $gbVolMgr, $glChapterID;
      
      if (!$gbSuperUser){
         if (!$gbVolMgr){
            bTestForURLHack('forceFail'); return;
         }else {
            if (is_null($lLocID)){
               $lLocID = $glChapterID;
            }else {
               if ($lLocID != $glChapterID){
                  bTestForURLHack('forceFail'); return;
               }
            }
         }
      }
      
      $bShowSuper = $lLocID <= 0;

   }
   
}
   