<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// Hospice Volunteer Solutions
// copyright (c) 2015 Database Austin
//
// author: John Zimmerman
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------*/

class mnav_brain_jar extends CI_Model{

   function __construct(){
      parent::__construct();
   }

   function navData(){
      return(strTrimAllLines($this->navDataHospiceVolunteer()));
   }

   private function navDataHospiceVolunteer(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbSuperUser, $gbVolMgr, $gbVolLogin, $gVolPerms, $gstrSafeName;

      $navData = "\n".'<ul id="navDD" class="dropdown dropdown-horizontal">'."\n";
      if ($gbSuperUser){
         $navData .= $this->navDataSuperUser();
      }elseif ($gbVolMgr){
         $navData .= $this->navMenu_VolMgr();
      }else {
         $navData .= $this->navDataVolunteer();
      }
      $navData .= '<li>'.anchor('hospice/more/help', 'Help', 'id="mb_vv_help"').'</li>';
      $navData .= '<li>&nbsp;</li><li>'.anchor('login/signout', 'Sign Out', 'id="mb_vv_so"').'</li>';
      $navData .= '</ul>';
      return($navData);
   }

   function navDataSuperUser(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
         //--------------------------------
         //   Super User => Locations
         //--------------------------------
      $strOut = '
            <li class="dir">Locations
               <ul>';
      $strOut .= '<li>'.anchor('hospice/super/locations/locDir',          'Location Directory',   'id="su_loc_dir"').'</li>
                  <li>'.anchor('hospice/super/location_rec/addEditLoc/0', 'Add New Location',     'id="su_loc_new"').'</li>'."\n";
      $strOut .= '
               </ul>
            </li>';

         //--------------------------------
         //   Super User => Accounts
         //--------------------------------
      $strOut .= '
            <li class="dir">Accounts
               <ul>';
      $strOut .= '<li>'.anchor('hospice/super/accounts/superVolMgr',     'Super User & Vol. Managers', 'id="su_ua_svm"').'</li>
                  <li>'.anchor('hospice/super/account_rec/addEditSuper',  'Add Super User Account',            'id="su_ua_addSU"').'</li>
                  <li>'.anchor('hospice/super/account_rec/addEditVolMgr', 'Add Vol. Manager Account',     'id="su_ua_addVM"').'</li>'."\n";
      $strOut .= '
               </ul>
            </li>';

         //--------------------------------
         //   Super User => Reports
         //--------------------------------
      $strOut .= '
            <li class="dir">Reports
               <ul>';
      $strOut .= '<li>'.anchor('hospice/reports/su_db_stats/run',        'Organization Stats', 'id="su_rep_dbstats"').'</li>'."\n";
      $strOut .= '<li>'.anchor('hospice/reports/su_annual/opts',         'Annual Summary',     'id="su_rep_annual"').'</li>'."\n";
      $strOut .= '<li>'.anchor('hospice/reports/su_monthly/opts',        'Monthly Summary',    'id="su_rep_monthly"').'</li>'."\n";
      $strOut .= '<li>'.anchor('hospice/reports/su_data_entry/opts',     'Monthly Data Entry', 'id="su_rep_mdentry"').'</li>'."\n";
      $strOut .= '
               </ul>
            </li>';

         //--------------------------------
         //   Super User => Admin
         //--------------------------------
      $strOut .= '
            <li class="dir">Admin
               <ul>';
      $strOut .= '<li>'.anchor('hospice/super/db/dbBackupOpts',         'Database Backup',   'id="mb_admin_dbback"').'</li>'."\n";
      $strOut .= '
               </ul>
            </li>';

      return($strOut);
   }

   function navDataVolunteer(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID;

      $strOut  = '<li>'.anchor('hospice/patient_visit/pAssoc', 'Patient Visit', 'id="mb_lpv"').'</li>';

      $strOut .= '<li>'.anchor('hospice/vols/hospice_vol/otherActivity', 'Other Volunteer Activity', 'id="mb_loa"').'</li>';

      $strOut .= '<li>'.anchor('hospice/review/reviewHours', 'Review Volunteer Log', 'id="mb_loa"').'</li>';

      $strOut .= '<li>'.anchor('hospice/vols/vol_record/viewVolRecViaUID', 'Your Contact Info', 'id="mb_vv_ci"').'</li>';

      $strOut .= '<li>'.anchor('more/user_acct/pw/'.$glUserID, 'Reset Password', 'id="mb_vv_rp"').'</li>';

      return($strOut);
   }

