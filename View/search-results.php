<?php
  include "../Controller/song-search-controller.class.php";
  session_start();
  $songSearchObj = new SongSearchController();
  $entries = $songSearchObj->getFormValues();

  function viewFormValues($entries){
    foreach($entries as $entry){
      echo "<tr>";
        echo "<td>";
          echo "<a href='song-info.php?sond_id=" . $entry['song_id'] . "'/>";
            echo $entry['title'];
          echo "</a>";
        echo "</td>";
        echo "<td>";
          echo $entry['artist_name'];
        echo "</td>";
        echo "<td>";
          echo $entry['year'];
        echo "</td>";
        echo "<td>";
          echo $entry['genre_name'];
        echo "</td>";
        echo "<td class='centered'>";
          echo round(intval($entry['popularity']) * (100/91), 1) . "%";
        echo "</td>";
        echo "<td class='centered favorite'>";
          if (isset($_SESSION['favorites']) && in_array($entry['song_id'], $_SESSION['favorites'])){
            echo "<a href='favorites.php?added=F-song_id=" . $entry['song_id'] . "' class='is-favorite'> <img src='images/checkmark.png' alt='No' width='16.5px' title='Click to remove favorite'/> </a>";
          }
          else{
            echo "<a href='favorites.php?added=T-song_id=" . $entry['song_id'] . "' class='not-favorite'> <img src='images/x.png' alt='No' width='16.5px' title='Click to add as favorite'/> </a>";
          }
        echo "</td>";
      echo "</tr>";
    }
  }
 ?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Results </title>
   <link rel="icon" type="image/x-icon" href="images/favicon.png">
   <link href="css/global-styles.css" rel="stylesheet">
   <link href="css/search-results-styles.css" rel="stylesheet">
</head>
<body>
   <?php include 'header.php'; ?>
   <main class="container">
     <h1> Search Results </h1>
     <h2 class='favorites-info'> To add a song as a favorite, press the x. To remove a favorite, press the checkmark. </h2>
     <!-- This page is going to be presenting a large table containing the desired song data -->
     <table>
       <thead>
         <tr>
           <th> Title </th>
           <th> Artist </th>
           <th> Year </th>
           <th> Genre </th>
           <th class='centered'> Popularity </th>
           <th class='centered'> Favorite </th>
         </tr>
       <thead>
       <tbody>
        <?php viewFormValues($entries) ?>
       </tbody>
     </table>
   </main>
   <?php include 'footer.php'; ?>
</body>
</html>
