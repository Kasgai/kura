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

phpinfo();

if (isset($_POST['html'])) {
    $html = $_POST['html'];
    $dir = uniqid();
    mkdir($dir);
    mkdir($dir . "/img");

    $zip = new ZipArchive;
    if ($zip->open('archive.zip') === true) {

        $zip->addEmptyDir('img');

        $html = preg_replace_callback('/img\s+src="(.+)"/', function ($match) use ($dir, $zip) {
            preg_match('/\/([^\/]+)\?/', urldecode($match[1]), $fileTitle);
            $content = file_get_contents($match[1]);
            $filename = $fileTitle[1] . ".png";
            $newPath = $dir ."/". $filename;
            file_put_contents($newPath, $content);
            $zip->addFile($newPath,"img/".$filename);
            return 'img src="img/' . $filename . '"';
        }, $html);

        $zip->addFromString("index.html",$html);
        $zip->close();
    } else {
        echo '失敗しました';
    }

    //rmdir_rec($dir);
    echo $html;
} else {
    echo "Not Available POST Data\n";
}
