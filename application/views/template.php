<!DOCTYPE HTML>
<html  lang="en" xmlns="http://www.w3.org/1999/html">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link type="image/x-icon" href="favicon.ico" rel="shortcut icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php echo $meta_data ?>  <!--This will contain all meta data and title for SEO-->
  <!-- Script for google analytics -->
  
  <!-- Script for google analytics -->
  <?php echo $_styles; ?>       
     		
  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
          <![endif]-->        
        </head>
        <body >
          <div class="container">
          <?php echo $header; ?>     
          <div class="inner_container">
                <?php echo $content; ?>            
                <?php echo $rightbar; ?>
          </div>
          <?php echo $footer; ?>
          </div>
          <?php echo $_scripts; ?>
        </body>
        </html>
