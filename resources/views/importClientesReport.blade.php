@extends('layouts.app')

@section('content')
<!--Encabezado-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="d-flex mb-2 justify-content-between">
            <h1>Importación de clientes</h1>
        </div>
        </div>
    </div>
  <!--Cuerpo-->
    <div class="row justify-content-center">
        <div class="container">
            <h3>Se concluyó el análisis y el procesamiento del archivo proporcionado.</h3>
            <br/>

            @if ($completos_total != 0)
                <p>se han creado <b>{{$completos_total}}</b> cuentas de clientes</p>
                <p> En este apartado del reporte de importación se presentan los clientes que están completos, no falta información en una o más columnas del documento Excel (.xlsx) y tampoco se han presentado problemas con los correos electrónicos, toda esta información se requiere para la correcta operación de la cuenta.</p>
                    @foreach ($completos as $c)
                    <li>Nombre: <b>{{$c[0]}}</b> ,Tipo: <b>{{$c[1]}}</b> ,Email: <b>{{$c[2]}}</b> ,Dirección: <b>{{$c[3]}}</b> ,Celular: <b>{{$c[4]}}</b> </li>
                    @endforeach
                <br>
            @else
                <p>No se ha creado algún usuario ya que no cumple con los requisitos para crear una cuenta.</p>
            @endif
            <p><br></p>
            @if ($incompletos_total != 0)
                <p>se han encontrado <b>{{$incompletos_total}}</b> filas las cuales no cumplen con los requisitos mínimos de información para crear la cuenta</p>
                <br>
                <p> En este apartado del reporte de importación solo muestra clientes, que le falta algún dato de alguna o más columnas, se debe revisar el documento (.xlsx), toda esta información se requiere para la correcta operación de la cuenta. </p>
                    @foreach ($incompletos as $in)
                        <li>Nombre: <b>{{ $in[0] }}</b> ,Tipo: <b>{{ $in[1] }}</b> ,Email: <b>{{ $in[2] }}</b> ,Dirección: <b>{{ $in[3] }}</b> ,Celular: <b>{{$in[4]}}</b> </li>
                    @endforeach
                    @foreach ($graves as $g)
                        <li>Nombre: <b>{{ $g[0] }}</b> ,Tipo: <b>{{ $g[1] }}</b> ,Email: <b>{{ $g[2] }}</b> ,Dirección: <b>{{ $g[3] }}</b> ,Celular: <b>{{$g[4]}}</b> </li>
                    @endforeach
                <br>
            @endif
            <p><br></p>
            @if ($correoUsados_total != 0)
                <p>se han encontrado <b>{{$correoUsados_total}}</b> filas las cuales están usando un correo el cual ya está en uso</p>
                <br>
                <p> En este apartado de reporte de importación se van a señalar usuarios que se están agregando a la base de datos que tienen un correo electrónico que está vinculado a otra cuenta de otro usuario ya registrado previamente, se recomienda revisar la base de datos en el apartado de clientes y solicitar al cliente otro correo electrónico, se requiere para correcta operación de la cuenta.</p>
                    @foreach ($correoUsados as $cu)
                        <li>Nombre: <b>{{$cu[0]}}</b> ,Tipo: <b>{{$cu[1]}}</b> ,Email: <b>{{$cu[2]}}</b> ,Dirección: <b>{{$cu[3]}}</b> ,Celular: <b>{{$cu[4]}}</b> </li>
                    @endforeach
                <br>
            @endif
            <p><br></p>
            @if ($correoDuplicados_total != 0)
                <p>se han encontrado <b>{{$correoDuplicados_total}}</b> filas las cuales están usando el mismo correo</p>
                <br>
                <p> En este apartado de reporte de importación se van a señalar, que en el mismo documento de Excel(.xlsx) hay dos usuarios utilizando el mismo correo y se indican a continuación; se recomiendo revisar el documento (.xlsx) y utilizar los correos que sean necesarios para cada usuario, uno por cada usuario, se requiere para la correcta operación de la cuenta.</p>
                <br>
                    @foreach ($correoDuplicados as $cd)
                        <li>Nombre: <b>{{$cd[0]}}</b> ,Tipo: <b>{{$cd[1]}}</b> ,Email: <b>{{$cd[2]}}</b> ,Dirección {{$cd[3]}},Celular {{$cd[4]}} </li>
                    @endforeach
                <br>
            @endif
            <p><br></p>
            @if ($no_son_correo_total != 0)
                <p>se han encontrado <b>{{$no_son_correo_total}}</b> filas las cuales están usando un correo el cual no cumple con las características para poder crear una cuenta</p>
                <br>
                <p> En este apartado de reporte de importación se van a señalar, que las filas señaladas están haciendo uso de un dato el cual no cumple con los requisitos para ser considerado un correo (revisar no dejar puntos, comas, dos puntos, etc. al final del correo esto puede generar errores), estos es muy importante ya que el correo se usara para crear la cuenta con la que se podrá ingresar y recibir notificaciones, utilizar más de un correo representa un problema para la correcta operación de la cuenta (modificar el documentos y solo seleccionar un correo).</p>
                <br>
                    @foreach ($no_son_correo as $nc)
                        <li>Nombre: <b>{{$nc[0]}}</b> ,Tipo: <b>{{$nc[1]}}</b> ,Email: <b>{{$nc[2]}}</b> ,Dirección {{$nc[3]}},Celular {{$nc[4]}} </li>
                    @endforeach
                <br>
            @endif
            <p><br></p>
            <br>
            <h4>Se recomienda hacer una revision de los errores señalados e intentar importar nuevamente solo aquellos pagos que hayan sido señalados con error.</h4>
            <br>
            <h4>Se recomienda revisar la tabla de clientes a fin de verificar que se hayan hecho los registros esperados.</h4>
            <br>
        </div>
    </div>
</div>


@endsection
