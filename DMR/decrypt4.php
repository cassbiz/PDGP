<?php
session_start();
?>
<html>
<head>

</head>
<body style="background-color:powderblue;">

<?php
$encrypt2 = $_POST["encrypt2"];
# echo  $_POST["encrypt2"];
# echo 'encrypt2= "';
# echo  $_POST["encrypt2"];
# echo '"<br><br>';

class PHP_AES_Cipher {

    private static $OPENSSL_CIPHER_NAME = "aes-128-cbc"; //Name of OpenSSL Cipher 
    private static $CIPHER_KEY_LEN = 16; //128 bits
        

    /**
     * Encrypt data using AES Cipher (CBC) with 128 bit key
     * 
     * @param type $key - key to use should be 16 bytes long (128 bits)
     * @param type $iv - initialization vector
     * @param type $data - data to encrypt
     * @return encrypted data in base64 encoding with iv attached at end after a :
     */

    static function encrypt($key, $iv, $data) {
        if (strlen($key) < PHP_AES_Cipher::$CIPHER_KEY_LEN) {
            $key = str_pad("$key", PHP_AES_Cipher::$CIPHER_KEY_LEN, "0"); //0 pad to len 16
        } else if (strlen($key) > PHP_AES_Cipher::$CIPHER_KEY_LEN) {
            $key = substr($str, 0, PHP_AES_Cipher::$CIPHER_KEY_LEN); //truncate to 16 bytes
        }
        
        $encodedEncryptedData = base64_encode(openssl_encrypt($data, PHP_AES_Cipher::$OPENSSL_CIPHER_NAME, $key, OPENSSL_RAW_DATA, $iv));
        $encodedIV = base64_encode($iv);
        $encryptedPayload = $encodedEncryptedData.":".$encodedIV;
        
        return $encryptedPayload;
        
    }


    /**
     * Decrypt data using AES Cipher (CBC) with 128 bit key
     * 
     * @param type $key - key to use should be 16 bytes long (128 bits)
     * @param type $data - data to be decrypted in base64 encoding with iv attached at the end after a :
     * @return decrypted data
     */
    static function decrypt($key, $data) {
        if (strlen($key) < PHP_AES_Cipher::$CIPHER_KEY_LEN) {
            $key = str_pad("$key", PHP_AES_Cipher::$CIPHER_KEY_LEN, "0"); //0 pad to len 16
        } else if (strlen($key) > PHP_AES_Cipher::$CIPHER_KEY_LEN) {
            $key = substr($str, 0, PHP_AES_Cipher::$CIPHER_KEY_LEN); //truncate to 16 bytes
        }
        
        $parts = explode(':', $data); //Separate Encrypted data from iv.
        $decryptedData = openssl_decrypt(base64_decode($parts[0]), PHP_AES_Cipher::$OPENSSL_CIPHER_NAME, $key, OPENSSL_RAW_DATA, base64_decode($parts[1]));

        return $decryptedData;
    }

}



//Code to Test Class
# $iv = 'fedcba9876543210'; #Same as in JAVA

$iv = $_SESSION["prvkey"];
$key = '0123456789abcdef'; #Same as in JAVA
# $encrypt = $_GET["encrypt2"];
# $data = $_GET["encrypt2"];
# $data1 = $_GET["encrypt2"];
$encrypt = $encrypt2;
$data = $encrypt2;
$data1 = $encrypt2;

$encrypted = PHP_AES_Cipher::encrypt($key, $iv, $encrypt);



# echo "Encrypted Payload: $encrypted <br><br>";

$decryptedPayload = PHP_AES_Cipher::decrypt($key, $encrypt);


echo '<form action="decrypt5.php" method="POST">';
echo 'insert text here';
echo '<input type="text" name="keytext" size="8"><br>';
echo 'Encrypted Text: <textarea name="encrypt3" rows="10" cols="80" onblur="this.value=removeSpaces(this.value)">';
echo " $decryptedPayload ";
echo ' </textarea><br><br>';
echo '<input type="submit"></form>';


# echo "Decrypted Payload: $decryptedPayload <br><br>";

?>



</body>
</html>