<?php
class AuthController {
 private $users; public function __construct($pdo){$this->users=new User($pdo);}
 public function login(){ $error=''; if($_SERVER['REQUEST_METHOD']==='POST'){ $u=$this->users->findByEmail(trim($_POST['email']??'')); if($u&&password_verify($_POST['password']??'',$u['password'])){session_regenerate_id(true);$_SESSION['user_id']=$u['id'];$_SESSION['user_nama']=$u['nama'];$_SESSION['user_role']=$u['role'];header('Location: index.php');exit;} $error='Email atau password salah';} include __DIR__.'/../views/auth/login.php'; }
 public function signup(){ $error=''; if($_SERVER['REQUEST_METHOD']==='POST'){ $nama=trim($_POST['nama']??'');$email=trim($_POST['email']??'');$pw=$_POST['password']??''; if(!$nama||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($pw)<6)$error='Nama, email valid, dan password minimal 6 karakter wajib diisi'; elseif($this->users->findByEmail($email))$error='Email sudah terdaftar'; else{$this->users->create($nama,$email,password_hash($pw,PASSWORD_DEFAULT));$_SESSION['flash']='Signup berhasil, silakan login';header('Location: index.php?page=login');exit;}} include __DIR__.'/../views/auth/signup.php'; }
 public function logout(){$_SESSION=[];session_destroy();header('Location: index.php?page=login');exit;}
}
?>
