<?php

namespace App\View\Helper;

use Cake\View\Helper;

class BoolHelper extends Helper
{

    public function yesNo($value, $showNo = true) {
        return ($value) ? "Yes" : (($showNo) ? "No" : "");
    }

    public function trueFalse($value, $showFalse = true) {
        return ($value) ? "True" : (($showFalse) ? "False" : "");
    }

}

?>