$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function addNewTeam() {
    alertify.genericDialog || alertify.dialog('genericDialog',function(){
        return {
            main:function(content){
                this.setContent(content);
            },
            setup:function(){
                return {
                    focus:{
                        element:function(){
                            return this.elements.body.querySelector(this.get('selector'));
                        },
                        select:true
                    },
                    options:{
                        basic:true,
                        maximizable:false,
                        resizable:false,
                        padding:false
                    }
                };
            },
            settings:{
                selector:undefined
            }
        };
    });
    alertify.genericDialog ($('#addTeam')[0]).set('selector', 'input[name="title"]');
}

function submitTeam() {
    if ($.trim($("input[name=title]").val()) == '') {
        alertify.error('Team title must be not empty.');
    }

    $.ajax({
        url: 'team/add',
        method: 'POST',
        data: $('#addTeam').serialize(),
        dataType: 'json',
        success: function (data) {
            addTeam(data);
            alertify.success("New team created.");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var msg = JSON.parse(xhr.responseText);
            alertify.error("Team was not added.\n Reason: " + msg.message);
        }
    });
}

function addTeam(data) {
    console.log(data);
    if (data.division == 'A') {
        $("#divisionA").append($("<option></option>").attr("value",data.team_id).text(data.title));
    } else {
        $("#divisionB").append($("<option></option>").attr("value",data.team_id).text(data.title));
    }
    $("input[name=title]").val('');
    $(".ajs-close").click();
}

function deleteTeams() {
    if (confirm("Are you sure do you want to delete ALL selected teams?")) {
        var array = new Array();
        $('#divisionA  option:selected').each(function() {
            array.push($(this).val());
        });
        $('#divisionB  option:selected').each(function() {
            array.push($(this).val());
        });
        if (array.length == 0) {
            alertify.error("You must select teams for deletion.");
            return;
        }

        $.ajax({
            url: 'team/remove',
            method: 'DELETE',
            data: {ids:array},
            dataType: 'json',
            success: function (data) {
                $('#divisionA  option:selected').each(function() {
                    $(this).remove();
                });
                $('#divisionB  option:selected').each(function() {
                    $(this).remove();
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var msg = JSON.parse(xhr.responseText);
                alertify.error("Teams was not removed.\n Reason: " + msg.message);
            }
        });

    }
}

function moveAtoB() {
    var array = new Array();
    $('#divisionA  option:selected').each(function () {
        array.push($(this).val());
    });
    if (array.length == 0) {
        alertify.error("You must select at least one team in Division A.");
        return;
    }
    $.ajax({
        url: 'team/moveAtoB',
        method: 'PUT',
        data: {ids: array},
        dataType: 'json',
        success: function (data) {
            $('#divisionA  option:selected').each(function () {
                $("#divisionB").append($("<option></option>").attr("value", $(this).val()).text($(this).text()));
                $(this).remove();
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var msg = JSON.parse(xhr.responseText);
            alertify.error(msg.message);
        }
    });
}

function moveBtoA() {
        var array = new Array();
        $('#divisionB  option:selected').each(function() {
            array.push($(this).val());
        });
        if (array.length == 0) {
            alertify.error("You must select at least one team in Division B.");
            return;
        }
        $.ajax({
            url: 'team/moveBtoA',
            method: 'PUT',
            data: {ids:array},
            dataType: 'json',
            success: function (data) {
                $('#divisionB  option:selected').each(function() {
                    $("#divisionA").append($("<option></option>").attr("value",$(this).val()).text($(this).text()));
                    $(this).remove();
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var msg = JSON.parse(xhr.responseText);
                alertify.error(msg.message);
            }
        });
}
