<?php
class tx_mzvoting_recalc extends tx_scheduler_Task {

	/**
	 * Function executed from the Scheduler.
	 *
	 * @return	void
	 */
	public function execute() {
		
		$no_error = true;
		
		$config = $this->getTypoScriptSetup();
		$config_pi1 =$config['plugin.']['tx_mzvoting_pi1.'];
		$config_pi2 =$config['plugin.']['tx_mzvoting_pi2.'];
		
		$active_votings = $GLOBALS["TYPO3_DB"]->exec_SELECTgetRows("uid, options", "tx_mzvoting_votings", "deleted = 0 AND hidden = 0", "", "uid ASC");
		
		foreach($active_votings as $voting) {
			
			//get current data
			$current_ranking_row = $GLOBALS["TYPO3_DB"]->exec_SELECTgetRows("ranking_data", "tx_mzvoting_ranking", "voting_id = ".$voting['uid'], "", "crdate DESC LIMIT 1");
			
			//print_r($current_ranking_row) ;
			
			$current_ranking_data = unserialize($current_ranking_row[0]['ranking_data']);
			
			//print_r($current_ranking_row[0]['ranking_data']);
			
			$current_ranking = implode(",", $current_ranking_data['ranking']);
			
			$new_ranking_data = array();
		
			for($i=1; $i<= $voting['options']; $i++) {
				$votings = $GLOBALS["TYPO3_DB"]->exec_SELECTgetRows("count(*) as total_record", "tx_mzvoting_votes", "voting = ".$voting['uid']." AND deleted = 0 AND hidden = 0 AND vote = $i");
				$temp_ranking_data[$i] = $votings['total_record'];
				
			}
			
			//print_r($temp_ranking_data);
			arsort($temp_ranking_data);
			//print_r($temp_ranking_data);
			
			$i = 1;
			foreach($temp_ranking_data as $optionid => $votes) {
				$new_ranking_data['ranking'][$i] = $optionid;
				$new_ranking_data['options'][$optionid]['totalvotes'] = $votes;
				$new_ranking_data['options'][$optionid]['ranking'] = $i;
				
				$i++;
			}
			$new_ranking_data['nrofoptions'] = $voting['options'];
			//print_r($new_ranking_data);
			$new_ranking = implode(",",$new_ranking_data['ranking']);
			
			
			var_dump($current_ranking);
			var_dump($new_ranking);
			
			if($current_ranking != $new_ranking) {
				//ranking has changed!
				
				//check trend
				foreach($new_ranking_data['options'] as $optionid => $option) {
					if($option['ranking'] == 1 or $option['ranking'] >>	 $current_ranking_data[$optionid]['ranking']) {
						$new_ranking_data['options'][$optionid]['trend'] = 'up';
					} else {
						$new_ranking_data['options'][$optionid]['trend'] = 'down';						
					}
				}
				
				//print_r($new_ranking_data);
				
				$datatostore['pid'] = '';
				$datatostore['tstamp'] = time();
				$datatostore['crdate'] = time();
				$datatostore['cruser_id'] = '0';
				$datatostore['ranking_data'] = serialize($new_ranking_data);
				$datatostore['voting_id'] = $voting['uid'];
				
				//insert new ranking
				$insert = $GLOBALS["TYPO3_DB"]->exec_INSERTquery('tx_mzvoting_ranking',$datatostore );
			}
			
		}
		
		return($no_error);
	}
	 /**
	  * Returns the TypoScript configuration found in module.tx_yourextension_yourmodule
	  * merged with the global configuration of your extension from module.tx_yourextension
	  *
	  * @param string $extensionName
	  * @param string $pluginName in BE mode this is actually the module signature. But we're using it just like the plugin name in FE
	  * @return array
	  */
	 protected function getPluginConfiguration($extensionName, $pluginName) {
		$setup = $this->getTypoScriptSetup();
		$pluginConfiguration = array();
		if (is_array($setup['module.']['tx_' . strtolower($extensionName) . '.'])) {
			$pluginConfiguration = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($setup['module.']['tx_' . strtolower($extensionName) . '.']);
		}
		$pluginSignature = strtolower($extensionName . '_' . $pluginName);
		if (is_array($setup['module.']['tx_' . $pluginSignature . '.'])) {
			$pluginConfiguration = t3lib_div::array_merge_recursive_overrule($pluginConfiguration, Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($setup['module.']['tx_' . $pluginSignature . '.']));
		}
		return $pluginConfiguration;
	 }
	 
	public function getTypoScriptSetup() {
		if ($this->typoScriptSetupCache === NULL) {
			$template = t3lib_div::makeInstance('t3lib_TStemplate');
			// do not log time-performance information
			$template->tt_track = 0;
			$template->init();
			// Get the root line
			$sysPage = t3lib_div::makeInstance('t3lib_pageSelect');
			// get the rootline for the current page
			$rootline = $sysPage->getRootLine($this->getCurrentPageId());
			// This generates the constants/config + hierarchy info for the template.
			$template->runThroughTemplates($rootline, 0);
			$template->generateConfig();
			$this->typoScriptSetupCache = $template->setup;
		}
		return $this->typoScriptSetupCache;
	}

/**
  * Returns the page uid of the current page.
  * If no page is selected, we'll return the uid of the first root page.
  *
  * @return integer current page id. If no page is selected current root page id is returned
  */
 protected function getCurrentPageId() {
  $pageId = (integer)t3lib_div::_GP('id');
  if ($pageId > 0) {
   return $pageId;
  }

   // get current site root
  $rootPages = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid', 'pages', 'deleted=0 AND hidden=0 AND is_siteroot=1', '', '', '1');
  if (count($rootPages) > 0) {
   return $rootPages[0]['uid'];
  }

   // get root template
  $rootTemplates = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('pid', 'sys_template', 'deleted=0 AND hidden=0 AND root=1', '', '', '1');
  if (count($rootTemplates) > 0) {
   return $rootTemplates[0]['pid'];
  }

   // fallback
  return self::DEFAULT_BACKEND_STORAGE_PID;
 }
}

?>
