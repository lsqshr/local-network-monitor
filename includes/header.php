<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/jquery.tooltip.css" />
  <script src="scripts/jquery.js" type="text/javascript"></script>
  <script src="scripts/jquery.bgiframe.js" type="text/javascript"></script>
  <script src="scripts/jquery.dimensions.js" type="text/javascript"></script>
  <script src="scripts/jquery.tooltip.min.js" type="text/javascript"></script>
  <script src="scripts/jquery-geturlvar.js" type="text/javascript"></script>
  <script src="scripts/chili-1.7.pack.js" type="text/javascript"></script>
  <script type="text/javascript">
  $(function() {
    $("map *").tooltip({ showURL: false, positionLeft: true });
  });
</script>
  <title><?php echo $title ?></title>  
  <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <div class="container">

    <header class="header clearfix">
      <div class="logo">Local Network Monitor</div>

      <nav class="menu_main">
        <ul>
          <li <?php echo checkPage('index.php'); ?>><a href="index.php">Home</a></li>
          <li <?php echo checkPage('registered.php'); ?>><a href="registered.php">Registered Devices</a></li>
          <li <?php echo checkPage('unregistered.php'); ?>><a href="unregistered.php">Unregistered Devices</a></li>
          <li <?php echo checkPage('map.php'); ?>><a href="map.php">Map</a></li>
		  <li <?php echo checkPage('conflicts.php'); ?>><a href="conflicts.php">Conflicts</a></li>
          <li <?php echo checkPage('logout.php'); ?>><a href="logout.php">Log Out</a></li>
        </ul>
      </nav>
    </header>
