<?php

namespace App\Services;
use Illuminate\Http;

class FakerService
{

    protected $type;
    protected $url;
    protected $values;



    public function __construct(String $type,String $url , String $values)
    {
        $this->type = $type;
        $this->url = $url;
        $this->values = $values;
    }

    public function requesthandler(){
        if($this->type=='Post'){
            $this->PostApi();
        }else{
            $this->GetApi();
        }
    }

    public function PostApi():Http{
        $jsonobject=json_decode($this->$values);
        $post_response = Http::post($this->$url,[$values]);
        return $post_response;
    }
    
    public function GetApi():Http{
        $jsonobject=json_decode($values);
        $getvariables="";
        $numvalues = count($jsonobject);
        $i = 0;
        foreach ($jsonobject as $key -> $value){
            if(++$i === $numvalues){
                $getvariables+=$key + "=" + $value ;
            }else{
            $getvariables+=$key + "=" + $value +"&";
            }
        }
        $getresponse = Http::get(
            $url .$getvariables
        );
        return $getresponse;
    }

   
}
