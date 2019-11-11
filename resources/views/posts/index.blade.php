@extends('layouts.default')
@section('content')

<ul>
  @forelse ($meigaras as $meigara)
    <li>
      <!--「http:(ドメイン)/posts/id」　へアクセスするリンクを作る -->
      <!-- action() コントローラーとメソッドを指定する記述　(Postsコントローラのshowメソッド) -->
      <!-- <a href="{{ action('PostsController@show', $meigara) }}">証券コード：{{ $meigara->meigaraCode }}</a> -->
      <a>証券コード：{{ $meigara->meigaraCode }}</a>
      <a>日付：{{ $meigara->date }}</a>
      <a>株価：{{ $meigara->lowPrice }}</a>
    </li>
  @empty
    <li>No meigara yet</li>
  @endforelse
</ul>

<a>ドル／円 </a></br>
<a>日経平均（円ベース） </a></br>
<a>日経平均（＄ベース） </a></br>

@endsection
