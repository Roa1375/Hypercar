<?php
// File to store version data
$jsonFile = 'app_data.json';

// Load the current data from the JSON file
$data = json_decode(file_get_contents($jsonFile), true);

// Check if the request is for JSON output
if (isset($_GET['json'])) {
    // Set the headers for a JSON response
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit; // Stop further execution to avoid rendering HTML
}

// Check if the form is submitted via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new values from the form
    $newVersion = $_POST['latest_version'] ?? $data['latest_version'];
    $newChangelog = $_POST['changelog'] ?? $data['changelog'];

    // Update the data array
    $data['latest_version'] = $newVersion;
    $data['changelog'] = $newChangelog;

    // Save the updated data back to the JSON file
    if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT))) {
        echo "<p>Version and changelog updated successfully!</p>";
    } else {
        echo "<p>Failed to update version and changelog.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>App Update Manager</title>
    <style>
        /* Base Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #444;
            margin: 20px 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .current-info {
            padding: 20px;
            background-color: #eaeaea;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
        }

        pre {
            background-color: #eaeaea;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input,
        textarea,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        input::placeholder,
        textarea::placeholder {
            color: #888;
            font-style: italic;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Media Queries for responsiveness */
        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 15px;
            }

            h1 {
                font-size: 1.5rem;
            }

            input,
            textarea,
            button {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.2rem;
            }

            .current-info {
                padding: 10px;
            }

            input,
            textarea,
            button {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <h1>App Update Manager</h1>
    <div class="container">
        <div class="current-info">
            <p><strong>Current Version:</strong> <?php echo htmlspecialchars($data['latest_version'] ?? 'N/A'); ?></p>
            <p><strong>Current Changelog:</strong></p>
            <pre><?php echo htmlspecialchars($data['changelog'] ?? 'No changelog available'); ?></pre>
        </div>
        <form method="post">
            <label for="latest_version">Latest Version:</label>
            <input type="text" id="latest_version" name="latest_version" placeholder="Enter the latest version">
            <label for="changelog">Changelog:</label>
            <textarea id="changelog" name="changelog" placeholder="Enter the changelog"></textarea>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
