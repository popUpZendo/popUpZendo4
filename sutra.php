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
      $sutraTitle = str_replace('_', ' ', $sutra)
    ?>




    <div class="controls"><i class="fas fa-play"></i> Play | <i class="fas fa-stop"></i> Stop | <i class="fas fa-angle-double-down"></i> | <i class="fas fa-angle-double-up"></i></div>
    <h1><?php echo $sutraTitle; ?></h1>
    <hr>
    <div id="txt"><span id="pre"></span><span id="post"></span></div>
    <?php } ?>
    <script type="application/javascript">
      var txtFile = new XMLHttpRequest();
      var allText = "file not found";
      var arrayText = new Array;
      var speed = 800; // setting up speed variable

      var txtFileTitle = <?php echo json_encode($sutra.'.txt'); ?>;
      
      txtFile.onreadystatechange = function () {
        if (txtFile.readyState === XMLHttpRequest.DONE && txtFile.status == 200) {
          allText = txtFile.responseText;
          allText = allText.split("\n").join("<br><hr> ");
          arrayText = allText.split(' ');
        }

        var wordPre = allText;
        document.getElementById('pre').innerHTML = wordPre;
        var wordCurrent = ''; // a number representing the current word position
        var wordPost = ''; // the array of words after the current word
        var displayText = arrayText;
        var i = 0;

        function showSutra(piStartpoint) {
          if(i<arrayText.length){
            wordPost += '<span class="wordPost">' + arrayText[i] + '</span> ';

            document.getElementById('post').innerHTML = wordPost;
            if(!piStartpoint){i++;}
          }
        }
        setInterval(showSutra,speed);
      }

      function setSpeed(psDirection) {
        if (!psDirection) { lsDirection = "increase" } else { lsDirection = psDirection } 
        if(lsDirection == "increase") {
          speed += 100;
        } else {
          speed = 100;
        }
        showSutra();
      }
      speed = 800;
      txtFile.open("GET", txtFileTitle, true);
      txtFile.send(null);
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