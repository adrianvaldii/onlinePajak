<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HitungPajak extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$content['js'] = $this->load->view('hitung_pajak/js', '', TRUE);
		$this->load->view('hitung_pajak/index', $content);
	}

	function calculate_tax()
	{
		// declare data
		$tax_relief = array(
			'TK0' => 54000000,
			'K0'  => 58500000,
			'K1'  => 63000000,
			'K2'  => 67500000,
			'K3'  => 72000000
		);

		// declare variable
		$status = $this->input->post('status');
		$npwp = $this->input->post('npwp');
		$gaji_pokok = str_replace(",", "", $this->input->post('gaji_pokok'));

		$penambahan_gapok = 0;
		$tunjangan = 0;
		$pengurangan = 0;
		$bruto = 0;
		$netto_monthly = 0;
		$netto_yearly = 0;
		$ptkp = 0;
		$tax_rate = 0;

		// calculate proses
		if ($status == 0) {
			// if single
			$bruto += $gaji_pokok;

			// if penambahan does exists
			if ($this->input->post('penambahan_total')) {
				foreach ($this->input->post('penambahan_total') as $key => $value) {
					$bruto += str_replace(",", "", $value);
				}
			}

			// if tunjangan does exists
			if ($this->input->post('tunjangan_total')) {
				foreach ($this->input->post('tunjangan_total') as $key => $value) {
					$bruto += str_replace(",", "", $value);
				}
			}

			// pengurangan
			$biaya_jabatan = (5/100) * $bruto;
			if ($biaya_jabatan > 500000) {
				$biaya_jabatan = 500000;
			}

			$pengurangan += $biaya_jabatan;

			// if pengurangan does exists
			if ($this->input->post('pengurangan_total')) {
				foreach ($this->input->post('pengurangan_total') as $key => $value) {
					$pengurangan += str_replace(",", "", $value);
				}
			}

			$netto_monthly = $bruto - $pengurangan;
			$netto_yearly = 12 * $netto_monthly;

			// find PTKP
			$ptkp = $tax_relief['TK0'];

			$kena_pajak_tahun = $netto_yearly - $ptkp;

			$round_pajak = floor($kena_pajak_tahun);

			// find tax rate 
			if ($round_pajak <= 50000000) {
				$tax_rate = 5;
			} elseif ($round_pajak >= 50000000 && $round_pajak <= 250000000) {
				$tax_rate = 15;
			} elseif ($round_pajak >= 250000000 && $round_pajak <= 500000000) {
				$tax_rate = 25;
			} else {
				$tax_rate = 30;
			}

			// pph terutang
			$pph_terutang = ($tax_rate/100) * $round_pajak;

			// npwp
			if ($npwp == 0) {
				$pph_terutang = (($tax_rate/100) * $round_pajak) * (120/100);	
			}

			// pph terutang perbulan
			$pph_terutang_bulan = $pph_terutang / 12;
		} else {
			$jumlah_anak = $this->input->post('jumlah_anak');

			// if single
			$bruto += $gaji_pokok;

			// if penambahan does exists
			if ($this->input->post('penambahan_total')) {
				foreach ($this->input->post('penambahan_total') as $key => $value) {
					$bruto += str_replace(",", "", $value);
				}
			}

			// if tunjangan does exists
			if ($this->input->post('tunjangan_total')) {
				foreach ($this->input->post('tunjangan_total') as $key => $value) {
					$bruto += str_replace(",", "", $value);
				}
			}

			// pengurangan
			$biaya_jabatan = (5/100) * $bruto;
			if ($biaya_jabatan > 500000) {
				$biaya_jabatan = 500000;
			}

			$pengurangan += $biaya_jabatan;

			// if pengurangan does exists
			if ($this->input->post('pengurangan_total')) {
				foreach ($this->input->post('pengurangan_total') as $key => $value) {
					$pengurangan += str_replace(",", "", $value);
				}
			}

			$netto_monthly = $bruto - $pengurangan;
			$netto_yearly = 12 * $netto_monthly;

			// find PTKP
			$ptkp = $tax_relief[$jumlah_anak];

			$kena_pajak_tahun = $netto_yearly - $ptkp;

			$round_pajak = floor($kena_pajak_tahun);

			// find tax rate 
			if ($round_pajak <= 50000000) {
				$tax_rate = 5;
			} elseif ($round_pajak >= 50000000 && $round_pajak <= 250000000) {
				$tax_rate = 15;
			} elseif ($round_pajak >= 250000000 && $round_pajak <= 500000000) {
				$tax_rate = 25;
			} else {
				$tax_rate = 30;
			}

			// pph terutang
			$pph_terutang = ($tax_rate/100) * $round_pajak;

			// npwp
			if ($npwp == 0) {
				$pph_terutang = (($tax_rate/100) * $round_pajak) * (120/100);	
			}

			// pph terutang perbulan
			$pph_terutang_bulan = $pph_terutang / 12;
		}


		$result = array(
			'bruto' => $bruto,
			'biaya_jabatan' => $biaya_jabatan,
			'total_pengurangan' => $pengurangan,
			'netto_bulan' => $netto_monthly,
			'netto_tahun' => $netto_yearly,
			'ptkp' => $ptkp,
			'kena_pajak_tahun' => $kena_pajak_tahun,
			'round_pajak' => $round_pajak,
			'pph_terutang_tahun' => $pph_terutang,
			'pph_terutang_bulan' => $pph_terutang_bulan,
			'percent_tahun' => $tax_rate
		);

		echo json_encode($result);
	}
}
