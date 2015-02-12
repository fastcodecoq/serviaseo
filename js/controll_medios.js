Array.prototype.remove = function(el){

	var index = objs.indexOf(el);
    objs.splice(index,1) ;

}

if (!(window.console && console.log)) {
(function() {
var noop = function() {},
console = window.console = {};
methods = 'assert clear count debug dir dirxml error exception group groupCollapsed groupEnd info log markTimeline profile profileEnd markTimeline table time timeEnd timeStamp trace warn',
methods = methods.split(' ');
for(x in methods){
console[methods[x]] = noop;
}
}());
}

var w = $(window),
    d = $(document);
    sign = undefined;

var path = "/";
var url = "http://gomosoft.com/props/fasalud</medios/"
var objs = new Array();
var rpath = "api";
var alt = ""

var target_ = false;

jQuery.fn.getRel = function(){

   return $(this).attr("rel");

}

function drag_drop () {

	var holder = document.getElementById("dropbox");

	holder.ondragover = function () { 
		this.className = 'span5 hover';

		$(holder).find("span:last-child").html("Suelta los archivos <b><em>AQUÍ</em></b>");

		return false;
	};

	holder.ondragend = function () {
		this.className = 'span5';
		$(holder).find("span:last-child").html("Arrastra los archivos hasta <b><em>AQUÍ</em></b>");
		return false;
	};

	holder.ondragleave = function () {
		this.className = 'span5';
		$(holder).find("span:last-child").html("Arrastra los archivos hasta <b><em>AQUÍ</em></b>");

		return false;
	};	


	holder.ondrop = function (e) {
		e.preventDefault();
		this.className = 'span5';
		console.log(e);
		$(holder).find("span:last-child").html("Arrastra los archivos hasta <b><em>AQUÍ</em></b>");		
		hideUpload();  
		procFiles(e.dataTransfer.files);
	};

}

