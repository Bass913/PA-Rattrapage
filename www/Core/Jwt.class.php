<?php

namespace App\Core;
class Jwt{

    private $token;

    public function __construct(array $data){

        $header = base64_encode(json_encode(array("alg"=>"HS256","typ"=>"JWT")));
		$playload = base64_encode(json_encode($data));
		$secret = base64_encode('Za1234');
		$signature = hash_hmac('sha256',$header.".".$playload,$secret);

        $this->token = $header.".".$playload.".".$signature.".".uniqid();
    }

    public function getToken(){
        return $this->token;
    }
}

