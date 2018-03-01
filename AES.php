<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>AES</title>
  </head>
  <body>
    <?php

    function encriptar_AES($string, $key)
{
   $td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, ''); //128 o 256 bits
   $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM );
   mcrypt_generic_init($td, $key, $iv);
   $encrypted_data_bin = mcrypt_generic($td, $string);
   mcrypt_generic_deinit($td);
   mcrypt_module_close($td);
   $encrypted_data_hex = bin2hex($iv).bin2hex($encrypted_data_bin);
   return $encrypted_data_hex;
}

function desencriptar_AES($encrypted_data_hex, $key)
{
   $td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, ''); //128 o 256 bits
   $iv_size_hex = mcrypt_enc_get_iv_size($td)*2;
   $iv = pack("H*", substr($encrypted_data_hex, 0, $iv_size_hex));
   $encrypted_data_bin = pack("H*", substr($encrypted_data_hex, $iv_size_hex));
   mcrypt_generic_init($td, $key, $iv);
   $decrypted = mdecrypt_generic($td, $encrypted_data_bin);
   mcrypt_generic_deinit($td);
   mcrypt_module_close($td);
   return $decrypted;
}

$frase = "Datos secretos confidenciales";
$clave = "vacaiberica";

$encriptado = encriptar_AES($frase, $clave);

$desencriptado = desencriptar_AES($encriptado, $clave);

    echo "Frase: ".$frase."<br>";
    echo "Encriptado: ".$encriptado."<br>";
    echo "Desencriptado: ".$desencriptado."<br>";

    ?>
  </body>
</html>
