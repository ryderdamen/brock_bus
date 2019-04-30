<!DOCTYPE html>
<!--
██████╗ ██████╗ 
██╔══██╗██╔══██╗
██████╔╝██║  ██║
██╔══██╗██║  ██║
██║  ██║██████╔╝
╚═╝  ╚═╝╚═════╝     
Designed and built by Ryder Damen, 2014
-->


<head>
    <title>Arriving Buses - Brock University</title>

    <link rel="stylesheet" type='text/css' href='/static/css/style.css' />
    <link rel='stylesheet' media='screen and (max-width: 900px)' href='/static/css/mobile.css' />
    <link rel='stylesheet' media='screen and (max-device-width: 900px)' href='/static/css/mobile.css' />
    <meta http-equiv='refresh' content='10800'>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script>
        $.ajaxSetup({
            cache: false
        });
        $(document).ready(function () {
            $("#predictions").load("schedule.php");

            setInterval(function () {
                $("#predictions").load("schedule.php");
            }, 10000);

        });
    </script>
</head>

<body>
    <div class='header'>
        <div class="headercontainer">
            <h1>BrockBus - Tower Departures</h1>
            <h6>Helping badgers get home on time</h6>
        </div>
    </div>
    <div class="headerbottom"></div>
    <div class="buscontainer">
        <div id="predictions"></div>
    </div>
    <div class="footer">
        <div class="footercontainer">
            <h7>Designed by <h6>Ryder Damen</h6>
            </h7>
            <h7><a href='https://ryderdamen.com' target='_blank' alt='ryderdamen.com'>ryderdamen.com</a></h7>
        </div>
    </div>
</body>

</html>