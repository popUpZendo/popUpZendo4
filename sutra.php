<?php include("assets/includes/global-header.php"); // 24 lines ?>
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

    <h1><?php echo $sutraTitle; ?>
    <small class="controls"><a href="javascript:playSutra()"><i class="fas fa-play"></i> Play</a> | <a href="javascript:stopSutra()"><i class="fas fa-stop"></i> Stop</a></small></h1>
    <hr>
    <div id="txt"><span id="pre"></span><span id="post"></span></div>
    <?php } ?>

    <script type="text/javascript">
      var sutraArray = new Array;
      sutraArray = <?php echo json_encode($sutra.'.txt'); ?>;
      var speed = 800; // setting up speed variable
      var sutraText = <?php echo json_encode($sutraContentsString); ?>;
      sutraText = sutraText.split("\n").join("<br><hr> ");
      sutraArray = sutraText.split(' ');
      var wordCurrent = 0;
      var wordsRead = '';
      var startWord = '';
      var inerval = '';

      document.getElementById('pre').innerHTML = sutraText;

      function showSutra() {
        if(wordCurrent<sutraArray.length) {
          wordsRead += '<span class="wordPost">' + sutraArray[wordCurrent] + ' </span>';
          document.getElementById('post').innerHTML = wordsRead;
        }
        wordCurrent++;
      }

      function playSutra(){
        interval = setInterval("showSutra()",speed);
      }

      function stopSutra(){
        clearInterval(interval);
      }
    </script>

  </div><!-- #form -->
  <style>
    body {font-size:22px;}
    #pre,#post {color:#888;display:block;position:absolute;}
    #pre {z-index: 1;}
    #post {z-index: 2;}
    #post span {color:#eee;}
    #post span:last-child {color:#111;}
    .controls {background:#eee;border-radius:10px;padding:10px;position:fixed;z-index:10;
    }
  </style>
<?php include("assets/includes/global-footer.php"); ?>