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

            @foreach ($all_currency as $cur)
                <tr>
                <td>
                За {{ $cur->scale }} {{ $cur->name }}({{ $cur->charcode }}/{{ $cur->numcode }})
                </td>
            
                @foreach ($all_currency_rate as $cur_rate)
                    
                    @if ($cur_rate->numcode === $cur->numcode)
                    <td>
                        {{ $cur_rate->rate}}
                    </td>
                    @endif
                    

                @endforeach                

                </tr>
            @endforeach

        </table>

    </body>
</html>
