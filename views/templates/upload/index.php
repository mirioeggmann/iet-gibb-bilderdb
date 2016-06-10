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

<p>Choose one or multiple photos:</p>
<form action="upload/doUpload" method="post" autocomplete="off" class="col s12 m12 l8" enctype="multipart/form-data">
	<div class="file-field input-field">
		<div class="btn">
			<span>File</span> <input name="files[]" id="files" type="file" multiple>
		</div>
		<div class="file-path-wrapper">
			<input class="file-path validate" type="text"
				placeholder="Upload one or more files">
		</div>
	</div>
	<div class="row">
      <div class="input-field col s12">
        <button class="btn waves-effect blue" type="submit" id="upload" name="upload">Upload
        </button>
      </div>
    </div>
</form>
