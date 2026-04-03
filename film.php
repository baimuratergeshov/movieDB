<?php

include_once("header.php");

if (isset($_GET['movie_id']) AND !empty($_GET['movie_id'])) {
    $movieId = $_GET['movie_id'] ?? 0;
}

$film = getFilmById($movieId, "fr-FR");

$filmEnglish = getFilmById($movieId, "en-US");

$actors = getActorsByMovieId($movieId);

$synopsis = $film["overview"] === "" ? $filmEnglish["overview"] . "(Pas de synopsis en fr)" : $film["overview"];

$trailer = getTrailerByMovieId($movieId) ?? null;

?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <img src="<?= 'https://image.tmdb.org/t/p/w780/' . $film['poster_path']; ?>" class="img-fluid"
                alt="<?= $film['title']; ?>">
        </div>
        <div class="col-md-8">
            <h1><?= $film['title']; ?></h1>
            <p><strong>Date de sortie :</strong> <?= $film['release_date']; ?></p>
            <p><strong>Note moyenne :</strong> <?= $film['vote_average']; ?>/10</p>
            <p><strong>Résumé :</strong> <?= $synopsis; ?></p>

            <?php if ($trailer) { ?>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $trailer[0]['key'] ?>"
                        title="<?= $trailer[0]['name'] ?>" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <?php } ?>
        </div>
    </div>

    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <h4>Acteurs</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                <?php foreach ($actors as $actor):
                    if ($actor['profile_path']) { ?>

                        <div class="d-flex align-items-stretchl">
                            <div class="card shadow-sm">
                                <img src="<?= $actor['profile_path'] ? 'https://image.tmdb.org/t/p/w342/' . $actor['profile_path'] : "images/default.png"; ?>"
                                    class="w-auto flex">
                                <div class="card-body lh-sm d-flex flex-column">
                                    <p class=" lh-sm">
                                        <strong><?= $actor['character']; ?></strong>
                                        <br>
                                        <small><?= $actor['name']; ?> - <?= $actor['known_for_department']; ?></small>
                                    </p>
                                    <button type="button" class="btn btn-primary mt-auto"
                                        onclick="location.href='actor.php?actor_id=<?= $actor['id'] ?>'">View</button>

                                </div>
                            </div>
                        </div>

                    <?php } ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require("footer.php"); ?>