<?php
namespace App\Http\Libraries;

class Security {

    private static function getCipher(){
        return 'AES-128-CTR';
    }

    private static function getEncryptKey(){
        return 'y+pSGEUVNpZaxRJeiAjxbKw8/UQcp0oYJZso0Kk73fg=';
    }

    public static function encryptId($val)
    {
        $iv_length = openssl_cipher_iv_length(self::getCipher());
        $iv = random_bytes($iv_length);
        $encrypted = openssl_encrypt($val, self::getCipher(), self::getEncryptKey(), 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    public static function decryptId($val)
    {
        $data = base64_decode($val);
        $iv_length = openssl_cipher_iv_length(self::getCipher());
        $iv = substr($data, 0, $iv_length);
        $encrypted = substr($data, $iv_length);
        return openssl_decrypt($encrypted, self::getCipher(), self::getEncryptKey(), 0, $iv);
    }
}
