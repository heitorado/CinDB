<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>[@title]</title>
      <link rel="stylesheet" href="[@path]/public/css/bootstrap.min.css">
      <link rel="stylesheet" href="[@path]/public/css/mgmtpgs_style.css">
      <link rel="stylesheet" href="[@path]/public/css/ie10-viewport-bug-workaround.css">
      <link rel="stylesheet" href="[@path]/public/css/style.css">
</head>
<body>
      <nav id="adminNav" class="navbar navbar-inverse visible-xs">
            <div class="container-fluid">
                  <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">CinDb</a>
                  </div>
                  <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                              [@menu]
                        </ul>
                  </div>
            </div>
      </nav>

      <div class="container-fluid">
            <div class="wrapper row">
                  <!-- Inicio nav -->
                  <nav id="adminSidebar" class="sidebar col-sm-12 col-md-2">
                        <!-- Nav Header -->
                        <div class="sidebar-header">
                              <h2>CinDb</h2>
                        </div>

                        <ul>
                              [@menu]
                        </ul>
                  </nav>
                  <!-- Fim nav -->
                  <div class="col-sm-12 col-md-10">
                        <h3>[@pagTitle]</h3>
                        <?php require_once "[@content]" ?>
                  </div>
            </div>
      </div>
      <script src="[@path]/public/js/jquery.min.js"></script>
      <script type="text/javascript" src="[@path]/public/js/bootstrap.min.js"></script>
</body>
</html>
