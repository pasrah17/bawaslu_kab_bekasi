<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:login.php');
}

$_SESSION['nav'] = "master-data";
$_SESSION['nav-page'] = "master-dpd-ri";

require_once('header.php');

require_once('navbar.php');

require_once('sidebar.php');

require_once('koneksi.php');

?>

<main id="main" class="main">

	<div class="pagetitle">
	<h1>Dashboard Master DPD - RI</h1>
	</div>

    <hr/>

	<section class="section">
	<div class="row">
		<div class="col-lg-12">

		<div class="card">
			<div class="card-body">

			<div class="d-flex justify-content-between align-items-center">
				<div class="col-sm-6 mb-6 mb-sm-0">
					<h5 class="card-title">Master DPD - RI</h5>
				</div>
				<div class="col-sm-3 mb-3 mb-sm-0">
					<form>
						<div class="input-group mt-3">
							<input type="text" class="form-control" placeholder="Search ..." aria-describedby="button-addon2" name="cari">
						</div>
					</form>
				</div>
			</div>
			
			<hr/>

			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Kategori Calon Pilihan</th>
						<th scope="col">Kode Partai</th>
						<th scope="col">Nomor Urut</th>
						<th scope="col">Nama Calon Pilihan</th>
						<th scope="col">Jenis Kelamin</th>
						<th scope="col">Daerah Pilihan</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php

					$page = (isset($_GET['page'])) ? $_GET['page'] : 1;

					$limit = 10; // Jumlah data per halamannya

					// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
					$limit_start = ($page - 1) * $limit;

					$No = $limit_start + 1;

					if (isset($_GET['cari'])) {
						$cari = $_GET['cari'];

						if ($cari == "") {
							$q = "SELECT id, kategori_capil, kode_partai, no_urut, nama_capil, jenis_kelamin, dapil, status FROM db_master_capil WHERE kategori_capil = 'DPD-RI' ORDER BY id ASC LIMIT $limit_start, $limit";
							$sql = mysqli_query($conn, $q);
						} else {
							$q = "SELECT id, kategori_capil, kode_partai, no_urut, nama_capil, jenis_kelamin, dapil, status FROM db_master_capil WHERE kategori_capil = 'DPD-RI' AND (kode_partai LIKE '%" . $cari . "%' OR nama_capil LIKE '%" . $cari . "%' OR dapil LIKE '%" . $cari . "%') ORDER BY id ASC LIMIT $limit_start, $limit";
							$sql = mysqli_query($conn, $q);
						}
					} else {
						$q = "SELECT id, kategori_capil, kode_partai, no_urut, nama_capil, jenis_kelamin, dapil, status FROM db_master_capil WHERE kategori_capil = 'DPD-RI' ORDER BY id ASC LIMIT $limit_start, $limit";
						$sql = mysqli_query($conn, $q);
					}

					while ($row = mysqli_fetch_assoc($sql)) {

						$Id = $row['id'];
						$KategoriCapil = $row['kategori_capil'];
						$KodePartai = $row['kode_partai'];
						$NomorUrut = $row['no_urut'];
						$NamaCapil = $row['nama_capil'];
						$JenisKelamin = $row['jenis_kelamin'];
						$Dapil = $row['dapil'];
						$Status = $row['status'];

						echo "
						<tr>
							<td>$No</td>
							<td>$KategoriCapil</td>
							<td>$KodePartai</td>
							<td>$NomorUrut</td>
							<td>$NamaCapil</td>
							<td>$JenisKelamin</td>
							<td>$Dapil</td>
							<td>$Status</td>
						</tr>
						";

						$No++;
					}
					?>
				</tbody>
			</table>

			<?php
			
			$q = "SELECT COUNT(1) AS cnt FROM db_master_capil WHERE kategori_capil = 'DPD-RI' AND (kode_partai LIKE '%" . $cari . "%' OR nama_capil LIKE '%" . $cari . "%' OR dapil LIKE '%" . $cari . "%') ORDER BY id ASC";
			$sql = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($sql);
			$total_data = $row['cnt'];
			
			?>

			<div style="font-weight: bold;color:red">Total Data : <?= $total_data ?></div>

			<nav aria-label="Page navigation example" style="padding-top: 15px;">
				<ul class="pagination">
					<!-- LINK FIRST AND PREV -->
					<?php

					if ($page == 1) { // Jika page adalah page ke 1, maka disable link PREV
						echo "<li class='page-item disbled'><a class='page-link' href='#'>First</a></li>";
						echo "<li class='page-item disbled'><a class='page-link' href='#'>&laquo;</a></li>";
					} else { // Jika page bukan page ke 1
						$link_prev = ($page > 1) ? $page - 1 : 1;
						echo "<li class='page-item'><a class='page-link' href='master-dpd-ri.php?page=1'>First</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-dpd-ri.php?page=$link_prev&cari=$cari'>&laquo;</a></li>";
					}

					if (isset($_GET['cari'])) {
						$cari = $_GET['cari'];

						if ($cari == "") {
							$q = "SELECT COUNT(1) AS cnt FROM db_master_capil WHERE kategori_capil = 'DPD-RI'";
							$sql = mysqli_query($conn, $q);
						} else {
							$q = "SELECT COUNT(1) AS cnt FROM db_master_capil WHERE kategori_capil = 'DPD-RI' AND (kode_partai LIKE '%" . $cari . "%' OR nama_capil LIKE '%" . $cari . "%' OR dapil LIKE '%" . $cari . "%') ORDER BY id ASC";
							$sql = mysqli_query($conn, $q);
						}
					} else {
						$q = "SELECT COUNT(1) AS cnt FROM db_master_capil WHERE kategori_capil = 'DPD-RI'";
						$sql = mysqli_query($conn, $q);
					}
					$sql = mysqli_query($conn, $q);
					$row = mysqli_fetch_assoc($sql);
					$jumlah = $row['cnt'];

					$jumlah_page = ceil($jumlah / $limit); // Hitung jumlah halamannya
					$jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
					$start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
					$end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

					for ($i = $start_number; $i <= $end_number; $i++) {

						$link_active = ($page == $i) ? ' class="page-item active"' : '';

						echo "<li$link_active><a class='page-link' href='master-dpd-ri.php?page=$i&cari=$cari'>$i</a></li>";
					}

					// LINK NEXT AND LAST

					// Jika page sama dengan jumlah page, maka disable link NEXT nya
					// Artinya page tersebut adalah page terakhir 
					if ($page == $jumlah_page) { // Jika page terakhir
						echo "<li class='page-item disbled'><a class='page-link' href='#'>&raquo;</a></li>";
						echo "<li class='page-item disbled'><a class='page-link' href='#'>Last</a></li>";
					} else { // Jika Bukan page terakhir
						$link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;

						echo "<li class='page-item'><a class='page-link' href='master-dpd-ri.php?page=$link_next&cari=$cari'>&raquo;</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-dpd-ri.php?page=$jumlah_page&cari=$cari'>Last</a></li>";
					}

					?>
				</ul>
			</nav>

			</div>
		</div>

		</div>
	</div>
	</section>

</main>

<?php

require_once('footer.php');

?>