<div class="row">
    <form action="../../album/doEdit/<?php echo $album->id; ?>" method="post" autocomplete="off"
          class="col s12 m8 l8">
        <div class="row">
            <div class="input-field col s12">
                <input value="<?php echo $album->name; ?>" id="name" name="name"
                       type="text" class="validate"> <label for="name">Name</label>
            </div>
        </div>
</div>
<div class="row">
    <div class="input-field col s12">
        <button class="btn waves-effect blue" type="submit" id="editAlbum"
                name="editAlbum">Edit
        </button>
    </div>
</div>
</form>
</div>
