function findItemById(item_id){

   var find = -1;
   var items = obtLS();

   console.log(items)


   for(i=0 ; i<items.length ; i++){

   	if(items[i].id == item_id)
   		find = i;

   }


   return find ;

}


function updateItem(item){

 var index = findItemById(item_id);
	    items = obtLS();
	    items[index] = item;

	    replaceLS(items);


}


function delItem(item_id){

	var index = findItemById(item_id);
	    items = obtLS();
	    items[index].active = -1;

	    replaceLS(items);

}


function cleanCart(callback){

	cleanLS();

	if(callback)
		callback();

}

function add_to_cart(info, callback){

	var item  = {

		id : info.id,
		active : 1,
		type : info.type,
		quantity : 1

	}

  

   if(findItemById(item.id) == -1)
      salvarLS(item);

   console.log(item);

}

/*
   rel = al id del item, es decir, un botón añadir al carro sería
     
     <a href="#" rel="id_item" data-role="cart_action" data-action="add_cart">Agregar al carro</a>
	
    ahora un botón para eliminar un item

     <a href="#" rel="id_item" data-role="cart_action" data-action="del_item">Eliminar &times;</a>

     Vaciar carro

     <a href="#" rel="id_item" data-role="cart_action" data-action="clean_cart">Vaciar carro </a>


*/

function hash_cart_controller(){

	a = $(this);

	switch(a.attr("data-action")){

		case "add_cart":

		    add_to_cart({ id : a.attr("rel") , type : a.attr("data-type")});

		break;


		case "del_item":

		  delItem(a.attr("rel"));

		break;


		case "clean_cart":

	   	 cleanCart();

		break;


		case "show_items":

		 get

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