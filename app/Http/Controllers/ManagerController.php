<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Hash;
use SimpleXMLElement;
use Feed;
use Illuminate\Database\Eloquent\Collection;

class ManagerController extends Controller
{

    public function __construct(

        ) {
           $this->httpClient = $this->getHttpClient();
        }

        public function getHttpClient() {
        //    return new Client(['base_uri' => config('https://www.correio24horas.com.br/')]);
        }

        public function convertData(){

        $urls = ["dados" => "https://www.correio24horas.com.br/rss",];

        $data = [];
        foreach ($urls as $name => $url) {
            $rss = Feed::loadRss($url);
            $data[$name] = $this->getItems($rss);
        }

           return $data;
        }

        private function getItems($rss) {
            $rssFeeds = [];
            foreach ($rss->item as $item) {
                $rssFeeds[] = [
                    "title"         => (string)$item->title,
                    "description"   => (string)$item->description,
                    "guid"         => (string)$item->guid,
                    "link"          => (string)$item->link,
                    "pubDate"      => (string)$item->pubDate,
                    "category"     => (string)$item->category,
                ];
            }
            return $rssFeeds;
        }

        public function convertMonths($month){

            $resul = "";
            switch ($month) {
                    case 'Jan':
                        $resul = '01';
                        break;
                    case 'Jan':
                        $resul = '01';
                        break;
                    case 'Feb':
                        $resul = '02';
                        break;
                    case 'Mar':
                        $resul = '03';
                        break;
                    case 'Apr':
                        $resul = '04';
                        break;
                    case 'May':
                        $resul = '05';
                        break;
                    case 'Jun':
                        $resul = '06';
                        break;
                    case 'Jul':
                        $resul = '07';
                        break;
                    case 'Aug':
                        $resul = '08';
                        break;
                    case 'Sep':
                        $resul = '09';
                        break;
                    case 'Oct':
                        $resul = '10';
                        break;
                    case 'Nov':
                        $resul = '11';
                        break;
                    case 'Dec':
                        $resul = '12';
                        break;

            }
            return $resul;
        }

        public function allNews(Request $request){

            $data = $this->formatData();

            return $data;

        }

        public function todayNews(Request $request){

            $val = (object)$request->only([
               'dt_today'
            ]);

            $data = $this->formatData();

            $result =  collect($data['dados'])->Where('pubDate',$val->dt_today);

           return $result;
        }

        public function newsByCategory(Request $request){

            $val = (object)$request->only([
                'category'
            ]);

            $data = $this->formatData();

            $result =  collect($data['dados'])->Where('category',$val->category);

            return $result;

        }

        private function formatData(){

            $data = $this->convertData();
            $arr =[];

            foreach ($data['dados'] as &$item) {

                 $dt = explode(" ",$item['pubDate']);
                 $dia = $dt[1];
                 $mes = $this->convertMonths($dt[2]);
                 $ano = $dt[3];
                 $item['pubDate'] = $ano.'-'.$mes.'-'.$dia;

            }
            return $data;
        }

}
