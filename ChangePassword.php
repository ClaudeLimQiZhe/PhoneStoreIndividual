<?php
$page_title = "Password Change";
$custom_css = "changepassword.css";
include_once 'header.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$db = "phone_shop";
$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request is JSON
    if (strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        // Read raw JSON input
        $inputJSON = file_get_contents("php://input");
        error_log("Raw Input JSON: " . $inputJSON); // Log raw input

        $input = json_decode($inputJSON, true);
        error_log("Decoded JSON: " . print_r($input, true)); // Log decoded JSON

        if (!$input || !isset($input['currentpassword']) || !isset($input['newpassword'])) {
            echo json_encode(["success" => false, "message" => "Missing input fields"]);
            exit();
        }
        $currentpassword = $input['currentpassword'];
        $newpassword = $input['newpassword'];
    }else{
        // Handle form submission
        $currentpassword = $_POST['currentpassword'];
        $newpassword = $_POST['newpassword'];
    }
    // Query the database
    $stmt = $conn->prepare("SELECT * FROM register WHERE Regis_Password = ?");
    $stmt->bind_param("s", $currentpassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        error_log("User found: " . print_r($user, true));

        session_start();
        $_SESSION['Regis_id'] = $user['Regis_ID'];
        $update_sql = "UPDATE register SET Regis_Password = '$newpassword' WHERE Regis_ID = " . $user['Regis_ID'];

        if (mysqli_query($conn, $update_sql)) {
            echo json_encode(["success" => true, "message" => "Change Password updated successfully."]);
            exit();
        } else {
            echo json_encode(["success" => false, "message" => "Error updating Change Password: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Current password is incorrect."]);
    }   
}
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <link rel="stylesheet" type="text/css" href="changepassword.css">
        <title>CHANGE PASSWORD</title>  
        <script>
        function validatePasswords() {
            var newPassword = document.getElementById("newpassword").value;
            var newPasswordAgain = document.getElementById("newpasswordagain").value;
            console.log("New Password: " + newPassword);
            console.log("New Password Again: " + newPasswordAgain);
            if (newPassword !== newPasswordAgain) {
                alert("New passwords do not match. Please try again.");
                return false;
            }
            return true;
        }

        function handleResponse(response) {
            if (response.success) {
                alert(response.message);
                window.location.href = 'index.php'; // Redirect to home page
            } else {
                alert(response.message);
            }
        }

        async function submitForm(event) {
            event.preventDefault();
            if (validatePasswords()) {
                const formData = new FormData(event.target);
                const data = Object.fromEntries(formData.entries());
                const response = await fetch(event.target.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                handleResponse(result);
            }
        }
        </script>
    </head>
    <body>
        <div id="change">
            <form name="changefrm" method="POST" onsubmit="submitForm(event)">
            <h3>
                Change Password
            </h3>
                <h4>
                    Enter your current password and your new password
                </h4> 
                    <p>
                        <input type="password" id = "currentpassword" name = "currentpassword" placeholder="Current Password"required/>
                        <img src="img/hidden.png" id="togglePassword1" style="cursor: pointer;" alt="Show Password">
                    </p>
                        <p>
                            <input type="password" id = "newpassword" name = "newpassword" placeholder="New Password"required/>
                            <img src="img/hidden.png" id="togglePassword2" style="cursor: pointer;" alt="Show Password">
                        </p>
                            <p>
                                <input type="password" id = "newpasswordagain" name = "newpasswordagain" placeholder="Enter new password again"required/>
                                <img src="img/hidden.png" id="togglePassword3" style="cursor: pointer;" alt="Show Password">
                            </p>

                            <div class="buttons">
                                <button type="submit" class="back-button">Change Password</button>
                                    <a href="index.php" class="back">Cancel</a>
                            </div>

                            <div class="devices">
                                <label>
                                    <input type="checkbox" name="devices" value="devices"> Log out all other devices
                                </label>
                            </div>
            </form>
        </div>
                <script>
                    // Toggle password visibility
                    document.getElementById('togglePassword1').addEventListener('click', function() {
                        const passwordField = document.getElementById('currentpassword');
                        if (passwordField.type === 'password') {
                            passwordField.type = 'text';
                            this.src = 'img/view.png'; // Change to hide icon
                        } else {
                            passwordField.type = 'password';
                            this.src = 'img/hidden.png'; // Change to show icon
                        }
                    });

                    document.getElementById('togglePassword2').addEventListener('click', function() {
                        const passwordField = document.getElementById('newpassword');
                        if (passwordField.type === 'password') {
                            passwordField.type = 'text';
                            this.src = 'img/view.png'; // Change to hide icon
                        } else {
                            passwordField.type = 'password';
                            this.src = 'img/hidden.png'; // Change to show icon
                        }
                    });

                    document.getElementById('togglePassword3').addEventListener('click', function() {
                        const passwordField = document.getElementById('newpasswordagain');
                        if (passwordField.type === 'password') {
                            passwordField.type = 'text';
                            this.src = 'img/view.png'; // Change to hide icon
                        } else {
                            passwordField.type = 'password';
                            this.src = 'img/hidden.png'; // Change to show icon
                        }
                    });
                </script>
    </body>
</html>

<?php
include_once 'footer.php';
?>