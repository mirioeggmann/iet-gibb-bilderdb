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
        <p>Title: <?php echo $photo->title; ?></p>
        <p>Type: <?php echo $photo->type; ?></p>
        <p>Description: <?php echo $photo->description; ?></p>
        <p>Size: <?php echo round($photo->size/1000,1); ?> kB</p>
        <p>Dimensions: <?php echo $photo->width . "/" . $photo->height ; ?></p>
        <p>Upload Date: <?php echo $photo->date; ?></p>
        <p>Tags:</p>
        <div class="chip">
            Tag1
        </div>
    </div>
</div>