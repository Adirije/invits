<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    
        <style>
            table, td, th {
                border: 1px solid black;
                border-collapse: collapse;
            }
    
            td {
                text-align: center;
            }
    
            td, th {
                padding-left: 10px;
                padding-right: 10px;
            }
    
            .info {
                color: #6c757d !important;
                font-size: 80%;
                font-weight: 400;
            }
    
            .branding{
                color: purple;
                background-color:  #fbfbfb; 
            }
    
            @page { 
                margin: 50px 35px 100px 35px; 
            }
    
            .footer { 
                position: fixed; 
                bottom: -70px; 
                padding: 10px 0;
                left: 0px; 
                right: 0px; 
                height: 50px; 
            }
    
            .footer .pagenum:before {
                content: counter(page);
            }
        </style>
    </head>
<body>
    <div class="footer">
        <div class="branding">
            <div>Powered by {{ config('app.name') }}</div>
            <div style="font-size: 85%;">
                <span style="margin-right: 15px">{{ config('app.url') }}</span>
                <span style="margin-right: 15px">{{ config('app.email') }}</span>
                <span>{{ config('app.phone') }}</span>
            </div>
        </div>
        <div style="text-align: center; font-size: 85%;" class="pagenum-container">Page <span class="pagenum"></span></div>
    </div>
    <div>
        @yield('content')
    </div>
</body>
</html>