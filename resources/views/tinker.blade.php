<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Meetup #1 - Botman</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        body {
            font-family: "Source Sans Pro", sans-serif;
            margin: 0;
            padding: 0;
            background: radial-gradient(#57bfc7, #45a6b3);
        }

        .container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .content {
            text-align: center;
        }

        .btn.botton {
            text-decoration: none;
            color: black;
            position: fixed;
            top: 20px;
            left: 20px;
            text-align: left;
            padding: 5px 10px;
            width: 175px;
            font-size: 18px !important;
            line-height: normal !important;
        }

        .btn.botton.active {
            background: black;
            color: gold;
        }

        .btn.botton:nth-of-type(2) {
            top: 60px;
        }

        .btn.botton:nth-of-type(3) {
            top: 100px;
        }

        .btn.botton:nth-of-type(4) {
            top: 140px;
        }

        .btn.botton:nth-of-type(5) {
            top: 180px;
        }

        div .ChatLog__avatar {
            border-radius: 0;
        }

        .ChatLog .btn {
            cursor: pointer;
            border: 2px solid black;
            background: white;
            transition: all .2s ease;
        }

        .ChatLog .btn:hover {
            background: black;
            color: white;
        }

        .ChatLog__entry.ChatLog__entry_mine .ChatLog__message:after {
            content: '';
            display: block;
            position: absolute;
            top: -13px;
            right: -60px;
            height: 50px;
            width: 50px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url(/me.png);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content" id="app">
        <a href="/botman/tinker/bases" class="btn botton {{ request()->is('*bases*') ? 'active': '' }}">1. Bases</a>
        <a href="/botman/tinker/conversations" class="btn botton {{ request()->is('*conversations*') ? 'active': '' }}">2. Conversations</a>
        <a href="/botman/tinker/storages" class="btn botton {{ request()->is('*storages*') ? 'active': '' }}">3. Storages</a>
        <a href="/botman/tinker/files" class="btn botton {{ request()->is('*files*') ? 'active': '' }}">4. Files</a>
        <a href="/botman/tinker/middlewares" class="btn botton {{ request()->is('*middlewares*') ? 'active': '' }}">5. Middlewares</a>
        <botman-tinker api-endpoint="/botman"></botman-tinker>
    </div>
</div>

<script src="/js/app.js"></script>
<script>
    window.addEventListener('load', function () {
        document.querySelector("input.ChatInput").focus();
    });
</script>
</body>
</html>