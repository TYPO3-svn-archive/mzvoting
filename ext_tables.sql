#
# Table structure for table 'tx_mzvoting_votes'
#
CREATE TABLE tx_mzvoting_votes (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	firstname tinytext,
	lastname tinytext,
	vote int(11) DEFAULT '0' NOT NULL,
	phone tinytext,
	country int(11) DEFAULT '0' NOT NULL,
	terms tinyint(4) DEFAULT '0' NOT NULL,
	newsletter tinyint(4) DEFAULT '0' NOT NULL,
	additional_data text,
	vote_ip tinytext,
	confirm_ip tinytext,
	vote_time int(11) DEFAULT '0' NOT NULL,
	confirm_time int(11) DEFAULT '0' NOT NULL,
	vote_referer tinytext,
	confirm_referer tinytext,
	vote_browser tinytext,
	confirm_browser tinytext,
	secret tinytext,
	voting int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_mzvoting_ranking'
#
CREATE TABLE tx_mzvoting_ranking (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	ranking_data tinytext,
	voting_id int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_mzvoting_votings'
#
CREATE TABLE tx_mzvoting_votings (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	name tinytext,
	options int(11) DEFAULT '0' NOT NULL,
	description text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_mzvoting_recomends'
#
CREATE TABLE tx_mzvoting_recomends (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	from_mail tinytext,
	from_name tinytext,
	to_mail tinytext,
	vote int(11) DEFAULT '0' NOT NULL,
	status tinytext,
	send_time int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);