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
    <form action="../../photo/doEdit/<?php echo $photo->id; ?>" method="post" autocomplete="off" class="col s12 m12 l8">
        <div class="row">
            <div class="input-field col s12">
                <input value="<?php echo $photo->title; ?>" id="title" name="title" type="text" class="validate">
                <label for="title">Title</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input value="<?php echo $tags; ?>" id="tags" name="tags" type="text" class="validate">
                <label for="tags">Tags</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <textarea id="description" name="description" type="text" class="materialize-textarea validate"><?php echo $photo->description; ?></textarea>
                <label for="description">Description</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <button id="photoEdit" name="photoEdit" class="btn waves-effect blue" type="submit">Save
                </button>
                <a class="btn waves-effect blue" href="../../photo/index/<?php echo $photo->id; ?>" type="button">Cancel
                </a>
            </div>
        </div>
    </form>
</div>