<?php
  include '../Controller/singles-controller.class.php';

  function getSongIdValue(){
    $querystring = $_SERVER['QUERY_STRING']; // retrieves the song_id query string from the href
    $songIdNumber = trim($querystring, "song_id=");
    return $songIdNumber;
  }

  $songController = new SingleSongController(getSongIdValue());
  $songObj = $songController->singleSong();

  // Song info title
  $title = $songObj->getTitle();
  $year = $songObj->getYear();
  $artist = $songObj->getArtist();
  // Song Info Basic
  $genre = $songObj->getGenre();
  $duration = $songObj->getDurationMinutes();
  // Song info analysis
  $bpm = $songController->interpretBpm($songObj->getBpm());
  $energy = $songController->interpretEnergy($songObj->getEnergy());
  $danceability = $songController->interpretDanceability($songObj->getDanceability());
  $liveness = $songController->interpretLiveness($songObj->getLiveness());
  $valence = $songController->interpretValence($songObj->getValence());
  $acousticness = $songController->interpretAcousticness($songObj->getAcousticness());
  $speechiness = $songController->interpretSpeechiness($songObj->getSpeechiness());
  $popularity = $songController->interpretPopularity($songObj->getPopularity());

  function makeSongInfoTop($title, $year, $artist, $genre, $duration){
    echo "<div class='song-info top'>";
      echo "<h1> $title [$year] </h1>";
      echo "<h3 class='artist-name'> Produced by $artist </h3>";
      echo "<p> Genre: $genre </p>";
      echo "<p> Duration: $duration minutes </p>";
    echo "</div>";
  }
  // The min and max values at the end of function represent the minimum and maximum values for the given field in the DB. Helps interpret the values.
  function makeSongAttributeBox($paramName, $paramInterpreted, $value, $lowEnd, $highEnd, $min, $max){
    echo "<div class='analysis-trait $paramName'>";
      echo "<h3> $paramName </h3>";
      echo "<p> $paramInterpreted </p>";
      echo "<br>";
      echo "<p class='progress-info'>" . $lowEnd. "<meter class='meter-bar' value=" . $value . " min='" . $min ."'  max='" . $max ."'> </meter>" . $highEnd . "</p>";

    echo "</div>";
  }

  function makeSongInfoAnalysis($bpm, $energy, $danceability, $liveness, $valence, $acousticness, $speechiness, $popularity, $songObj){
    echo "<div class='song-info analysis'>";
      echo "<h2 class='analysis-header'> Song Analysis </h2>";
      makeSongAttributeBox('Popularity', $popularity, $songObj->getPopularity(), 'Least Popular', 'Most Popular', 55, 91);
      makeSongAttributeBox('BPM', $bpm, $songObj->getBpm(), 'Slowest Tempo', 'Fastest Tempo', 66, 204);
      makeSongAttributeBox('Energy', $energy, $songObj->getEnergy(), 'Least Energy', 'Most Energy', 11, 95);
      makeSongAttributeBox('Valence', $valence, $songObj->getValence(), 'Sad Mood', 'Happy Mood', 4, 95);
      makeSongAttributeBox('Acousticness', $acousticness, $songObj->getAcousticness(), 'Least Acoustic', 'Most Acoustic', 0, 98);
      makeSongAttributeBox('Speechiness', $speechiness, $songObj->getSpeechiness(), 'Least Lyrical', 'Most Lyrical', 2, 53);
      makeSongAttributeBox('Liveness', $liveness, $songObj->getLiveness(), 'Lowest Liveness', 'Most Liveness', 2, 82);
      makeSongAttributeBox('Danceability', $danceability, $songObj->getDanceability(), "Least Danceable", 'Most Danceable', 33, 96);
    echo "</div>";
  }
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> Home Page </title>
   <link rel="icon" type="image/x-icon" href="images/favicon.png">
   <link href="css/single-info-styles.css" rel="stylesheet">
   <link href="css/global-styles.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
   <main class="grid-container">
     <?php
      makeSongInfoTop($title, $year, $artist, $genre, $duration);
      makeSongInfoAnalysis($bpm, $energy, $danceability, $liveness, $valence, $acousticness, $speechiness, $popularity, $songObj);
     ?>
   </main>

   <?php include 'footer.php'; ?>
</body>
</html>
