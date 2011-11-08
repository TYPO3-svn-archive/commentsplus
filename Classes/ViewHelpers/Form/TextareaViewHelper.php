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
 * The same as the standard Fluid Textarea but it won't require rows and cols-Attributes
 */
class Tx_Commentsplus_ViewHelpers_Form_TextareaViewHelper extends Tx_Fluid_ViewHelpers_Form_TextareaViewHelper {

	/**
	 * Initialize the arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->overrideArgument('rows', 'int', 'The number of rows of a text area', FALSE);
		$this->overrideArgument('cols', 'int', 'The number of columns of a text area', FALSE);
	}

}

?>