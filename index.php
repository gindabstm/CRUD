<?php 
	//koneksi Database
	$server = "localhost";
	$user	= "root";
	$pas	= "";
	$database = "dbnst";

	$koneksi = mysqli_connect($server, $user, $pas, $database)or die(mysqli_error($koneksi));


	//jika tombol simpan di klik
	if(isset($_POST['bsimpan']))
	{
			//pengujian apakah data akan di edit atau di simpan baru
		if($_GET['hal'] == "edit")
		{
			//data akan di edit
			$edit = mysqli_query($koneksi, " UPDATE tmnst_1 set
												 id_nst = '$_POST[tcode]',
												 nama = '$_POST[tnama]',
												 region = '$_POST[treg]',
												 fb = '$_POST[tfb]'
											WHERE id_nst = '$_GET[id]'
										   ");
					if($edit) //jika edit sukses
					{
						echo "<script>
								alert('edit Data Sukses');
								document.location = 'index.php';
							  </script>";
						}
						else
						{
							echo "<script>
									alert('edit Data Gagal');
									document.location = 'index.php';
								  </script>";
			}
		}
		else{
			//data akan di simpan baru
				$simpan = mysqli_query($koneksi, "INSERT INTO tmnst_1 (id_nst, nama, region, fb)
											 VALUES ('$_POST[tcode]', 
											 		'$_POST[tnama]', 
											 		'$_POST[treg]', 
											 		'$_POST[tfb]')
										 ");
					if($simpan) //jika simpan sukses
					{
						echo "<script>
								alert('Simpan Data Sukses');
								document.location = 'index.php';
							  </script>";
						}
						else
						{
							echo "<script>
									alert('Simpan Data Gagal');
									document.location = 'index.php';
								  </script>";
			}
		}

	}


	//pengujian jika tombol update di klik
	if (isset($_GET['hal']))
	{
		//tampilkan data yang akan di edit
		if($_GET['hal'] == "edit")
		{
			//tampilkan data yang akan di edit
			$tampil = mysqli_query($koneksi, "SELECT * FROM tmnst_1 WHERE id_nst = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//jika data di temukan, maka data di tampung ke dalam variabel
				$vid_nst = $data['id_nst'];
	  		    $vnama = $data['nama'];
	  			$vregion =$data['region'];
	  		    $vfb=$data['fb'];
			}

		}
		else if ($_GET['hal'] == "hapus")
		{
			//persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM tmnst_1 WHERE id_nst = '$_GET[id]' ");
			if ($hapus) {
			    echo "<script>
					alert('hapus data sukses');
					document.location = 'index.php';
					</script>";
			}
		}
	}
	

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>CRUD PHP & MYSQL + Bootstrap 4</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
	<h1 class="text-center">Data Member NSTEAM</h1>

	<!--Awal Card Form-->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Input Data Member
	  </div>
	  <div class="card-body">
	  	<form method="post" action="">
	  		<div class="form-group">
	  			<label>NST Code</label>
	  			<input type="text" name="tcode" value="<?=@$vid_nst?>" class="form-control" placeholder="Input code anda disini" required="">

	  		</div>
	  			<div class="form-group">
	  			<label>Nama Lengkap</label>
	  			<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama anda disini" required="">

	  		</div>
	  			<div class="form-group">
	  			<label>Region</label>
	  			<input type="text" name="treg" value="<?=@$vregion?>" class="form-control" placeholder="Input Region anda disini" required="">

	  		</div>
	  			 <div class="form-group">
	  			<label>Link Facebook</label>
	  			<input type="text" name="tfb" value="<?=@$vfb?>" class="form-control" placeholder="Input link fb anda disini" required="">

	  		</div>
	  			<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
	  			<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	  	</form>
	    
	  </div>
	</div>
	<!--Akhir Card Form-->

	<!--Awal Card tabel-->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftar Member
	  </div>
	  <div class="card-body">
	  	
	  		<table class="table table-bordered table-striped">
	  			<tr>
	  				<th>No</th>
	  				<th>NST Code</th>
	  				<th>Nama Lengkap</th>
	  				<th>Region</th>
	  				<th>Link Facebook</th>
	  				<th>Aksi</th>
	  			</tr>
	  			<?php
	  				$no=1;
	  				$tampil = mysqli_query($koneksi, "SELECT * from tmnst_1 order by id_nst desc ");
	  				while ($data = mysqli_fetch_array($tampil)) :
	  			?>
	  			<tr>
	  				<td><?=$no++?></td>
	  				<td><?=$data['id_nst']?></td>
	  				<td><?=$data['nama']?></td>
	  				<td><?=$data['region']?></td>
	  				<td><?=$data['fb']?></td>
	  				<td>
	  					<a href="index.php?hal=edit&id=<?=$data['id_nst']?>" class="btn btn-success">Update</a>
	  					<a href="index.php?=hapus&id=<?=$data['id_nst']?>" 
	  					onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger">Delete</a>
	  				</td>
	  			</tr>
	  		<?php endwhile; //penutup perulangan?>
	  		</table>

	  </div>
	</div>
	<!--Akhir Card tabel-->
	</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>