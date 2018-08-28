<?php 

try{

	$db=new PDO("mysql:host=localhost;dbname=eticaret;charset=utf8",'root','6lbkdb99k');

// echo "Veritabanı bağlantısı başarılı";

} catch(PDOExpception $e) {
	echo $e->getMessage();
}


 ?>