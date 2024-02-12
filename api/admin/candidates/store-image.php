<?php

    $targetPath = "../../../client/assets/images/candidates/" . Basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);

?>