   function navMenu_VolMgr(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glChapterID, $glUserID;

      $strOut = ''; // '<ul>'."\n";

         //--------------------------------
         //   Vol. Manager => Volunteers
         //--------------------------------
      $strOut .= '
            <li class="dir">Volunteers
               <ul>';
      $strOut .= '<li>'.anchor('hospice/vols/vol_directory/view/false/A',  'Volunteer Directory', 'id="mb_v_dir"').'</li>
                  <li>'.anchor('hospice/vols/hospice_vol/addEditVol/0',   'Add New Volunteer',   'id="mb_v_addnew"').'</li>'."\n";
      $strOut .= '
               </ul>
            </li>';

         //--------------------------------
         //   Vol. Manager => Patients
         //--------------------------------
      $strOut .= '
            <li class="dir">Patients
               <ul>';
      $strOut .= '<li>'.anchor('hospice/patients/patient_directory/view/N/A', 'Patient Directory', 'id="mb_p_dir"').'</li>
                  <li>'.anchor('hospice/patients/patient_rec/addEditPRec/0',  'Add New Patient',   'id="mb_p_addnew"').'</li>'."\n";
      $strOut .= '
               </ul>
            </li>';

         //--------------------------------
         //   Vol. Manager => Reports
         //--------------------------------
      $strOut .= '
            <li class="dir">Reports
               <ul>';
      $strOut .= '<li>'.anchor('hospice/reports/monthly/opts',          'Monthly Report',          'id="mb_rep_mo"').'</li>'."\n";
      $strOut .= '<li>'.anchor('hospice/reports/calendar_report/opts',  'Calendar Report',         'id="mb_rep_cal"').'</li>'."\n";
      $strOut .= '<li>'.anchor('hospice/reports/visit_review/opts',     'Patient Visit Review',    'id="mb_rep_pvReview"').'</li>';
      $strOut .= '<li>'.anchor('hospice/reports/activity/opts',         'Non-Visit Activies',      'id="mb_rep_activity"').'</li>';
      $strOut .= '<li>'.anchor('hospice/reports/activity/optsJobCodes', 'Non-Visit Job Codes',     'id="mb_rep_jobcodes"').'</li>';
      $strOut .= '<li>'.anchor('hospice/reports/vol_stats/opts',        'Volunteer Stats',         'id="mb_rep_volStats"').'</li>';
      $strOut .= '
               </ul>
            </li>';

         //--------------------------------
         //   Vol. Manager => More
         //--------------------------------
      $strOut .= '
            <li class="dir">More
               <ul>';
      $strOut .= '<li>'.anchor('hospice/super/location_rec/locationRecView/'.$glChapterID,  'Your Location', 'id="mb_admin_orgrec"').'</li>'."\n";
      $strOut .= '<li>'.anchor('more/user_acct/pw/'.$glUserID,                              'Reset Password', 'id="mb_vv_rp"').'</li>';
      $strOut .= '<li>'.anchor('hospice/super/account_rec/addEditAcct/'.$glUserID,          'Your Contact Info', 'id="mb_vv_ci"').'</li>';

         //--------------------------------
         //   Vol. Manager => Lists
         //--------------------------------
      $strOut .= '
            <li class="dir">Lists
               <ul>';
      $strOut .= '<li>'.anchor('admin/alists_generic/view/attrib',                 '"Attributed To"',                 'id="ml_attrib"').'</li>'."\n";
      $strOut .= '<li>'.anchor('admin/alists_generic/view/volShiftJobCodes',       'Job Codes',                       'id="ml_jobcodes"').'</li>'."\n";
      $strOut .= '<li>'.anchor('admin/alists_generic/view/pvActivities',           'Patient Visit / Activities',      'id="ml_pvActivities"').'</li>'."\n";
      $strOut .= '<li>'.anchor('admin/alists_generic/view/pvLocations',            'Patient Visit / Locations',       'id="ml_pvLocations"').'</li>'."\n";
      $strOut .= '<li>'.anchor('admin/alists_generic/view/pvPStatus',              'Patient Visit / Patient Status',  'id="ml_pvPStatus"').'</li>'."\n";
      $strOut .= '<li>'.anchor('admin/alists_generic/view/pvVisitTasks',           'Patient Visit / Visit Tasks',     'id="ml_pvVisitTasks"').'</li>'."\n";
      $strOut .= '<li>'.anchor('admin/alists_generic/view/volTraining',            'Volunteer Training',              'id="ml_volTraining"').'</li>'."\n";
      $strOut .= '<li>'.anchor('admin/alists_generic/view/volTrainingBy',          'Training Conducted By',           'id="ml_volTrainingBy"').'</li>'."\n";
      $strOut .= '<li>'.anchor('admin/alists_generic/view/patientContactRelation', 'Patient Contacts / Relationship', 'id="ml_pcRel"').'</li>'."\n";
      $strOut .= '
               </ul>
            </li>';
      $strOut .= '
               </ul>
            </li>';

      return($strOut);
   }

}