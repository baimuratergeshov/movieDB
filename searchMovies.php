<?php

include_once("header.php");

if (isset($_GET['query']) AND !empty($_GET['query'])) {
    $search = $_GET['query'];
}

$films = searchFilm($search);

?>

<div class="album py-5 bg-body-tertiary">
    <div class="container">
        <h4>Recherche de films : <?= $_GET['query'] ?></h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            <?php foreach ($films as $film): 
                if ($film['poster_path']) { ?>
                <div class="d-flex align-items-stretchl">
                    <div class="card shadow-sm ">
                        <img src="<?= 'https://image.tmdb.org/t/p/w780/' . $film['poster_path']; ?>">
                        <div class="card-body lh-sm d-flex flex-column">
                            <p class=" lh-sm">
                                <strong><?= $film['title']; ?></strong>
                            </p>
                            <button type="button" class="btn btn-primary mt-auto"
                                onclick="location.href='film.php?movie_id=<?= $film['id'] ?>'">View</button>
                        </div>
                    </div>
                </div>
                <?php } ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require("footer.php"); ?>