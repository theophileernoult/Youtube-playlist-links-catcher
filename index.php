<?php
require_once 'functions/functions.php';

if (isset($_GET['export'])) {
    $txt = str_replace("@@@@@", "\n", $_GET['export']);
    header('Content-type: text/plain');
    header('Content-Disposition: attachment;filename="YT_Playlist_export.txt"');
    echo $txt;
    die();
}
if (isset($_GET['url'])) {
    $playListId = getParam('list');
}
?>
    <html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
              integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
              crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
                integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
                crossorigin="anonymous"></script>
        <title>
            Youtube Playlist Links Catcher
        </title>
    </head>
    <body>

    <?php
    include 'src/sheader.html';
    ?>

    <form method="GET" action="">
        playlist URL: <input type="text" name="url" style="width: 500px"
                             value="<?= (isset($_GET['url'])) ? $_GET['url'] : '' ?>"
                             placeholder="E.g. https://www.youtube.com/playlist?list=PL3485902CC4FB6C67">
        <br>
        <input type="submit" value="Get Links" class="btn btn-success">
        <?php
        if (isset($playListId)) {
            ?>
            <a class="btn badge-info" href="#export">Export to txt</a>
            <?php
        }
        ?>
    </form>
    </body>
    </html>

<?php

if (isset($playListId)) {
    $maxResults = 50;
    $apiKey = 'Enter your Youtube api key';
    $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=' . $maxResults . '&playlistId=' . $playListId . '&key=' . $apiKey;
    $playlist = json_decode(file_get_contents($api_url));
    $txt = "";
    ?>
    <table class="table-bordered table-striped" width="100%">
        <tr>
            <th>thumbnail</th>
            <th>title</th>
            <th>url/link</th>
        </tr>
        <?php
        foreach ($playlist->items as $item) {
            $txt .= "https://www.youtube.com/watch?v=" . $item->snippet->resourceId->videoId . "@@@@@";
            ?>
            <tr>
                <td>
                    <img src="<?= $item->snippet->thumbnails->default->url ?>" width="60" height="45">
                </td>
                <td>
                    <?= $item->snippet->title ?>
                </td>
                <td>
                    <a href="https://www.youtube.com/watch?v=<?= $item->snippet->resourceId->videoId ?>"
                       target="_blank">
                        https://www.youtube.com/watch?v=<?= $item->snippet->resourceId->videoId ?>
                    </a>
                    <img src="src/_bank.jpg" width="16">
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <hr>
    <a id="export" href="index.php?export=<?= $txt ?>">
        <img src="src/txt_icon.jpg" width="32">
        export to txt
    </a>
    <br><br>
    <?php
}
?>