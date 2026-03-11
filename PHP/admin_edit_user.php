<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../adminLogIn.php");
    exit();
}

$message = "";
$user = null;

// Only proceed if both ID and action are given
if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];

    // Fetch user data for editing
    if ($action === 'E') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $approved = isset($_POST['is_approved']) ? 1 : 0;

            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ?, is_approved = ? WHERE unique_id = ?");
            $stmt->bind_param("sssii", $username, $email, $role, $approved, $id);

            if ($stmt->execute()) {
                $message = "✅ User updated successfully.";
            } else {
                $message = "❌ Update failed: " . $stmt->error;
            }
        }

        // Get user data to display in form
        $stmt = $conn->prepare("SELECT * FROM users WHERE unique_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    }

    // Delete user
    elseif ($action === 'D') {
        $stmt = $conn->prepare("DELETE FROM users WHERE unique_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: ../admin_dashboard.php");
        exit();
    }
}
?>

<!-- Only render the form if user exists -->
<?php if ($user): ?>
    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
            integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Edit User</title>
        <style>
            body {
                background-image: linear-gradient(180deg, #b6d8f4, #022135);
                background-repeat: no-repeat;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .form {
                width: fit-content;
                display: flex;
                flex-direction: column;
                gap: 10px;
                padding-left: 2em;
                padding-right: 2em;
                padding-bottom: 0.4em;
                background-color: #03021aff;
                border-radius: 25px;
                transition: .4s ease-in-out;
            }

            .form:hover {
                transform: scale(1.05);
                border: 1px solid black;
            }

            #heading {
                text-align: center;
                margin: 2em;
                color: rgb(255, 255, 255);
                font-size: 1.2em;
            }

            .field {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5em;
                border-radius: 25px;
                padding: 0.6em;
                border: none;
                outline: none;
                color: white;
                background-color: #030f3d;
                box-shadow: inset 2px 5px 10px rgba(14, 12, 26, 1);
            }

            .form label {
                display: inline-block;
            }

            .input-field {
                background: none;
                border: none;
                outline: none;
                width: 100%;
                color: #d3d3d3;
            }

            .form .btn {
                display: flex;
                justify-content: center;
                flex-direction: row;
                margin-top: 2.5em;
            }

            .button1 {
                padding: 0.5em;
                padding-left: 1.1em;
                padding-right: 1.1em;
                border-radius: 5px;
                margin-right: 0.5em;
                margin-bottom: 0.5em;
                border: none;
                outline: none;
                transition: .4s ease-in-out;
                background-color: #221b4dff;
                color: white;
            }

            .button1:hover {
                background-color: black;
                color: white;
                cursor: pointer;
            }

            .back-icon {
                text-decoration: none;
                color: white;
            }
        </style>
    </head>

    <body>


        <form method="POST" class="form">

            <p id="heading"><a href="../users_list.php" class="back-icon"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;</a>Edit User Info</p>
            <?php if ($message): ?>
                <p style="color:whitesmoke;"><?= $message ?></p>
            <?php endif; ?>
            <div class="field">
                <label>Username: </label><input name="username" class="input-field" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="field">
                <label>Email: </label><input name="email" class="input-field" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="field">
                <label>Role:</label>
                <select name="role" class="input-field">
                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                    <option value="consultant" <?= $user['role'] == 'consultant' ? 'selected' : '' ?>>Consultant</option>
                </select>
            </div>
            <div class="field">
                <label>Approved: </label><input type="checkbox" name="is_approved" <?= $user['is_approved'] ? 'checked' : '' ?>>
            </div>
            <div class="btn">
                <button type="submit" class="button1">Save Changes</button>
            </div>
        </form>
    </body>

    </html>
<?php else: ?>
    <p>User not found or invalid ID.</p>
<?php endif; ?>