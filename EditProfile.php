<?php
$page_title = "Profile Edit";
$custom_css = "editprofile.css";
include_once 'header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("<p style='color:red;'>Access denied. Please log in.</p>");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phone_shop";

// Database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user ID from session
$user_id = $_SESSION['user_id'];
$user = [];

if (isset($_GET['id']) && $_GET['id'] != $user_id) {
    die("<p style='color:red;'>Access denied. You are not authorized to view this profile.</p>");
}

// Fetch user data
$sql = "SELECT * FROM register WHERE Regis_ID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    die("<p style='color:red;'>Error: User not found!</p>");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Regis_firstname = mysqli_real_escape_string($conn, $_POST["Regis_Firstname"]);
    $Regis_lastname = mysqli_real_escape_string($conn, $_POST["Regis_Lastname"]);
    $Regis_contactnumber = mysqli_real_escape_string($conn, $_POST["Regis_Contactnumber"]);
    $Regis_gen = mysqli_real_escape_string($conn, $_POST["Regis_gender"]);
    $Regis_addressline1 = mysqli_real_escape_string($conn, $_POST["Regis_Addressline1"]);
    $Regis_addressline2 = mysqli_real_escape_string($conn, $_POST["Regis_Addressline2"]);
    $Regis_ci = mysqli_real_escape_string($conn, $_POST["Regis_city"]);
    $Regis_stat = mysqli_real_escape_string($conn, $_POST["Regis_state"]);
    $Regis_code = mysqli_real_escape_string($conn, $_POST["Regis_postcode"]);
    $Regis_coun = mysqli_real_escape_string($conn, $_POST["Regis_country"]);

    // Update query using prepared statements
    $update_sql = "UPDATE register SET 
        Regis_FirstName = ?, 
        Regis_LastName = ?, 
        Regis_ContactNumber = ?, 
        Regis_Gender = ?, 
        Regis_AddressLine1 = ?, 
        Regis_AddressLine2 = ?, 
        Regis_City = ?, 
        Regis_State = ?, 
        Regis_Postcode = ?, 
        Regis_Country = ?
        WHERE Regis_ID = ?";

    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "ssssssssisi", 
        $Regis_firstname, $Regis_lastname, $Regis_contactnumber, $Regis_gen, 
        $Regis_addressline1, $Regis_addressline2, $Regis_ci, $Regis_stat, 
        $Regis_code, $Regis_coun, $user_id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: EditProfile.php?success=1");
        exit();
    } else {
        die("<p style='color:red;'>Error updating profile: " . mysqli_error($conn) . "</p>");
    }
}

mysqli_close($conn);
?>

    <div class="container">
        <?php if (isset($_GET['success'])): ?>
            <script>alert('Updated Profile Succesfully!'); window.location.href = 'index.php';</script>";
        <?php endif; ?>
        <div class="profile-group">
        <h3>Edit Profile</h3>
            <form name="profilefrm" method="POST">
                <div class="profile">
                    <div class="input-group">
                        <label for="Regis_FirstName">First Name</label>
                        <input type="text" id="Regis_FirstName" name="Regis_Firstname" value="<?php echo htmlspecialchars($user['Regis_FirstName'] ?? ''); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="Regis_LastName">Last Name</label>
                        <input type="text" id="Regis_LastName" name="Regis_Lastname" value="<?php echo htmlspecialchars($user['Regis_LastName'] ?? ''); ?>" required>
                    </div>
                </div>

                <div id="profile_1">
                    <p>
                        Contact Number<br>
                        <input type="tel" id="Regis_ContactNumber" name="Regis_Contactnumber" value="<?php echo htmlspecialchars($user['Regis_ContactNumber'] ?? ''); ?>" required>
                    </p>
                    <p>
                        Gender
                        <select name="Regis_gender" id="Regis_Gender">
                            <option value="Male" <?php echo ($user['Regis_Gender'] ?? '') == 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($user['Regis_Gender'] ?? '') == 'Female' ? 'selected' : ''; ?>>Female</option>
                            <option value="Others" <?php echo ($user['Regis_Gender'] ?? '') == 'Others' ? 'selected' : ''; ?>>Others</option>
                        </select>
                    </p>
                </div>
                
                <div class="profile2">
                        <div class="input-group">
                            <label for="Regis_AddressLine1">Address Line 1</label>
                            <textarea id="Regis_AddressLine1" name="Regis_Addressline1" required><?php echo htmlspecialchars($user['Regis_AddressLine1'] ?? ''); ?></textarea>
                        </div>
                        <div class="input-group">
                            <label for="Regis_AddressLine2">Address Line 2</label>
                            <textarea id="Regis_AddressLine2" name="Regis_Addressline2"><?php echo htmlspecialchars($user['Regis_AddressLine2'] ?? ''); ?></textarea>
                        </div>
                </div>

                <div class="profile3">
                    <div class="input-group">
                        <label for="Regis_City">City</label>
                        <input type="text" id="Regis_City" name="Regis_city" value="<?php echo htmlspecialchars($user['Regis_City'] ?? ''); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="Regis_State">State/Province/Region</label>
                        <input type="text" id="Regis_State" name="Regis_state" value="<?php echo htmlspecialchars($user['Regis_State'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="profile4">
                    <div class="input-group">
                        <label for="Regis_Postcode">Postcode</label>
                        <input type="text" id="Regis_Postcode" name="Regis_postcode" value="<?php echo htmlspecialchars($user['Regis_Postcode'] ?? ''); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="Regis_Country">Country</label>
                        <input type="text" id="Regis_Country" name="Regis_country" value="<?php echo htmlspecialchars($user['Regis_Country'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="profile_2">
                    <div class="input-group">
                        <label for="Regis_Tagged">Tagged</label><br>
                        <input type="radio" name="tag" value="1"> Work
                        <input type="radio" name="tag" value="2" checked> Home
                    </div>
                </div>
                    <button type="submit" class="back-button">Submit</button>
            </form>  
        </div>
    </div>
</body>
</html>

<?php
    include_once 'footer.php';
?>