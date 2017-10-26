@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div id="truck-loader">
    <span class="ti">
        <i class="ti_truck">
            <i class="ti_truck__cloud"></i>
            <i class="ti_truck-window"></i>
            <i class="ti_truck-sticker"></i>
            <i class="ti_truck-bumper"></i>
            <i class="ti_truck-wheel wheel-left"></i>
            <i class="ti_truck-wheel wheel-right"></i>
            <i class="ti_truck__road"></i>
        </i>
    </span>
</div>
<div class="wrapper" id="login-container">
    <div class="container container-login">
        <div class="row">
            <div class="col-md-4 logo-container">
                <img class="img-responsive logo" src="http://a.dryicons.com/images/icon_sets/polygon_icons/png/256x256/map_pin.png">
                <h1>Ruteador</h1>
            </div>
            <div class="col-md-8">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                     {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email">Correo Electr&#243;nico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electr&#243;nico" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">Contrase&#241;a</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contrase&#241;a" required>
                    </div>
                    <button type="submit" class="btn btn-raised btn-success">Login</button>
                </form>
            </div>
        </div>
        <footer class="col-md-10">
            <small>Todos los derechos reservados, © OWL Chile 2017. </small><img src="http://qaowltms.owlchile.cl/branch/owl/img/owl.png" class="owl-footer"><span></span>
        </footer>
    </div>
</div>
<script>
    window.onload = function(e){  
        setInterval(function() {
            $("#truck-loader").fadeOut("slow");
            setInterval(function() {
                $("#truck-loader").delay(1000).css('display','none');
                $('#login-container').fadeIn("slow");
            }, 1000);
        }, 3500);
    }
</script>

<!--<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo Electr&#243;nico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contrase&#241;a</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                     ****   <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div> *****

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                               **** <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a> ****
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
@endsection