<h2>Login</h2>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
<div>
    <label>Email</label>
    <input name="email" type="email" required/>
</div>
<div>
    <label>Password</label>
    <input name="password" type="password" required/>
</div>
<div>
    <input type="submit" name="login" value="Login"/>
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

if(isset($_POST['login'])){

    //hae valuet login formista
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;

    //hae account info sähköpostille
    $sql = "SELECT id, email, password FROM users WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user === false) {
        die('Incorrect email and/or password, please try again');
    } else {
        $validPassword = password_verify($passwordAttempt, $user['password']);
        if($validPassword) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();
            header('Location: profile.php');
            exit;
        } else {
            die('Incorrect email and/or password, please try again');
        }
    }
}
