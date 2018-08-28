<?php 
include 'header.php';


                     $sayfada = 6; // sayfada gösterilecek içerik miktarını belirtiyoruz.
                     $sorgu=$db->prepare("SELECT * FROM urun");
                     $sorgu->execute();
                     $toplam_icerik=$sorgu->rowCount();
                     $toplam_sayfa = ceil($toplam_icerik / $sayfada);
                  // eğer sayfa girilmemişse 1 varsayalım.
                     $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
          // eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
                     if($sayfa < 1) $sayfa = 1; 
        // toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
                     if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 
                     $limit = ($sayfa - 1) * $sayfada;
                     //aşağısı bir önceki default kodumuz...
                     if (isset($_GET['sef'])) {
                       $kategorisor=$db->prepare("SELECT * FROM kategori where kategori_seourl=:seourl");
                       $kategorisor->execute(array(
                        'seourl' => $_GET['sef']
                      ));
                       $kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC);
                       $kategori_id=$kategoricek['kategori_id'];
                       $urunsor=$db->prepare("SELECT * FROM urun where kategori_id=:kategori_id order by urun_id DESC limit $limit,$sayfada");
                       $urunsor->execute(array(
                        'kategori_id' => $kategori_id
                      ));
                       $say=$urunsor->rowCount();
                     } else {
                       $urunsor=$db->prepare("SELECT * FROM urun order by urun_id DESC limit $limit,$sayfada");
                       $urunsor->execute();
                     }
                     
                      if ($kategoricek['kategori_ad']) { ?>

                     <head>

                      <title><?php echo $kategoricek['kategori_ad'] ?></title>

                    </head>
                  <?php } else {?>
                   <head>

                      <title>Kategori Sayfası</title>

                    </head>
                  <?php } ?>


                    <div class="container">
                      <div class="clearfix"></div>
                      <div class="lines"></div>
                    </div>
                    <div class="container">
                      <div class="row">
                       <div class="col-md-9"><!--Main content-->
                        <div class="title-bg">
                         <div class="title">Ürünler</div>
                         <div class="title-nav">
                          <a href="javascripti:void(0);"><i class="fa fa-th-large"></i>grid</a>
                          <a href="javascripti:void(0);"><i class="fa fa-bars"></i>List</a>
                        </div>
                      </div>
                      <div class="row prdct"><!--Products-->

                        <?php 
                        $say=$urunsor->rowCount();
                        if ($say==0) {
                         echo "Bu kategoride ürün bulunamadı";
                       }
                       while($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) {

                         $urun_id=$uruncek['urun_id'];
                         $urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:urun_id order by urunfoto_sira ASC limit 1");
                         $urunfotosor->execute(array(
                          'urun_id' => $urun_id
                        ));

                         $urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC);



                         ?>

                         <div class="col-md-4">
                          <div class="productwrap">
                           <div class="pr-img">
                            <div class="hot"></div>
                            <center><a href="urun-<?=seo($uruncek["urun_ad"]).'-'.$uruncek["urun_id"]?>"><img width="200" height="200" src="<?php echo $urunfotocek['urunfoto_resimyol'] ?>" alt="" class="img-rounded"></a></center>
                            <div class="pricetag blue"><div class="inner"><span><?php echo $uruncek['urun_fiyat'] ?> TL</span></div></div>
                          </div>
                          <span class="smalltitle"><a href="urun-<?=seo($uruncek["urun_ad"]).'-'.$uruncek["urun_id"]?>"><?php echo substr($uruncek['urun_ad'],0,18)."..."; ?></a></span>
                          <span class="smalldesc">Ürün Kodu.: <?php echo $uruncek['urun_id'] ?></span>
                        </div>
                      </div>


                    <?php } ?>

                    <div align="right" class="col-md-12">
                      <?php 

                      if ($kategoricek['kategori_ad']) { ?>

                       <ul class="pagination">
                        <?php 

                        $s=0;

                        while ($s < $toplam_sayfa) {

                         $s++; ?>

                         <?php 

                         if ($s==$sayfa) {?>

                          <li class="active">

                           <a href="kategori-<?=seo($kategoricek['kategori_ad']); ?>?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

                         </li>

                       <?php } else {?>


                        <li>

                         <a href="kategori-<?=seo($kategoricek['kategori_ad']); ?>?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

                       </li>

                     <?php   }


                   }
                   ?>
                 </ul>

               <?php } else { ?>
                <ul class="pagination">
                 <?php for($i = 1; $i <= $toplam_sayfa; $i++) { 
                  if ($i==$sayfa) { ?>
                   <li class="active">
                    <a href="kategoriler?sayfa=<?php echo $i; ?>"><?php echo $i; ?></a>
                  </li>
                <?php } else {?>
                 <li>
                   <a href="kategoriler?sayfa=<?php echo $i; ?>"><?php echo $i; ?></a>
                 </li>
               <?php } } } ?>
             </ul>
           </div>
         </div><!--Products-->
<!-- 
 <ul class="pagination shop-pag">
 <li><a href="#"><i class="fa fa-caret-left"></i></a></li>
 <li><a href="#">1</a></li>
 <li><a href="#">2</a></li>
 <li><a href="#">3</a></li>
 <li><a href="#">4</a></li>
 <li><a href="#">5</a></li>
 <li><a href="#"><i class="fa fa-caret-right"></i></a></li>
</ul> -->
</div>
<?php include 'sidebar.php' ?>
</div>
<div class="spacer"></div>
</div>

<?php include 'footer.php'; ?>