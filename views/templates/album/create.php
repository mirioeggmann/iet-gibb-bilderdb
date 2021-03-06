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
    <form action="../album/doCreate" method="post" autocomplete="off"
          class="col s12 m8 l8">
        <div class="row">
            <div class="input-field col s12">
                <input value="<?php echo $name; ?>" id="name" name="name"
                       type="text" class="validate"> <label for="name">Name</label>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <button class="btn waves-effect blue" type="submit" id="createAlbum"
                        name="createAlbum">Create</button>
            </div>
        </div>
    </form>
</div>
