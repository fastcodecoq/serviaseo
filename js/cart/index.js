/*

   gomoCart.js


   GUIA DE USO
   ===========

   el atributo rel siempre hará referencia al id del item (id de identificación en la BD), es decir, 
   un botón añadir al carro sería algo así:
     
     <a href="#" rel="id_item" data-role="cart_action" data-action="add_cart">Agregar al carro</a>
	
    ahora un botón para eliminar un item

     <a href="#" rel="id_item" data-role="cart_action" data-action="del_item">Eliminar &times;</a>

     Vaciar carro

     <a href="#" data-role="cart_action" data-action="clean_cart">Vaciar carro </a>

     Mostrar Items en el carro
	
	<a href="#"  data-role="cart_action" data-action="show_items">Mostrar Items</a>


	Ventajas de usar Local Storage: Es rápido, práctico y de fácil acceso, no expira por lo que
	podemos saber si un usuerio deja un carro abandonado y cuando regrese a la web, mostrarle los
	items que tenía en este. 

	Desventajas: Algunos navegadores no lo soportan, al no manejarse de lado servidor no podemos relacionar
	el carro abandonado con un user, pero, siempre habrá desventajas en cualquier método que se use.



	LICENCIA
	========

	Copyrights 2013 Javier Gómez Mora (@gomosoft) 

	This file is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.



    DEPENDENCIAS
    ============

    LSutil.js ---->  http://pastebin.com/E8hquAmC
    JQuery V >= 1.5  ------->  http://jquery.com/download/


    Autores
    =======

    @gomosoft


    Colaboradores
    =============

    @dannegm 
      - Aporte de clase de retrocompatibilidad para la clase localStorage


*/


function obtProducts(){

	var callback = function(items){

	    var rs = new Array();	    

		for(x in items)
		 if(items[x].active != -1 && items[x] instanceof Object)
					rs.push(items[x]);
	
		return rs;
        	

	}	


	return obtLS(callback);

	

}


function findItemById(item_id){

   var find = -1;
   var items = obtProducts();


   for(i=0 ; i<items.length ; i++){

   	if(items[i].id == item_id)
   		find = i;

   }


   return find ;

}


function updateItem(item){

 var index = findItemById(item.id);
	    items = obtLS();
	    items[index] = item;

	    replaceLS(items);


}


function delItem(item_id){

	var index = findItemById(item_id);
	    items = obtLS();
	    items.splice( index, 1 );

	    replaceLS(items);

}


function add_to_cart(info, callback){

	var item  = {

		id : info.id,
		active : 1,
		type : info.type,
		quantity : 1,
		image : info.image,
		price : info.price,
		name : info.name

	}

	var added = false;
  	var x = findItemById(item.id);
   if( x != -1){
   	         
   	          var it = obtLS()[x];  

        	  it.quantity += item.quantity;        	  
        	  updateItem(it);        	
        	  added = true;

       
    }else
    {

    	    salvarLS(item);
            added = true;

    }


   console.log(item);

   if(callback)
   	   callback(item, added);

}


function getItems(callback){

	  var items = obtLS();

      if(callback)
          callback(items);
      else
        return items;	  

}


function countItems(callback){

	var items = obtLS();	

	if(callback instanceof Function)	
		callback(items.length)
	else
	  return items.length;

}


function getQuty(callback){

	var items = obtLS();
	var quty = 0;

	for(x in items){

		quty += items[x].quantity;

	}	

	if(callback instanceof Function)
		callback(quty);
	else
	  return quty;

}




function cleanCart(){

	 cleanLS();

}




