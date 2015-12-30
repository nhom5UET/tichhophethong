<?php
//---------------------------------------------------------------------
// Hospice Volunteer Solutions!
//
// copyright (c) 2015 by Database Austin
// Austin, Texas
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//
/*---------------------------------------------------------------------
      $this->load->helper('hospice/hospice_util');
---------------------------------------------------------------------*/

   namespace hospiceUtil;

   function bVerifyVolClientAssoc($lVolID, $lPatientID, $volClients, &$idx){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (count($volClients) == 0) return(false);
      $idx = 0;
      foreach ($volClients as $vc){
         if (($vc->lVolID == $lVolID) && ($vc->lPatientID == $lPatientID)){
            return(true);
         }
         ++$idx;
      }
      return(false);
   }
