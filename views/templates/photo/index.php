<div class="row">
    <div class="col s12 m8 l8">
        <div class="card">
            <a href="../../userHomes/<?php echo $photo->user_id; ?>/photos/<?php echo $photo->name; ?>.<?php echo $photo->type; ?>">
                <div class="card-image">
                    <img src="../../userHomes/<?php echo $photo->user_id; ?>/photos/<?php echo $photo->name; ?>.<?php echo $photo->type; ?>" alt="Pic">
                </div>
            </a>
        </div>
    </div>
    <div class="col s12 m4 l4">
        <a href="../../photo/edit/<?php echo $photo->id; ?>" title="Edit photo"><i class="material-icons">edit</i></a>
        <a href="../../photo/doDelete/<?php echo $photo->id; ?>" title="Delete photo"><i class="material-icons">delete</i></a>
        <a href="../../photo/addTo/<?php echo $photo->id; ?>" title="Add photo to album"><i class="material-icons">add_to_photos</i></a>
        <p>Title: <?php echo $photo->title; ?></p>
        <p>Type: <?php echo $photo->type; ?></p>
        <p>Description: <?php echo $photo->description; ?></p>
        <p>Size: <?php echo round($photo->size/1000,1); ?> kB</p>
        <p>Dimensions: <?php echo $photo->width . "/" . $photo->height ; ?></p>
        <p>Upload Date: <?php echo $photo->date; ?></p>
        <p>Tags:</p>
        <?php foreach($tags as $tag): ?>
            <div class="chip">
                <?php echo $tag->name; ?>
            </div>
        <?php endforeach;?>
    </div>
</div>