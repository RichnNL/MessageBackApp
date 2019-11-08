<?php
namespace util;
class Request {

    // Gets Bearer Token from Header for JWT 
    public function getTokenFromHeader(){
        $headers = null;
       
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { 
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        $token = str_replace('Bearer','', $headers);
        return $token;
    }

    // Gets username from url 
    public function getUserNameParam() {
        $params = $_SERVER['QUERY_STRING'];
        $data = explode ("=", $params);  
        try {
            if($data[0] == 'username' && count($data) == 2) {
                $username = $data[1];
                return $username;
            } 
        } catch(Error $e) {
            return null;
        }
        return null;
    }


    //Gets Recipient and Content from params
    public function getContentRecipientFromParam() {
        $params = $_SERVER['QUERY_STRING'];
        try {
            if(isset($_GET["recipient"]) && isset($_GET["content"])) {
                $recipient = htmlspecialchars($_GET["recipient"]);
                $content = htmlspecialchars($_GET["content"]);
                return array('recipient' => $recipient, 'content' => $content);
            } 
        } catch(Error $e) {
            return null;
        }
        return null;
    }

    public function isPostRequest() {
        return ($_SERVER["REQUEST_METHOD"] == "POST");
    }

    public function isGetRequest() {
        return ($_SERVER["REQUEST_METHOD"] == "GET");
    }


}