$('#server-list').change(function (e) {
    $.ajax({
        url: '/admin/server/stats',
        method: 'GET',
        data: {
            period: $(this).val(),
        },
        success: function (data) {
            if (data.status == 0) {
                $('#js-all-stat-all').html(data.allStat.all);
                $('#js-all-stat-without').html(data.allStat.withOutCapcha);
                $('#js-all-stat-with').html(data.allStat.withCapcha);

                for (let i = 0; i < data.serversStat.length; i++) {
                    $("#js-stat-all[data-server-id='" + data.serversStat[i].server_id + "']").html(data.serversStat[i].all);
                    $("#js-stat-without[data-server-id='" + data.serversStat[i].server_id + "']").html(data.serversStat[i].withOutCapcha);
                    $("#js-stat-with[data-server-id='" + data.serversStat[i].server_id + "']").html(data.serversStat[i].withCapcha);
                }
            } else {
                console.log(data);
            }
        },
        error: function () {

        }
    });
});