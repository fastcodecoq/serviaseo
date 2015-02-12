var w = $(window),
    d = $(document);

jQuery.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}

jQuery.fn.getRel = function(){

   return $(this).attr("rel");

}

jQuery.fn.getDataRole = function(){

   return $(this).attr("data-role");

}

function list_url(){

	if( document.URL.match("#!") )
	 list_hash(document.URL);

}


function hash(){


      $("a[href^='#!']").live("click", function(e){

      		e.preventDefault();
            e.stopPropagation
      		list_hash($(this).attr("href"),$(this));

      });

}

function hash_(){

     $("a[href^='#']:not('#medios a')").live("click", function(e){

      e.preventDefault();
      e.stopPropagation();

      cmd = $(this).attr("href").replace("#","");


      switch(cmd){


      	         case "salir":

      		    	    dialog.show("listo salir");

      		    	 break;


      		    	 case "clic":

      		    	     var a = $(this);
      		    	     var el = $(a.attr("rel"));

      		    	     el.click();

      		    	 break;

                 case "submit":

                 var a = $(this);
                 var data_role =  a.attr("data-role");

                 if(data_role == "logout")
                   $("form[name='logout']").submit();

                 break;


      		    	 case "abrir":      		 


      		    	     var a = $(this);
      		    	     var el = $(a.attr("rel"));

      		    	     if(a.hasClass("prev"))					
							el.find(".info").html("<img src='" + a.attr("data-role") + "' alt='' />");
				



      		    	     if(a.hasClass("agregar")){
      		    	     	 target_ = $(a.attr("data-role"));
                         el.find(".btn-naranja").addClass("add-medios");                         
                         }else{

                        el.find(".btn-naranja").removeClass("add-medios");


                         }

      		    	     if(a.hasClass("medio"))      		    	     	 
      		    	          openMedios($(this));
      		    	     else if(a.hasClass("prev"))
      		    	     	   abrir( el , centrar( el.find(".info") , { w : a.parent().parent().find("img").width() , h : a.parent().parent().find("img").height() }) );
                     else if(a.attr("rel") == "#upload")
                         abrirUpload();
      		    	     else
      		    	     	 abrir(el);



      		    	     

      		    	 break;


      		    	 case "cerrar":


      		    	     var a = $(this);
      		    	     var el = $(a.attr("rel"));      		    	 

      		    	     cerrar(el);

      		    	     if(a.hasClass("share_"))
							$(".info-medios").css({overflowY:"auto"});

            hideUpload();




      		    	 break;





                  case "guardar":

                     if(objs.length == 0)
                  {

                     dialog.show("Debes agregar medios para poder guardar");
                     return false;

                  }

                  var a = $(this);
                  var rel = a.attr("rel");
                  var form = $(rel);
                  var cond = true;

                  form.find("input:not('input[name='fotos']'), textarea").each(function(){

                     var field = $(this);
                     var pat = new RegExp(field.attr("pattern"),"i");

                     if( !pat.test(field.val()) ) 
                     {

                        field.addClass("pink");
                        cond = false;

                     }else
                      field.removeClass("pink");

                  });

               

                  if(!cond){
                     
                     dialog.show("Debes rellenar de forma correcta los campos");
                     return false;

                   }
                

                  switch(rel){

                     case "#producto":

                      save_producto();

                     break;


                     case "#sliders":

                     save_sliders();

                     break;


                     case "#giftcard":

                     save_giftcard();

                     break;

                  }


                  break;	

                  case "eliminar":

                  var a = $(this);
                  var rel = a.attr("rel");
                  var data = a.getDataRole();                  

                  switch(data){

                     case "producto":

                     var con = confirm("Estas seguro de eliminar este producto?");

                     if(con)
                        $.ajax({

                          url : "core/php/app.delProduct.php",
                          data : {_id : rel},
                          type : "GET",
                          dataType : "JSON",
                          success : function(rs){

                           console.log(rs);
                            
                                 if(rs.success == 1)
                                 {

                                    a.parent().parent().parent().remove();

                                 }

                                 else
                                    dialog.show("Hubo un error")

                            }

                          });

                     break;


                     case "slider":

                     var con = confirm("Estas seguro de eliminar este slider?");

                     if(con)
                        $.ajax({

                          url : "core/php/app.delSlider.php",
                          data : {_id : rel},
                          type : "GET",
                          dataType : "JSON",
                          success : function(rs){

                           console.log(rs);
                            
                                 if(rs.success == 1)
                                 {

                                    a.parent().parent().parent().remove();

                                 }

                                 else
                                    dialog.show("Hubo un error")

                            }

                          });

                     break;


                     default:

                     del_objs_el(rel);  

                     break;


                  }
            
                   


                  break;    	


                



      }

      

      });

}





