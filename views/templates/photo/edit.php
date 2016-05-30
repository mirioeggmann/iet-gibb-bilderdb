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
                <input id="tags" name="tags" type="text" class="validate"><?php echo $tags; ?></input>
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
            </div>
        </div>
    </form>
</div>