<?php

    function ordinal_suffix($number) {
        $possible = array('th','st','nd','rd','th','th','th','th','th','th');

        if ((($number % 100) >= 11) && (($number%100) <= 13))
        {
            return $number . 'th';
        }
        else
        {
            return $number . $possible[$number % 10];
        }
    }