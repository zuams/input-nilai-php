<?php

echo "==>> Selamat datang di Program Input Nilai Ujian <<==\n";

function input(){
	echo "Masukkan Nama Peserta :";
	$file = fopen("data.txt","a+") or die("Unable to open file!");
	$nama = ucwords(trim(fgets(STDIN)));
	echo "Masukkan Nilai $nama :";
	fwrite($file, $nama . " ");
	$nilai = trim(fgets(STDIN));
	echo "Nilai $nama adalah $nilai\n";
	fwrite($file, $nilai . "\n");
	fclose($file);
	$message  =  "Lanjutkan? [Y/n]:";
	print $message;
	return run();
	}

input();


function run(){
	$file = fopen("data.txt","a+") or die("Unable to open file!");
	$confirmation  =  trim( fgets( STDIN ) );
	$nt = trim("\n");
	if ( $confirmation == 'Y' or $confirmation == 'y' or $confirmation == $nt ) {
			input();
	} else {
		$stat = fstat($file);
		ftruncate($file, $stat['size']-1);
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
		$array = [];
		$array1 = [];
		while (!feof($file)){
			$line = fgets($file);
			$num = preg_replace("/[^0-9\.]/", '', $line);
			$getnum = ltrim($num, '.'); //remove first dot
			$text = preg_replace("/([^a-zA-Z*\.]+)/i", ' ' ,$line);
			$gettext = rtrim($text, ". "); //remove last dot
			array_push($array, $gettext); //keys
			array_push($array1, $getnum); //values
			
		}

		$c = array_combine($array, $array1);
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


?>