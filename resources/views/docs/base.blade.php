<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>API Documentation</title>

    <link href="docs/screen.css" rel="stylesheet" media="screen"/>

    <script src="docs/js/lib/jquery.min.js"></script>
    <script src="docs/js/lib/jquery_ui.js"></script>
    <script src="docs/js/lib/energize.js"></script>
    <script src="docs/js/lib/renderjson.js"></script>
    <script src="docs/js/lib/imagesloaded.min.js"></script>
    <script src="docs/js/lib/jquery.highlight.js"></script>
    <script src="docs/js/lib/jquery.tocify.js"></script>
    <script src="docs/js/lib/lunr.js"></script>
    <script src="docs/js/script.js"></script>
</head>

<body class="index">

<a href="#" id="nav-button">
    <span>NAV<img src="docs/images/navbar.png"/></span>
</a>

<div class="tocify-wrapper">

    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>
    <ul class="search-results"></ul>
    <div id="toc"></div>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>

    <div class="content">
        {!! $content !!}
    </div>

    <div class="dark-box"></div>
</div>

<script type="application/javascript">
    $('pre code').each(function (i, block) {
        var json = JSON.parse($(block).html());
        renderjson.set_show_to_level(3);
        renderjson.set_max_string_length(30);
        $(block).html(renderjson(json));
    });
</script>
</body>
</html>
