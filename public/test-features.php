<!DOCTYPE html>
<html>

<head>
    <title>Features Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .feature {
            padding: 10px;
            margin: 5px 0;
            background: #f0f0f0;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>Features Test Page</h1>

    <?php
    // Direct database connection test
    try {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=finda_uk', 'root', '');
        $stmt = $pdo->query("SELECT * FROM features");
        $features = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<p><strong>Total Features: " . count($features) . "</strong></p>";

        if (count($features) > 0) {
            echo "<h2>Features List:</h2>";
            foreach ($features as $feature) {
                echo "<div class='feature'>";
                echo "ID: " . $feature['id'] . " - Name: " . $feature['name'];
                echo "</div>";
            }
        } else {
            echo "<p style='color: red;'>No features found in database!</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Database Error: " . $e->getMessage() . "</p>";
    }
    ?>
</body>

</html>