<?php

namespace App\Service;

class TokenService {
    // Generate a random token for the User
    public function generateRandomToken(){
        $token = random_bytes(32);
        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);
        return $token;
    }
}