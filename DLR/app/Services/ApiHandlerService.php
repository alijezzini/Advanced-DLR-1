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
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTY0ODY0NjU1MywiZXhwIjoxNjQ4NjUwMTUzLCJuYmYiOjE2NDg2NDY1NTMsImp0aSI6ImhJZmU3WkZXa2Z2aDczTEMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.J-HVmLLC2q7urzp-7roDq2XgjrNzQ4S99W85jyXQTDc',
            'Username' => 'whatstst',
            'Password' => 'Wh@ts@'
        ];
        $post_response = Http::withHeaders($headers)->post($this->url, $this->values);
        // $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        // $out->writeln($post_response);

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
        $getresponse = Http::get(
            $this->url . $getvariables
        );
        return $getresponse;
    }
}
