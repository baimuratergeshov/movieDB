# Compte Rendu de TP - Moteur de Recherche MovieDB
**Baimurat ERGESHOV** | SIO 1ère année

---

## Introduction

J'ai dû développer une application web pour rechercher et trier des films et des acteurs en PHP. Le but était d'apprendre à consommer une API REST (TheMovieDB) et à afficher les résultats dynamiquement sur une page web.

Le TP fourni un dossier de base avec :
- Un header avec une barre de navigation
- Une page `popular.php` qui affiche les films populaires
- Un fichier `test.php` qui contenait **toutes les requêtes brutes vers l'API**
- Une première fonction `popularMovies()` pour m'aider à démarrer

Mon travail a été de reprendre les requêtes du fichier test.php et les transformer en fonctions PHP réutilisables, puis créer les pages de recherche et de détails.

---

## Travail réalisé

### Les pages que j'ai créées

- `searchMovies.php` : Affiche les résultats de recherche de films
- `searchActor.php` : Affiche les résultats de recherche d'acteurs
- `film.php` : Page détails d'un film (synopsis, acteurs, bande-annonce)
- `actor.php` : Page détails d'un acteur (biographie, filmographie)
- `genreMovies` : Page qui permet de trier des films par genre
- `topRated` : Page qui trie les films par notation

### Les fonctions dans `fonctions.php`

J'ai créé plusieurs fonctions pour appeler l'API :
- `topRatedMovies()` : Trier des films par notation
- `filmParGenre($genreId)` : Trier des films par genre
- `getNameGenreById($genreId)` : Permet d'afficher le nom du genre avec l'ID
- `getFilmById($movieId, $language = "fr-FR")` : Permet de renvoyer les données d'un film en français ou en anglais si indisponible en français
- `getActorsByMovieId($movieId)` : Permet de renvoyer les acteurs d'un film grâce à l'ID
- `getActorById($actorId, $language = "fr-FR")` : Permet de renvoyer les infos d'un acteurs grâce à l'ID
- `getFilmsByActorId($actorId)` : Permet de renvoyer les films d'un acteur
- `searchFilm($query, $page)` : Chercher un film
- `searchActor($query, $page)` : Chercher un acteur
- `getTrailerByMovieId($movieId)` : Renvoie le trailer d'un film grâce à l'ID

### Comment appeler l'API

C'est simple, on construis une URL avec les bons paramètres, on récupère la réponse JSON, et on la décode en tableau PHP :
Exemple :
```php
function searchFilm($query, $page = 1) {
    global $key;
    $url = "https://api.themoviedb.org/3/search/movie?api_key=$key&query=" 
           . urlencode($query) . "&page=$page";
    
    $response = file_get_contents($url);
    $result = json_decode($response, true);
    
    return $result['results'];
}
```

Après, j'affiche les résultats en boucle `foreach` et j'utilise Bootstrap pour que ça soit responsive.

### Concepts clés appris

#### Les attributs du formulaire (action, method, name)

J'ai utilisé des formulaires dans le `header.php` pour permettre à l'utilisateur de chercher des films et des acteurs. Voici ce que j'ai compris sur les attributs :

**action** : C'est la page PHP qui va recevoir les données du formulaire. Par exemple :
```html
<form action="searchMovies.php" method="GET">
```
Ici, quand je soumets le formulaire, les données vont vers `searchMovies.php`.

**method** : C'est la façon d'envoyer les données. J'utilise GET pour la recherche (expliqué après).

**name** : C'est le nom du champ. Dans mon formulaire de recherche, j'ai :
```html
<input type="text" name="query" placeholder="Chercher un film...">
```
Le `name="query"` signifie que dans `searchMovies.php`, je peux récupérer la valeur avec `$_GET['query']`.

#### Différence entre GET et POST

J'ai choisi d'utiliser **GET** pour mes formulaires de recherche. Voici pourquoi :

**Avec GET :**
- Les données apparaissent dans l'URL : `searchMovies.php?query=avatar`
- L'utilisateur peut mettre la page en favoris ou revenir en arrière sans perdre sa recherche
- C'est visible dans l'URL, donc c'est plus facile à debugger

**Avec POST :**
- Les données sont cachées dans le corps de la requête (l'URL reste propre)
- L'utilisateur ne peut pas voir ce qu'il a cherché dans l'URL
- Pas de limite de taille vraiment (idéal pour envoyer beaucoup de données)
- Pour la recherche, c'est moins pratique parce que l'utilisateur ne peut pas revenir en arrière


### Ce que mon appli peut faire

- Chercher des films et des acteurs
- Voir les détails d'un film ou d'un acteur
- Naviguer entre les pages de résultats (pagination)
- Voir les films en français ou en anglais (fallback de langue)
- Afficher la bande-annonce d'un film si elle existe
- Voir la filmographie d'un acteur

---

## Problèmes rencontrés

**Problème 1 : Le JSON ne s'affichait pas**
J'ai d'abord écrit `$response = $url` au lieu de `$response = file_get_contents($url)`. Du coup j'avais une string et pas les vraies données. `json_decode()` retournait `null` et ça causait des erreurs. J'ai compris qu'il faut vraiment faire la requête HTTP avec `file_get_contents()`.

**Problème 2 : Les images manquaient**
Certains résultats n'avaient pas d'image. J'ai résolu ça en vérifiant si `$actor['profile_path']` existe avant d'afficher la carte.

**Problème 3 : Les données en français**
L'API retourne pas toujours les données en français (surtout les biographies). J'ai créé une logique pour récupérer la version FR et EN, et afficher la FR si elle existe, sinon la EN.

**Problème 4 : Trop de résultats**
Les recherches retournent des centaines de résultats, donc j'ai dû ajouter la pagination avec le paramètre `page` dans les requêtes.

---

## Outils utilisés

- VS Code pour coder
- XAMPP pour avoir un serveur PHP local
- PHP 7+ pour le backend
- HTML5 et Bootstrap 5 pour le frontend
- L'API TheMovieDB pour les données
- Git pour sauvegarder mon travail sur Github

---

## Conclusion

C'était vraiment intéressant de voir comment marche une vraie API et comment on peut récupérer des données de l'internet pour les afficher sur son site. Au début, c'était galère avec le JSON et l'encodage des caractères spéciaux, mais une fois que j'ai compris le pattern (récupérer -> décoder -> afficher), ça a été plus facile.

J'ai appris que développer une appli web c'est pas juste faire du HTML, c'est aussi savoir parler avec d'autres serveurs et traiter les données qu'ils envoient. J'ai bien aimé le concept et maintenant je comprends mieux comment les sites web "normaux" fonctionnent quand on tape quelque chose dans Google ou dans une barre de recherche.

---

