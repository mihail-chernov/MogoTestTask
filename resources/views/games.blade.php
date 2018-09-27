<!DOCTYPE html>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<html lang="en">
<head>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
    <script src="js/games.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>

    <meta charset="UTF-8">
    <title>Games</title>
</head>
<body>

<div style="width:100%;float:left;">
    <div style="width:100%;text-align: center;color:blue;">
        <div style="float:left; width:80%;"><H2>Games</H2></div>
        <div style="float:right; width:20%;"><a href="../">Teams</a></div>
    </div>
    <div style="float:left; width:48%;text-align:center;">
        <h3>Division A games</h3>
        @foreach ($games as $game)
            @if ($game->division == 'A')
            <div style="float:left;width:100%">{{ $game->team1->title }} vs {{ $game->team2->title }} :: {{ $game->scores1 }}:{{ $game->scores2 }}</div>
            @endif
        @endforeach
    </div>
    <div style="float:left; width:4%;text-align:center;vertical-align: middle;">
        <h3>&nbsp;</h3>
        <input type="button" value="Play" style="width:100%;" onclick="playGames()">
    </div>
    <div style="float:left; width:48%;text-align: center;">
        <h3>Division B games</h3>
        @foreach ($games as $game)
            @if ($game->division == 'B')
                <div style="float:left;width:100%">{{ $game->team1->title }} vs {{ $game->team2->title }} :: {{ $game->scores1 }}:{{ $game->scores2 }}</div>
            @endif
        @endforeach
    </div>
</div>

<div style="width:100%;text-align:center;padding-top:25px;float:left;">
    <h3>Semi-final</h3>
    @foreach ($games as $game)
        @if ($game->division == 'S')
            <div style="float:left;width:100%">{{ $game->team1->title }}({{ $game->team1->division }}) vs {{ $game->team2->title }}({{ $game->team2->division }}) :: {{ $game->scores1 }}:{{ $game->scores2 }}</div>
        @endif
    @endforeach

</div>

<div style="width:100%;text-align:center;padding-top:25px;float:left;">
    <h3>Final</h3>
    @foreach ($games as $game)
        @if ($game->division == 'F')
            <div style="float:left;width:100%">{{ $game->team1->title }}({{ $game->team1->division }}) vs {{ $game->team2->title }}({{ $game->team2->division }}) :: {{ $game->scores1 }}:{{ $game->scores2 }}</div>
        @endif
    @endforeach
</div>







</body>
</html>