<?php

require("header.php");

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

if (isset($_GET['id']) AND !empty($_GET['id'])) {
  $id = $_GET['id'];
  $genres = filmParGenre($id, $page);
}


$nameGenre = getNameGenreById($id)

  ?>

<div class="album py-5 bg-body-tertiary">
  <div class="container">
    <h4>Films pour <?= $nameGenre ?></h4>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
      <?php foreach ($genres as $movie): ?>
        <div class="d-flex align-items-stretchl">
          <div class="card shadow-sm ">
            <img src="<?= 'https://image.tmdb.org/t/p/w780/' . $movie['poster_path']; ?>">
            <div class="card-body lh-sm d-flex flex-column">
              <p class=" lh-sm">
                <strong><?= $movie['title']; ?></strong>
              </p>
              <button type="button" class="btn btn-primary mt-auto"
                onclick="location.href='film.php?movie_id=<?= $movie['id'] ?>'">View</button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="mt-4 d-flex justify-content-between">
      <?php if ($page > 1): ?>
        <a href="?id=<?= $id ?>&page=<?= $page - 1; ?>" class="btn btn-secondary">Précédent</a>
      <?php else: ?>
        <span></span>
      <?php endif; ?>
      <a href="?id=<?= $id ?>&page=<?= $page + 1; ?>" class="btn btn-secondary">Suivant</a>
    </div>
  </div>
</div>

<?php require("footer.php"); ?>