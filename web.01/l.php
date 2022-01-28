<?php
   $input = $_POST['suche'];
    $seite_google = 'https://www.google.de/#q=';
    $seite_myanimelist = 'http://myanimelist.net/anime.php?q=';
    $seite_anisearch = 'http://de.anisearch.com/anime/index/?char=all&text=';
    $seite_proxer = 'http://proxer.me/search?name=';
    ?>
    <form>
    <input type="button" onclick="location.href='<?php echo $seite_google.$input; ?>'" value='Google Suche'>
    <input type="button" onclick="location.href='<?php echo $seite_myanimelist.$input; ?>'" value='MyAnimeList'>
    <input type="button" onclick="location.href='<?php echo $seite_anisearch.$input; ?>&q=true'" value='AniSearch'>
    <input type="button" onclick="location.href='<?php echo $seite_proxer.$input; ?>&sprache=alle&typ=all&genre=&nogenre=&sort=name&length=&length-limit=down#search'" value='Proxer'>
    </form>

    <html>
    <body>
    <form method="post" action="">Suche: <input name="suche" type="text"><br>
         <input type="submit" value="OK" name="submit">
    </form>
    </body>
    </html>
