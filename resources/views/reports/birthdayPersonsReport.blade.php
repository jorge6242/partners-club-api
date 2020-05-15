<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 25px;
            }
            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 40px;

                /** Extra personal styles **/
                border: 1px solid black;
                border-top: 0px;
                border-left: 0px;
                border-right: 0px;
                border-bottom: 1px solid black;
                text-align: left;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 30px; 

                text-align: center;
                line-height: 35px;
            }
            .page-number:before {
                content: "Pagina " counter(page);
            }
            thead th{
                font-size: 8px;
                border-bottom: 1px black solid;
                padding-bottom: 5px;
                text-align: left;
            }
            tbody td{
                font-size: 8px;
                padding-top: 5px;
                padding-bottom: 5px;
            }
        }

        </style>
    </head>
    <body>

            <header>Reporte de Cumpleaños para el mes de {{ ucwords($month) }}</header>
            <footer>
                <div class="page-number"></div> 
            </footer>
            <table width="100%" cellspacing="0" page-break-inside: auto>
                <thead>
                    <tr>
                        <th>Accion</th>
                        <th>Parentesco</th>
                        <th>Rif/CI</th>
                        <th>Nombre</th>
                        <th>Nacimiento</th>
                   </tr>
               <thead>
                <tbody>
                @foreach ($data as $element)
                    <tr>
                        <td>{{ $element->shareList }}</td> 
                        <td>{{ $element->relation ? $element->relation: '' }} </td> 
                        <td>{{ $element->rif_ci }}</td> 
                        <td>{{ $element->name }} {{ $element->last_name }}</td> 
                        <td>{{ $element->birth_date }}</td> 
                        
                    </tr> 
                @endforeach
                 <tbody>
            </table>
    </body>
</html>