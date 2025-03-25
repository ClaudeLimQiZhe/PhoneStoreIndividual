<?php
    $page_title = "Login";
    include_once 'header.php';
?>

<div class="login-container">
    <h2>Login</h2>
    <form id="login-form">
        <input type="text" id="login_input" name="login_input" placeholder="Username or Email" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="/SignUp.php">Sign Up</a></p>
</div>

<script>
document.getElementById("login-form").addEventListener("submit", function(event) {
    event.preventDefault();
    
    let loginInput = document.getElementById("login_input").value;
    let password = document.getElementById("password").value;

    fetch("login_process.php", {  // Now calling the correct file
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ login_input: loginInput, password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});
</script>

<?php
    include_once 'footer.php';
?>
