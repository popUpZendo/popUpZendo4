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
            foreach (glob("*.txt") as $sutra){
              $sutra = str_replace('.txt', '', $sutra); // removing .txt of filename
              $sutraTitle = str_replace('_', ' ', $sutra); // make a Human Readable version of the filename
              echo "<option value=".$sutra.">".$sutraTitle."</option> \n"; // insert each .txt file as an option
            }
            ?>
          </select>
          <input type="submit" value="submit">
        </form>
      </div><!-- #main_content -->
    </div><!-- #content -->
    <?php } else {
      if (isset($_GET['sutra'])){
        $sutra = $_GET['sutra'];
      }
      $sutraTitle = str_replace('_', ' ', $sutra); // make a Human Readable version of the filename
      $sutraContentsString = file_get_contents ($sutra.'.txt'); // insert the file contents into a string
      $sutraContentsArray = file($sutra.'.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // make an array of the file contents **unused**
    ?>

    <h1><?php echo $sutraTitle; ?>
    <small class="controls"><a href="javascript:playSutra()"><i class="fas fa-play"></i></a> | <a href="javascript:stopSutra()"><i class="fas fa-stop"></i></a> | <a href="javascript:playSutra('50')"><i class="fas fa-angle-double-up"></i></a> | <a href="javascript:playSutra('-50')"><i class="fas fa-angle-double-down"></i></a> | <a href="javascript:resetSutra()"><i class="fas fa-undo"></i></a></small>
    </h1>
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

      function buildInitialSutra(){ // build the sutra
        for(var word = 0;word<sutraArray.length;word++){
        wordsComposed += '<span class="wordIndividual wordPre" id="word-' + word + '">' + sutraArray[word] + ' </span>'; // add the current word to the function
          document.getElementById('pre').innerHTML = wordsComposed + '<br><br>'; // insert the wordsComposed variable into the innerHML of #pre
        }
      }

      buildInitialSutra();

      function showSutra(){ // build the post words string
        if(wordCurrent<sutraArray.length){
          wordsRead += '<span class="wordIndividual wordPost" id="word-' + wordCurrent + '">' + sutraArray[wordCurrent] + ' </span>'; // add the current word
          document.getElementById('post').innerHTML = wordsRead; // insert the wordsRead variable into the innerHML of #post
        }
        wordCurrent++; // increase the value
      }

      function playSutra(speedChange){ // play the sutra
        stopSutra(); // stop the Sutrq
        if(!speedChange){ // no passed variable
          speed = speed; // don't change the speed
        } else { // passed variable
          if(Math.sign(speedChange) == 1){ // decrease
            speed = speed - 50; // subtract 50/1000 from the speed
          } else { // increase
            speed += 50; // add 50/1000 to the speed
          } 
        }
        interval = setInterval("showSutra()", speed); // set the interval
      }

      function stopSutra(){ // stop the sutra
        clearInterval(interval); // clear interval
      }

      function resetSutra(){ // reset and restart the sutra
        wordCurrent = 0; // set the current position to the beginning
        speed = 600; // reset default speed
        wordsRead = ''; // clear the post played words

        stopSutra(); // stop the sutra
        playSutra(); // start the sutra
      }
    </script>
  <?php } ?>
  </div><!-- #form -->
  <style>
    /* built by Benjamin Meyers for pop-up Zendo */
    body {font-family:Times serif;font-size:24px;}
    #pre,#post {color:#888;display:block;position:absolute;}
    #pre {z-index: 1;}
    #post {z-index: 2;}
    #post span {color:#eee;}
    .controls {background:#eee;border-radius:10px;margin:0 0 0 1em;padding:10px;position:fixed;z-index:10;}
  </style>
<?php include("assets/includes/global-footer.php"); ?>