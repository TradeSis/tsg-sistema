<?php

$destino = $_SERVER['DOCUMENT_ROOT'].$_POST['endereco'].$_FILES['arquivo']["name"];

move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino);
