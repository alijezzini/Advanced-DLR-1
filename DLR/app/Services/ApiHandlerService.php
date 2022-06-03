<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;


class ApiHandlerService
{
    protected string $type;
    protected string $url;
    protected array $values;

    public function __construct(string $type, string $url, array $values)
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

        $headers = [
            'Username' => 'whatstst',
            'Password' => 'Wh@ts@'
        ];
        $post_response = Http::withHeaders($headers)->post($this->url, $this->values);


        return $post_response;
    }

    public function getApi()
    {
        $getvariables = "";
        $numvalues = 0;
        foreach ($this->values as $key => $value) {
            $numvalues = $numvalues + 1;
        }
        $i = 0;
        foreach ($this->values as $key => $value) {
            if (++$i === $numvalues) {
                $getvariables .= $key . "=" . $value;
            } else {
                $getvariables .= $key . "=" . $value . "&";
            }
        }
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($this->url.$getvariables);
        $getresponse = Http::get(
            $this->url.$getvariables
        );
        return $getresponse;
    }
}
