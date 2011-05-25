<?php

########################################################################
# Extension Manager/Repository config file for ext "mzvoting".
#
# Auto generated 19-05-2011 15:15
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Voting',
	'description' => 'Insert Voting',
	'category' => 'plugin',
	'author' => 'Markus Zürcher',
	'author_email' => 'mz@webworker.ch',
	'shy' => '',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'experimental',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '4.3-4.5.2',
			'static_info_tables' => '2.2.0-'
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:20:{s:9:"ChangeLog";s:4:"4c23";s:10:"README.txt";s:4:"ee2d";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"774c";s:14:"ext_tables.php";s:4:"d7d3";s:14:"ext_tables.sql";s:4:"5705";s:28:"icon_tx_mzvoting_ranking.gif";s:4:"475a";s:30:"icon_tx_mzvoting_recomends.gif";s:4:"475a";s:26:"icon_tx_mzvoting_votes.gif";s:4:"475a";s:28:"icon_tx_mzvoting_votings.gif";s:4:"475a";s:16:"locallang_db.xml";s:4:"30b5";s:7:"tca.php";s:4:"5e19";s:19:"doc/wizard_form.dat";s:4:"536a";s:20:"doc/wizard_form.html";s:4:"bc88";s:29:"pi1/class.tx_mzvoting_pi1.php";s:4:"19d0";s:17:"pi1/locallang.xml";s:4:"9512";s:29:"pi2/class.tx_mzvoting_pi2.php";s:4:"5e16";s:17:"pi2/locallang.xml";s:4:"523e";s:37:"static/static_templates/constants.txt";s:4:"bdd3";s:33:"static/static_templates/setup.txt";s:4:"59b5";}',
);

?>