function upController(){

 $('#add_medio').live('change', function(){
				
		
		files = this.files;
		hideUpload();  
		procFiles(files);


	});

 }


 
 function hash__(){

     $("#medios a[href^='#']").live("click", function(e){

      e.preventDefault();
      e.stopPropagation();

      cmd = $(this).attr("href").replace("#","");


      switch(cmd){


      	            case "eliminar":

      		    	    var el = $(this).parent().parent();
 	 					deleteFile(el);

      		    	 break;


      		    	 case "abrir":    




      		    	     var a = $(this);
      		    	     var el = $(a.attr("rel"));


      		    	     if(a.hasClass("prev"))					
							el.find(".info").html("<img src='" + a.attr("data-role") + "' alt='' />");
				

      		    	     if(a.hasClass("agregar"))
      		    	     	el.find(".btn-naranja").addClass("add-medios");
      		    	     else
      		    	     	el.find(".btn-naranja").removeClass("add-medios");

      		    	     if(a.hasClass("medio"))      		    	     	 
      		    	         openMedios( function(){ alert("bye") })
      		    	     else if(a.hasClass("prev"))
      		    	     	 abrir( el , centrar( el.find(".info") , { w : a.parent().parent().find("img").width() , h : a.parent().parent().find("img").height() }) );
      		    	     else if(a.hasClass("upload"))
      		    	     	abrirUpload();
      		    	     else
      		    	     	 abrir(el);

      		    	     

      		    	 break;

      		    	 case "salir":

      		    	    alert("listo salir");

      		    	 break;


      		    	 case "clic":

      		    	     var a = $(this);
      		    	     var el = $(a.attr("rel"));

      		    	     el.click();


      		    	 break;


      		    	


      		    	 case "cerrar":


      		    	     var a = $(this);
      		    	     var el = $(a.attr("rel"));      		    	 

      		    	     if(a.hasClass("close_medios"))
      		    	     	closeMedios();
      		    	     else
      		    	        cerrar(el);

      		    	     if(a.hasClass("share_"))
							$(".info-medios").css({overflowY:"auto"});



                          hideUpload();



      		    	 break;


      		    	case "refresh":

      		    	   refresh();

      		    	break;  


           

                    case "filtro":

                  var a = $(this);
                  var rel = a.getRel();

                  $("a[href='#filtro'].active").removeClass("active");
                  a.addClass("active");

                  loadMedios_(rel);                  

                  break; 	


      		    	 case "play":

      		    	 	var media = $(this).parent().parent().find("video")[0];
      		    	    play_(media);

      		    	 break;

      		    	 case "stop":

      		    	 	var media = $(this).parent().parent().find("video")[0];
      		    	    stop_(media);

      		    	 break;

      		    	 case "share":

      		    	   var a = $(this);
      		    	   var file = a.attr("rel");
      		    	   var url = url_ + file;
      		    	   var thumb = a.parent().parent().find("img").attr("src");
      		    	       thumb = thumb.replace("../../",url_);
      		    	       thumb = thumb.replace("img/",url_);


      		    	   $.ajax({

      		    	   	url : rpath + "/app.short.php",
      		    	   	data : { u : url , make : "json" },
      		    	   	dataType : "JSON",
      		    	   	success : function(rs){

      		    	   		  console.log(rs)
      		    	   		  
      		    	   		  openShare(rs,thumb,file);

      		    	   	}      		    	   	


      		    	   });

      		    	 break;


      }

      

      });

}


 function procFiles(files){

     if(files.length == 0)
			return;

		var reader, file, files,filesData,files_ = new Array();
		var exts = new Array("jpg","pdf","gif","png","jpeg","zip","rar","mp3");			


			if(window.FormData){
			
				filesData = new FormData();
			
			}
    
     for(i=0; i<files.length;i++){

     	var ext = files[i].name.toString().split(".");
     	    ext = end(ext);
     	    ext = ext.toLowerCase();


     	    console.log(ext);

     	    if(!inArray(ext,exts))
     	    	if(files.length > 1)
     	    	 {

     	    	  	var preg = confirm("Solo puedes cargar imagenes, pdf, zip, rar, mp3. Deseas omitir este archivo y continuar con la carga?");

     	    	  	if(!preg)
     	    	  		return;

     	    	 }
     	    	else{
     	    	 
     	    	 alert("Solo puedes cargar imagenes, pdf's, zip's, rar's, mp3's");
     	    	 return;

     	    	}
     	    else
     	         filesData.append(i,files[i]);    	       

	   
	   }
	  	

	    console.log(filesData)
			
	    sendFiles(filesData);

 }


function end( array ){

   return array[ array.length - 1 ];

}


function inArray(search,array){


	return ( $.inArray(search,array) != -1) ? true : false;


}


 function sendFiles( data ){

   var min = 10;   
   
   $("#medios .loading_bar").fadeIn();
   $("thumbs").addClass("loading");


 	$.ajax({
				url : rpath + '/app.carga.php',
				type : 'POST',
				data : data,
				dataType : 'JSON',
				processData : false, 
				contentType : false,
				statusCode : {

			 "404" : function(){ alert("pagina no encontrada"); }

		        },
				xhr: function(){

     var xhr = new window.XMLHttpRequest();

      xhr.upload.addEventListener("progress", function(evt){
        
        if (evt.lengthComputable) {
          var percentComplete = evt.loaded / evt.total;
          var percent = parseFloat(Math.round( (percentComplete*100)));

          if( percent > min ){
          
          $("#medios .loading_bar").css({

          		width : percent + "%"

          }).find("span small").text(percent + "%");
           

          }

          if(percent == 100){

          	  $("#medios .loading_bar").fadeOut( function(){

          	  	$(this).css({width:"5%"}).find("span small").text("5%")

          	  });

          	  $("thumbs.loading").removeClass("loading");   
          	      	  

          	 }

          console.log(  percent );
       }
     }, false);
     
     xhr.addEventListener("progress", function(evt){
       if (evt.lengthComputable) {
        var percentComplete = evt.loaded / evt.total;         
         

         console.log(percentComplete);

     }

     }, false);

          return xhr;
      
      },

	success : function(r){


				loadMedios();													

				console.log(r);

				if(r.success)
					if(r.success == 0 )
						alert(r.rs.msg);

					
				},

	error : function(error){

			console.log(error);
			alert(error.responseText);

	}
			});

 }


 function deleteFile(el,multiple){

	var preg = confirm("Estas Seguro de eliminar este medio?");

	if(preg){

	  var _id = el.attr("id");


	  if(!multiple){
		
		$.ajax({
			url : rpath + "/app.eliminar.php",
			data : { _id : _id },
			statusCode : {

			 "404" : function(){ alert("pagina no encontrada"); }

	    	},
			success : function(rs){


				if(rs.success == 1)
				   el.fadeOut();
				else
				   console.log(rs);

			},

			error : function(error){

				console.log(error);


			}

		 });

	   } 

	}


}



