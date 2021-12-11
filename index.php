<?php
if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    //echo "$fileName<br>$fileTmpName<br>$fileType<br>$fileSize";

    if(in_array($fileActualExt, $allowed)) {
        if($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = './uploads/'.$fileNameNew;
                //<console class="log">$fileDestination</console>
                //move_uploaded_file($fileTmpName, $fileDestination);
                //stuff w/header
                //print_r($fileNameNew);
                header("location: index.html?$fileDestination");

                //header("Location: index.html?upload_success");
            }
            else {
                echo "too big file";
            }
        }
        else {
            echo "tmp upload failing with built in error check";
        }
    }
    else {
        echo "wrong file type";
    }
}
?>
