<?php

include_once("header.php");

if (isset($_GET['actor_id']) AND !empty($_GET['actor_id'])) {
    $actorId = $_GET['actor_id'] ?? 0;
}

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

$actor = getActorById($actorId);
$actorEnglish = getActorById($actorId, "en-US");
$films = getFilmsByActorId($actorId, $page);

$synopsis = $actor["biography"] === "" ? $actorEnglish["biography"] . "(Pas de synopsis en fr)" : $actor["biography"];
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <img src="<?= 'https://image.tmdb.org/t/p/w780/' . $actor['profile_path']; ?>" class="img-fluid"
                alt="<?= $actor['name']; ?>">
        </div>
        <div class="col-md-8">
            <h1><?= $actor['name']; ?></h1>
            <p><strong>Date de naissance :</strong> <?= $actor['birthday'] ?? "Inconnue"; ?></p>
            <p><strong>Lieu de naissance :</strong> <?= $actor['place_of_birth'] ?? "Inconnu"; ?></p>
            <p><strong>Résumé :</strong> <?= $synopsis; ?></p>
        </div>
    </div>

    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <h4>Films</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                <?php foreach ($films as $film):
                    if ($film['poster_path']) { ?>

                        <div class="d-flex align-items-stretchl">
                            <div class="card shadow-sm">
                                <img src="<?= $film['poster_path'] ? 'https://image.tmdb.org/t/p/w342/' . $film['poster_path'] : "images/default.png"; ?>"
                                    class="w-auto flex">
                                <div class="card-body lh-sm d-flex flex-column">
                                    <p class=" lh-sm">
                                        <strong><?= $film['title']; ?></strong>
                                        <br>
                                        <small><?= $film['release_date']; ?></small>
                                    </p>
                                    <button type="button" class="btn btn-primary mt-auto"
                                        onclick="location.href='film.php?movie_id=<?= $film['id'] ?>'">View</button>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                <?php endforeach; ?>
            </div>
            <div class="mt-4 d-flex justify-content-between">
                <?php if ($page > 1): ?>
                    <a href="?actor_id=<?= $actorId ?>&page=<?= $page - 1; ?>" class="btn btn-secondary">Précédent</a>
                <?php else: ?>
                    <span></span>
                <?php endif; ?>
                <a href="?actor_id=<?= $actorId ?>&page=<?= $page + 1; ?>" class="btn btn-secondary">Suivant</a>
            </div>
        </div>
    </div>
</div>