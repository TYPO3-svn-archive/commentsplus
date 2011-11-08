<?php
 
class Tx_Commentsplus_Utility_ReputationSystem {

	/**
	 * @var Tx_Commentsplus_Domain_Repository_CommentRepository
	 */
	protected $commentRepository;

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
	 * @var array $settings
	 */
	protected $settings;

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
	 * @return int
	 */
	public function determineApprovedStatus(Tx_Commentsplus_Domain_Model_Comment $newComment) {
		if($this->isSpam($newComment)) {
			return Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_SPAM;
		} elseif($this->approveCommentImmediatelly($newComment)) {
			return Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_APPROVED;
		} else {
			return Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_NOTAPPROVED;
		}
	}

	/**
	 * @param Tx_Commentsplus_Domain_Model_Comment $newComment
	 * @return bool
	 */
	protected function isSpam(Tx_Commentsplus_Domain_Model_Comment $newComment) {
		$postVars = t3lib_div::_POST('tx_commentsplus_comments');
        if(!empty($postVars['commentsplus_honeypot'])) {
            return TRUE;
        } else {
            return FALSE;
        }
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
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }


}
