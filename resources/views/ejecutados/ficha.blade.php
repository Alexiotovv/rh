@extends('bases.base')
@section('css')
    <style>
        #printableArea {
            border: 1px solid #000;
            padding: 20px;
            margin: 20px;
        }
        .cabecera img {
            max-width: 100%;
            height: auto;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <br>
            <a href="{{route('index.ejecutado')}}" class="btn btn-light btn-sm"><i class="fas fa-arrow-circle-left"></i> Regresar</a>
            <br>
             <div class="button-container">
                <button onclick="printDiv('printableArea')" class="btn btn-dark btn-sm"><i class="fas fa-print"></i> Imprimir Ficha</button>
            </div>
            <div id="printableArea">
                <div class="cabecera" style="text-align: center">
                    <img src="../../../assets/images/application/cabecera_gorel.png" alt="Cabecera de la Carta">
                </div>
                <h4 style="text-align: center">Ficha de Registro</h4>
                
                    <table class="table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align: center;">DATOS PERSONALES DEL TRABAJADOR (A)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 30%">NOMBRE/REP.LEGAL</td>
                                <td>
                                    @if ($deudor->ruc)
                                        {{$deudor->nombre_rep}}{{$deudor->apellidos_rep}}
                                    @else
                                        {{$deudor->nombre}} {{$deudor->apellidos}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%">DNI/RUC</td>
                                <td>
                                    @if ($deudor->ruc)
                                        {{$deudor->ruc}}
                                    @else
                                        {{$deudor->dni}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%">CARGO</td>
                                <td>
                                    {{$deudor->cargo}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%">CONDICIÓN LABORAL</td>
                                <td>
                                    {{$deudor->condicion_laboral}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    @foreach ($expediente as $exp)
                    
                        <br>
                        <table class="table-bordered" style="width: 100%">    
                            <thead>
                                <tr>
                                    <th colspan="2" style="text-align: center;">DATOS ENTIDAD FINANCIERA (B) - {{$loop->iteration}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td style="width: 30%">ENTIDAD</td>
                                        <td>
                                            {{$exp->nombre_entidad}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">TIPO CRÉDITO</td>
                                        <td>
                                            {{$exp->tipo_credito}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">PLAZO MESES</td>
                                        <td>
                                            {{$exp->plazo_meses}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">CUOTA</td>
                                        <td>
                                            {{$exp->monto_dscto}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">CANTIDAD</td>
                                        <td>
                                            {{$exp->monto}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">FECHA</td>
                                        <td>
                                            {{$exp->fecha}}
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        
                        <br>
                        @php $totalIngresos = 0; @endphp

                        <table class="table-bordered" style="width: 100%">    
                            <thead>
                                <tr>
                                    <th colspan="2" style="text-align: center;">INGRESOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ingresos as $ingr)
                                    @if ($exp->id==$ingr->expediente_id)
                                        @php $totalIngresos += $ingr->monto_ingreso; @endphp

                                        <tr>
                                            <td style="width: 30%">{{$ingr->nombre_ingreso}}</td>
                                            <td>{{ number_format($ingr->monto_ingreso, 2) }}</td>

                                        </tr>  
                                    @endif
                                @endforeach
                                <tr>
                                    <td style="font-weight: bold; text-align: right;">Total Ingresos:</td>
                                    <td style="font-weight: bold;">{{ number_format($totalIngresos, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <br>
                        @php $totalEgresos = 0; @endphp
                        <table class="table-bordered" style="width: 100%">    
                            <thead>
                                <tr>
                                    <th colspan="2" style="text-align: center;">EGRESOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($egresos as $egr)
                                    @if ($exp->id==$egr->expediente_id)
                                        @php $totalEgresos += $egr->monto_egreso; @endphp
                                        <tr>
                                            <td style="width: 30%">{{$egr->nombre_egreso}}</td>
                                            <td>{{ number_format($egr->monto_egreso, 2) }}</td>
                                        </tr>
                                                
                                    @endif
                                @endforeach
                                <tr>
                                    <td style="font-weight: bold; text-align: right;">Total Egresos:</td>
                                    <td style="font-weight: bold;">{{ number_format($totalEgresos, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                                        

                        <hr>

                    @endforeach



                <hr>
                {{-- <img src="{{asset('storage/firmas/'.$firma)}}" alt=""> --}}
            </div>
            
            
            <div class="button-container">
                <button onclick="printDiv('printableArea')" class="btn btn-dark btn-sm"><i class="fas fa-print"></i> Imprimir Ficha</button>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
function printDiv(divId) {
    var divToPrint = $('#' + divId).html();
    var styles = `
        <link rel="stylesheet" href="../../../assets/css/style.css" id="main-style-link" >
        <link rel="stylesheet" href="../../../assets/css/style-preset.css" >
        <link rel="stylesheet" href="../../../assets/fonts/material.css" >
        
        <style>
            @media print {
                @page { size: A4; margin: 20mm; }
                body { margin: 0; }
            }
        </style>
    `;
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write(`
        <html>
        <head>
            <title>Print</title>
            ${styles}
        </head>
        <body onload="window.print()">
            ${divToPrint}
        </body>
        </html>
    `);
    newWin.document.close();
    setTimeout(function() {
        newWin.close();
    }, 10);
}

</script>
@endsection