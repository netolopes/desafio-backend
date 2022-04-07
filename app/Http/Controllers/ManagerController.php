<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function convert(Request $request){
        
        $url = "https://www.correio24horas.com.br/rss/";
        try{
            $simpleXml = simplexml_load_file($url, "SimpleXMLElement", LIBXML_NOCDATA);
             $json = json_encode($simpleXml);
             return $json;
         } catch (\Exception $e){
           return null;
         }
    }

}
