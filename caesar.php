#!/usr/bin/php

<?php

function Cipher($ch, $key)
{
	if (!ctype_alpha($ch))
		return $ch;

	$offset = ord(ctype_upper($ch) ? 'A' : 'a');
	return chr(fmod(((ord($ch) + $key) - $offset), 26) + $offset);
}

function Encipher($input, $key)
{
	$output = "";

	$inputArr = str_split($input);
	foreach ($inputArr as $ch)
		$output .= Cipher($ch, $key);

	return $output;
}

function Decipher($input, $key)
{
	return Encipher($input, 26 - $key);
}

$text = "The quick brown fox jumps over the lazy dog";
$cipherText = Encipher($text, 3);
$plainText = Decipher($cipherText, 3);

echo $cipherText . "\r\n";
echo $plainText . "\r\n";
