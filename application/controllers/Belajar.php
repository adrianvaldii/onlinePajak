<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Belajar extends CI_Controller {

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
		print_r($this->h(1, "fruits"));
		print_r($this->h(2, "fruits"));
		print_r($this->h(5, "fruits"));
		print_r($this->h($this->pow(2, 1000000000000000), "fruits"));
		print_r($this->h($this->pow(2, 9831050005000007), "fruits"));
	}

	function g($str)
	{
		$i = 0;
		$new_str = "";
		while ($i <= count($str) - 1) {
			$new_str = $new_str . $str[$i + 1];
			$i = $i + 1;
		}

		return $new_str;
	}

	function f($str) {
		if (count($str) == 0) {
			return "";
		} elseif (count($str) == 1) {
			return $str;
		} else {
			return f($this->g($str)) + $str[0];
		}
	}

	function h($n, $str) {
		while ($n != 1) {
			if ($n % 2 == 0) {
				$n = $n/2;
			} else {
				$n = (3 * $n) + 1;
			}
			$str = $this->f($str);
		}

		return $str;
	}

	function pow($x, $y)
	{
		if ($y == 0) {
			return 1;
		} else {
			return $x * pow($x, $y-1);
		}
	}
}
