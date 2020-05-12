<?php include("assets/includes/global-header.php"); // 24 lines ?>
  <div id="form" class="container">
    <?php
      if(!isset($_GET['sutra'])) {
    ?>
    <div id="content">
      <div id="main_content">
        <h1>Sutra</h1>
        <form action="sutra.php" method="GET">
          <select name="sutra" id="sutra">
            <?php
            foreach (glob("*.txt") as $sutra) {
              $sutra = str_replace('.txt', '', $sutra); // removing .txt of filename
              $sutraTitle = str_replace('_', ' ', $sutra); // make a Human Readable version of the filename
              $sutraTitle = str_replace('.txt', '', $sutraTitle);
              echo "<option value=".$sutra.">".$sutraTitle."</option> \n";
            }
            ?>
          </select>
          <input type="submit" value="submit">
        </form>
      </div><!-- #main_content -->
    </div><!-- #content -->
    <?php } else {
      if (isset($_GET['sutra'])) {
        $sutra = $_GET['sutra'];
      }
      $sutraTitle = str_replace('_', ' ', $sutra); //  make a Human Readable version of the filename
      $sutraContentsString = file_get_contents ($sutra.'.txt');
      $sutraContentsArray = file($sutra.'.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    ?>

    <h1><?php echo $sutraTitle; ?>
    <small class="controls"><a href="javascript:playSutra()"><i class="fas fa-play"></i></a> | <a href="javascript:stopSutra()"><i class="fas fa-stop"></i></a> | <a href="javascript:playSutra('50')"><i class="fas fa-angle-double-up"></i></a> | <a href="javascript:playSutra('-50')"><i class="fas fa-angle-double-down"></i></a> | <a href="javascript:resetSutra()"><i class="fas fa-undo"></i></a></small></h1>
    <hr>
    <div id="txt"><span id="pre"></span><span id="post"></span></div>

    <script type="text/javascript">
      var sutraArray = new Array; // create array for the individual sutra
      sutraArray = <?php echo json_encode($sutra.'.txt'); ?>; // fill the individual sutra array with the file contents
      var speed = 600; // setting up speed variable
      var sutraText = <?php echo json_encode($sutraContentsString); ?>; // create a string of the individual sutra contents
      sutraText = sutraText.split("\n").join("<br><hr> "); // set the string appropriately
      sutraText = sutraText.split("|").join(""); // set the string appropriately
      sutraArray = sutraText.split(' '); // fill the individual sutra with the file string **duplicate?**
      var wordCurrent = 0; // set the string to hold the current word number of the individual sutra
      var wordsRead = ''; // set up a string to hold the read words of the individual sutra
      var wordsComposed = ''; // set the string of the individual sutra
      var startWord = ''; // set a string to hold the word read **unused**
      var interval = ''; // set a string to hold the interval of the setInterval function

      function buildInitialSutra() {
        for(var word = 0;word<sutraArray.length;word++) {
          wordsComposed += '<span class="wordIndividual wordPre" id="word-' + word + '">' + sutraArray[word] + ' </span>';
          document.getElementById('pre').innerHTML = wordsComposed;
        }
      }

      buildInitialSutra();

      function showSutra() { // build the post words string
        if(wordCurrent<sutraArray.length) {
          wordsRead += '<span class="wordIndividual wordPost" id="word-' + wordCurrent + '">' + sutraArray[wordCurrent] + ' </span>';
          document.getElementById('post').innerHTML = wordsRead;
        }
        wordCurrent++;
      }

      function playSutra(speedChange){
        stopSutra();
        if(!speedChange) {
          speed = speed;
        } else {
          if(Math.sign(speedChange) == 1) { // decrease
            speed = speed - 50;
          } else {
            speed += 50;
          }
        }
        interval = setInterval("showSutra()", speed);
      }

      function stopSutra(){
        clearInterval(interval);
      }

      function resetSutra(){
        wordCurrent = 0;
        speed = 600;
        wordsRead = '';

        stopSutra();
        playSutra();
      }
    </script>
  <?php } ?>
  </div><!-- #form -->
  <style>
    body {font-size:22px;}
    #pre,#post {color:#888;display:block;position:absolute;}
    #pre {z-index: 1;}
    #post {z-index: 2;}
    #post span {color:#eee;}
    #post span:last-child {color:#111;}
    .controls {background:#eee;border-radius:10px;margin:0 0 0 1em;padding:10px;position:fixed;z-index:10;
    }
  </style>
<?php include("assets/includes/global-footer.php"); ?>