<h2>Registration</h2>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
<div>
    <label>Username</label>
    <input name="username" type="text" required/>
</div>
<div>
    <label>Email</label>
    <input name="email" type="email" required/>
</div>
<div>
    <label>Password</label>
    <input name="password" type="password" pattern=".{8,}" title="min 8 merkkiä" required/>
</div>
<div>
    <label>Confirm password</label>
    <input name="confpassword" type="password" required/>
</div>
<div>
    <input type="submit" name="register" value="Register"/>
    <input type="reset" value="Reset"/>
    </br>
    <p>Already a user? Click <a href="login.php">here</a> to login</p>
</div>
</form>

<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webshop";

try{
    $db = new PDO("mysql:host=$servername;dbname=$dbname","$username",$password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    "ERROR: Could not connect. " . $e->getMessage();
}

if(isset($_POST['register'])){
    //hae valuet formista
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $passconf = $_POST['confpassword'];

    if($pass != $passconf) {
      die("The passwords do not match");
    }

    //tarkista onko email jo käytössä
    $sql = "SELECT COUNT(email) AS num FROM customer WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row['num'] > 0){
        die('That email is already registered');
    }

    //enkryptaa salasana
    $passwordhash = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));

    //tallenna tiedot db
    $sql = "INSERT INTO customer (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordhash);
    $result = $stmt->execute();

    if($result){
        echo ("Registration successful, click '<a href=login.php>Here</a>'to login");
    } else {
      echo ("Something went wrong, please try again");
    }

}
?>