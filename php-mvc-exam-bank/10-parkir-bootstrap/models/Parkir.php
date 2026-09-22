<?php
class Parkir{private PDO $pdo;function __construct(PDO $pdo){$this->pdo=$pdo;}
function aktif(){return $this->pdo->query("SELECT * FROM parkir WHERE status='masuk' ORDER BY waktu_masuk DESC")->fetchAll();}
function cariAktif($plat){$s=$this->pdo->prepare("SELECT * FROM parkir WHERE plat_nomor LIKE ? AND status='masuk' ORDER BY waktu_masuk DESC");$s->execute(['%'.strtoupper($plat).'%']);return $s->fetchAll();}
function masuk($plat,$jenis){$s=$this->pdo->prepare("INSERT INTO parkir(plat_nomor,jenis_roda,waktu_masuk,status) VALUES(?,?,NOW(),'masuk')");return $s->execute([strtoupper($plat),$jenis]);}
function keluar($id,$total){$s=$this->pdo->prepare("UPDATE parkir SET waktu_keluar=NOW(),status='keluar',total_bayar=? WHERE id=? AND status='masuk'");$s->execute([$total,$id]);return $s->rowCount()>0;}
function find($id){$s=$this->pdo->prepare('SELECT * FROM parkir WHERE id=?');$s->execute([$id]);return $s->fetch();}
function laporan($from,$to){$s=$this->pdo->prepare('SELECT * FROM parkir WHERE status="keluar" AND waktu_keluar BETWEEN ? AND ? ORDER BY waktu_keluar DESC');$s->execute([$from.' 00:00:00',$to.' 23:59:59']);return $s->fetchAll();}
function countAktif(){return (int)$this->pdo->query("SELECT COUNT(*) FROM parkir WHERE status='masuk'")->fetchColumn();}
function countHariIni(){return (int)$this->pdo->query("SELECT COUNT(*) FROM parkir WHERE status='keluar' AND DATE(waktu_keluar)=CURDATE()")->fetchColumn();}
function omzetHariIni(){return (int)$this->pdo->query("SELECT COALESCE(SUM(total_bayar),0) FROM parkir WHERE status='keluar' AND DATE(waktu_keluar)=CURDATE()")->fetchColumn();}}
