$("#input-iconic").fileinput({
    uploadUrl: "/api/carga/documentos",
    uploadAsync: false,
    minFileCount: 1,
    maxFileCount: 5,
    fileActionSettings: {
        showRemove: true,
        showUpload: false,
        showZoom: true,
        showDrag: false,},
    overwriteInitial: false,
    initialPreviewAsData: true, // defaults markup
    initialPreviewFileType: 'image', // image is the default and can be overridden in config below
    'uploadExtraData': {_token: $("input[name=_token]").val()},
    preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
    previewFileIconSettings: { // configure your icon file extensions
        'docx': '<i class="fa fa-file-word-o text-primary"></i>',
        'xlsx': '<i class="fa fa-file-excel-o text-success"></i>',
        'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
        'htm': '<i class="fa fa-file-code-o text-info"></i>',
        'txt': '<i class="fa fa-file-text-o text-info"></i>',
        'csv': '<i class="fa fa-file-text-o text-info"></i>',
        'mov': '<i class="fa fa-file-movie-o text-warning"></i>',
        'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
        // note for these file types below no extension determination logic 
        // has been configured (the keys itself will be used as extensions)
        'jpg': '<i class="fa fa-file-photo-o text-danger"></i>', 
        'gif': '<i class="fa fa-file-photo-o text-muted"></i>', 
        'png': '<i class="fa fa-file-photo-o text-primary"></i>'    
    },
    previewFileExtSettings: { // configure the logic for determining icon file extensions
        'doc': function(ext) {
            return ext.match(/(doc|docx)$/i);
        },
        'xls': function(ext) {
            return ext.match(/(xls|xlsx)$/i);
        },
        'ppt': function(ext) {
            return ext.match(/(ppt|pptx)$/i);
        },
        'zip': function(ext) {
            return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
        },
        'htm': function(ext) {
            return ext.match(/(htm|html)$/i);
        },
        'txt': function(ext) {
            return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
        },
        'mov': function(ext) {
            return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
        },
        'mp3': function(ext) {
            return ext.match(/(mp3|wav)$/i);
        },
    }
}).on('filesorted', function(e, params) {
    console.log('File sorted params', params);
}).on('fileuploaded', function(e, params) {
    console.log(params);
});

var addClassTimer=function(){
    var i=1;
    $('.loader').css('display','block');
    setInterval(function() {
        $('.loader').addClass('animated fadeOut');
        var interval = setInterval(function() {
            $('.loader').css('display','none');
            $('#'+i).show();
            $('#'+i).addClass('animated fadeIn');
            if(i==3){
                clearInterval(interval);
            }
            i++;
        }, 1000);
    }, 3000);
}
/*
var authenticate = function(){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: {email:'api@owlchile.cl',password:12346},
        url: 'http://router.dev/api/login?email=api@owlchile.cl&password=123456'
    });
}
var packages = function(token,vehiculos,cajas,productos,facturas){
    var formData = new FormData();
    //formData.append("token", token);
    formData.append("vehiculos",JSON.stringify(vehiculos));
    formData.append("cajas", JSON.stringify(cajas));
    formData.append("facturas", JSON.stringify(facturas));
    formData.append("productos", JSON.stringify(productos));
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: 'http://router.dev/api/packertest?token='+token
    });
}*/

$('#input-iconic').on('filebatchuploadsuccess', function(event, data, previewId, index) {
    var r = data.response,
        cajas=r.cajas,
        vehiculos=r.vehiculos,
        productos=r.productos,
        facturas=r.facturas;
    var cont=0;
    console.log(data);
    if(!r[0]['errors']){
        for(var y in r[0][0]){
            cont++;
            var div='<div class="panel panel-warning" id="'+cont+'"><div class="panel-heading"><i class="fa fa-truck" aria-hidden="true"></i> '+y+'</div><div class="panel-body"><ul class="list-group" id="list-'+cont+'"></ul></div><div class="panel-footer"></div></div>';
            $('#vehicles-container').append(div);
            for(var z in r[0][0][y]['asig']){
                var list='<li class="list-group-item"><div class="col-md-3"><i class="ion-clipboard" aria-hidden="true"></i> '+r[0][0][y]['asig'][z]+'</div><div class="col-md-8"><i class="ion-location" aria-hidden="true"></i> Av. Nueva Providencia 1650, Providencia, Las Condes, Región Metropolitana</div></li>';
                $("#list-"+cont).append(list);
            }
        }
        $('.panel-warning').hide();
        addClassTimer();
    }else{
        $('#vehicles-container').append('<div id="list-1">'+r[0]['errors']+'</div>');
        addClassTimer();
    }
});


var input_file_id,
    input_text_id,
    type;
$('.open-type').on('click', function(e){
  type=$(this).attr('data-type');
  var title='Agregar '+type.replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); });
  input_file_id='input_file_'+type;
  input_text_id='input_text_'+type;

  $('#addNewItem .modal-title').text(title);
  $('#addNewItem .modal-body input[type=file]').attr('id',input_file_id);
  $('#addNewItem .modal-body input[type=text]').attr('id',input_text_id);
});

var save_vehicles=function(input_file,type){
    var formData = new FormData();
    formData.append("input_file",input_file);
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        cache:false,
        url: '/api/save/'+type
    });
}

$('#save_items_csv').on('click',function(){
  var save_csv,
      file=$('#'+input_file_id).prop('files')[0];
  if(type=='vehiculo'){
      save_csv=save_vehicles(file,'vehicles');
  }else if(type=='producto')
      save_csv=save_vehicles(file,'products');
    save_csv.done(function(r){
        console.log(r);
        if(r[0]==true)
            swal("Bien hecho!", "Datos almacenados con éxito!", "success")
        else
            swal("Disculpe!", "Los datos ya existen!", "error")
    });
});
