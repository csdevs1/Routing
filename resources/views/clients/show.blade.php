@extends('layouts.app')
@section('title', 'Clientes')
@if(Auth::check())
    @section('content')
        <style>
            #map-display {
                height: 400px;
                width: 100%;
            }
        </style>
       <!-- <div class="container">
            <div class="row">
                <div class="col-xs-12 title">
                    <img src="{{ asset('images/client.png') }}" class="client-logo"><h1>Clientes Asociados</h1>
                </div>
            </div>
        </div>

        <div class="col-xs-12" id="from-gallery" style="float:none;">
            <div class="container panel-container" id="info-client">
                <div class="slider responsive">
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="https://imgflip.com/s/meme/Black-Girl-Wat.jpg">
                                <figcaption>Client Name 1</figcaption>
                            </figure>
                        </a>
                    </div>
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="https://i.pinimg.com/736x/33/b8/69/33b869f90619e81763dbf1fccc896d8d--lion-logo-modern-logo.jpg">
                                <figcaption>Client Name 2</figcaption>
                            </figure>
                        </a>
                    </div>
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="http://cdn-4-theme.designhill.com/images/infographic/twitter_new.png">
                                <figcaption>Client Name 3</figcaption>
                            </figure>
                        </a>
                    </div>
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="http://www.underconsideration.com/brandnew/archives/dell_2016_logo.png">
                                <figcaption>Client Name 4</figcaption>
                            </figure>
                        </a>
                    </div>
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="https://i.pinimg.com/originals/27/be/6f/27be6f1a11652d1ec99375502d785d76.jpg">
                                <figcaption>Client Name 5</figcaption>
                            </figure>
                        </a>
                    </div>
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="https://i.pinimg.com/736x/d4/15/72/d415725b637543b47da6057c21ab8f9b--pringles-logo-famous-logos.jpg">
                                <figcaption>Client Name 6</figcaption>
                            </figure>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container client-container">
            <div class="row">
                <div class="col-xs-12">
                    <a class="btn btn-success">Asociar un nuevo cliente</a>
                </div>
            </div>
        </div>
-->

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#clients">Clientes</a></li>
  <li><a data-toggle="tab" href="#vehicles">Vehiculos</a></li>
</ul>

<div class="tab-content">
    <div id="clients" class="tab-pane fade in active">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 title">
                    <img src="{{ asset('images/client.png') }}" class="client-logo"><h1>Clientes Asociados</h1>
                </div>
            </div>
        </div>

        <div class="col-xs-12" id="from-gallery" style="float:none;">
            <div class="container panel-container" id="info-client">
                <div class="slider responsive">
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="https://imgflip.com/s/meme/Black-Girl-Wat.jpg">
                                <figcaption>Client Name 1</figcaption>
                            </figure>
                        </a>
                    </div>
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="https://i.pinimg.com/736x/33/b8/69/33b869f90619e81763dbf1fccc896d8d--lion-logo-modern-logo.jpg">
                                <figcaption>Client Name 2</figcaption>
                            </figure>
                        </a>
                    </div>
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="http://cdn-4-theme.designhill.com/images/infographic/twitter_new.png">
                                <figcaption>Client Name 3</figcaption>
                            </figure>
                        </a>
                    </div>
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="http://www.underconsideration.com/brandnew/archives/dell_2016_logo.png">
                                <figcaption>Client Name 4</figcaption>
                            </figure>
                        </a>
                    </div>
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="https://i.pinimg.com/originals/27/be/6f/27be6f1a11652d1ec99375502d785d76.jpg">
                                <figcaption>Client Name 5</figcaption>
                            </figure>
                        </a>
                    </div>
                    <div class="img-gallery">
                        <a href="#app">
                            <figure>
                                <img src="https://i.pinimg.com/736x/d4/15/72/d415725b637543b47da6057c21ab8f9b--pringles-logo-famous-logos.jpg">
                                <figcaption>Client Name 6</figcaption>
                            </figure>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container client-container">
            <div class="row">
                <div class="col-xs-12">
                    <a class="btn btn-success">Asociar un nuevo cliente</a>
                </div>
            </div>
        </div>
    </div>
    <div id="vehicles" class="tab-pane fade">
        <h3>Vehiculos</h3>
        <p>Some content.</p>
    </div>
</div>
        <div class="page" id="info">
            <div class="page background"></div>
            <section class="section container">
                <a href="#" class="close-window">x</a>
                <div class="col-sm-12 title home-box">
                    <h2>
                        Client Name
                    </h2>
                    <h4>Direccion: <small>Av. Francisco Bilbao 4140-4146, Las Condes, Región Metropolitana</small></h4>
                </div>
                <div id="map-display"></div>
            </section>
        </div>
    @endsection
    @section('script')
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script>
        $('.slider').slick({
            centerMode: true,
            centerPadding: '60px',
            slidesToShow: 3,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });
        function initMap() {
            var uluru = {lat: -25.363, lng: 131.044};
            var map = new google.maps.Map(document.getElementById('map-display'), {
                zoom: 4,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzRvHQoE265Wfz6gRRrzfpfKxBuj6_dcg&callback=initMap"></script>
    @endsection
@endif
