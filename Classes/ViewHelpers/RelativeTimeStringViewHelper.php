<?php

class Tx_Commentsplus_ViewHelpers_RelativeTimeStringViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

    /**
     * @var Tx_Extbase_Object_ObjectManager
     */
    protected $objectManager;

    /**
     * @param Tx_Extbase_Object_ObjectManager $objectManager
     * @return void
     */
    public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }

    /**
     * @return string
     */
    public function render() {

		/**
		 * @var DateTime $time
		 */
		$time = $this->renderChildren();

		/**
		 * @var Tx_Commentsplus_Utility_TimeDifference $difference
		 */
        $difference = $this->objectManager->create('Tx_Commentsplus_Utility_TimeDifference', time() - $time->getTimestamp());
		
        if($difference->getTotal('seconds') < 60) {
            $content = $difference->getTotal('seconds') . ' second(s) ago';
        } elseif($difference->getTotal('minutes') < 60) {
            $content = $difference->getTotal('minutes') . ' minute(s) ago';
        } elseif($difference->getTotal('hours') < 24) {
            $content = $difference->getTotal('hours') . ' hour(s) ago';
        } else {
			$content = $difference->getTotal('seconds') . ' second(s) ago';
		}
        return $content;
    }

}
