#!/usr/bin/php

<?php

const KEY           = 3;
const KEY_WORD      = 'Complete Victory';
const ALPHABET_SIZE = 26;

function Cipher($ch, $sourceAlphas, $keyedAlphas)
{
	if (!ctype_alpha($ch))
		return $ch;

  return $keyedAlphas[array_search(strtoupper($ch), $sourceAlphas)];
}

function Encipher($input, $sourceAlphas, $keyedAlphas)
{
	$output = "";

	$inputArr = str_split($input);
	foreach ($inputArr as $ch)
    $output .= Cipher(strtoupper($ch), $sourceAlphas, $keyedAlphas);

	return $output;
}

function Decipher($input, $sourceAlphas, $keyedAlphas)
{
	return Encipher($input, $sourceAlphas, $keyedAlphas);
}

$concatedKey = str_replace(' ', '', KEY_WORD);
$key = array_unique(str_split(strtoupper($concatedKey)));
$alphas = range('A', 'Z');
$keyedAlphas = array_unique(array_merge($key, $alphas));
for ($i = 0; $i < KEY; $i++)
{
  array_unshift($keyedAlphas, end($keyedAlphas));
  array_pop($keyedAlphas);
}


$filePath = isset($argv[1]) ? $argv[1] : './plaintext.txt';
$myfile = fopen($filePath, "r") or die("Unable to open file with plain text!");
$text = fread($myfile,filesize($filePath));
fclose($myfile);

$cipherText = Encipher($text, range('A', 'Z'), $keyedAlphas);
$plainText = Decipher($cipherText, $keyedAlphas, range('A', 'Z'));

echo "Ciphered text: " . $cipherText . "\r\n";
echo "Deciphered text: " . $plainText . "\r\n";
