<?php

namespace App\Services;

use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class ApiHandler
{
    protected $type;
    protected $url;
    protected $values;
    public function __construct(String $type, String $url, String $values)
    {
        $this->type = $type;
        $this->url = $url;
        $this->values = $values;
    }
    public function requesthandler(): Response
    {
        if ($this->type == 'Post') {
            return $this->PostApi();
        } else {
            return $this->GetApi();
        }
    }
    public function PostApi()
    {
        $jsonobject = json_decode($this->values);
        $post_response = Http::post($this->url, [$jsonobject]);
        return $post_response;
    }
    public function GetApi()
    {
        $jsonobject = json_decode($this->values);
        $getvariables = "";
        $numvalues = count($jsonobject);
        $i = 0;
        foreach ($jsonobject as $key => $value) {
            if (++$i === $numvalues) {
                $getvariables += $key + "=" + $value;
            } else {
                $getvariables += $key + "=" + $value + "&";
            }
        }
        $getresponse = Response::get(
            $this->url . $getvariables
        );
        return $getresponse;
    }
}
