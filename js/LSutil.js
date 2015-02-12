

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  //


var ls = window.localStorage;
   
    function salvarLS( val , callback ){


          var item = val,
              its = obtLS();

              its.push( item );              
              its = toJSON( its );              

              ls.items = its;    


              if(callback)
                   callback();          


    }


    function obtLS(callback){

        if(callback instanceof Function)
          return callback( toOBJ( ls.items ) );
        else
          return toOBJ ( ls.items );

    }


    function cleanLS(){

           ls.removeItem("items");
           iniLS();   
           total = 0;        

    }

    function replaceLS(items){

        ls.items = toJSON(items);

     }


     function obtTotal(){

        var items = obtLS();
        var total = 0;

        for(x in items)
          if(items[x].active != -1){
           
             total += items[x].price * items[x].quantity;
             console.log(items[x].price);

           }

        return total;

     }


    function toJSON( val ){

       return JSON.stringify( val );

    }

    function toOBJ( val ){
          
          if(/\[.*\]/i.test(val))
          return JSON.parse( val );
          else{ 

          var obj = new Array();
          return obj;


          }

            
    }

    function iniLS( val ){


      if(!ls.items)       
          ls.setItem('items', toJSON( new Array() ) );                    
       
        var lss = obtLS();
        console.log(lss);
              

   
      }