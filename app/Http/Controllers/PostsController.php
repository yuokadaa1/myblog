<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use App\Meigara;
use App\MeigaraList;
use App\Kawase;

class PostsController extends Controller
{
    public function index() {
      $meigaras = Meigara::where('meigaraCode','1301')->where('date','2019-11-11')->get();
      return view('posts.index')->with('meigaras',$meigaras);
    }

    public function show(Meigara $meigaras) {
      return view('posts.show')->with('meigara', $meigara);
    }

    public function create() {
      return view('posts.create');
    }

    public function store(PostRequest $request) {
      $post = new Post();
      $post->title = $request->title;
      $post->body = $request->body;
      $post->save();
      return redirect('/');
    }

    public function edit(Post $post) {
      return view('posts.edit')->with('post', $post);
    }

    public function update(PostRequest $Request,Post $post) {
      $post->title = $request->title;
      $post->body = $request->body;
      $post->save();
      return redirect('/');
    }

    public function destroy(Post $post){
      $post->delete();
      return redirect('/');
    }

    public function stock() {
      return view('posts.stock');
    }

    public function stockChart(Request $request) {
      foreach ($request->input as $input) {
        //画面から入力された東証コードを配列に格納
         $array[] = $input;
      }
      //DBから値を取得
      $Meigaras = Meigara::select('meigaraCode', 'date','openingPrice','closingPrice','highPrice','lowPrice')->whereIn('meigaraCode', $array)->where('date','like','2019-11%')->orderBy('meigaraCode','asc')->orderBy('date','desc')->get();

      //json変換用に日付、各金額のみを抽出した二次配列に変換（キーは銘柄コード）
      $arrayDate = $Meigaras->mapToGroups(function ($item, $key) {
        return [$item['meigaraCode'] => [$item['date']]];
      });
      $arrayOpening = $Meigaras->mapToGroups(function ($item, $key) {
        return [$item['meigaraCode'] => [$item['openingPrice']]];
      });
      $arrayClosing = $Meigaras->mapToGroups(function ($item, $key) {
        return [$item['meigaraCode'] => [$item['closingPrice']]];
      });
      $arrayLow = $Meigaras->mapToGroups(function ($item, $key) {
        return [$item['meigaraCode'] => [$item['lowPrice']]];
      });
      $arrayHigh = $Meigaras->mapToGroups(function ($item, $key) {
        return [$item['meigaraCode'] => [$item['highPrice']]];
      });
      //jsonに変換
      $meigaraDate =  json_encode($arrayDate, JSON_UNESCAPED_UNICODE);
      $meigaraOpening =  json_encode($arrayOpening, JSON_UNESCAPED_UNICODE);
      $meigaraClosing =  json_encode($arrayClosing, JSON_UNESCAPED_UNICODE);
      $meigaraLow =  json_encode($arrayLow, JSON_UNESCAPED_UNICODE);
      $meigaraHigh =  json_encode($arrayHigh, JSON_UNESCAPED_UNICODE);

      return view('posts.stock',compact('Meigaras','meigaraDate','meigaraOpening','meigaraClosing','meigaraLow','meigaraHigh'));
    }

}
