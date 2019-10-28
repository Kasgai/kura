<?php
echo "Hello, World! ver2\n";
if(isset($_POST['html'])){
    $html = $_POST['html'];
    $domDoc = new DOMDocument();
    $domDoc->loadXML($html);
    $imgs = $domDoc->getElementsByTagName("img");
    foreach($imgs as $img) {
        echo $img->getAttribute("src");
        echo "\n";
    }
    echo $html;
} else {
    echo "Not Available POST Data\n";
}
?>