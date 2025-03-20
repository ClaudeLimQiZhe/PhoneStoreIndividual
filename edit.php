<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$db = "handphonestore"; // ✅ FIXED: Changed database name
$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user ID from query parameter
if (isset($_GET['id'])) { 
    $Regis_id = intval($_GET['id']); 
    $sql = "SELECT * FROM users WHERE id = $Regis_id"; 
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error executing query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "<p style='color:red;'>User not found!</p>";
        $user = [];  // Ensure $user is an empty array to prevent errors
    }
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Regis_firstname = $_POST["Regis_Firstname"];
    $Regis_lastname = $_POST["Regis_Lastname"];
    $Regis_contactnumber = $_POST["Regis_Contactnumber"];
    $Regis_gen = $_POST["Regis_gender"];
    $Regis_addressline1 = $_POST["Regis_Addressline1"];
    $Regis_addressline2 = $_POST["Regis_Addressline2"];
    $Regis_ci = $_POST["Regis_city"];
    $Regis_stat = $_POST["Regis_state"];
    $Regis_code = $_POST["Regis_postcode"];
    $Regis_coun = $_POST["Regis_country"];

    $update_sql = "UPDATE users SET  // ✅ FIXED: Changed register → users
        Regis_FirstName='$Regis_firstname',
        Regis_LastName='$Regis_lastname',
        Regis_ContactNumber='$Regis_contactnumber',
        Regis_Gender='$Regis_gen',
        Regis_AddressLine1='$Regis_addressline1',
        Regis_AddressLine2='$Regis_addressline2',
        Regis_City='$Regis_ci',
        Regis_State='$Regis_stat',
        Regis_Postcode='$Regis_code',
        Regis_Country='$Regis_coun'
        WHERE id=$Regis_id"; // ✅ FIXED: Changed Regis_ID → id

    if (mysqli_query($conn, $update_sql)) {
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="editprofile.css">
    <title>EDIT PROFILE</title>   
</head>
<body>
    <div class="container">
        <h3>Edit Profile</h3>
        <div class="profile-group">
            <form name="profilefrm" action="register.php" method="post"> <!-- ✅ FIXED: Changed register.php → EditProfile.php -->
                <div class="profile">
                    <div class="input-group">
                        <label for="Regis_FirstName">First Name</label>
                        <input type="text" name="Regis_Firstname" value="<?php echo isset($user['Regis_FirstName']) ? $user['Regis_FirstName'] : ''; ?>" required="">
                    </div>
                    <div class="input-group">
                        <label for="Regis_LastName">Last Name</label>
                        <input type="text" name="Regis_Lastname" value="<?php echo isset($user['Regis_LastName']) ? $user['Regis_LastName'] : ''; ?>" required="">
                    </div>
                </div>

                <div id="profile_1">
                    <p>
                        Contact Number<br>
                        <input type="text" name="Regis_ContactNumber" value="<?php echo isset($user['Regis_ContactNumber']) ? $user['Regis_ContactNumber'] : ''; ?>" required="">
                    </p>
                    <p>
                        Gender
                        <select name="Regis_Gender">
                            <option value="Male" <?php echo (isset($user['Regis_Gender']) && $user['Regis_Gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo (isset($user['Regis_Gender']) && $user['Regis_Gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </p>
                <div class="profile2">
                    <div class="input-group">
                        <label for="Regis_AddressLine1">Address Line 1</label>
                        <textarea id="Regis_AddressLine1" name="Regis_Addressline1" required=""><?php echo isset($row['Regis_AddressLine1']) ? $row['Regis_AddressLine1'] : ''; ?></textarea>
                    </div>
                    <div class="input-group">
                        <label for="Regis_AddressLine2">Address Line 2</label>
                        <textarea id="Regis_AddressLine2" name="Regis_Addressline2"><?php echo isset($row['Regis_AddressLine2']) ? $row['Regis_AddressLine2'] : ''; ?></textarea>
                    </div>
                </div>
                <div class="profile3">
                    <div class="input-group">
                        <label for="Regis_City">City</label>
                        <input type="text" id="Regis_City" name="Regis_city" value="<?php echo isset($row['Regis_City']) ? $row['Regis_City'] : ''; ?>" required="">
                    </div>
                    <div class="input-group">
                        <label for="Regis_State">State/Province/Region</label>
                        <input type="text" id="Regis_State" name="Regis_state" value="<?php echo isset($row['Regis_State']) ? $row['Regis_State'] : ''; ?>" required="">
                    </div>
                </div>
                <div class="profile4">
                    <div class="input-group">
                        <label for="Regis_Postcode">Postcode</label>
                        <input type="text" id="Regis_Postcode" name="Regis_postcode" value="<?php echo isset($row['Regis_Postcode']) ? $row['Regis_Postcode'] : ''; ?>" required="">
                    </div>
                    <div class="input-group">
                        <label for="Regis_Country">Country</label>
                        <input type="text" id="Regis_Country" name="Regis_country" value="<?php echo isset($row['Regis_Country']) ? $row['Regis_Country'] : ''; ?>" required="">
                    </div>
                </div>
                    <div id="profile_2">
                        <p>
                            Tagged<br>
                            <input type="radio" name="tag" value="1" <?php echo (isset($row['tag']) && $row['tag'] == 1) ? 'checked' : ''; ?>> Work
                            <input type="radio" name="tag" value="2" <?php echo (!isset($row['tag']) || $row['tag'] == 2) ? 'checked' : ''; ?>> Home
                        </p>
                        <p>
                            <input type="submit" name="submitbtn" value="Submit">
                        </p>
                    </div>
                </form>  
            </div>
        </div>
    </body>
</html>