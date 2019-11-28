@extends('layouts.default')
@section('content')

<!-- まさかの小文字と大文字誤り -->
@if (isset( $meigaras ))
  <ul>
    @forelse ($meigaras as $meigara)
      <li>
        <!--「http:(ドメイン)/posts/id」　へアクセスするリンクを作る -->
        <!-- action() コントローラーとメソッドを指定する記述　(Postsコントローラのshowメソッド) -->
        <!-- <a href="{{ action('PostsController@show', $meigara) }}">証券コード：{{ $meigara->meigaraCode }}</a> -->
        <a>銘柄：{{ $meigara->meigaraCode }}</a>
        <a>日付：{{ $meigara->date }}</a>
        <a>株価：{{ $meigara->lowPrice }}</a>
      </li>
      <li>
        <a>日経平均：{{ $meigara->meigaraCode }}</a>
        <a>日付：{{ $meigara->date }}</a>
      </li>
      <li>
        <a>NASDAQ：{{ $meigara->meigaraCode }}</a>
        <a>日付：{{ $meigara->date }}</a>
      </li>
      <li>
        <a>Doll円：{{ $meigara->meigaraCode }}</a>
        <a>日付：{{ $meigara->date }}</a>
      </li>
    @empty
      <li>No meigara yet</li>
    @endforelse
  </ul>
@else
  <p>受け取る変数なし。</p>
@endif


<a>ドル／円 </a></br>
<a>日経平均（円ベース） </a></br>
<a>日経平均（＄ベース） </a></br>

@endsection
