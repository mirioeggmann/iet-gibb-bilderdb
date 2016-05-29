<?php if (count($albums) > 0): ?>
    <div class="row">
        <div class="col s12 m9 l9">
            <?php foreach($albums as $album): ?>
                <div class="col s6 m4 l3">
                    <a href="/album/index/<?php echo $album->id; ?>">
                        <div class="card">
                            <h1 class="card-title"><?php echo $album->name; ?></h1>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col s12 m3 l3">
            <p>Navigation:</p>
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
    <p>There are no albums at the time.</p>
<?php endif; ?>