function save_producto(){

        var form = $("#producto");

         var vars = {

                        fotos : form.find("input[name='fotos']").val(),
                        nombre : form.find("input[name='nombre']").val(),
                        name : form.find("input[name='name']").val(),
                        precio : form.find("input[name='precio']").val(),
                        cantidad : form.find("input[name='cantidad']").val(),
                        descripcion : form.find("textarea[name='descripcion']").val().replace(/\n/g, "<br />").toString(),
                        description : form.find("textarea[name='description']").val().replace(/\n/g, "<br />").toString(),
                        categoria : form.find("select[name='cat']").val(),
                        slug : form.find("input[name='slug']").val()

                     };




                     $.ajax({

                        url : "core/php/app.save.producto.php",
                        data : vars,
                        type: "POST",
                        dataType: "JSON",
                        success : function(rs){

                           console.log(rs);

                           if(rs.success == 1)
                           {

                              resetFormProducto(form, function(){ dialog.show("El producto se ha cargado") });
                              resetObjs();

                           }else{
                           
                           dialog.show(rs.rs.msg);
                           window.reload();

                            }

                         },
                        error : function(error){

                           dialog.show("Error: " + error.responseText);

                        }                                                               

                        });



}

function save_giftcard(){

        var form = $("#producto");

         var vars = {

                        fotos : form.find("input[name='fotos']").val(),
                        nombre : form.find("input[name='nombre']").val(),
                        name : form.find("input[name='name']").val(),                                                
                        minval : form.find("input[name='minval']").val(),                                                
                        maxval : form.find("input[name='maxval']").val(),                                                
                        descripcion : form.find("textarea[name='descripcion']").val().replace(/\n/g, "<br />").toString(),
                        description : form.find("textarea[name='description']").val().replace(/\n/g, "<br />").toString(),                                                

                     };


                     $.ajax({

                        url : "core/php/app.saveGiftcard.php",
                        data : vars,
                        type: "POST",
                        dataType: "JSON",
                        success : function(rs){

                           console.log(rs);

                           if(rs.success == 1)
                           {

                              resetFormProducto(form, function(){ dialog.show("El producto se ha cargado") });
                              resetObjs();

                           }else
                           dialog.show(rs.rs.msg);

                         },
                        error : function(error){

                           dialog.show("Error: " + error.responseText);

                        }                                                               

                        });



}

function save_sliders(){

        var form = $("#elemento");

         var vars = {

                        sliders : form.find("input[name='fotos']").val(),   
                        lang : form.find("select[name='lang']").val()          

                     }

                     console.log(vars);


                     $.ajax({

                        url : "core/php/save.sliders.php",
                        data : vars,
                        type: "GET",
                        dataType: "JSON",
                        success : function(rs){

                           console.log(rs);

                           if(rs.success == 1)
                           {

                              $("#prevs").html("");
                              resetObjs();
                              dialog.show("Ok: Los sliders se han cargado");

                           }else
                           dialog.show(rs.rs.msg);

                         },
                        error : function(error){

                           console.log(error);

                        }                                                               

                        });



}

function resetFormProducto(form, callback){

   $("#prevs").html("");
   form.reset();

   if(callback)
      callback();

}


function del_objs_el(el){

    objs.remove(el);
    console.log(objs);
    target_.val(objs.join(";")).change();

}


