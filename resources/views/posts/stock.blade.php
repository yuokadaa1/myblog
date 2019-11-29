@extends('layouts.default')

@section('title', '適当なタイトル')

@section('content')

<!--  -->
<script type="text/javascript">
$(function() {
	//追加
	$('.addformbox').click(function() {
		//クローンを変数に格納
		var clonecode = $('.box:last').clone(true);
		//数字を＋１し変数に格納
		var cloneno = clonecode.attr('data-formno');
		var cloneno2 = parseInt(cloneno) + 1;
    var cloneno3 = parseInt(cloneno) + 2;
		//data属性の数字を＋１
		clonecode.attr('data-formno',cloneno2);
		//数値
		clonecode.find('.no').html(cloneno3);

		//name属性の数字を+1
		var namecode = clonecode.find('input.namae').attr('name');
		namecode = namecode.replace(/input\[[0-9]{1,2}/g,'input[' + cloneno2);
		clonecode.find('input.namae').attr('name',namecode);

		//HTMLに追加
		clonecode.insertAfter($('.box:last'));
	});


	//削除
	$('.deletformbox').click(function() {
		//クリックされた削除ボタンの親要素を削除
		$(this).parents(".box").remove();

		var scount = 0;
		//番号振り直し
		$('.box').each(function(){
			var scount2 = scount + 1;

			//data属性の数字
			$(this).attr('data-formno',scount);
			$('.no',this).html(scount2);

			//input質問タイトル番号振り直し
			var name = $('input.namae',this).attr('name');
			name = name.replace(/input\[[0-9]{1,2}/g,'input[' + scount);
			$('input.namae',this).attr('name',name);

			var name2 = $('textarea.toiawase',this).attr('name');
			name2 = name2.replace(/textarea\[[0-9]{1,2}/g,'textarea[' + scount);
			$('textarea.toiawase',this).attr('name',name2);

			scount += 1;
		});
	});

});
</script>

<script>
  var chartLabel = new Array();
  var chartDate = new Array();
  var chartPrice = new Array();
</script>

<form method="get" action="{{ url('/stock/meigaraCode') }}">
  {{ csrf_field() }}
  <div class="box" data-formno="0" style="border:dashed 1px #ccc">
    <li>
      <a class="no">1</a>
      <a>
        <input type="text" name="input[0]" class="namae" placeholder="東証コードの入力" value="{{ old('title') }}">
        @if ($errors->has('title'))
          <span class="error">{{ $errors->first('title') }}</span>
        @endif
      </a>
      <a class="addformbox">追加</a>
      <a class="deletformbox">削除</a>
    </li>
  </div>
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

// <script>
//   alert('label：' + chartLabel + 'date：' + chartDate + 'price：' + chartPrice);
// </script>

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
