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
class Tx_Commentsplus_Domain_Repository_CommentRepository extends Tx_Extbase_Persistence_Repository {

    /**
     * Returns all objects of this repository
     *
     * @return array An array of objects, empty if no objects found
     * @api
     */
    public function findAll() {
        $query = $this->createQuery();

        $querySettings = $query->getQuerySettings()->setRespectSysLanguage(FALSE);
        $query->setQuerySettings($querySettings);

        $constraint = $query->logicalAnd(
            $this->getSysLanguageConstraint($query),
            $query->equals('approved', 1)
        );
        return $query->matching($constraint)->execute();
    }

    /**
     * @param $email
     * @return int
     */
    public function countApprovedByEmail($email) {
        $query = $this->createQuery();
        $constraint = $query->logicalAnd(
            $query->equals('email', $email),
            $query->equals('approved', TRUE)
        );
        return $query->matching($constraint)->execute()->count();
    }

    /**
     * @param Tx_Extbase_Persistence_QueryInterface $query
     * @return Tx_Extbase_Persistence_QOM_ComparisonInterface
     */
    private function getSysLanguageConstraint(Tx_Extbase_Persistence_QueryInterface $query) {
        if (intval($GLOBALS['TSFE']->sys_language_uid) > 0) {
            $constraint = $query->equals('sys_language_uid', intval($GLOBALS['TSFE']->sys_language_uid));
        } else {
            $constraint = $query->in('sys_language_uid', array(0, -1));
        }
        return $constraint;
    }

}

?>