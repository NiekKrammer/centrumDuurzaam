<?php
// Include database connection
include_once '../classes/db.php';

// Maak verbinding met de database via de Database class
$database = new Database();
$conn = $database->getConnection();

// Check if form is submitted
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Update category in the database
    $query = "UPDATE categorie SET categorie = :name WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Category updated successfully.";
        header("Location: magazijnMedewerkerPagina.php");
        exit;
    } else {
        echo "Error updating category.";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM categorie WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "No category ID provided.";
    exit;
}

$database->disconnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bewerk categorie</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<nav>
        <img src="../assets/logo.png" alt="logo">
        <div class="roleTag_loguitBtn">
            <span>Magazijn</span>
            <a href="../logout.php">Uitloggen</a>
        </div>
    </nav>
    <div class="bewerkCategorie">
    <h1>Bewerk categorie</h1>
    <a href="magazijnMedewerkerPagina.php">&lt; Terug</a>
    <?php if ($category): ?>
    <form action="bewerkCategorie.php" method="post">
        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
        <label for="name">Category Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $category['categorie']; ?>" required>
        <button type="submit" name="update">Update</button>
    </form>
    <?php else: ?>
    <p>Category not found.</p>
    <?php endif; ?>

    </div>
    <footer>
    <p>© centrumDuurzaam</p>
    </footer>
</body>
</html>
