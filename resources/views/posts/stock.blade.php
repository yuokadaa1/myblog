@extends('layouts.default')

@section('title', '適当なタイトル')

@section('content')

<script>
  var chartLabel = new Array();
  var chartDate = new Array();
  var chartPrice = new Array();
</script>

<form method="get" action="{{ url('/stock/meigaraCode') }}">
  {{ csrf_field() }}
  <li>
    <a>
    <input type="text" name="title" placeholder="東証コードの入力" value="{{ old('title') }}">
    @if ($errors->has('title'))
      <span class="error">{{ $errors->first('title') }}</span>
    @endif
    </a>
    <a href="{{ url('/stock/meigaraCode') }}" class="edit">[Edit]</a>
  </li>
</form>

<form method="get" action="{{ url('/stock/meigaraCode') }}">
  {{ csrf_field() }}
  <p>
    <input type="submit" value="Search">
  </p>
</form>

@if (isset( $Meigaras ))
<ul>
  @forelse ($Meigaras as $meigara)
    <li>
      <a>証券コード：{{ $meigara->meigaraCode }}</a>
      <a>日付：{{ $meigara->date }}</a>
      <a>株価：{{ $meigara->lowPrice }}</a>
    </li>
    <script>
      chartLabel.push(<?php echo $meigara->meigaraCode; ?>);
      startLive = new Date(<?php echo strtotime($meigara->date)*1000; ?>);
      chartDate.push(startLive);
      chartPrice.push(<?php echo $meigara->lowPrice; ?>);
    </script>
  @empty
    <li>No meigara yet</li>
  @endforelse
</ul>
@else
  <p>受け取る変数なし。</p>
@endif

<script>
  alert('label：' + chartLabel + 'date：' + chartDate + 'price：' + chartPrice);
</script>

<h1>グラフ</h1>
<canvas id="myLineChart"></canvas>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script> -->
<script>
var ctx = document.getElementById("myLineChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    // labels: ['8月1日', '8月2日', '8月3日', '8月4日', '8月5日', '8月6日', '8月7日'],
    labels: chartDate,
    datasets: [
      {
        label: '最高気温(度）',
        // data: [35, 34, 37, 35, 34, 35, 34, 25],
        data: chartPrice,
        borderColor: "rgba(255,0,0,1)",
        backgroundColor: "rgba(0,0,0,0)"
      },
      {
        label: '最低気温(度）',
        data: [7025, 7027, 7027, 7025, 7026, 7027, 7025, 7021],
        // data: [25, 27, 27, 25, 26, 27, 25, 21],
        borderColor: "rgba(0,0,255,1)",
        backgroundColor: "rgba(0,0,0,0)"
      }
    ],
  },
  options: {
    title: {
      display: true,
      text: '気温（8月1日~8月7日）'
    },
    scales: {
      yAxes: [{
        ticks: {
          suggestedMax: 40,
          suggestedMin: 0,
          stepSize: 10,
          callback: function(value, index, values){
            return  value +  '円'
          }
        }
      }]
    },
  }
});
</script>

@endsection
