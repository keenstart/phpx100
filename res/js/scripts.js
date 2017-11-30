$(document).ready(function(){
    var Interval = 0;
    var user = {
        user_id: 0
    };

    $( ".ajaxTable" ).hide();

    user.transactions = function() {
        var addTable = "", row = "";
        $.ajax({
                type: "GET",
                url: 'getData.php',
                data: {userid:this.user_id},
                success: function(data)
                {
                    //alert(data);
                    objJSON = JSON.parse(data);
                    $.each(objJSON, function( i,d ) {
                        row =  user.transactionRow(d);
                        addTable = addTable + row;
                    });
                    $('tbody').html(addTable);
                    $( ".ajaxTable" ).show();

                }
        });
    };

    user.transactionRow = function(data) {
        var row = '<tr>' +
                    '<td>' + data.id + '</td>' +
                    '<td>' + data.transaction_detail + '</td>' +
                    '<td>' + data.userid + '</td>' +
                    '<td>' + data.username + '</td>' +
                    '<td>' + data.email + '</td>' +
                  '</tr>';

        return row;
    };

    $('#loadajax').click(function() {
        user.user_id = $("#userID").val();
        if ( user.user_id == null || user.user_id == "" ) {
          alert("Please enter User Id");
            return false;
       }
       user.transactions();
    });

    $('#loadMillion').click(function() {
        $( ".ajaxTable" ).hide();
        var OnOff = $('#OnOff').html();
        
        if(OnOff == 1) {
            $('#loadMillion').html('Click to Stop loading');
            $('#OnOff').html('0');
            $('.Ajax').hide();
            Interval = setInterval(getProgress, 5000);
        } else {
            $('#loadMillion').html('Click to Insert 1Mil rows');
            $('#OnOff').html('1');
            $('.Ajax').show();
            clearTimeout(Interval);
        }

        $.ajax({
                type: "GET",
                url: 'loadData.php',
                data: {onoff:OnOff},
                success: function(data)
                {
                }
        });
    });

    function getProgress() {
        $.ajax({
            type: "GET",
            url: 'loadData.php',
            data: {},
            success: function(data)
            {
                if ( data != "" ) {
                    $('.progress').html('<div class="progress-bar" role="progressbar" style="width: ' + data + '%;" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100">' + data + '%</div>');
                }
            }
        });
    }

});


