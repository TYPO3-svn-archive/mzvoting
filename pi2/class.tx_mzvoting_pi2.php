<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Markus Zürcher <mz@webworker.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Votingresults' for the 'mzvoting' extension.
 *
 * @author	Markus Zürcher <mz@webworker.ch>
 * @package	TYPO3
 * @subpackage	tx_mzvoting
 */
class tx_mzvoting_pi2 extends tslib_pibase {
	var $prefixId      = 'tx_mzvoting_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_mzvoting_pi2.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'mzvoting';	// The extension key.
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		//$this->conf = $conf;
		//$this->pi_setPiVarDefaults();
		$this->load_config($conf);
		$this->pi_loadLL();
		$this->pi_USER_INT_obj = 1;	// Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!
	
		
	
	
		if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
			t3lib_div::debug($this->conf);
		}
	
		// Get the template
		$this->templateHtml = $this->cObj->fileResource($this->conf['templateFile']);
	
	
		switch($this->conf['display']) {
			case 1:
				//complete ranking
				$content = $this->get_complete_ranking();
				break;
			case 2:
				//single ranking
				$content = $this->get_single_ranking();
				break;
			default:
				$content = "Please select what list you'd like to see";
				break;
		}
	
	
	
		return $this->pi_wrapInBaseClass($content);
	}
	
	  /**
    * Init Function: here all the needed configuration values are stored in class variables

    *
    * @param    array   $conf: configuration array from TS
    * @return   void

    */
   function load_config($conf) {
      $this->conf = $conf; // Store configuration

      $this->pi_setPiVarDefaults(); // Set default piVars from TS
      $this->pi_initPIflexForm(); // Init FlexForm configuration for plugin

      // Read extension configuration
      $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);

      if (is_array($extConf)) {
         $conf = t3lib_div::array_merge($extConf, $conf);

      }

      // Read TYPO3_CONF_VARS configuration
      $varsConf = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$this->extKey];

      if (is_array($varsConf)) {

         $conf = t3lib_div::array_merge($varsConf, $conf);

      }

      // Read FlexForm configuration
      if ($this->cObj->data['pi_flexform']['data']) {

         foreach ($this->cObj->data['pi_flexform']['data'] as $sheetName => $sheet) {

            foreach ($sheet as $langName => $lang) {
               foreach(array_keys($lang) as $key) {

                  $flexFormConf[$key] = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 
                                                             $key, $sheetName, $langName);

                  if (!$flexFormConf[$key]) {
                     unset($flexFormConf[$key]);

                  }
               }
            }
         }
      }

      if (is_array($flexFormConf)) {

         $conf = t3lib_div::array_merge($conf, $flexFormConf);
      }

      $this->conf = $conf;

   }


	/**
	 * funktionsvorlage zum kopieren
	 *
	 * @param	string		$content: The PlugIn content
	 * @return	the		voting form
	 */
	function get_complete_ranking() {
		
		if(empty($this->conf['votingid'])) {
			$return = 'Please define voting id';			
		} else {
			
			$rankingrow = $GLOBALS["TYPO3_DB"]->exec_SELECTgetRows("crdate, ranking_data", "tx_mzvoting_ranking", "voting_id = ".$this->conf['votingid'], "", "crdate DESC LIMIT 1");
			
			$rankingtime = date("d.m.Y H:i:s", $rankingrow[0]['crdate']);
			$rankingdata = unserialize($rankingrow[0]['ranking_data']);
			
			$entries = '';
			// Extract subparts from the template
			$entrie_subpart = $this->cObj->getSubpart($this->templateHtml, '###COMPLETERANKINGENTRIE###');
			
			
			for($i=1; $i<= $rankingdata['nrofoptions']; $i++) {
				
				$curent_entry = $rankingdata['option'][$rankingdata['ranking']['$i']];
		
				// Fill marker array
				$markerArray['###POSITION###'] = $curent_entry['position']; 
				$markerArray['###TOTALVOTES###'] = $curent_entry['totalvotes']; 
				$markerArray['###TREND###'] = $curent_entry['trend']; 		
				$markerArray['###OPTIONNAME###']  =  $curent_entry['name'];
		
				// Create the content by replacing the content markers in the template
				$entries .= $this->cObj->substituteMarkerArrayCached($entrie_subpart, $markerArray)."\n";
				
			}
			
		}

		return($return);

	}

	/**
	 * funktionsvorlage zum kopieren
	 *
	 * @param	string		$content: The PlugIn content
	 * @return	the		voting form
	 */
	function test() {

		return($return);

	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mzvoting/pi2/class.tx_mzvoting_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mzvoting/pi2/class.tx_mzvoting_pi2.php']);
}

?>