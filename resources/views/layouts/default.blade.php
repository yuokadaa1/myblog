<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <!-- <title>@yield('title')</title> -->
  <title>投資のサイト</title>
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/common.css">
  <script src="/js/main.js"></script>
  <script src="/js/chart.js"></script>
</head>

<body>
  <h1>    Blog Posts  </h1>
  <div id="menu">
    <ul>
      <li><a href={{ url("/first") }} class="active">初めに</a></li>
      <li><a href={{ url("/stock") }}>株価</a></li>
      <li><a href={{ url("/exchange") }}>為替</a></li>
      <li><a href={{ url("/zaimu") }}>財務</a></li>
    </ul>
  </div>
  <div id="topicPath">
    <a href="index.html">ホーム</a> &raquo; カテゴリ &raquo; ページ
  </div>
  <div id="contents">
    @yield('content')
  </div>
  <div id="footer">
   <div class="copyright">Copyright &copy; 2011 YOUR SITE NAME All Rights Reserved.</div>
  </div>
</body>

</html>
