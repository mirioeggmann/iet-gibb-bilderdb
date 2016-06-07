<div class="row">
    <form action="../../photo/doAddTo/<?php echo $photo->id; ?>" method="post" autocomplete="off"
          class="col s12 m12 l8">
        <div class="row">
            <?php if (count($albums) > 0): ?>
            <h5>Select the wished album</h5>
            <div class="input-field col s12">
                <select id="selectAlbum" name="selectAlbum" class="browser-default">
                    <option value="" disabled selected>Choose your option</option>
                    <?php foreach ($albums as $album): ?>
                        <option value="<?php echo $album->id; ?>"><?php echo $album->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h5>Member of the following albums:</h5>
            <?php foreach ($settedAlbums as $settedAlbum): ?>
                <p><a href="/album/index/<?php echo $settedAlbum->id; ?>"><?php echo $settedAlbum->name; ?></a></p>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <button id="photoAddTo" name="photoAddTo" class="btn waves-effect blue" type="submit">Add
                </button>
            </div>
        </div>
        <?php else: ?>
            <p>No albums at the time.</p>
        <?php endif; ?>
    </form>
</div>