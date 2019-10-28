<?php
function rmdir_rec($dir)
{
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        if (is_dir("$dir/$file")) {
            remove_directory("$dir/$file");
        } else {
            unlink("$dir/$file");
        }
    }
    return rmdir($dir);
}

if (isset($_POST)) {
    $html = json_decode(file_get_contents("php://input"),true)["html"];
    $dir = uniqid();
    mkdir($dir);
    mkdir($dir . "/img");

    $zip = new ZipArchive;
    $zipPath = $dir.'/myPage.zip';
    if ($zip->open($zipPath, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) === true) {

        $zip->addEmptyDir('img');

        $html = preg_replace_callback('/img\s+src="(.+)"/', function ($match) use ($dir, $zip) {
            preg_match('/\/([^\/]+)\?/', urldecode($match[1]), $fileTitle);
            $content = file_get_contents($match[1]);
            $filename = $fileTitle[1] . ".png";
            $newPath = $dir . "/" . $filename;
            file_put_contents($newPath, $content);
            $zip->addFile($newPath, "img/" . $filename);
            return 'img src="img/' . $filename . '"';
        }, $html);

        $zip->addFromString("index.html", $html);
        $zip->close();

        // HTTPヘッダを設定
        header('Content-Type: application/zip');
        header('Content-Length: ' . filesize($zipPath));
        header('Content-Disposition: attachment; filename=myPage.zip');

        readfile($zipPath);
    } else {
        echo '失敗しました';
    }

    //rmdir_rec($dir);
    echo $html;
} else {
    echo "No Available POST Data\n";
}
