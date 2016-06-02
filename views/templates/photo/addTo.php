<div class="row">
    <form action="../../photo/doAddTo/<?php echo $photo->id; ?>" method="post" autocomplete="off" class="col s12 m12 l8">
        <div class="row">
            <p>Select the wished album</p>
            <div class="input-field col s12">
                <select id="selectAlbum" class="browser-default">
                    <option value="" disabled selected>Choose your option</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <button id="photoAddTo" name="photoAddTo" class="btn waves-effect blue" type="submit">Add
                </button>
            </div>
        </div>
    </form>
</div>