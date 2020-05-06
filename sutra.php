<?php include("assets/includes/global-header.php"); ?>
  <div id="form" class="container">
    <?php
      if(!isset($_POST['submit']) && !isset($_GET['sutra'])) {
    ?>
    <div id="content">
      <div id="main_content">
        <h1>Sutra</h1>
        <form action="sutra.php" method="POST">
          <input type="text" name="sutra" id="sutra" value="sutra" placeholder="sutra">
          <input type="submit" name="submit" id="submit" value="submit">
        </form>
      </div><!-- #main_content -->
    </div><!-- #content -->
    <?php } else {
      if(isset($_POST['sutra'])) {
        $sutra = $_POST['sutra'];
      } elseif (isset($_GET['sutra'])) {
        $sutra = $_GET['sutra'];
      }
      $sutraTitle = str_replace('_', ' ', $sutra);
      $sutraContentsString = file_get_contents ($sutra.'.txt');
      $sutraContentsArray = file($sutra.'.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    ?>

    <div class="controls"><i class="fas fa-play"></i> Play | <i class="fas fa-stop"></i> Stop | <i class="fas fa-angle-double-down"></i> | <i class="fas fa-angle-double-up"></i></div>
    <h1><?php echo $sutraTitle; ?></h1>
    <hr>
    <div id="txt"><span id="pre"><?php for ($l=0; $l<count($sutraContentsArray); $l++){ 
      echo $sutraContentsArray[$l].'<br>'.'<hr>';
    }
    ?></span><span id="post"></span></div>
    <?php } ?>

    <script type="application/javascript">
      var arrayText = new Array;
      arrayText = <?php echo json_encode($sutra.'.txt'); ?>;
      var speed = 800; // setting up speed variable
      var allText = <?php echo json_encode($sutra); ?>;
      allText = allText.split("\n").join("<br><hr> ");
      arrayText = allText.split(' ');
    </script>

  </div><!-- #form -->
  <style>
    body {font-size:22px;}
    #pre,#post {color:#999;display:block;position:absolute;}
    .wordPost {color:#ccc;}
    .wordPost:last-child {color:#000;}
    .controls {background:#eee;border-radius:10px;bottom:10px;padding:10px;position:fixed;right:10px;}
  </style>
<?php include("assets/includes/global-footer.php"); ?>