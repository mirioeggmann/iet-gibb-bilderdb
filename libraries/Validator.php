<?php

/**
 * Lychez : Image database (https://lychez.luvirx.io)
 * Copyright (c) luvirx (https://luvirx.io)
 *
 * Licensed under The MIT License
 * For the full copyright and license information, please see the LICENSE.md
 * Redistributions of the files must retain the above copyright notice.
 *
 * @link 		https://lychez.luvirx.io Lychez Project
 * @copyright 	Copyright (c) 2016 luvirx (https://luvirx.io)
 * @license		https://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Includes methods to validate different things.
 */
class Validator {

    /**
     * Validate a value with a regex and return if its valid or not.
     *
     * @param $regex The regex expression.
     * @param $value The value which must be checked.
     * @return bool True if it is valid, false if not.
     */
    public function isValid($regex, $value) {
        if (preg_match ( $regex, $value )) {
            return true;
        } else {
            return false;
        }
    }
}