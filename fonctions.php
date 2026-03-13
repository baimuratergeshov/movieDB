<?php

require_once("get-proxy.php");// au lycée pour faire des requêtes https vous avons besoin d'indiquer le proxy

$key = "9e43f45f94705cc8e1d5a0400d19a7b7";

//fonction qui retourne dans un tableau asociatif les 20 films les plus populaires 
function popularMovies()
{
    global $key;
    $url = "https://api.themoviedb.org/3/movie/popular?api_key=$key&language=fr-FR";
    $response = getProxy($url);
    //$response = file_get_contents("https://api.themoviedb.org/3/movie/popular?api_key=$key&language=fr-FR");

    $result = json_decode($response, true);
    return $result['results'];
}

function topRatedMovies()
{
    global $key;
    $url = "https://api.themoviedb.org/3/movie/top_rated?api_key=$key&language=fr-FR";
    $response = getProxy($url);
    //$response = file_get_contents("https://api.themoviedb.org/3/movie/top_rated?api_key=$key&language=fr-FR");

    $result = json_decode($response, true);
    return $result['results'];
}

function filmParGenre($genreId)
{
    global $key;
    $url = "https://api.themoviedb.org/3/discover/movie?api_key=$key&language=fr-FR&with_genres=$genreId";
    $response = getProxy($url);
    //$response = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=$key&language=fr-FR&with_genres=$genreId");
    $result = json_decode($response, true);
    return $result['results'];
}

function getNameGenreById($genreId)
{
    global $key;
    $url = "https://api.themoviedb.org/3/genre/movie/list?api_key=$key&language=fr-FR";
    $response = getProxy($url);
    //$response = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=$key&language=fr-FR");
    $result = json_decode($response, true);
    foreach ($result['genres'] as $genre) {
        if ($genre['id'] == $genreId) {
            return $genre['name'];
        }
    }
    return "Inconnu";
}

function getFilmById($movieId, $language = "fr-FR")
{
    global $key;
    $url = "https://api.themoviedb.org/3/movie/$movieId?api_key=$key&language=$language";
    $response = getProxy($url);
    //$response = file_get_contents("https://api.themoviedb.org/3/movie/$movieId?api_key=$key&language=fr-FR");
    $result = json_decode($response, true);
    return $result;
}

function getActorsByMovieId($movieId){
    global $key;
    $url = "https://api.themoviedb.org/3/movie/$movieId/credits?api_key=$key&language=fr-FR";
    $response = getProxy($url);
    //$response = file_get_contents("https://api.themoviedb.org/3/movie/$movieId/credits?api_key=$key&language=fr-FR");
    $result = json_decode($response, true);
    return $result['cast'];
}

function getActorById($actorId, $language = "fr-FR"){
    global $key;
    $url = "https://api.themoviedb.org/3/person/$actorId?api_key=$key&language=$language";
    $response = getProxy($url);
    //$response = file_get_contents("https://api.themoviedb.org/3/person/$actorId?api_key=$key&language=fr-FR");
    $result = json_decode($response, true);
    return $result;
}

function getFilmsByActorId($actorId){
    global $key;
    $url = "https://api.themoviedb.org/3/person/$actorId/movie_credits?api_key=$key&language=fr-FR";
    $response = getProxy($url);
    //$response = file_get_contents("https://api.themoviedb.org/3/person/$actorId/movie_credits?api_key=$key&language=fr-FR");
    $result = json_decode($response, true);
    return $result['cast'];
}


?>