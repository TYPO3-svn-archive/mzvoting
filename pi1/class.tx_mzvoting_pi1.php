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
 *
 *
 *   59: class tx_mzvoting_pi1 extends tslib_pibase
 *   72:     function main($content, $conf)
 *  117:     function form_handler()
 *  152:     function get_votingform()
 *  178:     function render_terms()
 *  208:     function render_countries()
 *  254:     function formdata_handler($formdata)
 *  402:     function check_for_existing_votes($mail)
 *  423:     function send_confirmation_mail($mail, $firstname, $lastname, $vid, $secret )
 *  488:     function confirmation_handler()
 *  580:     function report_error($errorcode)
 *  595:     function load_config($conf)
 *  653:     function show_button()
 *  681:     function test()
 *
 * TOTAL FUNCTIONS: 13
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Votingform' for the 'mzvoting' extension.
 *
 * @author	Markus Zürcher <mz@webworker.ch>
 * @package	TYPO3
 * @subpackage	tx_mzvoting
 */
class tx_mzvoting_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_mzvoting_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_mzvoting_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'mzvoting';	// The extension key.
	var $pi_checkCHash = true;

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The		content that is displayed on the website
	 */
	function main($content, $conf) {
		//$this->conf = $conf;
		//$this->pi_setPiVarDefaults();

		$this->load_config($conf);

		$this->pi_loadLL();

		$this->getVars = t3lib_div::_GET('tx_mzvoting');



		// Get the template
		$this->templateHtml = $this->cObj->fileResource($this->conf['templateFile']);

		/**
		 * What do we have to display?
		 */

		switch ($this->getVars['action']) {
			case 2:
				/** confirm a vote **/
				$content = $this->confirmation_handler();
				break;
			case 1:
				/** display the form **/
				$content = $this->form_handler();
				break;
			default:
				/** display the button **/
				$content = $this->show_button();
				break;
		}


		return $this->pi_wrapInBaseClass($content);
	}



	/**
	 * decides if we have to display the form or have to handel any data
	 *
	 * @return	html		output
	 */
	function form_handler() {
		if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
			t3lib_div::debug();
		}

		/**
		* Have we got any form data
		**/
		if(isset($_POST['tx_mzvoting_pi1_votingform'])) {
			/**
			* do something with the data
			**/

			$return = $this->formdata_handler($_POST['tx_mzvoting_pi1_votingform']);

		} else {
			/**
			* get the form
			**/

			$return = $this->get_votingform();
		}


	return($return);

	}



	/**
	 * renders the form
	 * 
	 * @param	array	$formdata	available values
	 * @param	string	$errormsg	error message
	 * @return	the		voting form
	 */
	function get_votingform($formdata = '', $errormsg = '') {

		// Extract subparts from the template
		$subpart = $this->cObj->getSubpart($this->templateHtml, '###VOTINGFORM###');

		// Fill marker array
		$markerArray['###ACTION###'] = ''; //[todo] define by typoscript/constants
		$markerArray['###METHOD###'] = 'post'; //[todo] define by typoscript/constants
		$markerArray['###ERROR###'] = $errormsg; 


		$markerArray['###COUNTRY###']  =  $this->render_countries();
		$markerArray['###TERMSANDCONDITIONS###']  =  $this->render_terms();

		// Create the content by replacing the content markers in the template
		$return = $this->cObj->substituteMarkerArrayCached($subpart, $markerArray);

		return($return);

	}


	/**
	 * Renders and returns terms andconditions if needet
	 *
	 * @return	the		html for terms & conditions
	 */
	function render_terms() {
		/**
		*  is the therms and conditions check activ?
		**/
		if( $this->conf['terms.']['active'] == 1) {
			// Extract subparts from the template
			$subpart = $this->cObj->getSubpart($this->templateHtml, '###TERMS###');// Fill marker array

			// Set the URL to the terms
			$markerArray['###TERMSANDCONDITIONSURL###'] = $this->cObj->getTypoLink_URL($this->conf['terms.']['params']);

			//render
			$return = $this->cObj->substituteMarkerArrayCached($subpart, $markerArray);

			//send the html back
			return($return);
		} else {
			//return empty
			return ('');
		}

	}



	/**
	 * renders the options list for the countrie selector from static info table
	 *
	 * @return	the		countrie options
	 */
	function render_countries() {
		/**
		*  is the country selector active?
		**/
		if( $this->conf['country.']['active'] == 1) {
			// Extract subparts from the template
			$subpart = $this->cObj->getSubpart($this->templateHtml, '###COUNTRIESELECTOR###');

			$countries = $GLOBALS["TYPO3_DB"]->exec_SELECTgetRows("uid, cn_short_en", " static_countries", "1=1", "", "cn_short_en ASC");

			if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 1) {
				t3lib_div::debug($countries);
			}

			$countrie_options = '';
			foreach($countries as $country) {
				$countrie_options .= "\n" . '<option value="' . $country['uid'] . '">' . $country['cn_short_en'] . '</option>';
				if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
					t3lib_div::debug($country);
				}
			}


			// Fill marker array
			$markerArray['###OPTIONS###'] = $countrie_options;

			//render
			$return = $this->cObj->substituteMarkerArrayCached($subpart, $markerArray);

			//send the html back
			return($return);

		} else {
			//return empty
			return ('');
		}

	}


	/**
	 * funktionsvorlage zum kopieren
	 *
	 * @param	array		$formdata: POST Data
	 * @return	the		output
	 */
	function formdata_handler($formdata) {

		if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
			t3lib_div::debug($formdata);
		}


		$return = '';
		$errormsg = '';
		$errors = 0;





		if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
			t3lib_div::debug($this->conf['data.']['require.']);
		}


		// [TODO] IMPROVE VALIDATION

		foreach($this->conf['data.']['require.'] as $field => $setting) {
			if($setting == 1 && empty($formdata[$field])) {
				$errors ++;
				$errormsg .= $this->conf['data.']['error.'][$field];
			}

		}




		if($errors > 0 ) {

			if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
				t3lib_div::debug($this->conf['data.']['errorwrap']);
			}
			
			$wrap = explode("|", $this->conf['data.']['errorwrap']);

			if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
				t3lib_div::debug($wrap);
			}
			
			$return .= $this->get_votingform($formdata,$wrap[0].$errormsg.$wrap[1]);
		} else {
			//votet in the past 24 hours with this email?
			$existing_records = $this->check_for_existing_votes($formdata['email']);
			if(count($existing_records) == 0) {
				//no write data
				//datenspeichern
				$datatostore['email'] = $formdata['email']; unset($formdata['email']);
				$datatostore['firstname'] = $formdata['firstname']; unset($formdata['firstname']);
				$datatostore['lastname'] = $formdata['lastname']; unset($formdata['lastname']);
				$datatostore['phone'] = $formdata['phone']; unset($formdata['phone']);
				$datatostore['newsletter'] = intval($formdata['newsletter']); unset($formdata['newsletter']);
				$datatostore['country'] = intval($formdata['country']); unset($formdata['country']);
				$datatostore['terms'] = intval($formdata['terms']); unset($formdata['terms']);
				unset($formdata['data']);
				unset($formdata['submit']);


				if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
					t3lib_div::debug($formdata);
				}

				$datatostore['pid'] = intval($this->conf['votestorage']);
				$datatostore['tstamp'] = time();
				$datatostore['crdate'] = time();
				$datatostore['cruser_id'] = '0';
				$datatostore['deleted'] = '0';
				$datatostore['hidden'] = '1';

				$datatostore['secret'] = md5(uniqid()) ;
				$datatostore['vote_ip'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
				$datatostore['vote_time'] = time() ;
				$datatostore['vote_referer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
				$datatostore['vote_browser'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
				$datatostore['voting'] = intval($this->conf['voting']) ;
				$datatostore['vote'] = isset($formdata['vote']) ? $formdata['vote'] : $this->conf['vote'];

				$formdata['host'] = gethostbyaddr($datatostore['vote_ip']);

				$datatostore['additional_data '] = serialize($formdata);

				if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
					t3lib_div::debug($datatostore);
				}


				$insert = $GLOBALS["TYPO3_DB"]->exec_INSERTquery 	('tx_mzvoting_votes',$datatostore );
				if($insert) {
					$vid = mysql_insert_id();
					$return = "new row with uid $uid<br>".$insert;

					$this->send_confirmation_mail($datatostore['email'], $datatostore['firstname'], $datatostore['lastname'], $vid, $datatostore['secret']);
				} else {
					$return = "insert fialed";
				}



			} else {
				// fehler zeigen votet in the past 24h
				// [todo] fehler
				$next_time = $existing_records[0]['vote_time'] + (24*60*60);
				$time_diff = $next_time - time();

				if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
					t3lib_div::debug($existing_records[0]['vote_time']);
				}


				if($time_diff > 0) {
					// Extract subparts from the template
					$subpart = $this->cObj->getSubpart($this->templateHtml, '###24HERROR###');// Fill marker array


					$markerArray['###HOURS###'] = gmdate("H", $time_diff);
					$markerArray['###MINUTES###'] = gmdate("i", $time_diff);
					$markerArray['###SECONDS###'] = gmdate("s", $time_diff);

					//render
					$return = $this->cObj->substituteMarkerArrayCached($subpart, $markerArray);

				} else {
					//[TODO] resolution if time went to 0 during runtime so we never display 0 or less remaining blocktime


					// Extract subparts from the template
					$subpart = $this->cObj->getSubpart($this->templateHtml, '###24HERROR###');// Fill marker array


					$markerArray['###HOURS###'] = gmdate("H", $time_diff);
					$markerArray['###MINUTES###'] = gmdate("i", $time_diff);
					$markerArray['###SECONDS###'] = gmdate("s", $time_diff);

					//render
					$return = $this->cObj->substituteMarkerArrayCached($subpart, $markerArray);

				}
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
	function check_for_existing_votes($mail) {

		$decision_time = time()-(24*60*60);
		$records = $GLOBALS["TYPO3_DB"]->exec_SELECTgetRows("uid, vote_time, hidden", "tx_mzvoting_votes", "vote_time > $decision_time AND email = '".trim($mail)."'", "", "vote_time DESC LIMIT 1");


		return($records);

	}


	/**
	 * funktionsvorlage zum kopieren
	 *
	 * @param	string		$mail: email address
	 * @param	string		$firstname: receivers firstname
	 * @param	string		$lastname: receivers lastname
	 * @param	integer		$id: voteid
	 * @param	string		$secret: voteid
	 * @return	true		or false
	 */
	function send_confirmation_mail($mail, $firstname, $lastname, $vid, $secret ) {

		$linkparams['tx_mzvoting']['vote']= 'con'.dechex($vid);
		$linkparams['tx_mzvoting']['code']= $secret;
		$linkparams['tx_mzvoting']['action']= '2'; //activate

		$url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $this->cObj->getTypoLink_URL($GLOBALS["TSFE"]->id,$linkparams);


		if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
			t3lib_div::debug($this->cObj->getTypoLink_URL($GLOBALS["TSFE"]->id,$linkparams));
		}

		// Extract subparts from the template
		$html_subpart = $this->cObj->getSubpart($this->templateHtml, '###HTMLVOTINGCONFIRMATIONMAIL###');
		$txt_subpart = $this->cObj->getSubpart($this->templateHtml, '###TXTVOTINGCONFIRMATIONMAIL###');

		// Fill marker array
		$markerArray['###FIRSTNAME###'] = $firstname;
		$markerArray['###LASTNAME###'] = $lastname;
		$markerArray['###EMAIL###'] = $mail;
		$markerArray['###ACTIVATIONURL###']  =  $url;

		// Create the content by replacing the content markers in the template
		$html_mailcontent = $this->cObj->substituteMarkerArrayCached($html_subpart, $markerArray);
		$txt_mailcontent = $this->cObj->substituteMarkerArrayCached($txt_subpart, $markerArray);

		if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
			t3lib_div::debug($mailcontent);
		}


		$this->confirmationMail = t3lib_div::makeInstance('t3lib_htmlmail');
		$this->confirmationMail->start();
		$this->confirmationMail->recipient = $mail;
		if($this->conf['mail.']['copy.']['active'] == 1) {
			$this->confirmationMail->recipient_blindcopy = $this->conf['mail.']['copy.']['receiver'];
		}
		$this->confirmationMail->replyto_email = $this->conf['mail.']['reply'];
		$this->confirmationMail->replyto_name = $this->conf['mail.']['replyname'];
		$this->confirmationMail->subject = 'Please confirm your vote';
		$this->confirmationMail->from_email = $this->conf['mail.']['sender'];
		$this->confirmationMail->from_name = $this->conf['mail.']['sendername'];
		$this->confirmationMail->organisation = $this->conf['mail.']['organisation'];
		$this->confirmationMail->returnPath = $this->conf['mail.']['returnpath'];
		$this->confirmationMail->addPlain($txt_mailcontent);
		$this->confirmationMail->setHTML($this->confirmationMail->encodeMsg(/*$aEMailData['html_start'].*/$mailcontent/*.$aEMailData['html_end']*/));
		$this->confirmationMail->send($mail);


		if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
			t3lib_div::debug($this->confirmationMail);
		}

		return('true');

	}


	/**
	 * funktionsvorlage zum kopieren
	 *
	 * @param	string		$content: The PlugIn content
	 * @return	the		voting form
	 */
	function confirmation_handler() {
		//get the vars
		$uid = intval(hexdec(substr($this->getVars['vote'],2)));
		$secret = trim($this->getVars['code']);

		//check if entry exists
		$res = $GLOBALS["TYPO3_DB"]->exec_SELECTgetRows ("uid, hidden, confirm_time",
													   "tx_mzvoting_votes",
													   "uid = $uid AND secret = '$secret'"
													   );
		//ok it is there...
		if($res > 0) {
			if($res['deleted'] == 1) {
				// ...but entry is flaged as deleted
				$error =  $this->report_error("3");
			} elseif($res['hidden'] == 0) {
				// ...but entry allready active
				$error =  $this->report_error("4");
			} elseif($res['confirm_time'] > 0) {
				// ...but entry has been deactivatet after confirmation
				$error =  $this->report_error("5");
			} else {
				// ... and it looks good

				$datatostore['tstamp'] = time();
				$datatostore['hidden'] = '0';

				$datatostore['confirm_ip'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
				$datatostore['confirm_time'] = time() ;
				$datatostore['confirm_referer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
				$datatostore['confirm_browser'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';


				if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
					t3lib_div::debug($datatostore);
				}

				$update = $GLOBALS["TYPO3_DB"]->exec_UPDATEquery("tx_mzvoting_votes","deleted = 0 AND uid = $uid AND secret = '$secret' AND confirm_time = ''", $datatostore);

				if( $this->conf['debug.']['active'] == 1 && $this->conf['debug.']['level'] <= 2) {
					t3lib_div::debug($update);
				}
				if($update) {
					//update was sucessfull


					// Extract subparts from the template
					$subpart = $this->cObj->getSubpart($this->templateHtml, '###ACTIVATIONOK###');// Fill marker array

					//nomarkers yet
					//$markerArray['###MARKER###'] = '';

					//render
					$return = $this->cObj->substituteMarkerArrayCached($subpart, $markerArray);



					return($return);
				} else {
					//ooops the mysql update faild
					$error =  $this->report_error("2");
				}
			}
		} else {
			//ooops, no such entry here
			$error =  $this->report_error("1");
		}

		// Extract subparts from the template
		$subpart = $this->cObj->getSubpart($this->templateHtml, '###ACTIVATIONERROR###');// Fill marker array

		//nomarkers jet
		$markerArray['###ERROR###'] = $error;

		//render
		$return = $this->cObj->substituteMarkerArrayCached($subpart, $markerArray);



		return($return);


	}


	/**
	 * this function is called in case of an error
	 * prepared for later functions
	 *
	 * @param	string		$errorcode: the errorcode
	 * @return	string		the redered error output
	 */
	function report_error($errorcode) {

		$return = $errorcode;

		return($return);

	}


	   /**
 * Init Function: here all the needed configuration values are stored in class variables
 *
 * @param	array		$conf: configuration array from TS
 * @return	void
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
	 * displays the vote button
	 *
	 * @return	string		the html code
	 */
	function show_button() {

		// Extract subparts from the template
		$subpart = $this->cObj->getSubpart($this->templateHtml, '###VOTEBUTTON###');// Fill marker array


		$linkparams['tx_mzvoting']['action']= '1'; //vote


		//nomarkers jet
		$markerArray['###LINK###'] = $this->cObj->getTypoLink_URL($GLOBALS["TSFE"]->id,$linkparams);

		//render
		$return = $this->cObj->substituteMarkerArrayCached($subpart, $markerArray);



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



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mzvoting/pi1/class.tx_mzvoting_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mzvoting/pi1/class.tx_mzvoting_pi1.php']);
}

?>