<?php
class tx_mzvoting_sendmails_AdditionalFieldProvider implements tx_scheduler_AdditionalFieldProvider {


	public function getAdditionalFields(array &$taskInfo, $task, tx_scheduler_Module $schedulerModule) {
		$additionalFields = array();

		if (empty($taskInfo['senderAddress'])) {
                        if ($schedulerModule->CMD == 'add') {
                                $taskInfo['senderAddress'] = '';
                        } elseif ($schedulerModule->CMD == 'edit') {
                                $taskInfo['senderAddress'] = $task->senderAddress;
                        } else {
                                $taskInfo['senderAddress'] = $task->senderAddress;
                        }
		}
		
		if (empty($taskInfo['returnPath'])) {
                        if ($schedulerModule->CMD == 'add') {
                                $taskInfo['returnPath'] = '';
                        } elseif ($schedulerModule->CMD == 'edit') {
                                $taskInfo['returnPath'] = $task->returnPath;
                        } else {
                                $taskInfo['returnPath'] = $task->returnPath;
                        }
		}
		if (empty($taskInfo['countInARun'])) {
                        if ($schedulerModule->CMD == 'add') {
                                $taskInfo['countInARun'] = 40;
                        } elseif ($schedulerModule->CMD == 'edit') {
                                $taskInfo['countInARun'] = $task->countInARun;
                        } else {
                                $taskInfo['countInARun'] = $task->countInARun;
                        }
		}
		
		
		
		
		
		
		
			// input for senderAddress
		$fieldID = 'task_senderAddress';
		$fieldCode  = '<input type="text" name="tx_scheduler[senderAddress]" id="' . $fieldID . '" value="' . $taskInfo['senderAddress'] . '" />';
		$additionalFields[$fieldID] = array(
                        'code'     => $fieldCode,
                        'label'    => 'Sender email address';//[todo]'LLL:EXT:crawler/locallang_db.xml:crawler_im.countInARun'
                );
		
			// input for returnPath 
		$fieldID = 'task_returnPath';
		$fieldCode  = '<input type="text" name="tx_scheduler[returnPath]" id="' . $fieldID . '" value="' . $taskInfo['returnPath'] . '" />';
		$additionalFields[$fieldID] = array(
                        'code'     => $fieldCode,
                        'label'    => 'E-Mail Return Path';//[todo]'LLL:EXT:crawler/locallang_db.xml:crawler_im.countInARun'
                );
		
			// input for countInARun 
		$fieldID = 'task_countInARun';
		$fieldCode  = '<input type="text" name="tx_scheduler[countInARun]" id="' . $fieldID . '" value="' . $taskInfo['countInARun'] . '" />';
		$additionalFields[$fieldID] = array(
                        'code'     => $fieldCode,
                        'label'    => 'Mails in a Run';//[todo]'LLL:EXT:crawler/locallang_db.xml:crawler_im.countInARun'
                );

		return $additionalFields;
	}


	public function validateAdditionalFields(array &$submittedData, tx_scheduler_Module $schedulerModule) {
		$isValid = false;

		if ( $submittedData['senderAddress']) == '' ) {
			$isValid = false;
			$schedulerModule->addMessage('Please define sender email address' /*$GLOBALS['LANG']->sL('LLL:EXT:crawler/locallang_db.xml:crawler_im.invalidCountInARun')*/, t3lib_FlashMessage::ERROR);
		}
		if ( $submittedData['returnPath']) == '' ) {
			$isValid = false;
			$schedulerModule->addMessage('Please define return path' /*$GLOBALS['LANG']->sL('LLL:EXT:crawler/locallang_db.xml:crawler_im.invalidCountInARun')*/, t3lib_FlashMessage::ERROR);
		}
		if ( t3lib_div::intval_positive($submittedData['countInARun']) === 0 ) {
			$isValid = false;
			$schedulerModule->addMessage('Invalid input for Mails in a Run' /*$GLOBALS['LANG']->sL('LLL:EXT:crawler/locallang_db.xml:crawler_im.invalidCountInARun')*/, t3lib_FlashMessage::ERROR);
		}
		
		return $isValid;
	}

	/**
	 * This method is used to save any additional input into the current task object
	 * if the task class matches
	 *
	 * @param	array				$submittedData: array containing the data submitted by the user
	 * @param	tx_scheduler_Task	$task: reference to the current task object
	 */
	public function saveAdditionalFields(array $submittedData, tx_scheduler_Task $task) {

		$task->senderAddress      = $submittedData['senderAddress'];
		$task->returnPath      = $submittedData['returnPath'];
		$task->countInARun      = $submittedData['countInARun'];
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mzvoting/class.tx_mzvoting_sendmails_AdditionalFieldProvider.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mzvoting/class.tx_mzvoting_sendmails_AdditionalFieldProvider.php']);
}

?>
