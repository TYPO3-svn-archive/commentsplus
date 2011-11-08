<?php

class Tx_Commentsplus_ViewHelpers_DefineViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

    /**
     *
     * @param string $variable
     * @param string $value
     * @return string Rendered string
     */
	public function render($variable, $value) {
		$this->templateVariableContainer->add($variable, $value);
		$output = $this->renderChildren();
		$this->templateVariableContainer->remove($variable);
		return $output;
	}
}
