# linkpile tables
# made with mysql 4.0

CREATE TABLE users (
  id int(11) NOT NULL auto_increment,
  username varchar(32) NOT NULL default '',
  password varchar(32) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  created datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (id),
  UNIQUE KEY username (username)
) TYPE=MyISAM;
