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

CREATE TABLE bookmarks (
  id int(11) NOT NULL auto_increment,
  user_id int(11) NOT NULL default '0',
  url varchar(255) NOT NULL default '',
  title varchar(255) NOT NULL default '',
  notes text NOT NULL,
  created datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY url (url),
  KEY created (created)
) TYPE=MyISAM;

# one row for every tag on every bookmark
CREATE TABLE tags (
  bookmark_id int(11) NOT NULL default '0',
  tag varchar(64) NOT NULL default '',
  PRIMARY KEY (bookmark_id, tag),
  KEY tag (tag)
) TYPE=MyISAM;
