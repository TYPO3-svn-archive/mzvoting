<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_mzvoting_votes'] = array (
	'ctrl' => $TCA['tx_mzvoting_votes']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,email,firstname,lastname,vote,phone,vote_ip,confirm_ip,vote_time,confirm_time,vote_referer,confirm_referer,vote_browser,confirm_browser,secret,voting,country,additional_data'
	),
	'feInterface' => $TCA['tx_mzvoting_votes']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'email' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.email',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'firstname' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.firstname',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'lastname' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.lastname',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'vote' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.vote',		
			'config' => array (
				'type'     => 'input',
				'size'     => '4',
				'max'      => '4',
				'eval'     => 'int',
				'checkbox' => '0',
				'range'    => array (
					'upper' => '1000',
					'lower' => '10'
				),
				'default' => 0
			)
		),
		'phone' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.phone',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'country' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.country',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'static_countries',	
				'foreign_table_where' => 'ORDER BY static_countries.cn_short_en',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'terms' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.terms',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'newsletter' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.newsletter',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'additional_data' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.additional_data',		
			'config' => array (
				'type' => 'text',
				'wrap' => 'OFF',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'vote_ip' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.vote_ip',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'confirm_ip' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.confirm_ip',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'vote_time' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.vote_time',		
			'config' => array (
				'type'     => 'input',
				'size'     => '12',
				'max'      => '20',
				'eval'     => 'datetime',
				'checkbox' => '0',
				'default'  => '0'
			)
		),
		'confirm_time' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.confirm_time',		
			'config' => array (
				'type'     => 'input',
				'size'     => '12',
				'max'      => '20',
				'eval'     => 'datetime',
				'checkbox' => '0',
				'default'  => '0'
			)
		),
		'vote_referer' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.vote_referer',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'confirm_referer' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.confirm_referer',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'vote_browser' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.vote_browser',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'confirm_browser' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.confirm_browser',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'secret' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.secret',		
			'config' => array (
				'type' => 'none',
			)
		),
		'voting' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votes.voting',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_mzvoting_votings',	
				'foreign_table_where' => 'ORDER BY tx_mzvoting_votings.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, email, firstname, lastname, vote, phone, country, terms, newsletter, additional_data, vote_ip, confirm_ip, vote_time, confirm_time, vote_referer, confirm_referer, vote_browser, confirm_browser, secret, voting')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_mzvoting_ranking'] = array (
	'ctrl' => $TCA['tx_mzvoting_ranking']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'ranking_data,voting_id'
	),
	'feInterface' => $TCA['tx_mzvoting_ranking']['feInterface'],
	'columns' => array (
		'ranking_data' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_ranking.ranking_data',		
			'config' => array (
				'type' => 'none',
			)
		),
		'voting_id' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_ranking.voting_id',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_mzvoting_votings',	
				'foreign_table_where' => 'ORDER BY tx_mzvoting_votings.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'ranking_data;;;;1-1-1, voting_id')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_mzvoting_votings'] = array (
	'ctrl' => $TCA['tx_mzvoting_votings']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,starttime,endtime,name,description'
	),
	'feInterface' => $TCA['tx_mzvoting_votings']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(3, 14, 7, 1, 19, 2038),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		'name' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votings.name',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'options' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votings.options',		
			'config' => array (
				'type' => 'input',	
				'size' => '15',
			)
		),
		'description' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_votings.description',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, name, options, description')
	),
	'palettes' => array (
		'1' => array('showitem' => 'starttime, endtime')
	)
);



$TCA['tx_mzvoting_recomends'] = array (
	'ctrl' => $TCA['tx_mzvoting_recomends']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,from_mail,from_name,to_mail,vote,status,send_time'
	),
	'feInterface' => $TCA['tx_mzvoting_recomends']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'from_mail' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_recomends.from_mail',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'from_name' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_recomends.from_name',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'to_mail' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_recomends.to_mail',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'vote' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_recomends.vote',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_mzvoting_votes',	
				'foreign_table_where' => 'AND tx_mzvoting_votes.pid=###CURRENT_PID### ORDER BY tx_mzvoting_votes.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'status' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_recomends.status',		
			'config' => array (
				'type' => 'none',
			)
		),
		'send_time' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:mzvoting/locallang_db.xml:tx_mzvoting_recomends.send_time',		
			'config' => array (
				'type'     => 'input',
				'size'     => '12',
				'max'      => '20',
				'eval'     => 'datetime',
				'checkbox' => '0',
				'default'  => '0'
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, from_mail, from_name, to_mail, vote, status, send_time')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>