<?php
    $page_title = "Sign Up";
    $custom_css = "register.css";
    include_once 'header.php';
?>

            <hr>
                <div class="register">
                    <form name="registerfrm" action="registercheck.php" method="post" onsubmit="validateForm()">
                        <h3>
                        Register
                        </h3> 
                            <p>
                                <input type="text" id = "Regis_Username" name = "Regis_Username" placeholder="Type your username here"/>
                            </p>   
                                <p>
                                    <input type="email" id = "Regis_Email" name = "Regis_Email" placeholder="Type your email here"/>
                                </p>
                                    <p>
                                        <input type="password" id = "Regis_Password" name = "Regis_Password" placeholder="Type your password here"/>
                                        <img src="img/hidden.png" id="togglePassword" style="cursor: pointer;" alt="Show Password">
                                    </p>
                    
                        <p>
                            <div class="login">
                                    <label>
                                        <input type="checkbox" id="remember-me">Remember Me 
                                    </label>
                                    <a href="login.php">Already have an account? Login</a>
                            </div>
                        </p>

                        <div id="register-buttons">
                            <input type="submit" name="register" value="Register" class="back-button">
                        </div>
                            <a href="https://accounts.google.com">Google Register</a>
                            <a href="https://www.facebook.com">Facebook Register</a>
                    </form>
                </div>
                <div id="loading-spinner" style="display: none;">
                    <img src="img/spinner.gif" alt="Loading...">
                </div>
                
                <script>
                    // Toggle password visibility
                    document.getElementById('togglePassword').addEventListener('click', function() {
                        const passwordField = document.getElementById('Regis_Password');
                        if (passwordField.type === 'password') {
                            passwordField.type = 'word';
                            this.src = 'img/view.png'; // Change to hide icon
                        } else {
                            passwordField.type = 'password';
                            this.src = 'img/hidden.png'; // Change to show icon
                        }
                    });

                    // Check if there's a saved username/email in local storage and fill the input field
                    var savedUsername = localStorage.getItem('rememberedUsername');
                    if (savedUsername) {
                        document.getElementById('Regis_Username').value = savedUsername;
                    }
            
                    function validateForm() {
                        var username = document.getElementById("Regis_Username").value;
                        var email = document.getElementById("Regis_Email").value;
                        var password = document.getElementById("Regis_Password").value;
                        var rememberMeCheckbox = document.getElementById("remember-me");;
            
                        if (rememberMeCheckbox.checked) {
                            // Save the username/email to local storage
                            localStorage.setItem('rememberedUsername', username);
                        } else {
                            // Clear the saved username/email from local storage
                            localStorage.removeItem('rememberedUsername');
                        }
            
                        if (username === '' || email === '' || password === '') {
                            alert("Please enter username, email, and password.");
                            return false;
                        }
                        
                        if (password.length > 12) {
                            alert("Password length cannot exceed 12 characters.");
                            return false;
                        }
                        return true;
                    }
                </script>
        </body>
</html>

<?php
    include_once 'footer.php'
?>