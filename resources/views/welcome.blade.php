<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
        <h2>{{ $message }}</h2>

        <table border="1">

            <th>Валюта</th>
            @foreach ($date_period as $date)
            <th> {{ $date }} </th>
            @endforeach

            @foreach ($all_currency_all_rates as $cur)
                <tr>
                <td>
                    {{ $cur['name'] }} ({{ $cur['charcode'] }}/{{ $cur['numcode'] }}) (за {{ $cur['scale'] }})
                </td>
                    @foreach ($cur['rates'] as $rate)

                    <td>
                        {{ $rate }}
                    </td>

                    @endforeach
                </tr>
            @endforeach

        </table>

    </body>
</html>
