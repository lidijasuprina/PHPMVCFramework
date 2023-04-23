<?php

namespace app\core;

/**
* Class Application
*
* @author Lidija Šuprina <lidija.suprina7@gmail.com>
* @package app\core
*/

class Response 
{
    public function setStatusCode(int $code) 
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header("Location: $url");
    }
}