<nav>
    <link href="../styles.css" rel="stylesheet">
    <?php

    @session_start();

    require_once '../classes/helpers.php';

    $helpers = new Helpers();

    if (isset($_SESSION["role"])) {
        $href = "." . $helpers->getPageRoles()[$_SESSION["role"]];
        echo "<a href='$href'><img src='../assets/logo.png' alt='logo'>";
    } else {
        echo "<img src='../assets/logo.png' alt='logo'>";
    }
    ?>
    <a href="../logout.php">Uitloggen</a>
</nav>