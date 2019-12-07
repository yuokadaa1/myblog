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
	{{ $meigaraOpening }}
	<ul>
	  @forelse ($Meigaras as $meigara)
	    <li>
	      <a>証券コード：{{ $meigara->meigaraCode }}</a>
	      <a>日付：{{ $meigara->date }}</a>
	      <a>株価：{{ $meigara->openingPrice }}</a>
	    </li>
		@empty
	    <li>No meigara yet</li>
	  @endforelse
	</ul>

	<script>
	  // var colorArray = ['blue','red','navy','teal','green','lime','aqua','yelow']
		var colorArray = ['rgba(230,10,10,1)','rgba(0,0,14,0)','navy','teal','green','lime','aqua','yelow']
		var chartDate = new Array();
		var chartMeigaraCode = new Array();
		var chartOpen = new Array();
		var chartClose = new Array();
		var chartHigh = new Array();
		var chartLow = new Array();

		//phpをechoしてjavascriptにデータを渡す。
		var data = <?php echo $meigaraDate; ?>;
		for(key in data){			chartMeigaraCode.push(key);		};
		var i = 0;
		var dataDate = <?php echo $meigaraDate; ?>;
		var dataOpen = <?php echo $meigaraOpening; ?>;
		var dataClose = <?php echo $meigaraClosing; ?>;
		var dataHigh = <?php echo $meigaraHigh; ?>;
		var dataLow = <?php echo $meigaraLow; ?>;
		for(key in dataDate){
			chartDate[i] = dataDate[key];
			chartOpen.push(dataOpen[key]);
			chartClose.push(dataClose[key]);
			chartHigh.push(dataHigh[key]);
			chartLow.push(dataLow[key]);
			i++;
		}

		//chart.jsで使用するための配列に整理
		var datasetsArray = new Array();
		for (i = 0; i < chartMeigaraCode.length; i++) {
			var datasetArray = new Array();
			datasetArray['label'] = chartMeigaraCode[i];
			datasetArray['type'] = 'line';
			datasetArray['fill'] = 'false';
			datasetArray['data'] = chartOpen[i];
			datasetArray['borderColor'] = colorArray[i % 8];
			datasetArray['backgroundColor'] = "rgba(0,0,0,0)";
			datasetArray['yAxisID'] = "y-axis-1";
			datasetsArray[i] = datasetArray;
			//邪魔だからいったんコメントアウト（有効）
			// console.log("datasetsArray[i]['borderColor']"  + i + ":" + datasetsArray[i]['borderColor']);
	  }
		console.log("datasetsArray[0]['data']" + datasetsArray[0]['data']);
		console.log("datasetsArray[0]['borderColor']" + datasetsArray[0]['borderColor']);
		console.log("datasetsArray[1]['data']" + datasetsArray[1]['data']);
		console.log("datasetsArray[1]['borderColor']" + datasetsArray[1]['borderColor']);
	</script>
@else
  <p>受け取る変数なし。</p>
@endif

<h1>グラフ</h1>
<canvas id="myChart"></canvas>
<script type="text/javascript">
		var ctx = document.getElementById('myChart').getContext('2d');
		var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
						labels: chartDate[0],
						datasets: datasetsArray
						// datasets: [{
						// 		label: '折れ線A',
						// 		type: "line",
						// 		fill: false,
						// 		data: [10000, 11000, 15000, 12000, 9000, 12000, 13000],
						// 		borderColor: "rgb(154, 162, 235)",
						// 		yAxisID: "y-axis-1",
						// }, {
						// 		label: '折れ線B',
						// 		type: "line",
						// 		fill: false,
						// 		data: [8000, 9000, 10000, 9000, 6000, 8000, 7000],
						// 		borderColor: "rgb(54, 162, 235)",
						// 		yAxisID: "y-axis-1",
						// }, {
						// 		label: '棒グラフ',
						// 		data: [22, 23, 10, 15, 40, 35, 30],
						// 		borderColor: "rgb(255, 99, 132)",
						// 		backgroundColor: "rgba(255, 99, 132, 0.2)",
						// 		yAxisID: "y-axis-2",
						// }]
				},
				options: {
						tooltips: {
								mode: 'nearest',
								intersect: false,
						},
						responsive: true,
						scales: {
								yAxes: [{
										id: "y-axis-1",
										type: "linear",
										position: "left",
										ticks: {
												max: 3000,
												min: 0,
												stepSize: 1000
										},
								}, {
										id: "y-axis-2",
										type: "linear",
										position: "right",
										ticks: {
												max: 200,
												min: 0,
												stepSize: 5
										},
										gridLines: {
												drawOnChartArea: false,
										},
								}],
						},
				}
		});

</script>

@endsection
