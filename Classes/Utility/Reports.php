<?php
 
class Tx_Commentsplus_Utility_Reports implements tx_reports_StatusProvider {

	/**
	 * @return array
	 */
	public function getStatus() {
		$reports = array(
			'commentsToApprove' => $this->checkCommentsToBeApproved()
		);
		return $reports;
	}

	/**
	 * @return tx_reports_reports_status_Status
	 */
	protected function checkCommentsToBeApproved() {
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tx_commentsplus_domain_model_comment', 'approved = 0 AND deleted = 0', '', 'pid');
		$numberOfComments = $GLOBALS['TYPO3_DB']->sql_num_rows($res);
		if($numberOfComments > 0) {
			return t3lib_div::makeInstance('tx_reports_reports_status_Status',
				'Comments to approve',
				$numberOfComments . ' comments',
				'',
				tx_reports_reports_status_Status::WARNING
			);
		} else {
			return t3lib_div::makeInstance('tx_reports_reports_status_Status',
				'No Comments to approve',
				'',
				'',
				tx_reports_reports_status_Status::OK
			);
		}
	}

}
