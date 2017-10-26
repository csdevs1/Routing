@extends('layouts.app')
@section('title', 'Inicio')
@if(Auth::check())
    @section('content')
    <div class="container facturas-wrapper">
        <div class="row">
            <div class="col-xs-12">
                <h1>Facturas Cargadas</h1>
            </div>
            <?php
                foreach($vehicles as $k=>$v){
                    $id=$vehicles[$k]['attributes']["id"];
                    $name=$vehicles[$k]['attributes']["nombre"];
                    $patente=$vehicles[$k]['attributes']["patente"];
                    $id_oficina=$vehicles[$k]['attributes']["id_oficina"];
                    $office = \App\Oficinas::select(['direccion','lat','lng'])->where('id',$id_oficina)->get();
            ?>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card" style="max-width: 20rem;">
                    <iframe src="https://maps.google.com/maps?q=<?php echo $office[0]['lat'].",".$office[0]['lng']; ?>&hl=es;z=14&amp;output=embed" scrolling="no" frameborder="0" style="border:0;width: 100%;" allowfullscreen></iframe>
                    <div class="card-block">
                        <h4 class="card-title"><?php echo $name; ?></h4>
                        <p class="card-text"><b>Direccion oficina:</b> <?php echo $office[0]['direccion']; ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Patente:</b> <?php echo $patente; ?></li>
                    </ul>
                    <div class="card-block">
                        <a href="/api/export/<?php echo $id; ?>" download class="card-link">Descargar XLS</a>
                        <a href="#" class="card-link">Ver mas</a>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
        <hr>
        <div class='row'>
            <div class="col-xs-12"><a href='/exportar/vehiculos' class='btn btn-success' download><i class="ion-archive"></i> Descargar Resumen Vehiculos</a></div>
        </div>
    </div>
    <script>
        $('.card').click(function(){
            $(this).find('iframe').addClass('clicked');
        }).mouseleave(function(){
            $(this).find('iframe').removeClass('clicked');
        });
    </script>
    @endsection
@endif
