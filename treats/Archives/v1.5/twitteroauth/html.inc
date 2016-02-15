<!DOCTYPE html>

<html>
<head>
    <title>Tweet for Treats - Connect with the App</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    <link href='../treats-admin.css' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="../../img/favicon.png">
  </head>
  <body>
  <section class="form-container">
      <div class="form-center">
          <div id="logo">
              <img src="../../img/tweets-for-treats-logo-white.svg">
          </div>
          <img src="../images/app-connect.svg" class="connect">
          <span class="connect-message">
               Please allow the app to connect with your twitter account
          </span>
          <div class="twitter-signin">
              If you are having issues try <a href='./clearsessions.php'>clearing your session</a>.
          </div>
          <div class="twitter">
              <?php if (isset($menu)) { ?>
                  <?php echo $menu; ?>
              <?php } ?>

              <?php if (isset($status_text)) { ?>
                  <?php echo '<span class="connect-message">'.$status_text.'</span>'; ?>
              <?php } ?>

              <?php print_r($content); ?>
          </div>

    <div>
  </section>

  </body>
</html>
