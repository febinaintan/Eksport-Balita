<?php 
include 'koneksi.php';

if(isset($_POST['signUp'])){
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hanya menggunakan password_hash()

    $checkEmail = "SELECT * FROM register WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if($result->num_rows > 0){
        echo "Email Address Already Exists!";
    } else {
        $insertQuery = "INSERT INTO register (firstName, lastName, email, password)
                        VALUES ('$firstName', '$lastName', '$email', '$password')";
        if($conn->query($insertQuery) === TRUE){
            header("Location: homepage.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM register WHERE email='$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        session_start();
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])){ // Menggunakan password_verify() untuk memeriksa password
            $_SESSION['email'] = true;
            header("Location: homepage.php");
            exit();
        } else {
            echo "Incorrect Email or Password";
        }
    } else {
        echo "Email not found";
    }
}
?>