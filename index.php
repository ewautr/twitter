<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login');
}
?>

<!DOCTYPE html>
<html lang="en" user="<?= $_SESSION['user_id'] ?>">

<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="ie=edge" http-equiv="X-UA-Compatible" />
  <link href="style.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet" />
  <link rel="icon" type="image/png" href="https://abs.twimg.com/favicons/twitter.ico" />
  <title>Home / Twitter::Clone</title>
</head>

<body>
  <div id="page">
    <?php
    require_once('components/left/left.php');
    require_once('components/middle/middle.php');
    require_once('components/right/right.php');
    ?>
  </div>
  <script src="app.js"></script>
</body>

</html>