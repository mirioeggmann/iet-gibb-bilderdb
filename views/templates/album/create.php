<div class="row">
    <form action="../album/doCreate" method="post" autocomplete="off"
          class="col s12 m8 l8">
        <div class="row">
            <div class="input-field col s12">
                <input value="<?php echo $name; ?>" id="name" name="name"
                       type="text" class="validate"> <label for="name">Name</label>
            </div>
        </div>
        <!--
        <div class="row">
            <div class="input-field col s12">
                <input id="isShared" name="isShared" type="checkbox"
                       class="validate"> <label for="isShared">Share Album</label>
            </div>-->
        </div>
        <div class="row">
            <div class="input-field col s12">
                <button class="btn waves-effect blue" type="submit" id="createAlbum"
                        name="createAlbum">Create</button>
            </div>
        </div>
    </form>
</div>
