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
