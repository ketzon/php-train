<?php

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */

$postData = $_POST;


if (
    !isset($postData['email'])
    || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)
    || empty($postData['message'])
    || trim($postData['message']) === ''
) {
    echo('Il faut un email et un message valides pour soumettre le formulaire.');
    return;
}

if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0){
    if ($_FILES['screenshot']['size'] > 1000000){
        echo "le fichier est trop gros frerot";
            return;
    }
    $fileinfo = pathinfo($_FILES['screenshot']['name']);
    $extension = $fileinfo['extension'];
    $allowed = ['jpg', 'gif', 'png', 'jpeg'];
    if (!in_array($extension, $allowed)){
        echo "{$extention}: not allowed!";
        return ;
    }
    $path = __DIR__. '/uploads/';
    if (!is_dir($path)) {
        echo "mauvais path";
        return;
    }
    move_uploaded_file($FILES['screenshot']['tmp_name'], $path .
        basename($_FILES["screenshot"]["name"]));
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Contact reçu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">

        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Message bien reçu !</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Rappel de vos informations</h5>
                <p class="card-text"><b>Email</b> : <?php echo($postData['email']); ?></p>
                <p class="card-text"><b>Message</b> : <?php echo(strip_tags($postData['message'])); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
