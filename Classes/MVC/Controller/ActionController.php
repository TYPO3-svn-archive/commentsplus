<?php

 
class Tx_Commentsplus_MVC_Controller_ActionController extends Tx_Extbase_MVC_Controller_ActionController{

    /**
	 * @var Tx_Commentsplus_Domain_Repository_CommentRepository
	 */
	protected $commentRepository;

    /**
     * @var Tx_Commentsplus_MVC_Controller_ErrorContainer
     */
    protected $errorContainer;

	/**
	 * @var Tx_Extbase_Service_TypoScriptService
	 */
	protected $typoScriptService;

	/**
	 * injectCommentRepository
	 *
	 * @param Tx_Commentsplus_Domain_Repository_CommentRepository $commentRepository
	 * @return void
	 */
	public function injectCommentRepository(Tx_Commentsplus_Domain_Repository_CommentRepository $commentRepository) {
		$this->commentRepository = $commentRepository;
	}

    /**
     * @param Tx_Commentsplus_MVC_Controller_ErrorContainer $errorContainer
     * @return void
     */
    public function injectErrorContainer(Tx_Commentsplus_MVC_Controller_ErrorContainer $errorContainer) {
        $this->errorContainer = $errorContainer;
    }

	/**
	 * @param Tx_Extbase_Service_TypoScriptService $typoScriptService
	 * @return void
	 */
	public function injectTypoScriptService(Tx_Extbase_Service_TypoScriptService $typoScriptService) {
		$this->typoScriptService = $typoScriptService;
	}

    /**
     * @param Tx_Commentsplus_Domain_Model_Comment $newComment
     * @return bool
     */
    protected function approveCommentImmediatelly(Tx_Commentsplus_Domain_Model_Comment $newComment) {
        if($this->settings['spam']['moderateComments']) {
            if(intval($this->settings['spam']['autoApproveAfterGenuineComments']) > 0) {
                $approvedComments = $this->commentRepository->countApprovedByEmail($newComment->getEmail());
                if($approvedComments >= intval($this->settings['spam']['autoApproveAfterGenuineComments'])) {
                    $approve = TRUE;
                } else {
                    $approve = FALSE;
                }
            } else {
                $approve = FALSE;
            }
        } else {
            $approve = TRUE;
        }
        if($approve == FALSE) {
			$this->notifyCommentToApprove($newComment);
            $this->addFlashMessage('moderation', t3lib_FlashMessage::INFO);
        }
        return $approve;
    }

	/**
	 * @param Tx_Commentsplus_Domain_Model_Comment $newComment
	 * @return void
	 */
	protected function notifyCommentToApprove(Tx_Commentsplus_Domain_Model_Comment $newComment) {
		$configuration = $this->typoScriptService->convertPlainArrayToTypoScriptArray($this->settings['notification']['newCommentToApprove']);

		/**
		 * @var tslib_cObj $localCObj
		 */
		$localCObj = $this->objectManager->get('tslib_cObj');
		$localCObj->start(array(
							  'timestamp' => $newComment->getTime()->getTimestamp(),
							  'name' => $newComment->getName(),
							  'email' => $newComment->getEmail(),
							  'website' => $newComment->getWebsite(),
							  'message' => $newComment->getMessage(),
							  'ip' => $newComment->getIp()
						  ));
		$enable = $localCObj->stdWrap($configuration['enable'], $configuration['enable.']);
		if($enable) {
			$to = $localCObj->stdWrap($configuration['email'], $configuration['email.']);
			$subject = $localCObj->stdWrap($configuration['subject'], $configuration['subject.']);
			$message = $localCObj->stdWrap($configuration['message'], $configuration['message.']);
			$fromEmail = $localCObj->stdWrap($configuration['fromEmail'], $configuration['fromEmail.']);
			$fromName = $localCObj->stdWrap($configuration['fromName'], $configuration['fromName.']);
			$header = 'From: ' . $fromName . ' <' . $fromEmail . '>';
			t3lib_utility_Mail::mail($to, $subject, $message, $header);
		}
	}

	/**
	 * A special action which is called if the originally intended action could
	 * not be called, for example if the arguments were not valid.
	 *
	 * @return void
	 */
	protected function errorAction() {
		$this->request->setErrors($this->argumentsMappingResults->getErrors());
		$this->clearCacheOnError();
        $this->addNestedMessageFromErrorObjectToErrorContainer($this->argumentsMappingResults);

		$referrer = $this->request->getArgument('__referrer');
		$this->forward($referrer['actionName'], $referrer['controllerName'], $referrer['extensionName'], $this->request->getArguments());
	}

    /**
     * @param Object $error
     * @return string
     */
    protected function addNestedMessageFromErrorObjectToErrorContainer($error) {
        $subErrors = array();
        if(method_exists($error, 'getErrors')) {
            $subErrors = $error->getErrors();
        }
        if(count($subErrors)) {
            foreach($subErrors as $subError) {
                $this->addNestedMessageFromErrorObjectToErrorContainer($subError);
            }
        } else {
            $this->errorContainer->addError($error);
        }
    }

    /**
	 * Taken from EXT:blog_example
     *
     * helper function to render localized flashmessages
	 *
	 * @param string $action
	 * @param integer $severity optional severity code. One of the t3lib_FlashMessage constants
	 * @return void
	 */
	protected function addFlashMessage($action, $severity = t3lib_FlashMessage::OK) {
		$messageLocallangKey = sprintf('flashmessage_%s_%s', $this->request->getControllerName(), $action);
		$localizedMessage = Tx_Commentsplus_Utility_Localization::translate($messageLocallangKey, '[' . $messageLocallangKey . ']');
		$titleLocallangKey = sprintf('%s.title', $messageLocallangKey);
		$localizedTitle = Tx_Commentsplus_Utility_Localization::translate($titleLocallangKey, '[' . $titleLocallangKey . ']');
		$this->flashMessageContainer->add($localizedMessage, $localizedTitle, $severity);
	}

}
