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
	 * @var Tx_Commentsplus_Utility_NotificationService
	 */
	protected $notificationService;

	/**
	 * @var Tx_Commentsplus_Utility_ReputationSystem
	 */
	protected $reputationSystem;

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
	 * @param Tx_Commentsplus_Utility_NotificationService $notificationService
	 * @return void
	 */
	public function injectNotificationService(Tx_Commentsplus_Utility_NotificationService $notificationService) {
		$this->notificationService = $notificationService;
	}

	/**
	 * @param Tx_Commentsplus_Utility_ReputationSystem $reputationSystem
	 * @return void
	 */
	public function injectReputationSystem(Tx_Commentsplus_Utility_ReputationSystem $reputationSystem) {
		$this->reputationSystem = $reputationSystem;
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
