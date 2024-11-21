<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <?php
        $currentPage = basename($_SERVER['PHP_SELF'], '.php');
        if ($currentPage === 'index') {
            echo '<link rel="stylesheet" href="styles/style.css">';
        } else {
            echo '<link rel="stylesheet" href="styles/styles_' . htmlspecialchars($currentPage) . '.css">';
        }
        ?>
        <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet'>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link rel="icon" href="favicon.ico" sizes="32x32" type="image/x-icon">
        <link rel="icon" href="favicon-16x16.png" sizes="16x16" type="image/png">
        <link rel="icon" href="favicon-32x32.png" sizes="32x32" type="image/png">
        <link rel="apple-touch-icon" href="apple-touch-icon.png" sizes="180x180">
        <?php
        if ($currentPage === 'index') {
            echo '<script src="scripts/timedate.js" type="text/javascript"></script>';
            echo '<script src="scripts/kolorujtlo.js"></script>';
            echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>';
        }
        ?>
        <title><?php echo htmlspecialchars($title); ?></title>
    </head>
    <body <?php echo ($currentPage === 'index') ? ' onload="startClock()"' : ''; ?> >
        <header>
            <a href="index.php">
                <div class="logo">
                    <strong>JJ</strong>
                </div>
            </a>
        </header>