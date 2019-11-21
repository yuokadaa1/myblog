<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use App\Meigara;
use App\Kawase;
use DB;

class PostsController extends Controller
{
    public function index() {
      // $meigaras = Meigara::where('meigaraCode','1301')->where('date','2019-11-11')->latest()->get();
      // $meigaras = Meigara::where('meigaraCode','1301')->where('date','2019-11-11')->get();
      // $meigaras = Meigara::first();
      // $meigaras = DB::table('meigaras')->first();

      // $data = HogeModel::where([ ['id', $id], ['parent_id', $parent_id] ])->get()->toArray();
      $meigaras = Meigara::where([ ['meigaraCode', '1301'], ['meigaraCodeA',''],['date', '2019-11-11'] ])->get()->toArray();
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
      // $Meigaras = new Meigara();
      return view('posts.stock');
    }

    public function stockChart(int $meigaraCode) {
      $Meigaras = DB::table('meigaras')->select('meigaraCode', 'date','lowPrice')->where('meigaraCode', $meigaraCode)->get();
      return view('posts.stock')->with('Meigaras', $Meigaras);
      // 複数渡す場合
      // return view('test.normal',compact('test_1','test_2'));
    }

}
