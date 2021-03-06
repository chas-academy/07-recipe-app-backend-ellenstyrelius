<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>recipes API</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: darkseagreen;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                font-size: 60px;
                letter-spacing: 1px;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            a {
                color: darksalmon;
                font-size: 24px;
                font-weight: 100;
                padding: 2px 5px;
                text-decoration: none;
                text-transform: uppercase;
                border: 1px dashed darksalmon;
            }

            a:hover {
                background: antiquewhite;
                transition: 0.3s;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div>
                    <p>recipes API</p>
                    <p>\(°-°)/</p>
                    <a href="https://pastapizzapotato.netlify.com" target="_blank">go here to search for recipes</a>
                </div>
            </div>
        </div>
    </body>
</html>
