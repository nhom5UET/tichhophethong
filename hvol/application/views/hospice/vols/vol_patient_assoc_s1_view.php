<?php

   $attributes = array('name'     => 'frmNewVolClient',
                       'onSubmit' => 'return verifySimpleSearch(frmNewVolClient);'
                       );

   echoT(form_open('hospice/vols/patient_assoc/addS2/'.$lVolID, $attributes));
   echoT('<br><br>');
   
   $clsSearch = new msearch_single_generic;
   $clsSearch->strLegendLabel = 'Associate Volunteer with Patient';
   $clsSearch->strButtonLabel = 'Search';

   $clsSearch->lSearchTableWidth = 240;
   $clsSearch->searchClientTableForm();
   
