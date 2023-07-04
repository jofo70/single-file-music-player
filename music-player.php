
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
            $dir = dirname(__FILE__);
            echo basename($dir);
            echo " - Music Player";
        ?>            
    </title>
    <style>

        body {
    font-family: Arial, sans-serif;
    color: white;
    background-color: black;
    margin: 0;
}
h1, h2{
    font-size: 15px;
}
audio{
    height: 20px;
}
button{
    height: 10px;
    min-width: 20px;
    width: 45px;
    padding: 0;
    line-height: 6px;
    font-size: 8px;
    font-weight: bold;
}
#player {
    width: 300px;
    margin: 0 auto;
}
#playlist, #dir-list{
    list-style-type: none;
    padding: 0;
    margin: 0 auto;
    max-width: 300px;
}
#playlist-div {
    padding-top: 15px
    width: 300px;
    margin: 0 auto;
    overflow-y: auto;
    height: calc(100vh - 200px);
}
#playlist li, #dir-list li {
    position: relative;
    padding: 5px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    cursor: move;
    width: 290px;
    display: :inline-block;
    float: left;
    color: black;
    max-width: 300px;
    border-left: 0;
    border-right: 0;
}
#playlist li.active{
    background-color: Highlight;
    box-shadow: 0 0 15px Highlight;
    z-index: 10000;
}
#playlist li.err{
    background-color: #fcc;
}
.right-buttons {
    position: absolute;
    right: 3px;
    top: 3px;
    float: right;
    display: inline-block;
    margin:0;
    padding: 0;
    vertical-align: top;
}
.filename{
    float: left;
    display:inline-block;
}
.left-buttons {
    position: absolute;
    left: 3px;
    top: -4px;
    display: inline-block;
    margin: 0;
    padding: 0;
    vertical-align: top;
}
button#other-directories{
    left: 3px;
    display: inline-block;
    margin: 0;
    margin-top: 3px;
    padding: 0;
    vertical-align: top;
    width: 100px;
}
.delete {
    float: right;
}
a{
    color: white;
}
#current-song{
    min-height: 40px;
    margin 0 auto;
}
#button-controls{
    float: left;
    width: 300px;
    margin: 0 auto;
    /* text-align: center; */
}
.active .play{
    display: none;
}
.button-selected{
    background-color: Highlight;
    box-shadow: 0 0 15px Highlight;
    color: black;
    /* filter: brightness(0.7); */
}
#loop{
    float: right;
    margin-top: 7px;
}
li a:link, li a:visited, li a:hover{
  color: black;
  background-color: transparent;
  text-decoration: none;
}
.hidden{
    display: none !important;
}
</style>
</head>
<body>
    <div id="player">
        <h1>
            <?php
                $dir = dirname(__FILE__);
                echo basename($dir);
                echo " - Music Player";
            ?>  
        </h1>

        <audio id="audio" tabindex="-1" src="" controls></audio>
        <div id="button-controls">
            <button id="previous">&#124;&#9668;&#9668;</button>
            <button id="back">&#9668;&#9668;</button>
            <button id="forward">&#9658;&#9658;</button>
            <button id="next">&#9658;&#9658;&#124;</button>
            <button id="loop">LOOP</button>
        <h2 id="current-song"></h2>
</div>
<button id="other-directories">OTHER DIRECTORIES</button>
<button id="close-button" class="hidden">CLOSE</button>
<div id="playlist-div">
        <ul id="playlist">

            <?php 
            ini_set('display_errors', 1);
            $files = glob("*.{mp3,ogg,m4a,wav,flac,aac,webm,opus}", GLOB_BRACE);
// SORT THE CONTENTS BY MODIFICATION TIME
            array_multisort(array_map('filemtime', $files), SORT_NUMERIC, SORT_DESC, $files);
