<div class="row">
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-aqua">
			<div class="inner">
			  <h3><?php print getCount_pasien_rawat_jalan(); ?></h3>

			  <p>Pendaftaran Rawat Jalan</p>
			</div>
			<div class="icon">
			  <i class="ion ion-bag"></i>
			</div>
			<a href="t_pendaftaranadd.php" class="small-box-footer">Lanjutkan <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-green">
			<div class="inner">
			  <h3><?php print getCount_sep_rawat_jalan(); ?><sup style="font-size: 20px"></sup></h3>

			  <p>Pembuatan SEP Rawat Jalan</p>
			</div>
			<div class="icon">
			  <i class="ion ion-stats-bars"></i>
			</div>
			<a href="vw_bridging_sep_by_no_kartulist.php" class="small-box-footer">Lanjutkan <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>
		<!-- ./col -->


		
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-yellow">
			<div class="inner">
			  <h3><?php print getCount_pasienbaru(); ?></h3>

			  <p>Pendaftaran Pasien Baru</p>
			</div>
			<div class="icon">
			  <i class="ion ion-person-add"></i>
			</div>
			<a href="m_pasienadd.php" class="small-box-footer">Lanjutkan <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-red">
			<div class="inner">
				<h3><?php print getCount_order_admission(); ?></h3>
				<p>Permohonan Rawat Inap</p>
			</div>
			<div class="icon">
			  <i class="ion ion-pie-graph"></i>
			</div>
			<a href="t_orderadmissionlist.php" class="small-box-footer">Lanjutkan <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>
		<!-- ./col -->
</div>