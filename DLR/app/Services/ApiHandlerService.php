<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;


class ApiHandlerService
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

    public function requestHandler()
    {
        if ($this->type == 'Post') {
            return $this->postApi();
        } else {
            return $this->getApi();
        }
    }

    public function postApi()
    {
        $jsonobject = json_decode($this->values);
        $header_object = json_decode($this->header);

        $post_response = Http::withHeaders(["Username" => "whatstst", "Password" => "Wh@ts@"])->post($this->url, $jsonobject);
        return $post_response;
    }

    public function getApi()
    {
        $jsonobject = json_decode($this->values);
        $getvariables = "";
        $numvalues = 0;
        foreach ($jsonobject as $key => $value) {
            $numvalues = $numvalues + 1;
        }
        $i = 0;
        foreach ($jsonobject as $key => $value) {
            if (++$i === $numvalues) {
                $getvariables .= $key . "=" . $value;
            } else {
                $getvariables .= $key . "=" . $value . "&";
            }
        }
        $getresponse = Http::get(
            $this->url . $getvariables
        );
        return $getresponse;
    }
}