// SORT THE CONTENTS BY FILENAME
            //array_multisort(array_map('basename', $files), SORT_ASC, $files);            

            if(count($files) < 0){
                echo "<li>No files found</li>"; 
                }else{
                    foreach ($files as $file): ?>

                <li data-src="<?php echo $file; ?>">
                    <div class="left-buttons">
                        <button class="move-up">&#9650;</button>
                        <button class="move-down">&#9660;</button>
                    <button class="play" >&#9658;</button>
                </div>
                    <div class="right-buttons"><button class="delete" >REMOVE</button>
                </div>
                <div class="filename"><br /><?php echo $file; ?>
                </div>
                </li>
            <?php 
                    endforeach; 
                }
                ?>
 
            </ul>
                <div id="dir-dialog" class="hidden">
                    <?php




// START COMMENT OUT ---- TO REMOVE "OTHER DIRECTORIES" FUNCTIONALITY
                    //List all directories that are in the current directory with links to them in a table.
                    $dir = dirname(__FILE__);
                    $directories = glob("$dir/*", GLOB_ONLYDIR);
                    echo "<h2>Directories</h2>";
                    echo "<ul id='dir-list'>";
                    $musicPlayer = "";

// THE 2 STATEMENTS BELOW THIS LINE IS THE LINK TO GO UP ONE DIRECTORY.  COMMENT OUT IF NOT WANTED
                    //if the directory one up contains the file "music-player.php" then $musicPlayer = "music-player.php"
                    if(file_exists("$dir/../music-player.php")){$musicPlayer = "music-player.php";}
                    echo "<li><a href=\"../" . $musicPlayer . "\">..</a></li>";
// THE 2 STATEMENTS ABOVE THIS LINE IS THE LINK TO GO UP ONE DIRECTORY.  COMMENT OUT IF NOT WANTED

                    foreach($directories as $directory){
                        $musicPlayer = "";
                         //if $directory contains the file "music-player.php" then $musicPlayer = "music-player.php"
                         if(file_exists("$directory/music-player.php")){
                            $musicPlayer = "music-player.php";
                            }
                        $directory = explode("/", $directory);
                        $directory = end($directory) ;
                        echo "<li><a href=\"$directory/$musicPlayer\">$directory</a></li>";
                        }
                        echo "</li>";
                        echo "</ul>";
