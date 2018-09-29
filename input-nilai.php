<?php 

abstract class Data{
	
	abstract protected function index();

}

class InputNilai extends Data{
	private $data = '';
	private $message = "Lanjutkan? [Y/n]:";
	static  $proses;

	public function __construct($data = 'data.txt'){
		$file = fopen($data,"a+") or die("Unable to open file!");
		$this->data = $file;
	}

	public function index(){
		echo $this->input();
		print $this->message;
		echo $this->run();
	}

	public function input(){
		echo "Masukkan Nama Peserta :";
		$nama = ucwords(trim(fgets(STDIN)));
		echo "Masukkan Nilai $nama :";
		fwrite($this->data, $nama . " ");
		$nilai = trim(fgets(STDIN));
		echo "Nilai $nama adalah $nilai\n";
		fwrite($this->data, $nilai . "\n");
		fclose($this->data);
		// return run();
	}

	

	public function run(){
		$confirmation  =  trim( fgets( STDIN ) );
		$nt = trim("\n");
		if ( $confirmation == 'Y' or $confirmation == 'y' or $confirmation == $nt ){
				$proses = new InputNilai();
				return $proses->index();
			} else {
				$hasil = new InputNilai();
				echo $hasil->result();
			}
	}

	public function result(){
		$stat = fstat($this->data);
		ftruncate($this->data, $stat['size']-1);
		echo "Terimakasih sudah memasukkan nilai nilai peserta Ujian";
		echo "\n";
		echo "\n";
		for ($y=1; $y <= 99 ; $y++) {
			  if ($y==50) {
			    echo "*";  
			  } else {
			    echo "-";
			  }
		}
		echo "\n";
		$file = fopen("data.txt", "r");
		$nama = [];
		$nilai = [];
		while (!feof($this->data)){
			$line = fgets($this->data);
			$num = preg_replace("/[^0-9\.]/", '', $line);
			$getnum = ltrim($num, '.'); //remove first dot
			$text = preg_replace("/([^a-zA-Z*\.]+)/i", ' ' ,$line);
			$gettext = rtrim($text, ". "); //remove last dot
			array_push($nama, $gettext); //keys
			array_push($nilai, $getnum); //values
			
		}
		// $hasil = implode($array);
		// $keys =  ($array);
		// $values = ($array1);

		$c = array_combine($nama, $nilai);
		ksort($c);
		foreach ($c as $key => $value) {
			echo "$key => $value\n";
		}
		echo "===> Nilai Lulus ⇐==\n";
		arsort($c);
		function rank5($value){
			return $value > 5;
		}

		$lulus = array_filter($c, "rank5");
		foreach ($lulus as $key => $value) {
			echo "Nilai ujian $key telah mencukupi. Capaian ".($value*10)."%\n";
		}

		echo "===> Nilai Tidak Lulus ⇐==\n";
		asort($c);
		function ranksd5($value){
			return $value <= 5;
		}

		$tidaklulus = array_filter($c, "ranksd5");
		foreach ($tidaklulus as $key => $value) {
			echo "Nilai ujian $key tidak mencukupi. Capaian ".($value*10)."%\n";
		}
		echo "\n";

		arsort($c);
		foreach ($c as $key => $value) {
				echo "Nilai TERTINGGI adalah $key dengan nilai $value\n";
				break;
		}

		asort($c);
		foreach ($c as $key => $value) {
				echo "Nilai TERENDAH adalah $key dengan nilai $value";
				break;
		}

		echo "\n";
		echo "\n";

		$bahasa = "PHP";
		$namaku = "Sholeh Zuamsyah";
		echo "Program dibuat dengan bahasa $bahasa oleh $namaku\n";
	}

}


echo "==>> Selamat datang di Program Input Nilai Ujian <<==\n";
$input = new InputNilai();
$input->index();

 ?>