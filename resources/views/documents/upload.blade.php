@extends('layouts.app')
@section('title', 'Inicio')
@if(Auth::check())
    @section('content')
    <div>
        <ul class="nav navbar-nav">
            <li><a href="#" class="open-type" data-toggle="modal" data-type="vehiculo" data-target="#addNewItem">Agregar Vehiculos</a></li>
            <li><a href="#" class="open-type" data-toggle="modal" data-type="producto" data-target="#addNewItem">Agregar Productos</a></li>
        </ul>
    </div>
    <div class="modal" id="addNewItem" tabindex="-1" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Agregar Vehiculo</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <!--<label class="control-label" for="inputFile3">File</label>-->
                        <input type="file" class='opacity-0'>
                        <input type="text" readonly="" class="form-control" placeholder="Seleccione CSV">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id='save_items_csv'>Guargar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class='title'>Selecci&#243;n de Documentos</h2>
            </div>
            <div class='col-xs-12'>
                <input id="input-iconic" name="input-iconic[]" type="file"  multiple class="file-loading" accept=".csv">
                {{ csrf_field() }}
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12" id="vehicles-container">
                <div class="container">
                    <div class="row">
                        <div class='loader'>
                            <div class='loading-square'></div>
                            <div class='loading-square'></div>
                            <div class='loading-square'></div>
                            <div class='loading-square'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@endif
