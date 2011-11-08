<?php

class Tx_Commentsplus_Utility_NotificationService {

	/**
	 * @var array $settings
	 */
	protected $settings;

	/**
	 * @var tslib_cObj $contentObject
	 */
	protected $contentObject;

	/**
	 * @param tslib_cObj $contentObject
	 * @return void
	 */
	public function injectContentObject(tslib_cObj $contentObject) {
		$this->contentObject = $contentObject;
	}

	/**
	 * @var Tx_Extbase_Service_TypoScriptService
	 */
	protected $typoScriptService;

	/**
	 * @param Tx_Extbase_Service_TypoScriptService $typoScriptService
	 * @return void
	 */
	public function injectTypoScriptService(Tx_Extbase_Service_TypoScriptService $typoScriptService) {
		$this->typoScriptService = $typoScriptService;
	}

	/**
	 * @param array $settings
	 * @return Tx_Commentsplus_Utility_ReputationSystem
	 */
	public function setSettings($settings) {
		$this->settings = $settings;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getSettings() {
		return $this->settings;
	}

	/**
	 * @param Tx_Commentsplus_Domain_Model_Comment $newComment
	 * @return void
	 */
	public function notify(Tx_Commentsplus_Domain_Model_Comment $newComment) {
		$configuration = $this->typoScriptService->convertPlainArrayToTypoScriptArray($this->settings['notification']);

		$this->contentObject->start(array(
			'timestamp' => $newComment->getTime()->getTimestamp(),
			'name' => $newComment->getName(),
			'email' => $newComment->getEmail(),
			'website' => $newComment->getWebsite(),
			'message' => $newComment->getMessage(),
			'ip' => $newComment->getIp()
		));

		switch($newComment->getApproved()) {
			case Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_APPROVED:
				$this->sendNotification($configuration['newCommentApproved']);
				break;
			case Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_NOTAPPROVED:
				$this->sendNotification($configuration['newCommentToApprove']);
				break;
			case Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_SPAM:
				$this->sendNotification($configuration['newSpamComment']);
				break;
		}

	}

	/**
	 * @param array $configuration
	 * @return void
	 */
	protected function sendNotification($configuration) {
		if($this->contentObject->stdWrap($configuration['enable'], $configuration['enable.'])) {
			$to = $this->contentObject->stdWrap($configuration['email'], $configuration['email.']);
			$subject = $this->contentObject->stdWrap($configuration['subject'], $configuration['subject.']);
			$message = $this->contentObject->stdWrap($configuration['message'], $configuration['message.']);
			$fromEmail = $this->contentObject->stdWrap($configuration['fromEmail'], $configuration['fromEmail.']);
			$fromName = $this->contentObject->stdWrap($configuration['fromName'], $configuration['fromName.']);
			$header = 'From: ' . $fromName . ' <' . $fromEmail . '>';
			t3lib_utility_Mail::mail($to, $subject, $message, $header);
		}
	}

}
