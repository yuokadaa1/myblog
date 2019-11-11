<?php

// scraping・バッチ実行用のclass
namespace App\Console\Commands;

use Illuminate\Console\Command;
//MeigaraのModelを指定することでここのTableにデータを格納する。
use App\Meigara;
use Config;

class ScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    //コマンド名を設定（元：command:name→変更後：command:scrapecommand）
    //php artisan list で出てくる名前
    protected $signature = 'command:scrapecommand';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    //コマンドの説明（元：Command description→変更後：scrapecommandのコマンド説明）
    protected $description = 'scrapecommandのコマンド説明';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      // ここに処理を記述
      // function dbsave($url){
      function dbsave($url){

        $crawler = \Goutte::request('GET', $url);

        //li に年度データがあるのをすべて回収
        //https://kabuoji3.com/stock/7203/2018/
        $li = $crawler->filter('a')->each(function($element) use ($url){
              echo $element->attr('href')."\n";
              if (0 === strpos($element->attr('href'), $url)) {
                echo $element->attr('href')." は" .$url."から始まります"."\n";
              }
        });

        //これでtrをデータ格納。。。
        $tr = $crawler->filter('table')->eq(0)->filter('tr')->each(function($element){
          $meigara = new Meigara;
          if(count($element->filter('td'))){
            // $meigara->meigaraCode = $sampleService->getSampleRepository();;
            $meigara->meigaraCode = Config::get('user.name');
            $meigara->date = $element->filter('td')->eq(0)->text()."\n";
            $meigara->openingPrice = $element->filter('td')->eq(1)->text()."\n";
            $meigara->highPrice = $element->filter('td')->eq(2)->text()."\n";
            $meigara->lowPrice = $element->filter('td')->eq(3)->text()."\n";
            $meigara->closingPrice = $element->filter('td')->eq(4)->text()."\n";
            //SQLSTATE[22033]がおきるのでいったん置いておく。
            // $meigara->volume = $element->filter('td')->eq(5)->text()."\n";
            $meigara->save();
          }
        });
      }

      $meigaralist = \App\MeigaraList::select('meigaraCode')->get();

      foreach($meigaralist as $key=>$meigara){
        $siteurl = "https://kabuoji3.com/stock/".$meigara['meigaraCode']."/";
        Config::set(['user' => ['name' => $meigara['meigaraCode']]]);
        echo "実行開始：".$meigara['meigaraCode']."\n";
        dbsave($siteurl);
      }
      // $siteurl = "https://kabuoji3.com/stock/7203/";
      // dbsave($siteurl);
  }
}
