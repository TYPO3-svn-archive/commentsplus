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
 * A Comment
 *
 * @package commentsplus
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_Commentsplus_Domain_Model_Comment extends Tx_Extbase_DomainObject_AbstractEntity {

    const APPROVAL_STATUS_NOTAPPROVED = 0;
	const APPROVAL_STATUS_APPROVED = 1;
	const APPROVAL_STATUS_SPAM = -1;

	/**
	 * @var Tx_Commentsplus_Domain_Repository_CommentRepository
	 */
	protected $commentRepository;

	/**
	 * @param Tx_Commentsplus_Domain_Repository_CommentRepository $commentRepository
	 * @return void
	 */
	public function injectCommentRepository(Tx_Commentsplus_Domain_Repository_CommentRepository $commentRepository) {
		$this->commentRepository = $commentRepository;
	}

	/**
	 * @var integer
	 */
	protected $numberOfGenuineComments;

	/**
     * @var DateTime
     */
    protected $time;

    /**
     * @var string
     * @validate Tx_Commentsplus_Domain_Validator_NameNotEmptyValidator
     */
    protected $name;

    /**
     * @var string E-Mail of the Author
     * @validate EmailAddress
     */
    protected $email;

    /**
     * @var string Website of the Author
     * @validate Tx_Commentsplus_Domain_Validator_UrlValidator
     */
    protected $website;

    /**
     * @var string
     * @validate Tx_Commentsplus_Domain_Validator_MessageNotEmptyValidator
     */
    protected $message;

    /**
     * @var string
     */
    protected $ip;

    /**
     * @var bool
     */
    protected $approved;

    /**
     * @param string $email
     * @return Tx_Commentsplus_Domain_Model_Comment
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $message
     * @return Tx_Commentsplus_Domain_Model_Comment
     */
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage() {
        return htmlspecialchars($this->message);
    }

    /**
     * @param string $name
     * @return Tx_Commentsplus_Domain_Model_Comment
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() {
        return htmlspecialchars($this->name);
    }

    /**
     * @param DateTime $time
     * @return Tx_Commentsplus_Domain_Model_Comment
     */
    public function setTime($time) {
        $this->time = $time;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * @param string $website
     * @return Tx_Commentsplus_Domain_Model_Comment
     */
    public function setWebsite($website) {
        $this->website = $website;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite() {
        return $this->website;
    }

	/**
	 * @return string
	 */
	public function getNumberOfGenuineComments() {
		if(!$this->numberOfGenuineComments) {
			$this->numberOfGenuineComments = $this->commentRepository->countApprovedByEmail($this->email);
		}
		return $this->numberOfGenuineComments;
	}

    /**
     * @param string $ip
     * @return Tx_Commentsplus_Domain_Model_Comment
     */
    public function setIp($ip) {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp() {
        return $this->ip;
    }

    /**
     * @param boolean $approved
     * @return Tx_Commentsplus_Domain_Model_Comment
     */
    public function setApproved($approved) {
        $this->approved = $approved;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getApproved() {
        return $this->approved;
    }

	/**
	 * No idea, but this is needed
	 */
	public function __construct(){
	}

}

?>