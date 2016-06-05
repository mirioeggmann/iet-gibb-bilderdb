<?php

class Validator {
    
    public function isFieldValid($regex, $value) {
        if (preg_match ( $regex, $value )) {
            return true;
        } else {
            return false;
        }
    }
}