// END COMMENT OUT ---- TO REMOVE "OTHER DIRECTORIES" FUNCTIONALITY





                    ?>
                </div>
            </div>      
    <script>

        function playFirstSong(){
            var firstSong = document.querySelector("#playlist li");
            var song = firstSong.getAttribute("data-src");
            document.querySelector("#audio").setAttribute("src", song);
            document.querySelector("#current-song").innerHTML = firstSong.querySelector(".filename").innerHTML;
            if(document.querySelector("#playlist li.active")){ 
                document.querySelector("#playlist li.active").classList.remove("active");
            }
            firstSong.classList.add("active");
            if(firstSong.classList.contains("err")){
                firstSong.classList.add("err");
                playNextSong();
            }else{
                document.querySelector("#audio").play();
            }
        }

        document.querySelector("#audio").addEventListener("ended", function(){
            if(document.querySelector("#loop").classList.contains("button-selected")){
                document.querySelector("#audio").play();
                return;
            }
            playNextSong();
        });

        function playNextSong(){
            var nextSong = document.querySelector("#playlist li.active + li");
            if(nextSong){
                var song = nextSong.getAttribute("data-src");
                document.querySelector("#audio").setAttribute("src", song);
                document.querySelector("#current-song").innerHTML = nextSong.querySelector(".filename").innerHTML;
                if(document.querySelector("#playlist li.active")){ 
                    document.querySelector("#playlist li.active").classList.remove("active");
                }
                nextSong.classList.add("active");
                if(nextSong.classList.contains("err")){
                    playNextSong();
                }else{
                    document.querySelector("#audio").play();
                }
            }
            else{
                playFirstSong();
            }
        }

        document.getElementById('audio').onerror = function(event) {
            console.log('An error occurred:', event.target.error);
            catchAudioError(event.target.error);
        };

        function catchAudioError(err){
            switch (err.code) {
                case err.MEDIA_ERR_NETWORK:
                        return;
                 case err.MEDIA_ERR_DECODE:
                    document.querySelector("#playlist li.active").classList.add("err");
                    playNextSong();
                    break;
                case err.MEDIA_ERR_SRC_NOT_SUPPORTED:
                    document.querySelector("#playlist li.active").classList.add("err");
                    playNextSong();
                    break;
        
            }
        }

        document.addEventListener("DOMContentLoaded", playFirstSong);

        //Check if "dir-list" does not exist and if it does not, add "hidden" class to "OTHER DIRECTORIES" button
        if(!document.getElementById("dir-list")){
            document.getElementById("other-directories").classList.add("hidden");
        }

        document.addEventListener("click", function(e){
            console.log(e.target);
            if(e.target.id == "previous"){
                var previousSong = document.querySelector("#playlist li.active").previousElementSibling;
                if(previousSong){
                    var song = previousSong.getAttribute("data-src");
                    if(song.classList.contains("err")){
                        song = song.previousSibling;
                    }
                    document.querySelector("#audio").setAttribute("src", song);
                    document.querySelector("#current-song").innerHTML = previousSong.querySelector(".filename").innerHTML;
                    if(document.querySelector("#playlist li.active")){ 
                        document.querySelector("#playlist li.active").classList.remove("active");
                    }
                    previousSong.classList.add("active");
                    document.querySelector("#audio").play();
                }
                else{
                    var lastSong = document.querySelector("#playlist li:last-child");
                    var song = lastSong.getAttribute("data-src");
                    document.querySelector("#audio").setAttribute("src", song);
                    document.querySelector("#current-song").innerHTML = lastSong.querySelector(".filename").innerHTML;
                    if(document.querySelector("#playlist li.active")){ 
                        document.querySelector("#playlist li.active").classList.remove("active");
                    }
                    lastSong.classList.add("active");
                    document.querySelector("#audio").play();
                }
            }

            if(e.target.id == "next"){
                playNextSong();
            };

            if(e.target.id == "back"){
                var currentTime = document.querySelector("#audio").currentTime;
                var newTime = currentTime - 5;
                document.querySelector("#audio").currentTime = newTime;
            };

            if(e.target.id == "forward"){
                console.log("forward-Pressed")
                var currentTime = document.querySelector("#audio").currentTime;
                var newTime = currentTime + 5;
                document.querySelector("#audio").currentTime = newTime;
            };
            
            if(e.target.id == "loop"){
                if(document.querySelector("#loop").classList.contains("button-selected")){
                    document.querySelector("#loop").classList.remove("button-selected");
                }
                else{
                    document.querySelector("#loop").classList.add("button-selected");
                }
            }

            if(e.target && e.target.tagName == "BODY"){
                if(document.querySelector("#audio").paused){
                    document.querySelector("#audio").play();
                }
                else{
                    document.querySelector("#audio").pause();
                }
                return;
            }

            if(e.target && e.target.classList.contains("move-up")){
                var li = e.target.parentNode.parentNode;
                var prevLi = li.previousElementSibling;
                if(prevLi){
                    prevLi.parentNode.insertBefore(li, prevLi);
                }
            }
        
            if(e.target && e.target.classList.contains("move-down")){
                var li = e.target.parentNode.parentNode;
                var nextLi = li.nextElementSibling;
                if(nextLi){
                    nextLi.parentNode.insertBefore(li, nextLi.nextElementSibling);
                }
            }

            if(e.target && e.target.classList.contains("delete")){
                if(e.target && e.target.parentNode.parentNode.classList.contains("active")){
                    document.querySelector("#audio").dispatchEvent(new Event("ended"));
                }
                e.target.parentNode.parentNode.remove();
            }

            if(e.target && e.target.classList.contains("play")){
                var song = e.target.parentNode.parentNode.getAttribute("data-src");
                document.querySelector("#audio").setAttribute("src", song);
                document.querySelector("#current-song").innerHTML = e.target.parentNode.parentNode.querySelector(".filename").innerHTML;
                if(document.querySelector("#playlist li.active")) {
                    document.querySelector("#playlist li.active").classList.remove("active");
                }
                e.target.parentNode.parentNode.classList.add("active");
                document.querySelector("#audio").play();


            }

            if(e.target && e.target.id == "other-directories"){

                document.querySelector("#other-directories").classList.add("hidden");
                document.querySelector("#dir-dialog").classList.remove("hidden");
                document.querySelector("#playlist").classList.add("hidden");
                document.querySelector("#other-directories").classList.add("hidden");
                document.querySelector("#close-button").classList.remove("hidden");      
            }
           
            if(e.target && e.target.id == "close-button"){
                document.querySelector("#dir-dialog").classList.add("hidden");
                document.querySelector("#playlist").classList.remove("hidden");
                document.querySelector("#other-directories").classList.remove("hidden");
                document.querySelector("#close-button").classList.add("hidden");
             }
        });

        document.addEventListener("keydown", function(e){
            // Spacebar
            if(e.keyCode == 32){
                // if the player is focused spacebar will act on it and will toggle twice
                if( document.querySelector("#audio") === document.activeElement){
                    return;
                }
                let isPaused = document.querySelector("#audio").paused;
                if(isPaused){
                    document.querySelector("#audio").play();
                }else{
                    document.querySelector("#audio").pause();
                }
            }
            // right arrow
            if(e.keyCode == 39){
                var currentTime = document.querySelector("#audio").currentTime;
                var newTime = currentTime + 5;
                document.querySelector("#audio").currentTime = newTime;
            }
            // left arrow
            if(e.keyCode == 37){
                var currentTime = document.querySelector("#audio").currentTime;
                var newTime = currentTime - 5;
                document.querySelector("#audio").currentTime = newTime;
            }
            // l
            if(e.keyCode == 76){
                var currentTime = document.querySelector("#audio").currentTime;
                var newTime = currentTime + 10;
                document.querySelector("#audio").currentTime = newTime;
            }
            // j
            if(e.keyCode == 74){
                var currentTime = document.querySelector("#audio").currentTime;
                var newTime = currentTime - 10;
                document.querySelector("#audio").currentTime = newTime;
            }
            // up arrow
            if(e.keyCode == 38){
                var currentVolume = document.querySelector("#audio").volume;
                var newVolume = currentVolume + .1;
                if(newVolume > 1){
                    newVolume = 1;
                }
                document.querySelector("#audio").volume = newVolume;
            }
            // down arrow
            if(e.keyCode == 40){
                var currentVolume = document.querySelector("#audio").volume;
                // subtract .1 from the current volume
                var newVolume = currentVolume - .1;
                // if the new volume is less than 0
                if(newVolume < 0){
                    // set the new volume to 0
                    newVolume = 0;
                }
                // set the volume of the audio player to the new volume
                document.querySelector("#audio").volume = newVolume;
            }
            
            // if the delete key is pressed
            if(e.keyCode == 46){
                // get the parent li of the active song
                var li = document.querySelector("#playlist li.active");
                // remove the parent li from the playlist
                li.remove();
            }
            if(e.shiftKey && e.keyCode == 78){ 
                // play next song in playlist
                document.querySelector("#audio").dispatchEvent(new Event("ended"));
            }
            //if command and right arrow keys are pressed skip to previous song in the playlist
            if(e.shiftKey && e.keyCode == 80){ 
                //if the currently playing song is within the first five seconds play the previous song, otherwise play the beginning of the song
                if(document.querySelector("#audio").currentTime > 5){
                    document.querySelector("#audio").currentTime = 0;
                }else{
                    // get the parent li of the active song
                    var li = document.querySelector("#playlist li.active");
                    // get the previous li of the parent li
                    var prevLi = li.previousElementSibling;
                    // if there is a previous li
                    if(prevLi){
                        // play prevLi
                        prevLi.querySelector(".play").click();
                    }
                }

            }

            console.log("key pressed", e.keyCode);

        });





  

    </script>
</body>
       