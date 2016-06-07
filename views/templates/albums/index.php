<?php if (count($albums) > 0): ?>
    <div class="row">
        <div class="col s12 m9 l9">
            <?php foreach($albums as $album): ?>
                <div class="col s6 m4 l3">
                    <a href="/album/index/<?php echo $album->id; ?>">
                        <div class="card">
                            <h1 class="card-title center-align"><?php echo substr($album->name, 0 , 10); ?></h1>
                            <div class="card-image center-align">
                                <i class="large material-icons">collections</i>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col s12 m3 l3">
            <a href="../../album/create" title="Create album">Create album<i class="material-icons left">add</i></a>
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