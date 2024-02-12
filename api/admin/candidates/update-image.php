<?php

    $targetPath = "../../../client/assets/images/candidates/" . Basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);

    if($_POST["image"] != $_POST["imageOld"]) {
        unlink("../../../client/assets/images/candidates/".$_POST["imageOld"]);   
    }

?>