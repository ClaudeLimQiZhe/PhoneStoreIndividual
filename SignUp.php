<?php
    $page_title = "Sign Up";
    include_once 'header.php'
?>

<link rel="stylesheet" href="css/styles.css">

<div class="signup-container">
    <h2>Sign Up</h2>
    <form id="signup-form">
        <input type="text" id="username" name="username" placeholder="Username" class="input-field" required>
        <input type="email" id="email" name="email" placeholder="Email" class="input-field" required>
        <input type="password" id="password" name="password" placeholder="Password" class="input-field" required>
        <button type="submit" class="signup-button">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php" class="login-link">Login</a></p>
</div>

<script>
document.getElementById("signup-form").addEventListener("submit", function(event) {
    event.preventDefault();

    let username = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    fetch("signup_process.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, email, password })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            window.location.href = "login.php";
        }
    })
    .catch(error => console.error("Error:", error));
});
</script>

<?php
    include_once 'footer.php'
?>