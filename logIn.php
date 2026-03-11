<?php
session_start();
if (isset($_SESSION['unique_id']) && isset($_SESSION['is_approved']) && isset($_SESSION['role']) && $_SESSION['role'] != 0) {
  header("location: HomePage1.php");
  exit();
}

include_once "./PHP/config.php";

// ====================== Register Logic =====================
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = isset($_POST['role']) ? 'consultant' : 'user';
  $approved = ($role === 'consultant') ? 0 : 1;

  if (!empty($username) && !empty($email) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $check_email_exist_dml = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' ");
      if (mysqli_num_rows($check_email_exist_dml) > 0) {
        $login_message = "⚠️ $email - This email already registered.";
      } else {
        $ran_id = rand(time(), 100000000);
        $status = "Online";
        $encrypt_pass = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (unique_id, username, email, password, role, is_approved, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssis", $ran_id, $username, $email, $encrypt_pass, $role, $approved, $status);
        $stmt->execute();

        if ($stmt) {
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
          if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            $register_message = ($role === 'consultant')
              ? "✅ Registration successful. Please wait for admin approval."
              : "✅ Registration successful. You can log in now.";
          } else {
            $login_message = "⚠️ This email address does not exist.";
          }
        }
      }
    } else {
      $login_message = "⚠️ $email is not a valid email.";
    }
  } else {
    $login_message = "⚠️ All input fields are required!";
  }
}


// ====================== Login Logic =====================
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
  $email = $_POST['log_email'];
  $password = $_POST['log_password'];
  $role = isset($_POST['log_role']) ? 'consultant' : 'user';

  if (!empty($email) && !empty($password)) {
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");

    if (mysqli_num_rows($sql) > 0) {
      $row = mysqli_fetch_assoc($sql);
      $enc_pass = $row['password'];
      $user_approval = $row['is_approved'];
      $user_role = $row['role'];

      if ($user_role !== $role) {
        // Role mismatch warning
        if ($role === 'consultant') {
          $login_message = "❌ $email - This email didn't apply to be a consultant.";
        } else {
          $login_message = "❌ $email - This email applied to be a consultant.";
        }
      } elseif (!password_verify($password, $enc_pass)) {
        // Password incorrect
        $login_message = "❌ Invalid email or password.";
      } elseif ($role === 'consultant' && $user_approval == 0) {
        // Consultant not approved
        $login_message = "⏳ Your consultant account is pending admin approval.";
      } elseif ($user_approval == 1) {
        // Login successful
        $status = "Online";
        $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
        if ($sql2) {
          $_SESSION['unique_id'] = $row['unique_id'];
          $_SESSION['is_approved'] = $row['is_approved'];
          $_SESSION['role'] = $row['role'];
          header("location: HomePage1.php");
          exit();
        } else {
          $login_message = "⚠️ Something went wrong. Please try again.";
        }
      } else {
        $login_message = "❌ Your account is not approved yet.";
      }
    } else {
      $login_message = "⚠️ $email - This email does not exist.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login / Register</title>
  <link rel="stylesheet" href="./CSS/logIn.css">
  <link rel="stylesheet" href="./CSS/utility.css">
</head>

<body>

  <div class="main">
    <input type="checkbox" id="chk" aria-hidden="true" />

    <!-- Login Form -->
    <div class="login">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="chk" class="label">Log in</label>
        <?php if (isset($login_message)) echo "<div class='message'>$login_message</div>"; ?>
        <input class="input" type="email" name="log_email" placeholder="Email" required />
        <input class="input" type="password" name="log_password" placeholder="Password" required />
        <div class="checkbox">
          <input type="checkbox" id="login-role" name="log_role" value="consultant" />
          <label for="login-role">Log in as Consultant</label>
        </div>
        <button type="submit" name="login">Log in</button>
      </form>
      <label for="chk" class="switch-btn">Register</label>
    </div>

    <!-- Register Form -->
    <div action="<?php echo $_SERVER['PHP_SELF']; ?>" class="register">
      <form method="post">
        <label for="chk" class="label">Register</label>
        <?php if (isset($register_message)) echo "<div class='message'>$register_message</div>"; ?>
        <input class="input" type="text" name="username" placeholder="Username" required />
        <input class="input" type="email" name="email" placeholder="Email" required />
        <input class="input" type="password" name="password" placeholder="Password" required />
        <div class="checkbox">
          <input type="checkbox" id="register-role" name="role" value="consultant" />
          <label for="register-role">Sign up as Consultant</label>
        </div>
        <button type="submit" name="register">Register</button>
      </form>
      <label for="chk" class="switch-btn">Log in</label>
    </div>
  </div>

</body>

</html>