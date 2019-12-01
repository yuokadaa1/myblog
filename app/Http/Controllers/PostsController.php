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
      $inputCount = count($array);
      //DBから丸ごととってくる。
      $Meigaras = Meigara::select('meigaraCode', 'date','lowPrice')->whereIn('meigaraCode', $array)->where('date','like','2019-11%')->orderBy('meigaraCode','asc')->orderBy('date','desc')->get();

      //取得してきたDBの値を項目ごとに分解する。
      $i = 0;
      foreach ($request->input as $input) {
        //画面から入力された東証コードを連想配列に格納
        $filtered = $Meigaras->where('meigaraCode', $input);
        //要素の中から指定したキーの項目だけをまとめて取ってきて多重配列に格納する。
        //$arrayMeigaraCode[][] =[[0][1301,1301,1301],[1][1332,1332,1332]]
        $plucked = $Meigaras->pluck('meigaraCode');
        $arrayMeigaraCode[$i][] = $plucked->all();
        $plucked = $Meigaras->pluck('date');
        $arrayDate[$i][] = $plucked->all();
        $plucked = $Meigaras->pluck('lowPrice');
        $arrayPrice[$i][] = $plucked->all();
        $i++;
      }

      // return view('posts.stock')->with(['Meigaras' => $Meigaras,'inputCount' => count($array)]);
      return view('posts.stock',compact('Meigaras','inputCount','arrayMeigaraCode','arrayDate','arrayPrice'));
    }

}
