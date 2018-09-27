<!DOCTYPE html>
<meta name="csrf-token" content="{{ csrf_token() }}">
<html lang="en">
<head>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
    <script src="js/teams.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>

    <meta charset="UTF-8">
    <title>Teams</title>
</head>
<body>

<div style="width:100%;text-align: center;color:blue;">
    <div style="float:left; width:80%;"><H2>Teams</H2></div>
    <div style="float:right; width:20%;"><a href="games">Games</a></div>
</div>
<div style="float:left; width:48%;text-align:center;">
        <h3>Division A</h3>
    <select style="width: 100%;height:350px;" multiple id="divisionA">
        @foreach ($teams as $team)
            @if ($team->division == 'A')
                <option value="{{ $team->team_id }}">{{ $team->title }}</option>
            @endif
        @endforeach
    </select>
</div>
<div style="float:left; width:4%;text-align:center;vertical-align: middle;">
    <h3>&nbsp;</h3>
    <input type="button" value="<" style="width:100%;" onclick="moveBtoA()">
    <BR>
    <BR>
    <input type="button" value=">" style="width:100%;" onclick="moveAtoB()">
    <BR>
    <BR>
    <input type="button" value="+" style="width:100%;" onclick="addNewTeam()">
    <BR>
    <BR>
    <input type="button" value="-" style="width:100%;" onclick="deleteTeams()">
</div>
<div style="float:left; width:48%;text-align: center;">
        <h3>Division B</h3>
    <select style="width: 100%;height:350px;" multiple id="divisionB">
        @foreach ($teams as $team)
            @if ($team->division == 'B')
                <option value="{{ $team->team_id }}">{{ $team->title }}</option>
            @endif
        @endforeach
    </select>

</div>
<div style="display: none;">
    <!-- the form to be viewed as dialog-->
    <form id="addTeam">
        <fieldset>
            <div style="width:100%;">
                <label> Title </label>
                <input type="text" name="title" value="" style="width: 300px;">
            </div>
            <div style="width:100%;padding-top: 8px;">
                <label> Division </label>
                <select name="division">
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select>
            </div>
            <div style="width:100%;padding-top: 8px;">
                <input type="button" value="Add team" onclick="submitTeam()">
            </div>
        </fieldset>
    </form>
</div>




</body>
</html>