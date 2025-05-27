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
            <a href="{{route('index.constancias')}}" class="btn btn-light btn-sm"><i class="fas fa-arrow-circle-left"></i> Regresar</a>
            <br>
            <div id="printableArea">
                <div class="cabecera" style="text-align: center">
                    <img src="../../../assets/images/application/cabecera_gorel.png" alt="Cabecera de la Carta">
                </div>
                <p>CARTA N° {{$numero_carta}}</p>
                <p>Sr./Razón: 
                    @if ($deudor->ruc)
                        {{$deudor->razon}}
                    @else
                        {{$deudor->nombre}} {{$deudor->apellidos}}
                    @endif
                </p>
                <p>DNI/RUC: 
                    @if ($deudor->ruc)
                        {{$deudor->ruc}}
                    @else
                        {{$deudor->dni}}
                    @endif

                </p>
                <p>Dirección: {{$deudor->domicilio}}</p>
                <p>LUGAR: LORETO-{{$deudor->nombre_provincia}}-{{$deudor->nombre_distrito}}</p>
                <p>Presente.</p>
                {{-- <p>Ref. Informe N° 009-2024-GRL-GRA-OECC/mlt</p> --}}
                <p>
                    {!!$contenido!!}   
                </p>
                <p>Por tanto; se le extiende la presente carta.</p>
                <p>Atentamente,</p>
                <img src="{{asset('storage/firmas/'.$firma)}}" alt="">
            </div>
            
            
            <div class="button-container">
                <button onclick="printDiv('printableArea')" class="btn btn-dark btn-sm"><i class="fas fa-print"></i> Imprimir Constancia</button>
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