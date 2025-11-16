<?php

// Normalise le mot : minuscules + trim
function normalizeWord($word) {
    return strtolower(trim($word));
}

// Dictionnaire complet FR → EN
function getDictionary() {
    return [
        "chat" => "cat",
        "chien" => "dog",
        "maison" => "house",
        "voiture" => "car",
        "arbre" => "tree",
        "soleil" => "sun",
        "lune" => "moon",
        "mer" => "sea",
        "montagne" => "mountain",
        "ordinateur" => "computer",
        "telephone" => "phone",
        "table" => "table",
        "chaise" => "chair",
        "porte" => "door",
        "fenetre" => "window",
        "livre" => "book",
        "stylo" => "pen",
        "ville" => "city",
        "pays" => "country",
        "ecole" => "school",
        "ami" => "friend",
        "famille" => "family",
        "professeur" => "teacher",
        "eleve" => "student",
        "travail" => "work",
        "argent" => "money",
        "eau" => "water",
        "feu" => "fire",
        "terre" => "earth",
        "vent" => "wind",
        "rouge" => "red",
        "bleu" => "blue",
        "vert" => "green",
        "noir" => "black",
        "blanc" => "white",
        "beau" => "beautiful",
        "rapide" => "fast",
        "lent" => "slow",
        "fort" => "strong",
        "faible" => "weak",
        "grand" => "tall",
        "petit" => "small",
        "froid" => "cold",
        "chaud" => "hot",
        "manger" => "eat",
        "boire" => "drink",
        "marcher" => "walk",
        "parler" => "talk",
        "dormir" => "sleep"
    ];
}

// Liste des mots connus selon le sens
function getKnownWords($direction) {
    $dict = getDictionary();

    if ($direction === "toEnglish") {
        return array_keys($dict); // mots FR
    }

    if ($direction === "toFrench") {
        return array_values($dict); // mots EN
    }

    return [];
}

// Fonction de traduction
function translate($word, $direction) {
    $dict = getDictionary();
    $word = normalizeWord($word);

    if ($direction === "toEnglish" && isset($dict[$word])) {
        return $dict[$word];
    }

    if ($direction === "toFrench") {
        $reversed = array_flip($dict);
        if (isset($reversed[$word])) {
            return $reversed[$word];
        }
    }

    return "unknown"; // mot non trouvé
}

// ------------------------------------------------------
// Code principal
// ------------------------------------------------------

$result = null;
$error = null;
$word = "";
$direction = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $word = $_POST["word"] ?? "";
    $direction = $_POST["direction"] ?? "";

    if ($word === "") {
        $error = "Veuillez saisir un mot.";
    } elseif ($direction === "") {
        $error = "Veuillez choisir un sens de traduction.";
    } else {
        $result = translate($word, $direction);
    }
}

$dictionary = getDictionary();
$knownWords = getKnownWords($direction);

include "template.phtml";
