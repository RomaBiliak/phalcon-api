<?php
declare(strict_types=1);
namespace Apps\Common\Service;
use Firebase\JWT\JWT;
class JwtService  extends \Phalcon\DI\Injectable
{

    protected $iss = 'test';
    protected $aud = 'test';
    protected $iat;
    protected $nbf;
    protected $algo;
    protected $private_key;
    protected $public_key;
    protected $expire = 15;
	public function __construct($setting)
	{
        $key = 'Rf5sR_li3os';
        if(isset($setting['iss']))
            $this->iss = $setting['iss'];
        if(isset($setting['aud']))
            $this->aud = $setting['aud'];
        if(isset($setting['expire']))
            $this->expire = $setting['expire'];
        if(isset($setting['algo']))
            $this->algo = [$setting['algo']];
        else
            $this->algo = 'HS256';

        if($this->algo=='HS256'){
            if(isset($setting['key'])){
                $this->private_key = $setting['key'];
                $this->public_key = $setting['key'];
            }else{
                $this->private_key = $key;
                $this->public_key = $key;
            }
        }else{
            if(isset($setting['private_key']) && isset($setting['public_key'])){
                $this->private_key = $setting['private_key'];
                $this->public_key = $setting['public_key'];
            }else{
                $this->private_key = $key;
                $this->public_key = $key;
                $this->algo = 'HS256';
            }
        }
	}

    public function generateUserJWT(array $custom_fields):string
    {
        $data = [
            "iss" => $this->iss,
            "aud" => $this->aud,
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + $this->expire * 60
        ];
        $data = array_merge($data, $custom_fields);
        return JWT::encode($data, $this->private_key, $this->algo);
    }
    public function getJWTData()
    {
        $access_token = $this->request->getHeaders()['Access-Token'];
        return JWT::decode($access_token, $this->public_key, array($this->algo));
    }



}