function hash_cart_controller(e){

	e.preventDefault();
	e.stopPropagation();
	a = $(this);
	


	switch(a.attr("data-action")){



		case "add_cart":

		   var call = function(it,rs){

		   	if(rs)
		   	{

		var items = obtProducts();
			qty = getQuty();

		if(items.length == 1)
			$("#cart-widget").fadeIn(function(){

					$("#dropProduct").html("<div id='added' style='padding: .3em; margin-bottom:3px'>"+									
				                   "<div class='pull-left'><img src='/t/60/" + it.image + "' alt='' /></div>"+
				                   "<div class='pull-left' style='margin-left:4px'><span class='pull-left'  style=\" display:block; width:100%\">" + it.name + "</span><b style='display:block; width: 100%' class='pull-left'> $" + number_format(it.price,0,".",".") + "</b> </div></div>"
				                   );

					
        $("*[data-role = 'cart-products-aq']").text("(" + qty + ")");
	  	$("*[data-role = 'cart-products-total']").text("$" + number_format(obtTotal(),0,".",".") );
        
        var inter = setInterval(function(){

		$("#dropProduct").fadeOut( function(){
	      $("#dropProduct div").remove();
	      });

		clearInterval(inter);

        },2000);	

			});
		else{
            $("#dropProduct").fadeIn();
					$("#dropProduct").html("<div id='added' style='padding: .3em; margin-bottom:3px'>"+									
				                   "<div class='pull-left'><img src='/t/60/" + it.image + "' alt='' /></div>"+
				                   "<div class='pull-left' style='margin-left:4px'><span class='pull-left'  style=\" display:block; width:100%\">" + it.name + "</span><b style='display:block; width: 100%' class='pull-left'> $" + number_format(it.price,0,".",".") + "</b> </div></div>"
				                   );
					$("*[data-role = 'cart-products-aq']").text("(" + qty + ")");
	  	$("*[data-role = 'cart-products-total']").text("$" + number_format(obtTotal(),0,".",".") );

        
        var inter = setInterval(function(){


		$("#dropProduct").fadeOut( function(){

			$("#dropProduct div").remove();

		});

		clearInterval(inter);

        },2000);	

		}

			


		   	}
		    else
		    alert("Ya has agregado este item, revisa tu carro");

		   };

		    add_to_cart({  id : a.attr("rel") , 
		    			   type : a.attr("data-type") , 
		    	           image : a.attr("data-image") ,
		    	           price : parseInt(a.attr("data-price").replace(/[$.\s]/g,"")),
		    	           name : a.attr("data-name")

		                 } ,  call);

		break;


		case "del_item":
               

		  delItem(a.attr("data-item"));

		  if(a.attr("data-ecosys") == "table")
		  {

		  	a.parents("tr:first").remove();
		  	var total = obtTotal();

		  	$("#total_").text("$" + number_format(total,0,".","."));


		  }

	

		break;


		case "clean_cart":

	   	 cleanCart();

		break;


		case "show_items":

		//en este caso usaré una función sencilla con un simple alert 
		//pero queda  a su criterio que hacer en el callback

		 var mostrar = function(items){

		 	  alert( items.join(" || "));

		 }

		 getItems( mostrar );

		break;


		case "send_order":

			 var data = {

			 	 fact_delivery : localStorage.fact_delivery,
			 	 products : localStorage.items,
			 	 mail : "<table width=\"720\" class=\"table\">" + $("#summary").html() + "</table>"			 	 

			 }

			 data.mail = data.mail.replace(/\/t/g,"http://scholes-store.com/t");		

		      $.ajax({

		      	url : "/api/app.orders.php",
		      	data : data,
		      	type : "POST",
		      	dataType : "JSON",
		      	success : function(rs){

		      		 console.log(rs);

		      		 if(rs.success == 1)
		      		 	{

		      		 		localStorage.other = JSON.stringify(rs.rs);		
		      		 		localStorage.removeItem("items");
		      		 		localStorage.removeItem("fact_delivery");		      		 		

		      		 		document.location = "thanks"; 
		      		 		 	

		      		 	}
		      		 else
		      		 	alert("error");

		      	},
		      	error : function(err){

		      		alert("hubo error");

		      		console.log(err);

		      	}

		      })

		break;

	}

}


function hash_cart(){


   $("a[data-role='cart_action']").live("click", hash_cart_controller);


}


function _ini_cart_(){
 
   hash_cart();
   iniLS();      

   console.log("Cart iniciado");
 

}




$(_ini_cart_);