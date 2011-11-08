<?php
class Tx_Commentsplus_Utility_TimeDifference {
    
    protected $totalDifference = array();

    protected $nestedDifference = array();

    public function __construct($seconds) {
        $this->totalDifference['seconds'] = $seconds;
    }

    public function getTotal($key) {
        if(!isset($this->totalDifference[$key])) {
            switch($key) {
                case 'minutes':
                   $this->totalDifference[$key] = floor($this->totalDifference['seconds'] / 60);
                   break;
                case 'hours':
                   $this->totalDifference[$key] = floor($this->totalDifference['seconds'] / (60*60));
                   break;
            }
        }
        return $this->totalDifference[$key];
    }

}
