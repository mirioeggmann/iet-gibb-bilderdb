<?php if (count($photos) > 0): ?>
    <div class="row">
        <div class="col s12 m9 l9">
            <?php foreach($photos as $photo): ?>
                <div class="col s6 m4 l3">
                    <a href="/photo/index/<?php echo $photo->id; ?>">
                        <div class="card">
                            <div class="card-image">
                                <img src="userHomes/<?php echo $photo->user_id; ?>/thumbnails/<?php echo $photo->name; ?>.<?php echo $photo->type; ?>">
                                <span class="card-title"></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col s12 m3 l3">
            <p>Tags:</p>
        </div>
    </div>
    <div class="row">
        <ul class="pagination">
            <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>

            <li class="waves-effect"><a href="#!">1</a></li>

            <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>
    </div>
<?php else: ?>
    <p>There are no photos at the time.</p>
<?php endif; ?>