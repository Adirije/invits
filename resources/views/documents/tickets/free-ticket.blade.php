<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} - Event ticket</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700|Kreon:700|Audiowide&subset=latin,latin-ext'
        rel='stylesheet' type='text/css'>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="/admin_assets/plugins/fontawesome-free/css/all.min.css">
</head>

<style>
    body {
        margin: 0;
        color: #ffffff;
        font-family: "Open Sans", sans-serif;
        font-weight: 400;
        font-size: 25px;
    }

    .container {
        width: 795px;
        margin: 0 auto;
    }

    .section {
        position: relative;
        width: 100%;
        background-color: #800080;
        overflow: hidden;
        padding-bottom: 10px;
    }

    .section .left {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        width: 635px;
        padding: 20px 0 0 30px;
    }

    .section .right {
        padding-top: 15px;
        margin-bottom: 10px
    }

    .section .event {
        margin-bottom: 5px;
        font-weight: 700;
        font-size: 1.2em;
        line-height: 35px;
    }

    .section .info {
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .section .seats {
        margin-bottom: 40px;
        font-size: 0.36em;
        text-align: right;
    }

    .section .seats span {
        /* display: block; */
        margin-left: 15px;
        padding: 10px 5px;
        color: #F5A623;
        background: black;
        font-family: 'Courier New', Courier, monospace;
        font-size: 1.777em;
        text-align: center;
        vertical-align: middle;
    }

    .page-break {
        page-break-after: always;
    }
</style>

<body>
    <div class="container">
        <div class="section" style="margin-bottom: 50px">
            <div class="left">
                <div class="event">{{$reg->event->name}}</div>
                <div style="color: #F5A623;">{{ $reg->event->tagline }}</div>

                <div  style="color: #F5A623; margin-top: 20px; margin-bottom: 20px">
                    <span style="color: white">Pass Code: </span>
                    <span style="background-color: black; padding: 5px 2px; font-family:'Courier New', Courier, monospace; letter-spacing: 2px">{{ $reg->checkin_code }}</span>
                </div>
                
                <div>
                    <span class="seats" style="text-transform: uppercase; margin-right: 20px;"><strong>Type</strong><span>FREE</span></span>
                    <span class="seats" style="margin-bottom: 0">
                        <strong style="text-transform: uppercase;">Seat</strong>
                        
                        <span>{{ $reg->seat }}</span>
                    </span>
                </div>

                <div class="info" style="margin-top: 20px">
                    <span style="color: #F5A623;">Date: </span>
                    {{ $reg->event->starts->toDayDateTimeString() }} <span style="color: #F5A623;">- </span>{{ $reg->event->ends->toDayDateTimeString() }}
                </div>

                
                <div class="info" style="margin-top: 10px;">
                    <span style="color: #F5A623;">Venue: </span>
                    {{ $reg->event->location->name }} - <span style="font-size: .7rem;">{{ $reg->event->location->address }}</span>
                </div>
            </div>
            
            <hr style="border: 1px dotted orange; width:100%;">
            <div style=" padding-left:30px; width:100%">
                <div style="font-size: .7rem">Powered by {{config('app.name')}}</div>
                <div style="font-size: .7rem; color: #F5A623;">
                    <span style="padding-right: 15px"><i class="fab fa-internet-explorer"></i> {{config('app.url')}}</span>
                    <span style="padding-right: 15px"><i class="fas fa-at"></i> {{config('app.email')}}</span>
                    <span><i class="fas fa-phone"></i> {{config('app.phone')}}</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>