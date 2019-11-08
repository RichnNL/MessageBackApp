<?php
namespace util;

require_once '../libs/php-jwt-master/src/BeforeValidException.php';
require_once '../libs/php-jwt-master/src/ExpiredException.php';
require_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
require_once '../libs/php-jwt-master/src/JWT.php';

use Firebase\JWT\JWT;
class TokenGenerator {
    private $key;
    public function __construct() {
        $this->key = base64_decode(getenv("APP_KEY"));
    }

    public function generateToken($data) {
        $tokenId = base64_encode(random_bytes(32));
        $issuedAt = time();
        $notBefore = $issuedAt;
        $expire = $notBefore + 604800;
        $serverName = getenv("DB_HOST");
        $tokenDetails = [
            'iat' => $issuedAt, 
            'jti' => $tokenId, 
            "aud" => $data->getName(),
            'iss' => $serverName, 
            'nbf' => $notBefore, 
            'exp' => $expire, 
        ];
        try {
            $token = JWT::encode($tokenDetails, $this->key, 'HS256');
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
        $token = trim($token);
        return $token;
    }

    public function decodeToken($token) {
        try {
            $token = trim($token);
            $decoded = JWT::decode($token, $this->key, array('HS256'));
            $decoded_array = (array) $decoded;
            $username = $decoded_array['aud'];
            if($username !== null) {
                return $username;
            }
            return null;
         
        }
        catch(\SignatureInvalidException $e) {
            echo $e->getMessage();
            return null;
        } catch(\UnexpectedValueException $e) {
            echo $e->getMessage();
            return null;
        }
        catch(\ExpiredException $e) {
            echo $e->getMessage();
            return null;
        }
        catch(\BeforeValidException $e) {
            echo $e->getMessage();
            return null;
        }
        
    }

}