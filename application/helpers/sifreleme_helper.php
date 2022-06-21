<?php defined('BASEPATH') OR exit('No direct script access allowed');

function sifreleme($sayi=128){
	$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ'.'012345678901234567890123');
	shuffle($seed);
	$hrand = '';
	foreach (array_rand($seed, $sayi) as $k) $hrand .= $seed[$k];

	return $hrand;
} 