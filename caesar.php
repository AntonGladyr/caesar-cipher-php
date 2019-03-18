#!/usr/bin/php

<?php

const KEY           = 3;
const KEY_WORD      = 'Complete Victory';
const ALPHABET_SIZE = 26;

// encipher $input text
function encipher($input, $sourceAlphas, $keyedAlphas)
{
	$output = "";

	$inputArr = str_split($input);
	foreach ($inputArr as $ch)
  {
    if (!ctype_alpha($ch))
  		$output .= $ch;
    else
      $output .= $keyedAlphas[array_search(strtoupper($ch), $sourceAlphas)];
  }

	return $output;
}

// decipher $input text
function decipher($input, $sourceAlphas, $keyedAlphas)
{
	return encipher($input, $sourceAlphas, $keyedAlphas);
}

function getKeyedAlphabet($key = KEY, $keyWord = KEY_WORD)
{
  $concatedKeyWord = str_replace(' ', '', $keyWord);
  $uniqueKeyWord = array_unique(str_split(strtoupper($concatedKeyWord)));
  $keyedAlphas = array_unique(array_merge($uniqueKeyWord, range('A', 'Z')));
  for ($i = 0; $i < $key; $i++)
  {
    array_unshift($keyedAlphas, end($keyedAlphas));
    array_pop($keyedAlphas);
  }

  return $keyedAlphas;
}


$filePath = isset($argv[1]) ? $argv[1] : './plaintext.txt';
$myfile = fopen($filePath, "r") or die("Unable to open file with plain text!");
$text = fread($myfile,filesize($filePath));
fclose($myfile);

$keyedAlphas = getKeyedAlphabet();

$cipherText = encipher($text, range('A', 'Z'), $keyedAlphas);
$plainText = decipher($cipherText, $keyedAlphas, range('A', 'Z'));

$myfile = fopen("ciphered_text.txt", "w+") or
    die("Unable to create/open ciphered_text.txt file!");
fwrite($myfile, $cipherText);
fclose($myfile);

echo "Ciphered text: " . $cipherText . "\r\n";
echo "Deciphered text: " . $plainText . "\r\n";
echo str_repeat("-", 70) . "\r\n";
echo "Enter a key value (must be a number): " . "\r\n";
$key = fgets(STDIN);
if (!$keyValue = intval($key))
	die("A key must be an integer value. Try again...\r\n");
echo "Enter a key word: " . "\r\n";
$keyWord = trim(fgets(STDIN), "\n");
if (empty($keyWord))
	die("A key word can not be empty. Try again...\r\n");

$keyedAlphas = getKeyedAlphabet($keyValue, $keyWord);
$plainText = decipher($cipherText, $keyedAlphas, range('A', 'Z'));
echo "Deciphered text: " . $plainText . "\r\n";
