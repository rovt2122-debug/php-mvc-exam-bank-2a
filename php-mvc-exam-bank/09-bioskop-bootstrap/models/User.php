<?php
class User {
 private $pdo; public function __construct($pdo){$this->pdo=$pdo;}
 public function findByEmail($email){$s=$this->pdo->prepare('SELECT * FROM users WHERE email=?');$s->execute([$email]);return $s->fetch();}
 public function create($nama,$email,$password){$s=$this->pdo->prepare('INSERT INTO users(nama,email,password,role) VALUES(?,?,?,?)');return $s->execute([$nama,$email,$password,'user']);}
}
?>