function loadMedios( callback ){


	$.ajax({ 

		url : rpath + "/app.getInfo.php",
		data : {},
		dataType : "JSON",
		statusCode : {

			 "404" : function(){ alert("pagina no encontrada"); }

		},
		success: function(rs) {

		var doc = rs.rs;	
		var opts = '<div class="opts"><a href="#abrir" title="ampliar" rel="#preview" class="prev" data-role="'+path+'f/%src%"><i class="icon-search"></i></a><a href="#share" title="Compartir" rel="%url%"><i class="icon-link"></i></a><a href="#select" rel="%url%" title="seleccionar"><i class="icon-ok"></i></a><a href="#eliminar" title="eliminar"><i class="icon-remove"></i></a></div>';		
		var optsv = '<div class="opts"><a href="#play" title="reproducir" rel="%src%"  ><i class="icon-play"></i></a><a href="#stop" title="detener" rel="%src%"  ><i class="icon-stop"></i></a><a href="#share" title="Compartir" rel="%url%"><i class="icon-link"></i></a><a href="#select" rel="%url%" title="seleccionar"><i class="icon-ok"></i></a><a href="#eliminar" title="eliminar"><i class="icon-remove"></i></a></div>';


		if(doc.length > 0)
			$("#medios .info-medios .thumbs-cont").html("");
	    
	    var obj = $("#medios .info-medios .thumbs-cont");

		for(i=0; i<doc.length; i++){		

			var etq = getEtiqueta(doc[i].tipo);	

			if(!etq.file){			

			var  el = etq.toString().replace("%opts%", opts);
				 el = el.toString().replace("%src%", doc[i].nombre);
			     el = el.toString().replace("%src_%", doc[i].nombre);			   
			     el = el.toString().replace("%url%", doc[i].nombre);			   			     			  
			     el = el.toString().replace("%url%", doc[i].nombre);			   			     			  
			     el = el.toString().replace("%_id%", doc[i]._id.$id);

			 }
			 else
			   {

			   	switch(etq.type){

			   		case "mp3":

			var  el = etq.modelo.toString().replace("%opts%", optsv);
				 el = el.toString().replace("%src%", doc[i].nombre);			     	  
				 el = el.toString().replace("%src_%", doc[i].nombre);			     	  
				 el = el.toString().replace("%file%", doc[i].nombre);
			     el = el.toString().replace("%url%", doc[i].nombre);			   				 			     	 
			     el = el.toString().replace("%url%", doc[i].nombre);			   				 			     	 
			     el = el.toString().replace("%_id%", doc[i]._id.$id);

			   		break;

			   	}

		

			   }

            obj.append( el );            

		}



		var height = obj.height();

		$("#medios .info-medios").scrollTop(0,0);
		  


	}

  });


}

