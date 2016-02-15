<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Tweet for Treats - Connect with the App</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link href='../treats.css' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <div>
      <h1>Please allow the app to connect with your twitter account</h1>

      <p>If you are having issues try <a href='./clearsessions.php'>clearing your session</a>.</p>

      <?php if (isset($menu)) { ?>
        <?php echo $menu; ?>
      <?php } ?>
    </div>
    <?php if (isset($status_text)) { ?>
      <?php echo '<h3>'.$status_text.'</h3>'; ?>
    <?php } ?>
    <p>
      <pre>
        <?php print_r($content); ?>
      </pre>
    </p>

  </body>
</html>
