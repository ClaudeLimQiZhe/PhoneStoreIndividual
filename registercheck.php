<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "phone_shop";
 
$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    if(isset($_POST["register"]))
    {
                $Regis_Username = $_POST['Regis_Username'];
                $Regis_Email = $_POST['Regis_Email'];
                $Regis_Password = $_POST['Regis_Password'];
                $Regis_FirstName = $_POST['Regis_FirstName'];
                $Regis_LastName = $_POST['Regis_LastName'];
                $Regis_ContactNumber = $_POST['Regis_ContactNumber'];
                $Regis_Gender = $_POST['Regis_Gender'];
                $Regis_AddressLine1 = $_POST['Regis_AddressLine1'];
                $Regis_AddressLine2 = $_POST['Regis_AddressLine2'];
                $Regis_City = $_POST['Regis_City'];
                $Regis_State = $_POST['Regis_State'];
                $Regis_Postcode = $_POST['Regis_Postcode'];
                $Regis_Country = $_POST['Regis_Country'];

                // Check if username and email already exists
                $check_sql = "SELECT * FROM register WHERE Regis_Username = '$Regis_Username' OR Regis_Email = '$Regis_Email' OR Regis_Password = '$Regis_Password'";
                $check_result = mysqli_query($conn, $check_sql);

                    if (empty($Regis_Username) || empty($Regis_Email) || empty($Regis_Password))
                    {
                        echo "<script>window.history.back();</script>";
                        exit();
                    }
                        else if(strlen($Regis_Password) > 12)
                        {
                            echo "<script>window.history.back();</script>";
                            exit();
                        }
                            else 
                            {
                                if (mysqli_num_rows($check_result) > 0) 
                                {
                                    echo "<script>alert('This user already registered. Please type another username, email, or password.'); window.history.back();</script>";
                                    exit();
                                }
                                    else
                                    {
                                    $insert_sql =  "INSERT INTO register (Regis_Username, 
                                                                    Regis_Email, 
                                                                    Regis_Password, 
                                                                    Regis_FirstName, 
                                                                    Regis_LastName, 
                                                                    Regis_ContactNumber, 
                                                                    Regis_Gender, 
                                                                    Regis_AddressLine1, 
                                                                    Regis_AddressLine2, 
                                                                    Regis_City, 
                                                                    Regis_State, 
                                                                    Regis_Postcode, 
                                                                    Regis_Country) 
                                                        VALUES ('$Regis_Username', 
                                                                '$Regis_Email', 
                                                                '$Regis_Password', 
                                                                '$Regis_FirstName', 
                                                                '$Regis_LastName', 
                                                                '$Regis_ContactNumber', 
                                                                '$Regis_Gender', 
                                                                '$Regis_AddressLine1', 
                                                                '$Regis_AddressLine2', 
                                                                '$Regis_City', 
                                                                '$Regis_State', 
                                                                '$Regis_Postcode', 
                                                                '$Regis_Country')";
                                    }
                                        if (mysqli_query($conn, $insert_sql)) 
                                        {
                                            echo "<script>alert('Register Successfully.'); window.location.href = 'login.php';</script>";
                                            //header("Location: login.html");
                                            exit();
                                        } 
                                            else 
                                            {
                                            echo "Error: " . mysqli_error($conn);
                                            }
                        }
    }
?>