function loadMedios_( filtro ){

	var filtros = {

		filtro : "none"

	}



	if(filtro)
		filtros.filtro = filtro;



	$.ajax({ 

		url : rpath + "/app.getInfo.php",
		data : filtros,
		dataType : "JSON",
		statusCode : {

			 "404" : function(){ alert("pagina no encontrada"); }

		},
		success: function(rs) {

		var doc = rs.rs;	
		var opts = '<div class="opts"><a href="#abrir" title="ampliar" rel="#preview" class="prev" data-role="'+path+'f/%src%"><i class="icon-search"></i></a><a href="#share" title="Compartir" rel="%url%"><i class="icon-link"></i></a><a href="#select" rel="%url%" title="seleccionar"><i class="icon-ok"></i></a><a href="#eliminar" title="eliminar"><i class="icon-remove"></i></a></div>';		
		var optsv = '<div class="opts"><a href="#play" title="reproducir" rel="%src%"  ><i class="icon-play"></i></a><a href="#stop" title="detener" rel="%src%"  ><i class="icon-stop"></i></a><a href="#share" title="Compartir" rel="%url%"><i class="icon-link"></i></a><a href="#select" rel="%url%" title="seleccionar"><i class="icon-ok"></i></a><a href="#eliminar" title="eliminar"><i class="icon-remove"></i></a></div>';


			$("#medios .info-medios .thumbs-cont").html("");

	    console.log(doc);
	    var obj = $("#medios .info-medios .thumbs-cont");

		for(i=0; i<doc.length; i++){		

			var etq = getEtiqueta(doc[i].tipo);	

			if(!etq.file){			

			var  el = etq.toString().replace("%opts%", opts);
				 el = el.toString().replace("%src%", doc[i].nombre);
			     el = el.toString().replace("%src_%", doc[i].nombre);			   
			     el = el.toString().replace("%url%", doc[i].nombre);			   			     			  
			     el = el.toString().replace("%url%", doc[i].nombre);			   			     			  
			     el = el.toString().replace("%_id%", doc[i]._id.$id);

			 }
			 else
			   {

			   	switch(etq.type){

			   		case "mp3":

			var  el = etq.modelo.toString().replace("%opts%", optsv);
				 el = el.toString().replace("%src%", doc[i].nombre);			     	  
				 el = el.toString().replace("%src_%", doc[i].nombre);			     	  
				 el = el.toString().replace("%file%", doc[i].nombre);
			     el = el.toString().replace("%url%", doc[i].nombre);			   				 			     	 
			     el = el.toString().replace("%url%", doc[i].nombre);			   				 			     	 
			     el = el.toString().replace("%_id%", doc[i]._id.$id);

			   		break;

			   	}

		

			   }

            obj.append( el );            

		}



		var height = obj.height();

		$("#medios .info-medios").scrollTop(0,0);
		  


	}

  });


}


function getEtiqueta( mime ){

		switch(mime){

			case "image/jpeg" : case "image/png" : case "image/gif":


			return  "<div class='span3 thumbs' id='%_id%'>%opts%<img src='" + alt + "t/150/%src_%' alt='' /></div>";												
			


			break;

			case "url/video":

			break;


			case "url/image":

			break;

			case "url/file":

			break;


			case "application/pdf":

			return "<div class='span3 thumbs file' id='%_id%'>%opts%<a href='" + path + "f/%src_%' target='_blank'><img src='panel/img/pdf.png' alt='' /></a></div>";									

			break;

			case "application/octet-stream":

			return "<div class='span3 thumbs file' id='%_id%'>%opts%<a href='" + path + "f/%src_%' target='_blank'><img src='panel/img/rar.png' alt='' /></a></div>";									

			break;			


			default:
			
			return { modelo : "<div class='span3 thumbs file'id='%_id%'>%opts%" +
			        "<a href='../../medios/%src_%' target='_blank'><img src='" + path + "panel/img/mp3.png' class='media' alt='' />'</a>" +
			        '<video controls class="hidden"><source src="'+ path +'f/%file%" type="audio/mpeg"></video>'+
			        "</div>" , 
			       file : true ,
			       type : "mp3"

			        };						


		}

}

