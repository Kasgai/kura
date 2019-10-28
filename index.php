<?php
echo "Hello, World! ver2";
if(isset($_POST['html'])){
    $comment = $_POST['html'];
    echo $comment;
} else {
    echo "Not Available POST Data";
}
?>