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

    // public function stockChart(int $meigaraCode) {
    // public function stockChart(Request $request) {
    public function stockChart(Request $request) {
      foreach ($request->input as $input) {
         $array[] = $input;
      }
      $Meigaras = Meigara::select('meigaraCode', 'date','lowPrice')->whereIn('meigaraCode', $array)->where('date','like','2019-11%')->get();
      return view('posts.stock')->with('Meigaras', $Meigaras);
    }

}
