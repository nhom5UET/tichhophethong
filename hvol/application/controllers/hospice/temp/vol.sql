

DROP TABLE IF EXISTS volunteers;
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

  vol_bRetired         tinyint(1) NOT NULL DEFAULT '0',
  vol_lOriginID        int(11) NOT NULL DEFAULT '0',
  vol_lLastUpdateID    int(11) NOT NULL DEFAULT '0',
  vol_dteOrigin        datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  vol_dteLastUpdate    timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (vol_lKeyID),
  KEY vol_strFName (vol_strFName),
  KEY vol_strLName (vol_strLName),
  KEY vol_lChapterID (vol_lChapterID)
  
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

