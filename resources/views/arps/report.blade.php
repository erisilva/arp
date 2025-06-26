<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style media="screen">
        @page {
            margin: 0cm 0cm;
        }

        body {
            margin-top: 2cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: rgb(179, 179, 179);
            color: white;
            text-align: center;
            line-height: 1.5cm;
            font-family: Helvetica, Arial, sans-serif;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: rgb(179, 179, 179);
            color: white;
            text-align: center;
            line-height: 1.5cm;
        }

        footer .page-number:after {
            content: counter(page);
        }

        .bordered td {
            border-color: #959594;
            border-style: solid;
            border-width: 1px;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <header>
        ARP
    </header>

    <footer>
        <span>{{ date('d/m/Y H:i:s') }} - </span><span class="page-number">Página </span>
    </footer>

    <main>
        <table class="bordered" width="100%">
            <thead>
                <th style="text-align:left;">ARP</th>
                <th style="text-align:left;">PAC</th>
                <th style="text-align:left;">PE</th>
                <th style="text-align:left;">Vigência Inicial</th>
                <th style="text-align:left;">Vigência Final</th>
                <th style="text-align:center;">Situação</th>
                <th style="text-align:left;">SIGMA</th>
                <th style="text-align:left;">Objeto</th>
                <th style="text-align:left;">Valor</th>
                <th style="text-align:right;">Cota</th>
                <th style="text-align:right;">Empenho</th>
            </thead>
            <tbody>
                @foreach($dataset as $row)
                    <tr>
                        <td>{{ $row->arp }}</td>
                        <td>{{ $row->pac }}</td>
                        <td>{{ $row->pe }}</td>
                        <td>{{ $row->vigenciaInicio->format('d/m/Y') }}</td>
                        <td>{{ $row->vigenciaFim->format('d/m/Y') }}</td>
                        <td style="text-align:center;">
                            {{ $row->vigente == 1 ? 'Vigente' : 'Vencido' }}
                        </td>
                        <td>{{ $row->sigma }}</td>
                        <td>{{ $row->objeto }}</td>
                        <td style="text-align:right;">
                            {{ number_format($row->valor, 2, ',', '.') }}
                        </td>
                        <td style="text-align:right;">
                            {{ $row->cota_total }}
                        </td>
                        <td style="text-align:right;">
                            {{ $row->empenho_total }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
