<?php 
include 'header.php';

?>

<div class="container">
	<div class="clearfix"></div>
	<div class="lines"></div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">

		</div>
	</div>
	<div class="title-bg">
		<div class="title">Alışveriş Sepetim</div>
	</div>

	<div class="table-responsive">
		<table class="table table-bordered chart">
			<thead>
				<tr>
					<th>Remove</th>
					<th>Ürün Resim</th>
					<th>Ürün Ad</th>
					<th>Ürün Kodu</th>
					<th>Adet</th>
					<th>Toplam Fiyat</th>
				</tr>
			</thead>
			<tbody>

				<?php 

				$kullanici_id=$kullanicicek['kullanici_id'];

				$sepetsor=$db->prepare("SELECT * from sepet where kullanici_id=:id");
				$sepetsor->execute(array(
					'id' => $kullanici_id
				));



				while($sepetcek=$sepetsor->fetch(PDO::FETCH_ASSOC)) {

					$urun_id=$sepetcek['urun_id'];
					$urunsor=$db->prepare("SELECT * from urun where urun_id=:urun_id");
					$urunsor->execute(array(
						'urun_id' => $urun_id
					));

					$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
					// $toplam_fiyat+=$uruncek['urun_fiyat']*$sepetcek['urun_adet'];  ==> HEADERDAN toplam_fiyat değişkeni geliyor

					?>

					<tr>
						<td><form><input type="checkbox"></form></td>
						<td><img src="images\demo-img.jpg" width="100" alt=""></td>
						<td><?php echo $uruncek['urun_ad'] ?></td>
						<td><?php echo $uruncek['urun_id'] ?></td>
						<td><form><input type="text" class="form-control quantity" value="<?php echo $sepetcek['urun_adet'] ?>" disabled=' '>
						<td>
							<?php

							// echo $uruncek['urun_fiyat']

							echo $uruncek['urun_fiyat']*$sepetcek['urun_adet']


							?></td>
						</tr>

					<?php } ?>

				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-md-6">

			</div>
			<div class="col-md-3 col-md-offset-3">
				<div class="subtotal-wrap">
				<!--
				<div class="subtotal">
					<p>Toplam Fiyat : $26.00</p>
					<p>Vat 17% : $54.00</p>
				</div>
			-->
			<div class="total">Ödenecek Tutar : <span class="bigprice"><?php echo $toplam_fiyat ?></span></div>
			<div class="clearfix"></div>
			<a href="odeme" class="btn btn-default btn-yellow">Ödeme Sayfası</a>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="spacer"></div>
</div>

<?php include 'footer.php'; ?>