<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../php/session.php');
  $session = new Session();


  require_once(__DIR__ . '/../db/connection.db.php');
  $db = getDBConn();

  require_once(__DIR__ . '/../db/class.album.php');
  $albums = Album::getAlbums($db);

  require_once(__DIR__ . '/../html/html.main.php');
  require_once(__DIR__ . '/../html/html.albums.php');
  require_once(__DIR__ . '/../html/html.user.php');
  if ($session->isLoggedIn()) {
    drawHeaderProfile($session);
    drawProfile($session);
    drawFooter();
  } else {
    header('Location: login.php');
  }
?>

  