<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Sebastian Michaelsen <michaelsen@t3seo.de>, t3seo.de
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 *
 *
 * @package commentsplus
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_Commentsplus_Controller_CommentController extends Tx_Commentsplus_MVC_Controller_ActionController {

    /**
     * action list
     *
     * @param Tx_Commentsplus_Domain_Model_Comment $newComment
     * @return void
     * @dontvalidate $newComment
     */
    public function listAction(Tx_Commentsplus_Domain_Model_Comment $newComment = NULL) {
        $comments = $this->commentRepository->findAll();
        $this->view->assign('comments', $comments);
        $this->view->assign('newComment', $newComment);
        $this->view->assign('errors', $this->errorContainer->getErrors());
    }

    /**
     * action create
     *
     * @param Tx_Commentsplus_Domain_Model_Comment $newComment
     * @return void
     */
    public function createAction(Tx_Commentsplus_Domain_Model_Comment $newComment) {
        $newComment
                ->setTime(new DateTime())
                ->setApproved($this->approveCommentImmediatelly($newComment))
                ->_setProperty('_languageUid', intval($GLOBALS['TSFE']->sys_language_uid));
		if($this->settings['saveIP']) {
			$newComment->setIp($_SERVER['REMOTE_ADDR']);
		}
        $this->commentRepository->add($newComment);
        $this->redirect('list');
    }


}

?>