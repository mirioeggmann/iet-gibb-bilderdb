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
?>

<div class="row">
    <form action="../../user/doDelete" method="post" autocomplete="off" class="col s12 m12 l8">
        <div class="row">
            <p>Do you really want to delete the user?</p>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <button id="userDelete" name="userDelete" class="btn waves-effect blue" type="submit">Delete
                </button>
                <a class="btn waves-effect blue" href="../../user/index" type="button">Cancel
                </a>
            </div>
        </div>
    </form>
</div>