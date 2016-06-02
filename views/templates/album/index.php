<?php if (count($tags) > 0): ?>
    <ul id="dropdown2" class="dropdown-content">
        <?php foreach ($tags as $tag): ?>
            <li>
                <a href="/album/index/<?php echo $album->id ?><?php echo '?page=' . $selectedPage . '&tags=' . $tagIds . '-' . $tag->id; ?>"><?php echo $tag->name; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if (count($photos) > 0): ?>
<div class="row">
    <div class="col s12 m9 l9">
        <?php foreach ($photos as $photo): ?>
            <div class="col s6 m4 l3">
                <a href="/photo/index/<?php echo $photo->id; ?>">
                    <div class="card">
                        <div class="card-image">
                            <img
                                src="../../userHomes/<?php echo $photo->user_id; ?>/thumbnails/<?php echo $photo->name; ?>.<?php echo $photo->type; ?>">
                            <span class="card-title"></span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div class="row">
        <div class="col s12 m9 l9">
            <p>There are no photos at the time.</p>
        </div>
        <?php endif; ?>

        <div class="col s12 m3 l3">
            <p>Tags:
                <a class="btn dropdown-button" href="#!" data-activates="dropdown2">Select<i
                        class="mdi-navigation-arrow-drop-down right"></i></a></p>
            <?php if (count($selectedTags) > 0): ?>
                <?php foreach ($selectedTags as $selectedTag): ?>
                    <a href="/album/index/<?php echo $album->id ?>?tags=<?php echo str_replace($selectedTag->id, '', $tagIds); ?>">
                        <div class="chip">
                            <?php echo $selectedTag->name; ?>
                            <i class="material-icons">close</i>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <ul class="pagination">
            <li class=<?php echo($selectedPage == 1 ? "disabled" : "waves-effect"); ?>><a
                    href="/album/index/<?php echo $album->id ?>?page=<?php echo ($selectedPage - 1) . "&tags=" . $tagIds; ?>"><i
                        class="material-icons">chevron_left</i></a></li>
            <?php for ($i = 0; $i < $amountOfPages; $i++): ?>
                <li class="waves-effect"><a
                        href="/album/index/<?php echo $album->id ?>?page=<?php echo ($i + 1) . "&tags=" . $tagIds; ?>"><?php echo $i + 1; ?></a>
                </li>
            <?php endfor; ?>
            <li class=<?php echo(($amountOfPages) == $selectedPage ? "disabled" : "waves-effect"); ?>><a
                    href="/album/index/<?php echo $album->id ?>?page=<?php echo ($selectedPage + 1) . "&tags=" . $tagIds; ?>"><i
                        class="material-icons">chevron_right</i></a></li>
        </ul>
    </div>