function abrirUpload(){


    var padre = $(".info-medios");    
  
    $("#upload").css({ top : padre.scrollTop() + "px"});

    $("#upload").fadeIn();

    padre.css({overflow : "hidden"});
    $("#upload").css({top: padre.scrollTop() + "px"})

}

function hideUpload(){

  $("#upload").fadeOut(function(){

     $(this).find("input").val("");

     var padre = $(".info-medios");    
     padre.css({overflowY : "auto"});


  });

}


function select( opts){

           if( !opts.opts.select )
      		    	 	return false;
      		    

      		    	 var a = opts.obj;

      		    	 if(a.hasClass("selected"))
      		    	 	{

      		    	 		a.removeClass("selected");
      		    	 		objs.remove(a.attr("rel"));
      		    	        a.parent().removeClass("sel");


      		    	 	}else{

      		    	if(!opts.opts.multiple && objs.length == 1)
      		    	 	 return false;

      		    	 var el = a.attr("rel");
      		    	 a.addClass("selected");
      		    	 a.parent().addClass("sel");

      		    	 objs.push(el);

      		    	     }


      		    	 if(objs.length > 0)
      		    	 	$("a[href='#medio_ok']").removeClass("disable");
      		    	 else
      		    	 	$("a[href='#medio_ok']").addClass("disable");


}


function lisSel(opts){

     $("#medios a[href='#select']").live("click", function(){

     	    select({obj: $(this), opts : opts});

     });

}

function __Ok(opts, callback){

	                var a = $("a[href='#medio_ok']");

                     if(a.hasClass("disable"))
                        return;

                       console.log(objs);

                     if(!(callback instanceof Function)){
                     
                       opts.target.val( objs.join(";") ).change();
                       console.log(opts.target.val());  

                      }else{


                      	console.log(opts.target);
                      	callback(objs , opts.target);

                      }                      

                     closeMedios();

}


function lisOk( opts, callback){

	if(callback instanceof Function)
	 $("a[href='#medio_ok']").live("click", function(){

	 	__Ok(opts, callback);

	 });
	else
	 $("a[href='#medio_ok']").live("click", function(){

	 	__Ok(opts);

	 });


	lisSel(opts);

}


function openMedios( opts , callback){

	  abrir($("#medios"));
	  loadMedios();

	  console.log(opts);

	  var opts = {

	  	 multiple : (opts.attr("data-role") == "multiple") ? true : false,
	  	 filter : (opts.attr("data-filter")) ? opts.attr("data-filter") : undefined,
	  	 target : (opts.attr("data-target")) ? $(opts.attr("data-target")) : undefined,
	  	 select :  (opts.attr("data-select")) ? true : undefined

	  };



	  console.log(opts);


	  if(callback instanceof Function)
	  	 lisOk(opts,callback);
	  else
	   	 lisOk(opts);


}


function closeMedios(){

	$("a[href='#medio_ok']").addClass("disable");
	$("a[href='#medio_ok']").die("click");
	$("#medios a[href='#select']").die("click");
	cerrar($("#medios"));

}




function openShare(rs,thumb,file){

	var server_name = "http://gomosoft.com/props/homepgc";
	var fb = "http://www.facebook.com/sharer.php?s=100&p[title]=" + encodeURIComponent("Scholes-store") + "&u=%url%";
	    fb = fb.replace("%url%", encodeURIComponent(server_name + "/share/" + file));
	    fb = fb.replace("%thumb%",thumb);
	var tw = "http://twitter.com/intent/tweet?text=Tweet&url=%url%&via=scholes-store";
	    tw = tw.replace("%url%",server_name + "/s/" + rs.short);	    
	
	var padre = $(".info-medios");		
	
	$("#share").css({ top : padre.scrollTop() + "px"});
		
		padre.css({overflow : "hidden"});

	var qr;

	if(!rs.qr.match("http"))
	var qr = "http://api.gomosoft.com/qr/i=" + server_name + "/f/" + file ;
	else		
	var qr = "http://api.gomosoft.com/qr/i=" + rs.qr;


	$("#short").val( server_name + "/s/" + rs.short );
	$("#external_qrcode").attr("href", qr);
	$("#qrcode").attr("src", qr);
	$("#fb").attr("href", fb);
	$("#tw").attr("href", tw);

	abrir($("#share"));

}