function list_hash( cmd , a){


               if(cmd.match("!")){

                cmd = cmd.split("!");
      		      cmd = cmd[1];

              }

      		    switch(cmd){

      		    	 case "/girar":

      		    	   $("body").addClass("gira");

      		    	 break;
              
      		    	 case "/salir":

      		    	    dialog.show("listo salir");

      		    	 break;

      		    	 case "/medios":

      		    	   openMedios();

      		    	 break;


      		    	 default:


                    $(this).addClass("active");

                    if(a){
                    
                    var index = a.parent("li").attr("id");                    
                      
                      console.log(a.parents("div"));

                    if($(a.parents("div")[0]).hasClass("lateral"))
                     loadVista(cmd, index);
                    else
                      loadVista(cmd, -1);

                     }else
                     loadVista(cmd, 0);

      		    	 break;

      		    }

}


function loadVista(cmd,index){


          if(!cmd)
            var cmd = "adm_tienda.html";

                  var con = true;

                      if(objs.length > 0)
                        con = confirm("Aun no has acabado de crear el producto, deseas abandonar?");

                     if(!con)
                        return false;

                    console.log("Cargando contenido");     



                    $("#content").addClass("loading"); 
                    $(".cargando").fadeIn();

                    $.ajax({

                       url : "get_vista.php",
                       data : get_vista(cmd),
                       type : "GET",
                       success : function(rs){
                        

                          if(index)
                          load_cont(rs,index);
                          else
                          load_cont(rs,0);                  

                       },
                       error : function(){

                        dialog.show("error");

                       }

                    });

}




function abrir(el, callback){


	if(callback)
	 el.fadeIn(callback);
	else
	 el.fadeIn();


}


function slug(){


  $("input[name='nombre']").live("change", function(){

       var slug = $(this).val().toString().replace(" ","-");


       $("input[name='slug']").val(slug);

  });


}



function cerrar(el, callback){

	if(callback)
	el.fadeOut(callback);
	else
	el.fadeOut();

   

}


function centrar(el , mini){

	var ratio = mini.w / mini.h;

 
	var w =  500 * ratio;
	var ws = $(window).width();


	var mg =  (ws - w) / 2;

	el.css({ marginLeft : mg + "px" });


}





function preview(){

  
  $("#preview").click( function(){ cerrar($(this)); });


}


function get_vista( cmd ){



	switch(cmd){


		case "/tienda":

		  return { f : "tienda.php"};

		break;


		case "/medios":

		return { f : "medios.php" };

		break;

      case"/productos":

      return { f : "productos.html" };


      break;


      case"/sitio-web":

      return { f : "adm_sitio.html" }; 


      break;

      case "/pqr":

      return { f : "pqr.html" }; 


      break;


      case"/sliders":

      return { f : "sliders.html" };


      break;


       case"/listar-sliders":

      return { f : "see_sliders.html" };


      break;

      case"/rutas":

      return { f : "rutas.php" };

      break;

       case "/giftcard":

      return { f : "add_gift.html" };


      break;


      default:

      return { f : "adm_sitio.html" }; 
      


      break;

	}


}


 function seeActivity(){  

       var inte = setInterval(function(){
       var url = document.URL;
       var path_ = "";

       if(url.match("localhost"))
          path_ = "schooles";


          $.getJSON("core/php/ajax.activity.controller.php", function(rs){

            console.log(rs);

                var rss = rs.rs;

                if(rs.success == 0){
                   
                   window.location.reload();                   

                }

          });

       }, 80000);

    }



function numerarLi(){

  var i = 0;

   $(".lateral li").each(function(){

         $(this).attr("id",i);
         i++;

   });

}


function scrolling( vars ){

       var vars_ = {

          target : window,
          callback : function(e){

                var this_ = $(this);
                console.log(this_.scrollTop());

          }

       }  


      if(vars instanceof Object)
        $.extend(vars_, vars);

       console.log(vars_)


      $(vars_.target).scroll( vars_.callback );

}


function handlerLogo(){

    var vars = { 
             
             callback : function(){

                 var this_ = $(this);

                  if(this_.scrollTop() >= 100)
                       $("#aside-logo").fadeIn();
                  else
                       $("#aside-logo").hide();                      


                } 

               }


            scrolling(vars);

}



function iniHash(){

   hash();
   list_url();   
   hash_();

}


function ini(){

	iniHash();	
	preview();
  loadVista();
  slug();
  numerarLi();
  seeActivity();
  handlerLogo();

	console.log("Sistema iniciado");

}



d.ready(ini);