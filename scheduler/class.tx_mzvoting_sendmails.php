<?php
class tx_mzvoting_sendmails extends tx_scheduler_Task {

	/**
	 * @var integer
	 */
	public $senderAddress;
	public $returnPath;
	public $countInARun;
	/**
	 * Function executed from the Scheduler.
	 *
	 * @return	void
	 */
	public function execute() {
		//$this->setCliArguments();
		$this->cObj = new tslib_cObj();
	
		// Extract subparts from the template
		$subpart = $this->cObj->getSubpart(t3lib_extMgm::extPath('mzvoting')."static/templates/scheduler/recommendation_mail.html", '###MAIL###');// Fill marker array

		

		
		$records = $GLOBALS["TYPO3_DB"]->exec_SELECTgetRows("uid, from_name, fromm_mail, to_mail, url", "tx_mzvoting_recomends", "status = 1 AND deleted = 0 AND hidden = 0", "", "tstamp ASC LIMIT ".$this->$countInARun);
		$errors = 0;
		if($records) {
			foreach($records as $record) {
				
				//nomarkers jet
				$markerArray['###FROM_NAME###'] = $record['from_name'];
				$markerArray['###FROM_MAIL###'] = $record['from_mail'];
				$markerArray['###URL###'] = $record['url'];
				$markerArray['###TO_MAIL###'] = $record['to_mail'];
				
				
			
				$this->recommendationMail = t3lib_div::makeInstance('t3lib_htmlmail');
					
				$this->recommendationMail->start();
				$this->recommendationMail->recipient = $record['to_mail'];
				$this->recommendationMail->replyto_email = $record['from_mail'];
				$this->recommendationMail->replyto_name = $record['from_name'];
				$this->recommendationMail->subject = $record['from_name'] . 'Please confirm your vote';
				$this->recommendationMail->from_email = $this->senderAddress;
				$this->recommendationMail->from_name = $record['from_name'];
				//$this->recommendationMail->organisation = $this->conf['mail.']['organisation'];
				$this->recommendationMail->returnPath = $this->returnPath;
				//$this->recommendationMail->addPlain($txt_mailcontent);
				$this->recommendationMail->setHTML($this->recommendationMail->encodeMsg($this->cObj->substituteMarkerArrayCached($subpart, $markerArray)));
				$this->recommendationMail->send($record['to_mail']);
				
				$datatostore['tstamp'] = time();
				$datatostore['status'] = 3; 
				
				$update = $GLOBALS["TYPO3_DB"]->exec_UPDATEquery("tx_mzvoting_recomends","uid = ".$record['uid'], $datatostore);
			}
		}
		
		if($errors == 0) {
			return(true);
		} else {
			return(false);
		}
	}


}

?>