function refresh(){

	loadMedios();

}


function load_cont(rs,index){


	console.log(rs);
	resetObjs();

  	var cont = $("#content");

  	cont.html("");  	
  	cont.html(rs);
  	
  	$(".cargando").fadeOut("fast",function(){

  		cont.removeClass("loading");       

   if(index != -1){
    
    $(".active").removeClass("active");    
    $($(".lateral li")[index]).addClass("active");

    }

  	});
  


}




 function imgZoom(){

 	  $(".thumbs-cont .thumbs img:not('.thumbs.file img')").live("click", function(){

 	  	   var file = $(this).attr("src");
 	  	   var url  = file.replace("t/150", path + "f");

 	  	   var w = $(this).width();
 	  	   var h = $(this).height();

 	  	   var mini = { w : w , h : h};

 	  	   $("#preview .info").html("<img src='"+url+"' alt='' />");

 	  	   abrir( $("#preview") , centrar($("#preview .info"), mini));
 	  	   window.scrollTo(0,0);

 	  });

 }


 function play_(el){

 	el.play();

 }


function stop_(el){

 	el.pause();

 }


 function multimedia(){


 	$("img.media").live("click", function(){

 		play_( $(this).parent().find("video")[0] );

 	});

 }


 function medios_target(){


   $(".medio_target").live("change", function(){	

   	  var el = $(this);
   	  var rel = el.attr("rel");
   	  var data = el.attr("data-role");

   	  if(objs.length == 0)
   	  	$("a[href='#medio_ok']").addClass("disable");

   	  if( data != "" )
   	  	
   	  	switch(data){

   	  		default:
   	  		break;

   	  	}

   	  var t = $(rel);
   	  t.html("");
   	  var els = el.val().split(";");
	  var opts = '<div class="opts"><a href="#eliminar" rel="%file%" title="eliminar"><i class="icon-remove"></i></a></div>';		

	 if(objs.length > 0)
   	  for(i=0; i < els.length ; i++){
   	  	 
   	  	 var optsz = opts.replace("%file%",els[i]);
   	  	 var text = "<div class='span2 thumbs' style='height: 80px; width: 80px; overflow:hidden'>" + optsz + "<img src='"+ path +"t/150/" + els[i] + "' alt='' /></div>";   	  	 	 

   	  	 	 t.append(text);   	  	

   	  	}



   });


 }


 function setVal(el,val){

 	$(el).val(val);

 }


 function resetObjs(){

 	 objs = new Array();

 }


 function abrir(el, callback){


	if(callback)
	 el.fadeIn(callback);
	else
	 el.fadeIn();


}

function centrar(el , mini){

	var ratio = mini.w / mini.h;

 
	var w =  500 * ratio;
	var ws = $(window).width();


	var mg =  (ws - w) / 2;

	el.css({ marginLeft : mg + "px" });


}


function cerrar(el, callback){

	if(callback)
	el.fadeOut(callback);
	else
	el.fadeOut();

   

}



function mediosController(){

   upController();
   hash__();   
   imgZoom();
   multimedia();
   medios_target();
   drag_drop();
   console.log("control medios iniciado");

 }


 function ini(){

 
   mediosController();

   $("#preview").on('click', function(){

   	  $(this).fadeOut();

   });
  

 }


 d.ready(ini);




