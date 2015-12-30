# -------------------------------------------------------------------
#  Hospice Volunteer Solutions - Volunteers Helping Volunteers
#
#  copyright (c) 2015 by Database Austin
#  Austin, Texas
#
#  This software is provided under the GPL.
#  Please see http://www.gnu.org/copyleft/gpl.html for details.
#
#  Hospice Volunteer Solutions sql version 1.000 2015-08-04
# --------------------------------------------------------------------


#
# Table structure for table 'admin_chapters'
#

DROP TABLE IF EXISTS admin_chapters;

# [BREAK]

CREATE TABLE IF NOT EXISTS admin_chapters (
  ch_lKeyID           int(11) NOT NULL AUTO_INCREMENT,
  ch_strChapterName   varchar(80)  NOT NULL DEFAULT '',
  ch_strBannerTagLine varchar(80)  NOT NULL DEFAULT 'Your Organization' COMMENT 'Tag line for top banner',
  ch_lPW_MinLen       tinyint(4)   NOT NULL DEFAULT '5',
  ch_bPW_UpperLower   tinyint(1)   NOT NULL DEFAULT '0',
  ch_bPW_Number       tinyint(1)   NOT NULL DEFAULT '0',
  ch_strAddress1      varchar(80)  NOT NULL DEFAULT '',
  ch_strAddress2      varchar(80)  NOT NULL DEFAULT '',
  ch_strCity          varchar(40)  NOT NULL DEFAULT '',
  ch_strState         varchar(40)  NOT NULL DEFAULT '',
  ch_strCountry       varchar(40)  NOT NULL DEFAULT '',
  ch_strZip           varchar(25)  NOT NULL DEFAULT '',
  ch_strFax           varchar(50)  NOT NULL DEFAULT '',
  ch_strPhone         varchar(50)  NOT NULL DEFAULT '',
  ch_strEmail         varchar(80)  NOT NULL DEFAULT '',
  ch_strWebSite       varchar(100) NOT NULL DEFAULT '',
  ch_strDefAreaCode   varchar(10)  NOT NULL DEFAULT '',
  ch_strDefState      varchar(40)  NOT NULL DEFAULT ''  COMMENT 'Default state for new contacts',
  ch_strDefCountry    varchar(40)  NOT NULL DEFAULT ''  COMMENT 'Default country for new contacts',
  ch_bUS_DateFormat   tinyint(1)   NOT NULL DEFAULT '1' COMMENT 'if true, default is mm/dd/yyyy',
  ch_lTimeZone        int(11)      NOT NULL DEFAULT '2' COMMENT 'foreign key to table lists_tz',
  ch_strTaxID         varchar(80) NOT NULL,
  ch_lDefaultACO      int(11) NOT NULL DEFAULT '1'    COMMENT 'foreign key to table admin_aco',
  ch_strNotes         text NOT NULL,
  ch_bActive          tinyint(1) NOT NULL DEFAULT '1',
  ch_bRetired         tinyint(1) NOT NULL DEFAULT '0',
  ch_lOrigID          int(11) NOT NULL DEFAULT '0',
  ch_lLastUpdateID    int(11) NOT NULL DEFAULT '0',
  ch_dteOrigin        datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  ch_dteLastUpdate    timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (ch_lKeyID),
  KEY ch_strChapterName (ch_strChapterName)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='identifies the various locations of the organization';

# [BREAK]

#
# Insertng data for table 'admin_chapters'
#

INSERT INTO admin_chapters (ch_lKeyID, ch_strChapterName, ch_strBannerTagLine, ch_lPW_MinLen, ch_bPW_UpperLower,
       ch_bPW_Number, ch_strAddress1, ch_strAddress2, ch_strCity, ch_strState, ch_strCountry, ch_strZip, ch_strFax,
       ch_strPhone, ch_strEmail, ch_strWebSite, ch_strDefAreaCode, ch_strDefState,
       ch_strDefCountry, ch_bUS_DateFormat, ch_lTimeZone, ch_strTaxID, ch_lDefaultACO, ch_strNotes,
       ch_bActive, ch_bRetired, ch_lOrigID, ch_lLastUpdateID, ch_dteOrigin, ch_dteLastUpdate)
VALUES
(1, 'Your Hospice', 'Your Hospice / Your Location', 1, 0, 0, '123 Pine St.', '', 'Your Town', 'TX', 'US', '78700',
     '555-faxx', '(512) 555-1212', 'abc@test.com', 'www.test.com', '512', 'TX', 'US', 1, 12, '', 0,
     '', 1, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00');

# [BREAK]

#
# Table structure for table 'admin_usage_log'
#

DROP TABLE IF EXISTS admin_usage_log;

# [BREAK]

CREATE TABLE IF NOT EXISTS admin_usage_log (
  el_lKeyID           int(11) NOT NULL AUTO_INCREMENT,
  el_lUserID          int(11) DEFAULT NULL,
  el_dteLogDate       timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  el_strUserName      varchar(100) NOT NULL DEFAULT '',
  el_bLoginSuccessful tinyint(1) NOT NULL DEFAULT '0',
  el_str_Remote_Addr  varchar(20) NOT NULL DEFAULT '',
  el_str_Remote_Host  varchar(20) NOT NULL DEFAULT '',
  el_str_Remote_Port  varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (el_lKeyID),
  KEY el_dteLogDate (el_dteLogDate),
  KEY el_lUserID    (el_lUserID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Record of log-ins';


# [BREAK]

#
# Table structure for table 'admin_users'
#

DROP TABLE IF EXISTS admin_users;

# [BREAK]

CREATE TABLE IF NOT EXISTS admin_users (
  us_lKeyID          int(11) NOT NULL AUTO_INCREMENT,
  us_strUserName     varchar(120) NOT NULL DEFAULT '',
  us_strUserPWord    varchar(80) NOT NULL DEFAULT '',
  us_lChapterID      int(11) NOT NULL,
  us_bSuperUser      tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Super users control accounts for all locations',
  us_bAdmin          tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Access to all systems',
  us_bDebugger       tinyint(1) NOT NULL DEFAULT '0',
  us_bVolAccount     tinyint(1) NOT NULL DEFAULT '0',
  us_bUserVolManager tinyint(1) NOT NULL DEFAULT '0',
  us_lVolID          int(11) DEFAULT NULL,
  us_strFirstName    varchar(40) NOT NULL DEFAULT '',
  us_strLastName     varchar(40) NOT NULL DEFAULT '',
  us_strTitle        varchar(80) NOT NULL DEFAULT '',
  us_strPhone        varchar(50) NOT NULL,
  us_strCell         varchar(50) NOT NULL,
  us_strEmail        varchar(80) NOT NULL DEFAULT '',
  us_strAddr1        varchar(80) NOT NULL DEFAULT '',
  us_strAddr2        varchar(80) NOT NULL DEFAULT '',
  us_strCity         varchar(40) NOT NULL DEFAULT '',
  us_strState        varchar(40) NOT NULL DEFAULT '',
  us_strCountry      varchar(40) NOT NULL DEFAULT '',
  us_strZip          varchar(25) NOT NULL DEFAULT '',
  us_enumDateFormat  enum('M j Y','m/d/Y','j M Y','d/m/Y','F j Y','j F Y') NOT NULL DEFAULT 'j M Y',
  us_enumMeasurePref enum('metric','English') NOT NULL DEFAULT 'English',
  us_strNotes        text NOT NULL,
  us_bInactive       tinyint(1) NOT NULL DEFAULT '0',
  us_dteOrigin       datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  us_dteLastUpdate   timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  us_lOriginID       int(11) NOT NULL DEFAULT '0',
  us_lLastUpdateID   int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (us_lKeyID),
  KEY us_strUserName  (us_strUserName),
  KEY us_strUserPWord (us_strUserPWord),
  KEY us_lChapterID   (us_lChapterID),
  KEY us_lVolID       (us_lVolID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='users of the Hospice Volunteer Manager system';


# [BREAK]

INSERT INTO admin_users (
         us_lKeyID,               us_strUserName,           us_strUserPWord,            us_lChapterID,         us_bSuperUser,
         us_bAdmin,               us_bDebugger,             us_bVolAccount,
         us_bUserVolManager,
         us_lVolID,               us_strFirstName,          us_strLastName,             us_strTitle,           us_strPhone,
         us_strCell,              us_strEmail,              us_strAddr1,                us_strAddr2,           us_strCity,
         us_strState,             us_strCountry,            us_strZip,                  us_enumDateFormat,     us_enumMeasurePref,
         us_strNotes,             us_bInactive,             us_dteOrigin,               us_dteLastUpdate,      us_lOriginID,
         us_lLastUpdateID)
VALUES
    (1,             'root',             PASSWORD('root'),        0,                    1,
    0,              0,                  0,
    0,
    NULL,           'Sally',            'Superuser',             '',                   '555-1234',
    '555-cell',     'root@test.com',    '',                      '',                   'Austin',
    'TX',           'US',               '78700',                 'j M Y',              'English',
    '',             0,                  '2015-08-04 00:00:00',   '2015-08-04 00:00:00', 1,
    1);

# [BREAK]

#
# Table structure for table 'admin_version'
#

DROP TABLE IF EXISTS admin_version;

# [BREAK]

CREATE TABLE IF NOT EXISTS admin_version (
  av_lKeyID           int(11) NOT NULL AUTO_INCREMENT,
  av_sngVersion       decimal(10,3) NOT NULL DEFAULT '0.000',
  av_strVersionNotes  varchar(80) NOT NULL DEFAULT '',
  av_dteInstalled     timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (av_lKeyID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Version and upgrade info';

#
# Insertng data for table 'admin_version'
#
# [BREAK]

INSERT INTO admin_version (av_lKeyID, av_sngVersion, av_strVersionNotes, av_dteInstalled) VALUES
(1, '1.000', 'Initial schema for Hospice Volunteer Solutions', '2015-08-04 00:00:00');

# [BREAK]

#
# Table structure for table 'docs_images'
#

DROP TABLE IF EXISTS docs_images;
# [BREAK]

CREATE TABLE IF NOT EXISTS docs_images (
  di_lKeyID             int(11) NOT NULL AUTO_INCREMENT,
  di_enumEntryType      enum('image','pdf','Unknown') NOT NULL DEFAULT 'Unknown',
  di_enumContextType    enum('patient', 'volunteer', 'volManager', 'location', 'unknown') NOT NULL DEFAULT 'unknown',
  di_lForeignID         int(11) NOT NULL DEFAULT '0' COMMENT 'Foreign key based on enumContextType',
  di_strCaptionTitle    varchar(255) NOT NULL DEFAULT '',
  di_strDescription     text NOT NULL,
  di_dteDocImage        date DEFAULT NULL,
  di_bProfile           tinyint(1) NOT NULL DEFAULT '0'  COMMENT 'Profile image?',
  di_strUserFN          varchar(255) NOT NULL DEFAULT '' COMMENT 'Original name of file user uploaded',
  di_strSystemFN        varchar(255) NOT NULL DEFAULT '' COMMENT 'Renamed filename/extension',
  di_strSystemThumbFN   varchar(255) DEFAULT NULL,
  di_strPath            varchar(255) NOT NULL DEFAULT '',
  di_bRetired           tinyint(1) NOT NULL DEFAULT '0',
  di_lOriginID          int(11) NOT NULL DEFAULT '0',
  di_lLastUpdateID      int(11) NOT NULL DEFAULT '0',
  di_dteOrigin          datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  di_dteLastUpdate      timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (di_lKeyID),
  KEY di_enumEntryType   (di_enumEntryType),
  KEY di_enumContextType (di_enumContextType),
  KEY di_lForeignID      (di_lForeignID),
  KEY di_dteDocImage     (di_dteDocImage),
  KEY di_strSystemFN     (di_strSystemFN),
  FULLTEXT KEY di_strDescription (di_strDescription)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Document and Image Catelog';

# [BREAK]

#
# Table structure for table 'doc_img_tag_ddl'
#

DROP TABLE IF EXISTS doc_img_tag_ddl;
# [BREAK]

CREATE TABLE IF NOT EXISTS doc_img_tag_ddl (
  dit_lKeyID       int(11) NOT NULL AUTO_INCREMENT,
  dit_enumContext  enum('imgPatient', 'imgVolunteer', 'imgVolManager', 'imgLocation', 'unknown') NOT NULL DEFAULT 'unknown',
  dit_strDDLEntry  varchar(80) NOT NULL,
  dit_lSortIDX     int(11) NOT NULL DEFAULT '0',
  dit_bRetired     tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (dit_lKeyID),
  KEY dit_enumContext (dit_enumContext),
  KEY dit_lSortIDX    (dit_lSortIDX)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Image/document drop-down list entries (tags)';

# [BREAK]

#
# Table structure for table 'doc_img_tag_ddl_multi'
#

DROP TABLE IF EXISTS doc_img_tag_ddl_multi;
# [BREAK]
CREATE TABLE IF NOT EXISTS doc_img_tag_ddl_multi (
  dim_lKeyID    int(11) NOT NULL AUTO_INCREMENT,
  dim_lImgDocID int(11) NOT NULL DEFAULT '0' COMMENT 'Foreign key to docs_images',
  dim_lDDLID    int(11) NOT NULL DEFAULT '0' COMMENT 'Foreign key to doc_img_tag_ddl',
  PRIMARY KEY (dim_lKeyID),
  KEY dim_lDDLID    (dim_lImgDocID),
  KEY pdm_lUTableID (dim_lDDLID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# [BREAK]

#
# Table structure for table 'lists_generic'
#

DROP TABLE IF EXISTS lists_generic;

# [BREAK]

CREATE TABLE IF NOT EXISTS lists_generic (
  lgen_lKeyID        int(11) NOT NULL AUTO_INCREMENT,
  lgen_lChapterID    int(11) NOT NULL,
  lgen_enumListType  enum('attrib','volJobCat','volSkills','volActivities','volShiftJobCodes',
                          'volTraining', 'volTrainingBy',
                          'pvActivities','pvLocations','pvPStatus','pvVisitTasks',
                          'patientContactRelation') DEFAULT NULL,
  lgen_strListItem   varchar(255) NOT NULL DEFAULT '',
  lgen_lSortIDX      int(11)      NOT NULL DEFAULT '0' COMMENT 'reserved',
  lgen_bRetired      tinyint(1)   NOT NULL DEFAULT '0',
  lgen_lOriginID     int(11)      NOT NULL DEFAULT '0',
  lgen_lLastUpdateID int(11)      NOT NULL DEFAULT '0',
  lgen_dteOrigin     datetime     NOT NULL DEFAULT '0000-00-00 00:00:00',
  lgen_dteLastUpdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (lgen_lKeyID),
  KEY lgen_enumListType (lgen_enumListType),
  KEY lgen_lSortIDX     (lgen_lSortIDX),
  KEY lgen_strListItem  (lgen_strListItem),
  KEY lgen_lChapterID   (lgen_lChapterID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

# [BREAK]

#
# Insertng data for table 'lists_generic'
#

INSERT INTO lists_generic (lgen_lChapterID, lgen_enumListType, lgen_strListItem,
lgen_lSortIDX, lgen_bRetired, lgen_lOriginID, lgen_lLastUpdateID, lgen_dteOrigin, lgen_dteLastUpdate)
VALUES

(1, 'attrib',           '(other)',                            0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'attrib',           '(unknown)',                          0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'attrib',           'Internet',                           0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'attrib',           'Staff Member',                       0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'attrib',           'Web Site',                           0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),

(1, 'volActivities',    '(Other)',                            0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volActivities',    'Accounting/Bookkeeping',             0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volActivities',    'Administrative Support',             0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volActivities',    'Data Entry',                         0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volActivities',    'Errands',                            0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volActivities',    'Event Planning',                     0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volActivities',    'Facilities Management',              0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volActivities',    'Landscaping',                        0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volActivities',    'Office Support',                     0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volActivities',    'Software/Database/Computers',        0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volActivities',    'Tuck-In',                            0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volActivities',    'Web Design/Update',                  0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),

(1, 'volShiftJobCodes', '2000 Administrative Support',        0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volShiftJobCodes', '2010 Event Planning',                0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volShiftJobCodes', '2020 Office Support',                0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volShiftJobCodes', '5000 Tuck-In',                       0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volShiftJobCodes', '6000 Data Entry',                    0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volShiftJobCodes', '6010 Database/Software',             0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volShiftJobCodes', '6020 Web Design/Updates',            0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),

(1, 'volTraining',      '(other)',                            0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volTraining',      'Annual Refresher',                   0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volTraining',      'Orientation',                        0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),

(1, 'volTrainingBy',    '(other)',                            0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volTrainingBy',    'Contracted Facilitator',             0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volTrainingBy',    'Staff Member',                       0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'volTrainingBy',    'Volunteer Coordinator',              0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),

(1, 'pvActivities',     '(Other - please specify in notes)',  0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvActivities',     'Bereavement',                        0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvActivities',     'Telephone Call',                     0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvActivities',     'Visit',                              0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvLocations',      '(Other - please specify in notes)',  0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvLocations',      'Assisted Living Facility',           0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvLocations',      'Group Home',                         0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvLocations',      'Home',                               0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvLocations',      'Hospital',                           0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvLocations',      'Nursing Home',                       0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),

(1, 'pvPStatus',        '(Does not apply)',                   0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvPStatus',        'Alert',                              0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvPStatus',        'Appeared calm',                      0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvPStatus',        'Appeared cheerful',                  0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvPStatus',        'Appeared confused',                  0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvPStatus',        'Appeared sad',                       0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvPStatus',        'Awake',                              0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvPStatus',        'Drowsy',                             0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvPStatus',        'In bed',                             0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvPStatus',        'In wheelchair',                      0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvPStatus',        'Sleeping',                           0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvPStatus',        'Up in a chair',                      0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),

(1, 'pvVisitTasks',     '(Does not apply)',                               0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvVisitTasks',     '(Other - please specify in notes)',              0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvVisitTasks',     'Confimed patient''s emotional reactions',        0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvVisitTasks',     'Did light housekeeping',                         0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvVisitTasks',     'Listened to music with patient',                 0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvVisitTasks',     'Looked at pictures with patient',                0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvVisitTasks',     'Read to patient',                                0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvVisitTasks',     'Socialized with patient during volunteer visit', 0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvVisitTasks',     'Talked to patient',                              0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvVisitTasks',     'Took patient to activities',                     0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'pvVisitTasks',     'Walked along side of patient',                   0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),

(1, 'patientContactRelation', '(other)',              0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Adult Child',          0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Brother',              0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Child',                0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Daughter',             0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Father',               0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Friend',               0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Husband',              0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Mother',               0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Other Family Member',  0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Sister',               0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Son',                  0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00'),
(1, 'patientContactRelation', 'Wife',                 0, 0, 1, 1, '2015-08-04 00:00:00', '2015-08-04 00:00:00');


# [BREAK]

#
# Table structure for table 'lists_generic_multi'
#

DROP TABLE IF EXISTS lists_generic_multi;

# [BREAK]

CREATE TABLE IF NOT EXISTS lists_generic_multi (
  glm_lKeyID    int(11) NOT NULL AUTO_INCREMENT,
  glm_enumField enum('pvPStatus','pvVisitTasks') NOT NULL,
  glm_lRecID    int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key to appropriate parent table',
  glm_lListID   int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key to lists_generic',
  PRIMARY KEY (glm_lKeyID),
  KEY glm_enumField (glm_enumField),
  KEY glm_lRecID  (glm_lRecID),
  KEY glm_lListID (glm_lListID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

# [BREAK]


#

#
# Table structure for table 'lists_tz'
#

DROP TABLE IF EXISTS lists_tz;
# [BREAK]
CREATE TABLE IF NOT EXISTS lists_tz (
  tz_lKeyID      int(11) NOT NULL AUTO_INCREMENT,
  tz_strTimeZone varchar(120) NOT NULL DEFAULT '',
  tz_lTZ_Const   int(11) NOT NULL,
  tz_bTopList    tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (tz_lKeyID),
  KEY tz_strTimeZone (tz_strTimeZone)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='php time zone constants via http://pecl.php.net/get/timezonedb';
# [BREAK]

#
# Insertng data for table 'lists_tz'
#

INSERT INTO `lists_tz` (`tz_lKeyID`, `tz_strTimeZone`, `tz_lTZ_Const`, `tz_bTopList`) VALUES
(1,  'US/Eastern',                         255194, 1),  (2, 'US/Central',                          253903, 1),
(3,  'US/Mountain',                        258908, 1),  (4, 'US/Pacific',                          259797, 1),
(5,  'US/Alaska',                          252018, 1),  (6, 'US/Hawaii',                           257091, 1),
(7,  'Canada/Atlantic',                    156029, 1),  (8,  'Canada/Central',                     157285, 1),
(9,  'Canada/East-Saskatchewan',           159599, 1),  (10, 'Canada/Eastern',                     158335, 1),
(11, 'Canada/Mountain',                    159992, 1),  (12, 'Canada/Newfoundland',                160878, 1),
(13, 'Canada/Pacific',                     162201, 1),  (14, 'Canada/Saskatchewan',                163250, 1),
(15, 'Canada/Yukon',                       163643, 1),  (16, 'Africa/Abidjan',                          0, 0),
(17, 'Africa/Accra',                           85, 0),  (18, 'Africa/Addis_Ababa',                    413, 0),
(19, 'Africa/Algiers',                        540, 0),  (20, 'Africa/Asmara',                         839, 0),
(21, 'Africa/Asmera',                         966, 0),  (22, 'Africa/Bamako',                        1093, 0),
(23, 'Africa/Bangui',                        1178, 0),  (24, 'Africa/Banjul',                        1263, 0),
(25, 'Africa/Bissau',                        1348, 0),  (26, 'Africa/Blantyre',                      1450, 0),
(27, 'Africa/Brazzaville',                   1535, 0),  (28, 'Africa/Bujumbura',                     1620, 0),
(29, 'Africa/Cairo',                         1705, 0),  (30, 'Africa/Casablanca',                    2704, 0),
(31, 'Africa/Ceuta',                         3314, 0),  (32, 'Africa/Conakry',                       4089, 0),
(33, 'Africa/Dakar',                         4174, 0),  (34, 'Africa/Dar_es_Salaam',                 4259, 0),
(35, 'Africa/Djibouti',                      4386, 0),  (36, 'Africa/Douala',                        4513, 0),
(37, 'Africa/El_Aaiun',                      4598, 0),  (38, 'Africa/Freetown',                      5153, 0),
(39, 'Africa/Gaborone',                      5238, 0),  (40, 'Africa/Harare',                        5323, 0),
(41, 'Africa/Johannesburg',                  5408, 0),  (42, 'Africa/Juba',                          5518, 0),
(43, 'Africa/Kampala',                       5793, 0),  (44, 'Africa/Khartoum',                      5920, 0),
(45, 'Africa/Kigali',                        6195, 0),  (46, 'Africa/Kinshasa',                      6280, 0),
(47, 'Africa/Lagos',                         6388, 0),  (48, 'Africa/Libreville',                    6473, 0),
(49, 'Africa/Lome',                          6558, 0),  (50, 'Africa/Luanda',                        6643, 0),
(51, 'Africa/Lubumbashi',                    6728, 0),  (52, 'Africa/Lusaka',                        6836, 0),
(53, 'Africa/Malabo',                        6921, 0),  (54, 'Africa/Maputo',                        7006, 0),
(55, 'Africa/Maseru',                        7091, 0),  (56, 'Africa/Mbabane',                       7201, 0),
(57, 'Africa/Mogadishu',                     7311, 0),  (58, 'Africa/Monrovia',                      7438, 0),
(59, 'Africa/Nairobi',                       7540, 0),  (60, 'Africa/Ndjamena',                      7667, 0),
(61, 'Africa/Niamey',                        7775, 0),  (62, 'Africa/Nouakchott',                    7860, 0),
(63, 'Africa/Ouagadougou',                   7945, 0),  (64, 'Africa/Porto-Novo',                    8030, 0),
(65, 'Africa/Sao_Tome',                      8115, 0),  (66, 'Africa/Timbuktu',                      8200, 0),
(67, 'Africa/Tripoli',                       8285, 0),  (68, 'Africa/Tunis',                         8550, 0),
(69, 'Africa/Windhoek',                      8824, 0),  (70, 'America/Adak',                         9407, 0),
(71, 'America/Anchorage',                   10293, 0),  (72, 'America/Anguilla',                    11177, 0),
(73, 'America/Antigua',                     11262, 0),  (74, 'America/Araguaina',                   11347, 0),
(75, 'America/Argentina/Buenos_Aires',      11704, 0),  (76, 'America/Argentina/Catamarca',         12134, 0),
(77, 'America/Argentina/ComodRivadavia',    12583, 0),  (78, 'America/Argentina/Cordoba',           13005, 0),
(79, 'America/Argentina/Jujuy',             13474, 0),  (80, 'America/Argentina/La_Rioja',          13910, 0),
(81, 'America/Argentina/Mendoza',           14350, 0),  (82, 'America/Argentina/Rio_Gallegos',      14798, 0),
(83, 'America/Argentina/Salta',             15235, 0),  (84, 'America/Argentina/San_Juan',          15663, 0),
(85, 'America/Argentina/San_Luis',          16103, 0),  (86, 'America/Argentina/Tucuman',           16557, 0),
(87, 'America/Argentina/Ushuaia',           17001, 0),  (88, 'America/Aruba',                       17444, 0),
(89, 'America/Asuncion',                    17546, 0),  (90, 'America/Atikokan',                    18287, 0),
(91, 'America/Atka',                        18501, 0),  (92, 'America/Bahia',                       19371, 0),
(93, 'America/Bahia_Banderas',              19774, 0),  (94, 'America/Barbados',                    20407, 0),
(95, 'America/Belem',                       20561, 0),  (96, 'America/Belize',                      20812, 0),
(97, 'America/Blanc-Sablon',                21192, 0),  (98, 'America/Boa_Vista',                   21372, 0),
(99, 'America/Bogota',                      21637, 0),  (100, 'America/Boise',                      21745, 0),
(101, 'America/Buenos_Aires',               22664, 0),  (102, 'America/Cambridge_Bay',              23073, 0),
(103, 'America/Campo_Grande',               23881, 0),  (104, 'America/Cancun',                     24632, 0),
(105, 'America/Caracas',                    24994, 0),  (106, 'America/Catamarca',                  25097, 0),
(107, 'America/Cayenne',                    25519, 0),  (108, 'America/Cayman',                     25617, 0),
(109, 'America/Chicago',                    25702, 0),  (110, 'America/Chihuahua',                  27005, 0),
(111, 'America/Coral_Harbour',              27624, 0),  (112, 'America/Cordoba',                    27770, 0),
(113, 'America/Costa_Rica',                 28192, 0),  (114, 'America/Creston',                    28330, 0),
(115, 'America/Cuiaba',                     28470, 0),  (116, 'America/Curacao',                    29204, 0),
(117, 'America/Danmarkshavn',               29306, 0),  (118, 'America/Dawson',                     29630, 0),
(119, 'America/Dawson_Creek',               30427, 0),  (120, 'America/Denver',                     30901, 0),
(121, 'America/Detroit',                    31803, 0),  (122, 'America/Dominica',                   32666, 0),
(123, 'America/Edmonton',                   32751, 0),  (124, 'America/Eirunepe',                   33703, 0),
(125, 'America/El_Salvador',                33983, 0),  (126, 'America/Ensenada',                   34100, 0),
(127, 'America/Fort_Wayne',                 35291, 0),  (128, 'America/Fortaleza',                  34973, 0),
(129, 'America/Glace_Bay',                  35909, 0),  (130, 'America/Godthab',                    36796, 0),
(131, 'America/Goose_Bay',                  37504, 0),  (132, 'America/Grand_Turk',                 38717, 0),
(133, 'America/Grenada',                    39196, 0),  (134, 'America/Guadeloupe',                 39281, 0),
(135, 'America/Guatemala',                  39366, 0),  (136, 'America/Guayaquil',                  39503, 0),
(137, 'America/Guyana',                     39596, 0),  (138, 'America/Halifax',                    39725, 0),
(139, 'America/Havana',                     41027, 0),  (140, 'America/Hermosillo',                 41910, 0),
(141, 'America/Indiana/Indianapolis',       42132, 0),  (142, 'America/Indiana/Knox',               42789, 0),
(143, 'America/Indiana/Marengo',            43708, 0),  (144, 'America/Indiana/Petersburg',         44386, 0),
(145, 'America/Indiana/Tell_City',          45743, 0),  (146, 'America/Indiana/Vevay',              46408, 0),
(147, 'America/Indiana/Vincennes',          46979, 0),  (148, 'America/Indiana/Winamac',            47671, 0),
(149, 'America/Indianapolis',               45125, 0),  (150, 'America/Inuvik',                     48368, 0),
(151, 'America/Iqaluit',                    49127, 0),  (152, 'America/Jamaica',                    49929, 0),
(153, 'America/Jujuy',                      50126, 0),  (154, 'America/Juneau',                     50552, 0),
(155, 'America/Kentucky/Louisville',        51446, 0),  (156, 'America/Kentucky/Monticello',        52500, 0),
(157, 'America/Knox_IN',                    53401, 0),  (158, 'America/Kralendijk',                 54282, 0),
(159, 'America/La_Paz',                     54384, 0),  (160, 'America/Lima',                       54487, 0),
(161, 'America/Los_Angeles',                54655, 0),  (162, 'America/Louisville',                 55696, 0),
(163, 'America/Lower_Princes',              56709, 0),  (164, 'America/Maceio',                     56811, 0),
(165, 'America/Managua',                    57125, 0),  (166, 'America/Manaus',                     57304, 0),
(167, 'America/Marigot',                    57562, 0),  (168, 'America/Martinique',                 57647, 0),
(169, 'America/Matamoros',                  57755, 0),  (170, 'America/Mazatlan',                   58356, 0),
(171, 'America/Mendoza',                    58977, 0),  (172, 'America/Menominee',                  59413, 0),
(173, 'America/Merida',                     60310, 0),  (174, 'America/Metlakatla',                 60881, 0),
(175, 'America/Mexico_City',                61196, 0),  (176, 'America/Miquelon',                   61831, 0),
(177, 'America/Moncton',                    62457, 0),  (178, 'America/Monterrey',                  63632, 0),
(179, 'America/Montevideo',                 64243, 0),  (180, 'America/Montreal',                   65029, 0),
(181, 'America/Montserrat',                 66293, 0),  (182, 'America/Nassau',                     66378, 0),
(183, 'America/New_York',                   67215, 0),  (184, 'America/Nipigon',                    68506, 0),
(185, 'America/Nome',                       69355, 0),  (186, 'America/Noronha',                    70249, 0),
(187, 'America/North_Dakota/Beulah',        70553, 0),  (188, 'America/North_Dakota/Center',        71469, 0),
(189, 'America/North_Dakota/New_Salem',     72385, 0),  (190, 'America/Ojinaga',                    73322, 0),
(191, 'America/Panama',                     73931, 0),  (192, 'America/Pangnirtung',                74016, 0),
(193, 'America/Paramaribo',                 74838, 0),  (194, 'America/Phoenix',                    74984, 0),
(195, 'America/Port-au-Prince',             75174, 0),  (196, 'America/Port_of_Spain',              75978, 0),
(197, 'America/Porto_Acre',                 75718, 0),  (198, 'America/Porto_Velho',                76063, 0),
(199, 'America/Puerto_Rico',                76309, 0),  (200, 'America/Rainy_River',                76416, 0),
(201, 'America/Rankin_Inlet',               77240, 0),  (202, 'America/Recife',                     77982, 0),
(203, 'America/Regina',                     78280, 0),  (204, 'America/Resolute',                   78726, 0),
(205, 'America/Rio_Branco',                 79470, 0),  (206, 'America/Rosario',                    79734, 0),
(207, 'America/Santa_Isabel',               80156, 0),  (208, 'America/Santarem',                   81087, 0),
(209, 'America/Santiago',                   81348, 0),  (210, 'America/Santo_Domingo',              82068, 0),
(211, 'America/Sao_Paulo',                  82266, 0),  (212, 'America/Scoresbysund',               83049, 0),
(213, 'America/Shiprock',                   83799, 0),  (214, 'America/Sitka',                      84688, 0),
(215, 'America/St_Barthelemy',              85592, 0),  (216, 'America/St_Johns',                   85677, 0),
(217, 'America/St_Kitts',                   87040, 0),  (218, 'America/St_Lucia',                   87125, 0),
(219, 'America/St_Thomas',                  87210, 0),  (220, 'America/St_Vincent',                 87295, 0),
(221, 'America/Swift_Current',              87380, 0),  (222, 'America/Tegucigalpa',                87669, 0),
(223, 'America/Thule',                      87796, 0),  (224, 'America/Thunder_Bay',                88379, 0),
(225, 'America/Tijuana',                    89220, 0),  (226, 'America/Toronto',                    90141, 0),
(227, 'America/Tortola',                    91453, 0),  (228, 'America/Vancouver',                  91538, 0),
(229, 'America/Virgin',                     92623, 0),  (230, 'America/Whitehorse',                 92708, 0),
(231, 'America/Winnipeg',                   93505, 0),  (232, 'America/Yakutat',                    94593, 0),
(233, 'America/Yellowknife',                95468, 0),  (234, 'Antarctica/Casey',                   96252, 0),
(235, 'Antarctica/Davis',                   96410, 0),  (236, 'Antarctica/DumontDUrville',          96571, 0),
(237, 'Antarctica/Macquarie',               96716, 0),  (238, 'Antarctica/Mawson',                  97305, 0),
(239, 'Antarctica/McMurdo',                 97429, 0),  (240, 'Antarctica/Palmer',                  98368, 0),
(241, 'Antarctica/Rothera',                 98947, 0),  (242, 'Antarctica/South_Pole',              99065, 0),
(243, 'Antarctica/Syowa',                   99959, 0),  (244, 'Antarctica/Troll',                  100069, 0),
(245, 'Antarctica/Vostok',                 100535, 0),  (246, 'Arctic/Longyearbyen',               100648, 0),
(247, 'Asia/Aden',                         101466, 0),  (248, 'Asia/Almaty',                       101551, 0),
(249, 'Asia/Amman',                        101934, 0),  (250, 'Asia/Anadyr',                       102628, 0),
(251, 'Asia/Aqtau',                        103142, 0),  (252, 'Asia/Aqtobe',                       103653, 0),
(253, 'Asia/Ashgabat',                     104093, 0),  (254, 'Asia/Ashkhabad',                    104378, 0),
(255, 'Asia/Baghdad',                      104663, 0),  (256, 'Asia/Bahrain',                      105036, 0),
(257, 'Asia/Baku',                         105138, 0),  (258, 'Asia/Bangkok',                      105882, 0),
(259, 'Asia/Beirut',                       105967, 0),  (260, 'Asia/Bishkek',                      106748, 0),
(261, 'Asia/Brunei',                       107176, 0),  (262, 'Asia/Calcutta',                     107274, 0),
(263, 'Asia/Chita',                        107395, 0),  (264, 'Asia/Choibalsan',                   107928, 0),
(265, 'Asia/Chongqing',                    108543, 0),  (266, 'Asia/Chungking',                    108703, 0),
(267, 'Asia/Colombo',                      108863, 0),  (268, 'Asia/Dacca',                        109019, 0),
(269, 'Asia/Damascus',                     109185, 0),  (270, 'Asia/Dhaka',                        110033, 0),
(271, 'Asia/Dili',                         110199, 0),  (272, 'Asia/Dubai',                        110337, 0),
(273, 'Asia/Dushanbe',                     110422, 0),  (274, 'Asia/Gaza',                         110681, 0),
(275, 'Asia/Harbin',                       111532, 0),  (276, 'Asia/Hebron',                       111692, 0),

(277, 'Asia/Ho_Chi_Minh', 112552, 0),      (278, 'Asia/Hong_Kong', 112714, 0),      (279, 'Asia/Hovd', 113164, 0),
(280, 'Asia/Irkutsk', 113770, 0),          (281, 'Asia/Istanbul', 114261, 0),       (282, 'Asia/Jakarta', 115266, 0),
(283, 'Asia/Jayapura', 115436, 0),         (284, 'Asia/Jerusalem', 115593, 0),      (285, 'Asia/Kabul', 116408, 0),
(286, 'Asia/Kamchatka', 116489, 0),        (287, 'Asia/Karachi', 116994, 0),        (288, 'Asia/Kashgar', 117175, 0),
(289, 'Asia/Kathmandu', 117260, 0),        (290, 'Asia/Katmandu', 117362, 0),       (291, 'Asia/Khandyga', 117464, 0),
(292, 'Asia/Kolkata', 118018, 0),          (293, 'Asia/Krasnoyarsk', 118139, 0),    (294, 'Asia/Kuala_Lumpur', 118632, 0),
(295, 'Asia/Kuching', 118821, 0),          (296, 'Asia/Kuwait', 119059, 0),         (297, 'Asia/Macao', 119144, 0),
(298, 'Asia/Macau', 119459, 0),            (299, 'Asia/Magadan', 119774, 0),        (300, 'Asia/Makassar', 120290, 0),
(301, 'Asia/Manila', 120487, 0),           (302, 'Asia/Muscat', 120620, 0),         (303, 'Asia/Nicosia', 120705, 0),
(304, 'Asia/Novokuznetsk', 121449, 0),     (305, 'Asia/Novosibirsk', 121993, 0),    (306, 'Asia/Omsk', 122489, 0),
(307, 'Asia/Oral', 122981, 0),             (308, 'Asia/Phnom_Penh', 123445, 0),     (309, 'Asia/Pontianak', 123530, 0),
(310, 'Asia/Pyongyang', 123724, 0),        (311, 'Asia/Qatar', 123857, 0),          (312, 'Asia/Qyzylorda', 123959, 0),
(313, 'Asia/Rangoon', 124429, 0),          (314, 'Asia/Riyadh', 124549, 0),         (315, 'Asia/Saigon', 124634, 0),
(316, 'Asia/Sakhalin', 124796, 0),         (317, 'Asia/Samarkand', 125305, 0),      (318, 'Asia/Seoul', 125615, 0),
(319, 'Asia/Shanghai', 125858, 0),         (320, 'Asia/Singapore', 126030, 0),      (321, 'Asia/Srednekolymsk', 126213, 0),
(322, 'Asia/Taipei', 126725, 0),           (323, 'Asia/Tashkent', 127030, 0),       (324, 'Asia/Tbilisi', 127335, 0),
(325, 'Asia/Tehran', 127777, 0),           (326, 'Asia/Tel_Aviv', 128399, 0),       (327, 'Asia/Thimbu', 129214, 0),
(328, 'Asia/Thimphu', 129316, 0),          (329, 'Asia/Tokyo', 129418, 0),          (330, 'Asia/Ujung_Pandang', 129556, 0),
(331, 'Asia/Ulaanbaatar', 129681, 0),      (332, 'Asia/Ulan_Bator', 130258, 0),     (333, 'Asia/Urumqi', 130821, 0),
(334, 'Asia/Ust-Nera', 130919, 0),         (335, 'Asia/Vientiane', 131449, 0),      (336, 'Asia/Vladivostok', 131534, 0),
(337, 'Asia/Yakutsk', 132024, 0),          (338, 'Asia/Yekaterinburg', 132514, 0),  (339, 'Asia/Yerevan', 133059, 0),
(340, 'Atlantic/Azores', 133571, 0),       (341, 'Atlantic/Bermuda', 134854, 0),    (342, 'Atlantic/Canary', 135591, 0),
(343, 'Atlantic/Cape_Verde', 136317, 0),   (344, 'Atlantic/Faeroe', 136438, 0),     (345, 'Atlantic/Faroe', 137114, 0),
(346, 'Atlantic/Jan_Mayen', 137790, 0),    (347, 'Atlantic/Madeira', 138608, 0),    (348, 'Atlantic/Reykjavik', 139897, 0),
(349, 'Atlantic/South_Georgia', 140358, 0),(350, 'Atlantic/St_Helena', 140888, 0),  (351, 'Atlantic/Stanley', 140426, 0),
(352, 'Australia/ACT', 140973, 0),         (353, 'Australia/Adelaide', 141776, 0),  (354, 'Australia/Brisbane', 142594, 0),
(355, 'Australia/Broken_Hill', 142799, 0), (356, 'Australia/Canberra', 143635, 0),  (357, 'Australia/Currie', 144438, 0),
(358, 'Australia/Darwin', 145263, 0),      (359, 'Australia/Eucla', 145403, 0),     (360, 'Australia/Hobart', 145623, 0),
(361, 'Australia/LHI', 146491, 0),         (362, 'Australia/Lindeman', 147164, 0),  (363, 'Australia/Lord_Howe', 147395, 0),
(364, 'Australia/Melbourne', 148084, 0),   (365, 'Australia/North', 148895, 0),     (366, 'Australia/NSW', 149017, 0),
(367, 'Australia/Perth', 149820, 0),       (368, 'Australia/Queensland', 150042, 0),(369, 'Australia/South', 150220, 0),
(370, 'Australia/Sydney', 151023, 0),      (371, 'Australia/Tasmania', 151858, 0),  (372, 'Australia/Victoria', 152701, 0),
(373, 'Australia/West', 153504, 0),        (374, 'Australia/Yancowinna', 153692, 0),(375, 'Brazil/Acre', 154500, 0),
(376, 'Brazil/DeNoronha', 154760, 0),      (377, 'Brazil/East', 155048, 0),         (378, 'Brazil/West', 155781, 0),
(379, 'Canada/Atlantic', 156029, 0),       (380, 'Canada/Central', 157285, 0),      (381, 'Canada/East-Saskatchewan', 159599, 0),
(382, 'Canada/Eastern', 158335, 0),        (383, 'Canada/Mountain', 159992, 0),     (384, 'Canada/Newfoundland', 160878, 0),
(385, 'Canada/Pacific', 162201, 0),        (386, 'Canada/Saskatchewan', 163250, 0), (387, 'Canada/Yukon', 163643, 0),
(388, 'CET', 164414, 0),                   (389, 'Chile/Continental', 165191, 0),   (390, 'Chile/EasterIsland', 165897, 0),
(391, 'CST6CDT', 166514, 0),               (392, 'Cuba', 167363, 0),                (393, 'EET', 168246, 0),
(394, 'Egypt', 168937, 0),                 (395, 'Eire', 169936, 0),

(396, 'EST',           171233, 0),     (397, 'EST5EDT',       171301, 0),        (398, 'Etc/GMT',       172150, 0),
(399, 'Etc/GMT+0',     172354, 0),     (400, 'Etc/GMT+1',     172492, 0),        (401, 'Etc/GMT+10',    172633, 0),
(402, 'Etc/GMT+11',    172775, 0),     (403, 'Etc/GMT+12',    172917, 0),        (404, 'Etc/GMT+2',     173200, 0),
(405, 'Etc/GMT+3',     173340, 0),     (406, 'Etc/GMT+4',     173480, 0),        (407, 'Etc/GMT+5',     173620, 0),
(408, 'Etc/GMT+6',     173760, 0),     (409, 'Etc/GMT+7',     173900, 0),        (410, 'Etc/GMT+8',     174040, 0),
(411, 'Etc/GMT+9',     174180, 0),     (412, 'Etc/GMT-0',     172286, 0),        (413, 'Etc/GMT-1',     172422, 0),
(414, 'Etc/GMT-10',    172562, 0),     (415, 'Etc/GMT-11',    172704, 0),        (416, 'Etc/GMT-12',    172846, 0),
(417, 'Etc/GMT-13',    172988, 0),     (418, 'Etc/GMT-14',    173059, 0),        (419, 'Etc/GMT-2',     173130, 0),
(420, 'Etc/GMT-3',     173270, 0),     (421, 'Etc/GMT-4',     173410, 0),        (422, 'Etc/GMT-5',     173550, 0),
(423, 'Etc/GMT-6',     173690, 0),     (424, 'Etc/GMT-7',     173830, 0),        (425, 'Etc/GMT-8',     173970, 0),
(426, 'Etc/GMT-9',     174110, 0),     (427, 'Etc/GMT0',      172218, 0),        (428, 'Etc/Greenwich', 174250, 0),
(429, 'Etc/UCT',       174318, 0),     (430, 'Etc/Universal', 174386, 0),        (431, 'Etc/UTC',       174454, 0),
(432, 'Etc/Zulu',      174522, 0),

(433, 'Europe/Amsterdam', 174590, 0),  (434, 'Europe/Andorra', 175676, 0),       (435, 'Europe/Athens', 176312, 0),
(436, 'Europe/Belfast', 177147, 0),    (437, 'Europe/Belgrade', 178482, 0),      (438, 'Europe/Berlin', 179195, 0),
(439, 'Europe/Bratislava', 180063, 0), (440, 'Europe/Brussels', 180881, 0),      (441, 'Europe/Bucharest', 181960, 0),
(442, 'Europe/Budapest', 182770, 0),   (443, 'Europe/Busingen', 183643, 0),      (444, 'Europe/Chisinau', 184338, 0),
(445, 'Europe/Copenhagen', 185248, 0), (446, 'Europe/Dublin', 186026, 0),        (447, 'Europe/Gibraltar', 187323, 0),
(448, 'Europe/Guernsey', 188434, 0),   (449, 'Europe/Helsinki', 189769, 0),      (450, 'Europe/Isle_of_Man', 190463, 0),
(451, 'Europe/Istanbul', 191798, 0),   (452, 'Europe/Jersey', 192803, 0),        (453, 'Europe/Kaliningrad', 194138, 0),
(454, 'Europe/Kiev', 194757, 0),       (455, 'Europe/Lisbon', 195553, 0),        (456, 'Europe/Ljubljana', 196837, 0),
(457, 'Europe/London', 197550, 0),     (458, 'Europe/Luxembourg', 198885, 0),    (459, 'Europe/Madrid', 199995, 0),
(460, 'Europe/Malta', 200961, 0),      (461, 'Europe/Mariehamn', 201914, 0),     (462, 'Europe/Minsk', 202608, 0),
(463, 'Europe/Monaco', 203139, 0),     (464, 'Europe/Moscow', 204222, 0),        (465, 'Europe/Nicosia', 204824, 0),
(466, 'Europe/Oslo', 205568, 0),       (467, 'Europe/Paris', 206386, 0),         (468, 'Europe/Podgorica', 207480, 0),
(469, 'Europe/Prague', 208193, 0),     (470, 'Europe/Riga', 209011, 0),          (471, 'Europe/Rome', 209848, 0),
(472, 'Europe/Samara', 210811, 0),     (473, 'Europe/San_Marino', 211428, 0),    (474, 'Europe/Sarajevo', 212391, 0),
(475, 'Europe/Simferopol', 213104, 0), (476, 'Europe/Skopje', 213697, 0),        (477, 'Europe/Sofia', 214410, 0),
(478, 'Europe/Stockholm', 215186, 0),  (479, 'Europe/Tallinn', 215873, 0),       (480, 'Europe/Tirane', 216699, 0),
(481, 'Europe/Tiraspol', 217473, 0),   (482, 'Europe/Uzhgorod', 218383, 0),      (483, 'Europe/Vaduz', 219174, 0),
(484, 'Europe/Vatican', 219861, 0),    (485, 'Europe/Vienna', 220824, 0),        (486, 'Europe/Vilnius', 221637, 0),
(487, 'Europe/Volgograd', 222468, 0),  (488, 'Europe/Warsaw', 223017, 0),        (489, 'Europe/Zagreb', 224010, 0),
(490, 'Europe/Zaporozhye', 224723, 0), (491, 'Europe/Zurich', 225556, 0),        (492, 'Factory', 226243, 0),
(493, 'GB', 226356, 0),                (494, 'GB-Eire', 227691, 0),              (495, 'GMT', 229026, 0),
(496, 'GMT+0', 229230, 0),             (497, 'GMT-0', 229162, 0),                (498, 'GMT0', 229094, 0),
(499, 'Greenwich', 229298, 0),         (500, 'Hongkong', 229366, 0),             (501, 'HST', 229816, 0),
(502, 'Iceland', 229884, 0),           (503, 'Indian/Antananarivo', 230345, 0),  (504, 'Indian/Chagos', 230472, 0),
(505, 'Indian/Christmas', 230570, 0),  (506, 'Indian/Cocos', 230638, 0),         (507, 'Indian/Comoro', 230706, 0),
(508, 'Indian/Kerguelen', 230833, 0),  (509, 'Indian/Mahe', 230918, 0),          (510, 'Indian/Maldives', 231003, 0),
(511, 'Indian/Mauritius', 231088, 0),  (512, 'Indian/Mayotte', 231206, 0),       (513, 'Indian/Reunion', 231333, 0),
(514, 'Iran', 231418, 0),              (515, 'Israel', 232040, 0),               (516, 'Jamaica', 232855, 0),
(517, 'Japan', 233052, 0),             (518, 'Kwajalein', 233190, 0),            (519, 'Libya', 233289, 0),
(520, 'MET', 233554, 0),               (521, 'Mexico/BajaNorte', 234331, 0),     (522, 'Mexico/BajaSur', 235204, 0),
(523, 'Mexico/General', 235785, 0),    (524, 'MST', 236391, 0),                  (525, 'MST7MDT', 236459, 0),
(526, 'Navajo', 237308, 0),            (527, 'NZ', 238197, 0),                   (528, 'NZ-CHAT', 239091, 0),
(529, 'Pacific/Apia', 239831, 0),      (530, 'Pacific/Auckland', 240243, 0),     (531, 'Pacific/Bougainville', 241151, 0),
(532, 'Pacific/Chatham', 241270, 0),   (533, 'Pacific/Chuuk', 242025, 0),        (534, 'Pacific/Easter', 242114, 0),
(535, 'Pacific/Efate', 242744, 0),     (536, 'Pacific/Enderbury', 242942, 0),    (537, 'Pacific/Fakaofo', 243052, 0),
(538, 'Pacific/Fiji', 243133, 0),      (539, 'Pacific/Funafuti', 243536, 0),     (540, 'Pacific/Galapagos', 243604, 0),
(541, 'Pacific/Gambier', 243724, 0),   (542, 'Pacific/Guadalcanal', 243825, 0),  (543, 'Pacific/Guam', 243910, 0),
(544, 'Pacific/Honolulu', 243996, 0),  (545, 'Pacific/Johnston', 244115, 0),     (546, 'Pacific/Kiritimati', 244242, 0),
(547, 'Pacific/Kosrae', 244349, 0),    (548, 'Pacific/Kwajalein', 244442, 0),    (549, 'Pacific/Majuro', 244550, 0),
(550, 'Pacific/Marquesas', 244645, 0), (551, 'Pacific/Midway', 244748, 0),       (552, 'Pacific/Nauru', 244881, 0),
(553, 'Pacific/Niue', 245001, 0),      (554, 'Pacific/Norfolk', 245095, 0),      (555, 'Pacific/Noumea', 245180, 0),
(556, 'Pacific/Pago_Pago', 245324, 0), (557, 'Pacific/Palau', 245443, 0),        (558, 'Pacific/Pitcairn', 245511, 0),
(559, 'Pacific/Pohnpei', 245596, 0),   (560, 'Pacific/Ponape', 245681, 0),       (561, 'Pacific/Port_Moresby', 245750, 0),
(562, 'Pacific/Rarotonga', 245832, 0), (563, 'Pacific/Saipan', 246052, 0),       (564, 'Pacific/Samoa', 246138, 0),
(565, 'Pacific/Tahiti', 246257, 0),    (566, 'Pacific/Tarawa', 246358, 0),       (567, 'Pacific/Tongatapu', 246442, 0),
(568, 'Pacific/Truk', 246582, 0),      (569, 'Pacific/Wake', 246651, 0),         (570, 'Pacific/Wallis', 246731, 0),
(571, 'Pacific/Yap', 246799, 0),       (572, 'Poland', 246868, 0),               (573, 'Portugal', 247861, 0),
(574, 'PRC', 249137, 0),               (575, 'PST8PDT', 249297, 0),              (576, 'ROC', 250146, 0),
(577, 'ROK', 250451, 0),               (578, 'Singapore', 250694, 0),            (579, 'Turkey', 250877, 0),
(580, 'UCT',               251882, 0), (581, 'Universal',         251950, 0),    (582, 'US/Alaska',         252018, 0),
(583, 'US/Aleutian',       252891, 0), (584, 'US/Arizona',        253761, 0),    (585, 'US/Central',        253903, 0),
(586, 'US/East-Indiana',   256473, 0), (587, 'US/Eastern',        255194, 0),    (588, 'US/Hawaii',         257091, 0),
(589, 'US/Indiana-Starke', 257204, 0), (590, 'US/Michigan',       258085, 0),    (591, 'US/Mountain',       258908, 0),
(592, 'US/Pacific',        259797, 0), (593, 'US/Pacific-New',    260826, 0),    (594, 'US/Samoa',          261855, 0),
(595, 'UTC',               261974, 0), (596, 'W-SU',              262733, 0),    (597, 'WET',               262042, 0),
(598, 'Zulu',              263312, 0);

# [BREAK]


#
# Table structure for table 'patient_contacts'
#

DROP TABLE IF EXISTS patient_contacts;
# [BREAK]
CREATE TABLE IF NOT EXISTS patient_contacts (
  cc_lKeyID          int(11) NOT NULL AUTO_INCREMENT,
  cc_lPatientID      int(11) NOT NULL,
  cc_strTitle        varbinary(255) NOT NULL,
  cc_strFName        varbinary(255) NOT NULL DEFAULT '',
  cc_strMName        varbinary(255) NOT NULL DEFAULT '',
  cc_strLName        varbinary(255) NOT NULL DEFAULT '',
  cc_lRelationshipID int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key to lists_generic',
  cc_enumGender      enum('Male','Female','Unknown') NOT NULL DEFAULT 'Unknown',
  cc_strAddr1        varbinary(255) NOT NULL DEFAULT '',
  cc_strAddr2        varbinary(255) NOT NULL DEFAULT '',
  cc_strCity         varbinary(255) NOT NULL DEFAULT '',
  cc_strState        varbinary(255) NOT NULL DEFAULT '',
  cc_strCountry      varbinary(255) NOT NULL DEFAULT '',
  cc_strZip          varbinary(255) NOT NULL DEFAULT '',
  cc_strPhone        varbinary(255) NOT NULL DEFAULT '',
  cc_strCell         varbinary(255) NOT NULL DEFAULT '',
  cc_strEmail        varbinary(255) NOT NULL DEFAULT '',
  cc_strNotes        blob NOT NULL,
  cc_bRetired        tinyint(1) NOT NULL DEFAULT '0',
  cc_lOriginID       int(11) NOT NULL DEFAULT '0',
  cc_lLastUpdateID   int(11) NOT NULL DEFAULT '0',
  cc_dteOrigin       datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  cc_dteLastUpdate   timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (cc_lKeyID),
  KEY cc_enumGender      (cc_enumGender),
  KEY cc_lPatientID      (cc_lPatientID),
  KEY cc_lRelationshipID (cc_lRelationshipID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Client contacts' ;

# [BREAK]


#
# Table structure for table 'patient_records'
#

DROP TABLE IF EXISTS patient_records;
# [BREAK]
CREATE TABLE IF NOT EXISTS patient_records (
  cr_lKeyID        int(11) NOT NULL AUTO_INCREMENT,
  cr_lChapterID    int(11) NOT NULL,
  cr_strTitle      varbinary(255) NOT NULL,
  cr_strFName      varbinary(255) NOT NULL DEFAULT '',
  cr_strMName      varbinary(255) NOT NULL DEFAULT '',
  cr_strLName      varbinary(255) NOT NULL DEFAULT '',
  cr_bActive       tinyint(1) NOT NULL DEFAULT '1',
  cr_dteInactive   date DEFAULT NULL,  
  cr_dteEnrollment date DEFAULT NULL,
  cr_dteBirth      varbinary(255) DEFAULT NULL,
  cr_dteDeath      varbinary(255) DEFAULT NULL,
  cr_enumGender    enum('Male','Female','Unknown') NOT NULL DEFAULT 'Unknown',
  cr_strAddr1      varbinary(255) NOT NULL DEFAULT '',
  cr_strAddr2      varbinary(255) NOT NULL DEFAULT '',
  cr_strCity       varbinary(255) NOT NULL DEFAULT '',
  cr_strState      varbinary(255) NOT NULL DEFAULT '',
  cr_strCountry    varbinary(255) NOT NULL DEFAULT '',
  cr_strZip        varbinary(255) NOT NULL DEFAULT '',
  cr_strPhone      varbinary(255) NOT NULL DEFAULT '',
  cr_strCell       varbinary(255) NOT NULL DEFAULT '',
  cr_strEmail      varbinary(255) NOT NULL DEFAULT '',
  cr_strBio        blob NOT NULL,
  cr_lAttributedTo int(11) DEFAULT NULL,
  cr_bRetired      tinyint(1) NOT NULL DEFAULT '0',
  cr_lOriginID     int(11) NOT NULL DEFAULT '0',
  cr_lLastUpdateID int(11) NOT NULL DEFAULT '0',
  cr_dteOrigin     datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  cr_dteLastUpdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (cr_lKeyID),
  KEY cr_enumGender    (cr_enumGender),
  KEY cr_lAttributedTo (cr_lAttributedTo),
  KEY cr_lChapterID    (cr_lChapterID),
  KEY cr_dteInactive   (cr_dteInactive)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Patient records';

# [BREAK]


#
# Table structure for table 'patient_visit'
#

DROP TABLE IF EXISTS patient_visit;
# [BREAK]

CREATE TABLE IF NOT EXISTS patient_visit (
  pv_lKeyID                  int(11) NOT NULL AUTO_INCREMENT,
  pv_lChapterID              int(11) NOT NULL,
  pv_lPatientID              int(11) NOT NULL,
  pv_lVolID                  int(11) NOT NULL,
  pv_dteVisit                date DEFAULT NULL,
  pv_lStartTime              int(11) DEFAULT NULL COMMENT 'Unix timestamp',
  pv_lDuration               int(11) NOT NULL DEFAULT '0' COMMENT 'In minutes',
  pv_strMedRec               varchar(80) NOT NULL DEFAULT '',
  pv_ps_bPatient             tinyint(1) NOT NULL DEFAULT '0',
  pv_ps_bCaregiver           tinyint(1) NOT NULL DEFAULT '0',
  pv_ps_bBereaved            tinyint(1) NOT NULL DEFAULT '0',
  pv_ps_bOther               tinyint(1) NOT NULL DEFAULT '0',
  pv_ps_strNotes             text NOT NULL,
  pv_act_lActivityID         int(11) NOT NULL COMMENT 'foreign ID to lists_generic',
  pv_act_strNotes            text NOT NULL,
  pv_loc_lLocationID         int(11) NOT NULL COMMENT 'foreign ID to lists_generic',
  pv_loc_strNotes            text NOT NULL,
  pv_in_bCompanionship       tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bCaregiverRelief     tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bEmotionalSupport    tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bSocialization       tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bBereavement         tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bTelephoneCall       tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bExcursionErrands    tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bMusicPetArt         tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bFoodPrep            tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bHouseholdChores     tinyint(1) NOT NULL DEFAULT '0',
  pv_in_bOther               tinyint(1) NOT NULL DEFAULT '0',
  pv_in_strNotes             text NOT NULL,
  pv_tsk_strOtherNotes       text NOT NULL,
  pv_tsk_bVisitors           tinyint(1) NOT NULL DEFAULT '0',
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Patient Visit Info';

# [BREAK]



#
# Table structure for table 'serial_objects'
#

DROP TABLE IF EXISTS serial_objects;
# [BREAK]
CREATE TABLE IF NOT EXISTS serial_objects (
  so_lKeyID    int(11) NOT NULL AUTO_INCREMENT,
  so_object     text NOT NULL COMMENT 'serialized object',
  so_dteCreated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (so_lKeyID),
  KEY so_dteCreated (so_dteCreated)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Hold temporary serialized objects';

# [BREAK]

#
# Table structure for table 'volunteers'
#

DROP TABLE IF EXISTS volunteers;

# [BREAK]

CREATE TABLE IF NOT EXISTS volunteers (
  vol_lKeyID           int(11) NOT NULL AUTO_INCREMENT,
  vol_lChapterID       int(11) NOT NULL DEFAULT '0',
  vol_strTitle         varchar(80) NOT NULL DEFAULT '',
  vol_strFName         varchar(80) NOT NULL DEFAULT '',
  vol_strMName         varchar(80) NOT NULL DEFAULT '',
  vol_strLName         varchar(80) NOT NULL DEFAULT '',
  vol_strPreferredName varchar(80) NOT NULL DEFAULT '',
  vol_dteBirthDate     date DEFAULT NULL,
  vol_strAddr1         varchar(80) NOT NULL DEFAULT '',
  vol_strAddr2         varchar(80) NOT NULL DEFAULT '',
  vol_strCity          varchar(80) NOT NULL DEFAULT '',
  vol_strState         varchar(80) NOT NULL DEFAULT '',
  vol_strCountry       varchar(80) NOT NULL DEFAULT '',
  vol_strZip           varchar(40) NOT NULL DEFAULT '',
  vol_strPhone         varchar(40) NOT NULL DEFAULT '',
  vol_strCell          varchar(40) NOT NULL DEFAULT '',
  vol_strEmail         varchar(120) NOT NULL DEFAULT '',
  vol_bInactive        tinyint(1) NOT NULL DEFAULT '0',
  vol_dteInactive      datetime DEFAULT NULL,
  vol_strNotes         text NOT NULL,
  vol_lAttributedTo    int(11) DEFAULT NULL COMMENT 'foreign key to lists_generic',
  vol_bRetired         tinyint(1) NOT NULL DEFAULT '0',
  vol_lOriginID        int(11) NOT NULL DEFAULT '0',
  vol_lLastUpdateID    int(11) NOT NULL DEFAULT '0',
  vol_dteOrigin        datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  vol_dteLastUpdate    timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (vol_lKeyID),
  KEY vol_strFName      (vol_strFName),
  KEY vol_strLName      (vol_strLName),
  KEY vol_lChapterID    (vol_lChapterID),
  KEY vol_lAttributedTo (vol_lAttributedTo)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

# [BREAK]

#
# Table structure for table 'vol_client_association'
#

DROP TABLE IF EXISTS vol_client_association;
# [BREAK]

CREATE TABLE IF NOT EXISTS vol_client_association (
  vca_lKeyID        int(11) NOT NULL AUTO_INCREMENT,
  vca_lVolID        int(11) NOT NULL DEFAULT '0' COMMENT 'Foreign key to volunteers',
  vca_lClientID     int(11) NOT NULL DEFAULT '0' COMMENT 'Foreign key to client_records',
  vca_strNotes      text,
  vca_bActive       tinyint(4) NOT NULL DEFAULT '1',
  vca_dteInactive   datetime DEFAULT NULL,
  vca_bRetired      tinyint(1) NOT NULL DEFAULT '0',
  vca_lOriginID     int(11)    NOT NULL DEFAULT '0',
  vca_lLastUpdateID int(11)    NOT NULL DEFAULT '0',
  vca_dteOrigin     datetime   NOT NULL DEFAULT '0000-00-00 00:00:00',
  vca_dteLastUpdate timestamp  NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (vca_lKeyID),
  KEY ufddl_lFieldID (vca_lVolID),
  KEY ufddl_lSortIDX (vca_lClientID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Associates volunteers with clients';

# [BREAK]


#
# Table structure for table 'vol_events'
#

DROP TABLE IF EXISTS vol_events;
# [BREAK]
CREATE TABLE IF NOT EXISTS vol_events (
  vem_lKeyID            int(11) NOT NULL AUTO_INCREMENT,
  vem_strEventName      varchar(255) NOT NULL DEFAULT '',
  vem_strDescription    text NOT NULL,
  vem_dteEventStartDate date NOT NULL DEFAULT '0000-00-00',
  vem_dteEventEndDate   date NOT NULL DEFAULT '0000-00-00',
  vem_strLocation       text NOT NULL,
  vem_strContact        varchar(255) NOT NULL DEFAULT '',
  vem_strPhone          varchar(80) NOT NULL DEFAULT '',
  vem_strEmail          varchar(200) NOT NULL DEFAULT '',
  vem_strWebSite        varchar(200) NOT NULL DEFAULT '',
  vem_bRetired          tinyint(1) NOT NULL DEFAULT '0',
  vem_lOriginID         int(11) NOT NULL DEFAULT '0',
  vem_lLastUpdateID     int(11) NOT NULL DEFAULT '0',
  vem_dteOrigin         datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  vem_dteLastUpdate     timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (vem_lKeyID),
  KEY vem_dteEventDate    (vem_dteEventStartDate),
  KEY vem_dteEventEndDate (vem_dteEventEndDate)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

# [BREAK]

#
# Table structure for table 'vol_events_dates'
#

DROP TABLE IF EXISTS vol_events_dates;
# [BREAK]

CREATE TABLE IF NOT EXISTS vol_events_dates (
  ved_lKeyID      int(11) NOT NULL AUTO_INCREMENT,
  ved_lVolEventID int(11) DEFAULT NULL COMMENT 'foreign key to table vol_events',
  ved_dteEvent    date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (ved_lKeyID),
  KEY ved_lVolEventID (ved_lVolEventID),
  KEY ved_dteEvent (ved_dteEvent)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Volunteer event dates';

# [BREAK]


#
# Table structure for table 'vol_events_dates_shifts'
#

DROP TABLE IF EXISTS vol_events_dates_shifts;
# [BREAK]

CREATE TABLE IF NOT EXISTS vol_events_dates_shifts (
  vs_lKeyID            int(11) NOT NULL AUTO_INCREMENT,
  vs_lEventDateID      int(11) NOT NULL COMMENT 'Foreign key to vol_events_dates',
  vs_strShiftName      varchar(255) NOT NULL DEFAULT '',
  vs_lJobCode          int(11) DEFAULT NULL COMMENT 'Foreign key to lists_generic',
  vs_strDescription    text NOT NULL,
  vs_dteShiftStartTime time NOT NULL,
  vs_enumDuration      enum('(all day)','15 minutes','30 minutes','45 minutes','1 hour','1 hour 15 minutes','1 hour 30 minutes','1 hour 45 minutes','2 hours','2 hours 15 minutes','2 hours 30 minutes','2 hours 45 minutes','3 hours','3 hours 15 minutes','3 hours 30 minutes','3 hours 45 minutes','4 hours','4 hours 15 minutes','4 hours 30 minutes','4 hours 45 minutes','5 hours','5 hours 15 minutes','5 hours 30 minutes','5 hours 45 minutes','6 hours','6 hours 15 minutes','6 hours 30 minutes','6 hours 45 minutes','7 hours','7 hours 15 minutes','7 hours 30 minutes','7 hours 45 minutes','8 hours','8 hours 15 minutes','8 hours 30 minutes','8 hours 45 minutes','9 hours','9 hours 15 minutes','9 hours 30 minutes','9 hours 45 minutes','10 hours','10 hours 15 minutes','10 hours 30 minutes','10 hours 45 minutes','11 hours','11 hours 15 minutes','11 hours 30 minutes','11 hours 45 minutes','12 hours','12 hours 15 minutes','12 hours 30 minutes','12 hours 45 minutes','13 hours','13 hours 15 minutes','13 hours 30 minutes','13 hours 45 minutes','14 hours','14 hours 15 minutes','14 hours 30 minutes','14 hours 45 minutes','15 hours','15 hours 15 minutes','15 hours 30 minutes','15 hours 45 minutes','16 hours','16 hours 15 minutes','16 hours 30 minutes','16 hours 45 minutes','17 hours','17 hours 15 minutes','17 hours 30 minutes','17 hours 45 minutes','18 hours','18 hours 15 minutes','18 hours 30 minutes','18 hours 45 minutes','19 hours','19 hours 15 minutes','19 hours 30 minutes','19 hours 45 minutes','20 hours','20 hours 15 minutes','20 hours 30 minutes','20 hours 45 minutes','21 hours','21 hours 15 minutes','21 hours 30 minutes','21 hours 45 minutes','22 hours','22 hours 15 minutes','22 hours 30 minutes','22 hours 45 minutes','23 hours','23 hours 15 minutes','23 hours 30 minutes','23 hours 45 minutes') NOT NULL DEFAULT '(all day)' COMMENT 'Duration',
  vs_lNumVolsNeeded    smallint(6) NOT NULL DEFAULT '0',
  vs_bRetired          tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (vs_lKeyID),
  KEY vs_lEventDateID      (vs_lEventDateID),
  KEY vs_dteShiftStartDate (vs_dteShiftStartTime)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

# [BREAK]


#
# Table structure for table 'vol_events_dates_shifts_assign'
#

DROP TABLE IF EXISTS vol_events_dates_shifts_assign;
# [BREAK]
CREATE TABLE IF NOT EXISTS vol_events_dates_shifts_assign (
  vsa_lKeyID            int(11) NOT NULL AUTO_INCREMENT,
  vsa_lChapterID        int(11) NOT NULL,
  vsa_lEventDateShiftID int(11) DEFAULT NULL COMMENT 'Foreign key to vol_events_dates_shifts / null for simple vol hrs',
  vsa_lVolID            int(11) NOT NULL COMMENT 'Foreign key to volunteers',
  vsa_strNotes          text NOT NULL,
  vsa_dHoursWorked      decimal(10,2) NOT NULL DEFAULT '0.00',
  vsa_dteActivityDate   datetime DEFAULT NULL COMMENT 'Date/time start for unscheduled hours',
  vsa_lActivityID       int(11)  DEFAULT NULL COMMENT 'fkey to lists_generic/for unscheduled hours',
  vsa_lJobCode          int(11)  DEFAULT NULL COMMENT 'only for unscheduled hours',
  vsa_bRetired          tinyint(1) NOT NULL DEFAULT '0',
  vsa_lOriginID         int(11)  DEFAULT NULL COMMENT 'for unscheduled hours',
  vsa_lLastUpdateID     int(11)  DEFAULT NULL COMMENT 'for unscheduled hours',
  vsa_dteOrigin         datetime DEFAULT NULL COMMENT 'for unscheduled hours',
  vsa_dteLastUpdate     timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'for unscheduled hours',
  PRIMARY KEY (vsa_lKeyID),
  KEY vsa_lEventDateShiftID (vsa_lEventDateShiftID),
  KEY vsa_lVolID            (vsa_lVolID),
  KEY vsa_lChapterID        (vsa_lChapterID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

# [BREAK]

#
# Table structure for table 'vol_skills'
#

DROP TABLE IF EXISTS vol_skills;
# [BREAK]

CREATE TABLE IF NOT EXISTS vol_skills (
  vs_lKeyID    int(11) NOT NULL AUTO_INCREMENT,
  vs_lVolID    int(11) NOT NULL COMMENT 'Foreign Key to volunteers',
  vs_lSkillID  int(11) NOT NULL COMMENT 'Foreign Key to lists_generic/volSkills',
  vs_Notes     text,
  PRIMARY KEY (vs_lKeyID),
  KEY vs_lVolID   (vs_lVolID),
  KEY vs_lSkillID (vs_lSkillID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

# [BREAK]

#
# Table structure for table 'vol_training'
#

DROP TABLE IF EXISTS vol_training;

# [BREAK]

CREATE TABLE IF NOT EXISTS vol_training (
  vt_lKeyID           int(11) NOT NULL AUTO_INCREMENT,
  vt_lVolID           int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key to table volunteers',
  vt_lChapterID       int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key to table admin_chapters',
  vt_dteDate          date DEFAULT NULL,
  vt_lDuration        int(11) NOT NULL DEFAULT '0' COMMENT 'In minutes',
  vt_lTrainingID      int(11) DEFAULT NULL COMMENT 'foreign key to lists_generic',
  vt_lTrainingByID    int(11) DEFAULT NULL COMMENT 'foreign key to lists_generic',
  vt_strNotes         text NOT NULL,
  vt_bRetired         tinyint(1) NOT NULL DEFAULT '0',
  vt_lOriginID        int(11)  NOT NULL DEFAULT '0',
  vt_lLastUpdateID    int(11)  NOT NULL DEFAULT '0',
  vt_dteOrigin        datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  vt_dteLastUpdate    timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (vt_lKeyID),
  KEY vt_lVolID        (vt_lVolID),
  KEY vt_lChapterID    (vt_lChapterID),
  KEY vt_dteDate       (vt_dteDate),
  KEY vt_lTrainingID   (vt_lTrainingID),
  KEY vt_lTrainingByID (vt_lTrainingByID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

# [BREAK]


