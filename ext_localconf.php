<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_mzvoting_pi1.php', '_pi1', 'list_type', 1);


t3lib_extMgm::addPItoST43($_EXTKEY, 'pi2/class.tx_mzvoting_pi2.php', '_pi2', 'list_type', 0);

$TYPO3_CONF_VARS['SC_OPTIONS']['scheduler']['tasks']['tx_mzvoting_recalc'] = array(
	'extension' => $_EXTKEY, // Selbsterklärend
	'title' => 'Calculate Ranking', //'LLL:EXT:'.$_EXTKEY.'/locallang.xml:TaskName.name', // Der Titel der Aufgabe
	'description' => 'Recalculate the voting ranking', //'LLL:EXT:'.$_EXTKEY.'/locallang.xml:TaskName.description', // Die Beschreibung der Aufgabe
	// 'additionalFields' => 'tx_extkey_TaskName_AdditionalFieldProvider' // Zusätzliche Felder
);
$TYPO3_CONF_VARS['SC_OPTIONS']['scheduler']['tasks']['tx_mzvoting_sendmails'] = array(
	'extension' => $_EXTKEY, // Selbsterklärend
	'title' => 'Send recommendations', //'LLL:EXT:'.$_EXTKEY.'/locallang.xml:TaskName.name', // Der Titel der Aufgabe
	'description' => 'Sends the recommendation mails', //'LLL:EXT:'.$_EXTKEY.'/locallang.xml:TaskName.description', // Die Beschreibung der Aufgabe
	'additionalFields' => 'tx_mzvoting_sendmails_AdditionalFieldProvider',
);

?>