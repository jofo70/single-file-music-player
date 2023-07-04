#Single File Music Player

###This is a one file audio player application that you can drop into any folder on a PHP 5+ server to put all web playable audio files in that directory into a playlist.  It will also list all sub-directories, and let you navigate up a directory.

**BASIC USAGE AND FEATURES**
- The user must interact (hit a play button) for the player to start.
- The playlist will loop.
- The song files will be listed by filename sorted by modified date.
- They can be sorted, removed from playlist, or played directly by using the buttons in each listing.
- There are player buttons to jump to next/previous song, skip forward/backward 5 seconds.
- There is also a latching "LOOP" button that will repeat one song.
- Youtube key commands related to audio can be used.
- The "OTHER DIRECTORIES" button will link to other sub-directories as well as a link to go up a directory when "music-player.php" exists there.
- While searching for other directories, if it finds "music-player.php" it will link directly to that instead of the directory root.

**DIRECTIONS**

- Upload "music-player.php" into any directory to turn all playable audio files into a playlist.
- Put another copy of "music-player.php" into any sub-directoies.
- The directories tab will link directly to the sub-directory's copy of "music-player.php" if found.  Otherwise it will link to the root of the directory.

**TIPS**
- Clear comments in the code indicate what to comment out if the "OTHER DIRECTORIES" functionality is not wanted.
- Comments to remove the functionality to go up a directory are also there.
- except for 404 errors, I haven't been able to test the error catching when it can't play a file.  It should mark it pink and start skipping over it.
- The code should be easy to alter to suit your needs for titles and styling
