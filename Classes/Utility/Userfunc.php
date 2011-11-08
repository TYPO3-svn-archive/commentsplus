<?php

class Tx_Commentsplus_Utility_Userfunc {

	public function reputationField($PA, $fObj) {
		$comment = $PA['row'];
		$TS = Tx_Commentsplus_Utility_BackendTyposcript::getTyposcriptSetup($comment['pid']);
		$pluginTS = $TS['plugin.']['tx_commentsplus.'];
		$moderateComments = $pluginTS['settings.']['spam.']['moderateComments'];
		$autoApproveAfterGenuineComments = $pluginTS['settings.']['spam.']['autoApproveAfterGenuineComments'];
		$userNotApprovedComments = $this->countCommentsOfUser($comment['email'], Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_NOTAPPROVED);
		$userApprovedComments = $this->countCommentsOfUser($comment['email'], Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_APPROVED);
		$userSpamComments = $this->countCommentsOfUser($comment['email'], Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_SPAM);
		$content = 'This user has made ';
		$output = array();
		if($userNotApprovedComments > 0) {
			$output[] = '<b>' . $userNotApprovedComments . ' not yet approved</b>';
		}
		if($userApprovedComments > 0) {
			$output[] = '<b>' . $userApprovedComments . ' approved</b>';
		}
		if($userSpamComments > 0) {
			$output[] = '<b>' . $userSpamComments . ' spam</b>';
		}
		if(count($output) == 0) {
			$content .= 'no ';
		} elseif(count($output) == 1) {
			$content .= $output[0] . ' ';
		} elseif(count($output) == 2) {
			$content .= $output[0] . ' and ' . $output[1] . ' ';
		} elseif(count($output) == 3) {
			$content .= $output[0] . ', ' . $output[1] . ' and ' . $output[2] . ' ';
		}
		$content .= 'comments so far.';
		if($moderateComments && $autoApproveAfterGenuineComments) {
			if($userApprovedComments >= $autoApproveAfterGenuineComments) {
				$content .= '<br>New comments of this user will be approved automatically, because he/she has ' .
							$autoApproveAfterGenuineComments . ' or more approved comments.';
			} else {
				$content .= '<br>The user needs ' . ($autoApproveAfterGenuineComments - $userApprovedComments) .
							' more approved comments to that his/her comments get approved automatically.';
			}
		}
		return '<p>' . $content . '</p>';
	}

	protected function countCommentsOfUser($email, $approvalStatus) {
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tx_commentsplus_domain_model_comment', 'email = "' . $email . '" AND approved = "' . $approvalStatus . '" AND deleted = 0');
		return $GLOBALS['TYPO3_DB']->sql_num_rows($res);
	}

}

?>