

DROP TABLE IF EXISTS patient_visit;
CREATE TABLE IF NOT EXISTS patient_visit (
  pv_lKeyID        int(11) NOT NULL AUTO_INCREMENT,
  pv_lChapterID    int(11) NOT NULL,
  pv_lPatientID    int(11) NOT NULL,
  pv_lVolID        int(11) NOT NULL,
  pv_dteVisit      date DEFAULT NULL,
  pv_lStartTime    int(11) DEFAULT NULL COMMENT 'Unix timestamp',
  pv_lDuration     int(11) NOT NULL DEFAULT '0' COMMENT 'In minutes',
  pv_strMedRec     varchar(80) NOT NULL DEFAULT '',

     -- person served
  pv_ps_bPatient   tinyint(1) NOT NULL DEFAULT '0',
  pv_ps_bCaregiver tinyint(1) NOT NULL DEFAULT '0',
  pv_ps_bBereaved  tinyint(1) NOT NULL DEFAULT '0',
  pv_ps_bOther     tinyint(1) NOT NULL DEFAULT '0',
  pv_ps_strNotes   text NOT NULL,
  
     -- type of activity
  pv_act_lActivityID   int(11) NOT NULL COMMENT 'foreign ID to lists_generic',
  pv_act_strNotes      text NOT NULL,  

     -- location
  pv_loc_lLocationID   int(11) NOT NULL COMMENT 'foreign ID to lists_generic',
  pv_loc_strNotes      text NOT NULL,

     -- intervention
  pv_in_bCompanionship       tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bCaregiverRelief     tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bEmotionalSupport    tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bSocialization       tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bBereavement	     tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bTelephoneCall       tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bExcursionErrands 	 tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bMusicPetArt         tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bFoodPrep            tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bHouseholdChores     tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bOther               tinyint(1) NOT NULL DEFAULT '0',
  pv_in_strNotes             text NOT NULL,

     -- Other visit info / tasks
  pv_tsk_strOtherNotes       text NOT NULL,
  pv_tsk_bVisitors	         tinyint(1) NOT NULL DEFAULT '0',
  pv_tsk_strPatientComfort   text NOT NULL,
  pv_tsk_strPatientPain      text NOT NULL,
  pv_tsk_strChangesConcerns  text NOT NULL,

  pv_bRetired                tinyint(1) NOT NULL DEFAULT '0',
  pv_lOriginID               int(11) NOT NULL DEFAULT '0',
  pv_lLastUpdateID           int(11) NOT NULL DEFAULT '0',
  pv_dteOrigin               datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  pv_dteLastUpdate           timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (pv_lKeyID),
  KEY pv_lChapterID (pv_lChapterID),
  KEY pv_lPatientID (pv_lPatientID),
  KEY pv_lVolID     (pv_lVolID),
  KEY pv_dteVisit   (pv_dteVisit)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Patient Visit Info' AUTO_INCREMENT=1 ;






DROP TABLE IF EXISTS lists_generic_multi;
CREATE TABLE IF NOT EXISTS lists_generic_multi (
  glm_lKeyID    int(11) NOT NULL AUTO_INCREMENT,  
  glm_enumField enum('pv_patient_status','pv_activity') NOT NULL,
  glm_lRecID    int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key to appropriate parent table',
  glm_lListID   int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key to lists_generic',
  
  PRIMARY KEY (glm_lKeyID),
  KEY glm_enumField (glm_enumField),
  KEY glm_lRecID    (glm_lRecID),
  KEY glm_lListID   (glm_lListID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


















