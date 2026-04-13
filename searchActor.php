<?php

include_once("header.php");

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $search = $_GET['query'];
}

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

$actors = searchActor($search, $page);

?>

<div class="album py-5 bg-body-tertiary">
    <div class="container">
        <h4>Recherche d'acteurs : <?= $_GET['query'] ?></h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            <?php
            if (empty($actors)) {
                echo "Aucun acteur trouvé.";
            } else { ?>
                <?php foreach ($actors as $actor):
                    if ($actor['profile_path']) { ?>
                        <div class="d-flex align-items-stretchl">

                            <div class="card shadow-sm ">
                                <img src="<?= 'https://image.tmdb.org/t/p/w780/' . $actor['profile_path']; ?>">
                                <div class="card-body lh-sm d-flex flex-column">
                                    <p class=" lh-sm">
                                        <strong><?= $actor['name']; ?></strong>
                                    </p>
                                    <button type="button" class="btn btn-primary mt-auto"
                                        onclick="location.href='actor.php?actor_id=<?= $actor['id'] ?>'">View</button>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                <?php endforeach; ?>
            <?php } ?>
        </div>
        <?php if (!empty($actors) && count($actors) >= 20) : ?>
            <div class="mt-4 d-flex justify-content-between">
      <?php if ($page > 1): ?>
        <a href="?query=<?= urlencode($search) ?>&page=<?= $page - 1; ?>" class="btn btn-secondary">Précédent</a>
      <?php else: ?>
        <span></span>
      <?php endif; ?>
      <a href="?query=<?= urlencode($search) ?>&page=<?= $page + 1; ?>" class="btn btn-secondary">Suivant</a>
    </div>
    <?php endif; ?>
    </div>
</div>

<?php require("footer.php"); ?>