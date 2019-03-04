<!DOCTYPE html>
<html>
<head>
	<title>Personal Income Tax</title>

	<!-- load css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . '/assets/css/bootstrap.min.css' ?>">
	<style type="text/css">
		.kanan {
			text-align: right;
		}
	</style>

	<!-- load js -->
	<script src="<?php echo base_url() . '/assets/js/jquery.js' ?>"></script>
	<script src="<?php echo base_url() . '/assets/js/bootstrap.min.js' ?>"></script>
	
</head>
<body>
	<div class="container">
		<form>
			<br>
			<div class="row">
				<div class="col-md-12">
					<h1 class="text-center">Perhitungan Pajak Pribadi</h1>
				</div>
			</div>
			<br>
			<div class="row justify-content-around" style="border: 1px solid #000;">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							<table class="table">
								<tr>
									<td>Status</td>
									<td>
										<select class="form-control form-control-sm" id="status" name="status" onchange="changeStatus()">
											<option value="">Select Status</option>
											<option value="0">Single</option>
											<option value="1">Menikah</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Jumlah anak</td>
									<td>
										<select class="form-control form-control-sm" name="jumlah_anak" id="anak" disabled="disabled">
											<option value="">Select Jumlah anak</option>
											<option value="K0">Belum memiliki anak</option>
											<option value="K1">Memiliki 1 anak</option>
											<option value="K2">Memiliki 2 anak</option>
											<option value="K3">Memiliki 3 anak</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
						<div class="col-md-6">
							<table class="table">
								<tr>
									<td>NPWP</td>
									<td>
										<select class="form-control form-control-sm" name="npwp">
											<option value="">Select NPWP</option>
											<option value="0">Belum memiliki NPWP</option>
											<option value="1">Memiliki NPWP</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row justify-content-around">
				<div class="col-md-6" style="border: 1px solid #000;">
					<!-- input pendapatan dan tunjangan, dll -->
					<table class="table">
						<thead>
							<tr>
								<th>Items</th>
								<th>Percent</th>
								<th>Total</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody id="penambahan">
							<tr>
								<td>Gaji Pokok</td>
								<td>&nbsp;</td>
								<td>
									<input type="text" name="gaji_pokok" id="gaji_pokok" class="form-control form-control-sm" style="text-align: right" onkeyup= "fkeyup(this)">
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3"><strong>Penambahan dari Gaji Pokok</strong></td>
								<td><button type="button" id="addPenambahan" class="btn btn-primary btn-sm">+</button></td>
							</tr>
						</tbody>
					</table>
					<table class="table">
						<tbody id="tunjangan">
							<tr>
								<td colspan="3"><strong>Tunjangan Lainnya</strong></td>
								<td>
									<button type="button" id="addTunjangan" class="btn btn-primary btn-sm">+</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-6" style="border: 1px solid #000">
					<table class="table">
						<tbody id="pengurangan">
							<tr>
								<td colspan="2"><strong>Penghasilan bruto (kotor) sebulan</strong></td>
								<td class="kanan bruto"></td>
								<td></td>
							</tr>
							<tr>
								<td><strong>Pengurangan</strong></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Biaya Jabatan dari Bruto</td>
								<td class="kanan">5%</td>
								<td class="kanan biaya_jabatan"></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="3"><strong>Pengurangan dari Gaji Pokok</strong></td>
								<td><button type="button" id="addPengurangan" class="btn btn-primary btn-sm">+</button></td>
							</tr>
						</tbody>
					</table>
					<table class="table">
						<tr>
							<td colspan="2"><strong>Total Pengurangan</strong></td>
							<td class="kanan total_pengurangan"></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="2"><strong>Penghasilan netto (bersih) sebulan</strong></td>
							<td class="kanan netto_bulan"></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="2">Penghasilan netto setahun</td>
							<td class="kanan netto_tahun"></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="2"><strong>Penghasilan Tidak Kena Pajak (PTKP)</strong></td>
							<td class="kanan ptkp"></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="2"><strong>Penghasilan Kena Pajak Setahun</strong></td>
							<td class="kanan kena_pajak_tahun"></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="2">Pembulatan ke bawah</td>
							<td class="kanan round_pajak"></td>
							<td></td>
						</tr>
						<tr>
							<td><strong>PPh Terutang Tahun</strong></td>
							<td class="percent_tahun kanan"></td>
							<td class="pph_terutang_tahun kanan"></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="2"><strong>PPh Terutang Bulan</strong></td>
							<td class="pph_terutang_bulan kanan"></td>
							<td></td>
						</tr>
					</table>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-success" id="hitungPajak">Hitung</button>
				</div>
			</div>
			<br>
		</form>		
	</div>

	<?php if(isset($js)){ echo $js; }; ?>
</body>
</html>