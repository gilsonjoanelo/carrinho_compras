<?php
class Token {
    public function createJWT($userId, $nome)
    {
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ]);
        $payload = json_encode([
            'exp' => calculateJWTExpiration(), // calcular
            'userId' => $userId,
            'name' => $nome
        ]);
    
        $base64UrlHeader = base64UrlEncode($header);
        $base64UrlPayload = base64UrlEncode($payload);
    
        $data = $base64UrlHeader . "." . $base64UrlPayload;
        $signature = hash_hmac('sha256', $data, JWT_PASS, true);
    
        $base64UrlSignature = base64UrlEncode($signature);
    
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    
        return $jwt;
    }

    public function validateJWT($jwt)
    {
        try {
    
            $tokenParts = explode('.', $jwt);
            $header = base64UrlDecode($tokenParts[0]);
            $payload = base64UrlDecode($tokenParts[1]);
            $signatureProvided = $tokenParts[2];
    
            $base64UrlHeader = base64UrlEncode($header);
            $base64UrlPayload = base64UrlEncode($payload);
    
            $data = $base64UrlHeader . "." . $base64UrlPayload;
            $signature = hash_hmac('sha256', $data, JWT_PASS, true);
    
            $base64UrlSignature = base64UrlEncode($signature);
    
            $jwtTemp = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    
            if ($jwtTemp !== $jwt) {
                $retorno = new stdClass();
                $retorno->isExpirado = true;
                $retorno->isValido = false;
                $retorno->data = "--------------";
                return $retorno;
            } else {
                $headerObj = json_decode($header);
                $payloadObj = json_decode($payload);
                if ($headerObj->typ === "JWT" && $headerObj->alg === "HS256") {
    
                    $date = new DateTime();
                    $expiration = $date->setTimestamp($payloadObj->exp);
    
                    $hoje = new DateTime();
                    $hoje->setTimestamp(time());
                    $diff = $expiration->getTimestamp() - $hoje->getTimestamp();
    
                    $retorno = new stdClass();
                    $retorno->isExpirado = $diff < 0;
                    $retorno->isValido = $diff >= 0;
                    $retorno->data = "";
                    return $retorno;
                } else {
                    $retorno = new stdClass();
                    $retorno->isExpirado = true;
                    $retorno->isValido = false;
                    $retorno->data = "";
                    return $retorno;
                }
            }
        } catch (Exception $ex) {
            $retorno = new stdClass();
            $retorno->isExpirado = true;
            $retorno->isValido = fal;
            $retorno->data = "";
            return $retorno;
        }
    }

    public function getBearerToken()
    {
        $headers = getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (! empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    private function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { // Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            // print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    private function base64UrlEncode($text)
    {
        return str_replace([
            '+',
            '/',
            '='
        ], [
            '-',
            '_',
            ''
        ], base64_encode($text));
    }
    
    private function base64UrlDecode($text)
    {
        return str_replace([
            '-',
            '_',
            ''
        ], [
            '+',
            '/',
            '='
        ], base64_decode($text));
    }

    private function calculateJWTExpiration()
    {
        $nowStr = date("Y-m-d H:i:s");
        $date = new DateTime($nowStr);
        $date->add(new DateInterval('P1D'));
    
        return $date->getTimestamp();
    }
}