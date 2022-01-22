var llenadoCatalogo = '';
var llenadoObj = '';
var app = new Vue({
	el : '#app',
	data : {
		lista : retornarLista(),
		moviles : [],
		options : [],
		new_name : "",
		new_last_name : "",
		new_id : "",
		new_mail : "",
		new_phone : "",
		xname : "",
		xlast_name : "",
		xmail : "",
		xphone : "",

		/*descripcion:"",
		selected : "", */
	    tipoprod:"",
	    id_m : "",
	    id_d : "",
		lista_modificado :  [],
	    //precio:0,
	},
	methods : {
		//PROCEDIMIENTOS
		disb : function(id){

			
			axios.post('http://localhost/tienda/retener.php?proc=disb_emp' , { idd : id }).then(response => {
					if(response.data == "1") {
							swal('De acuerdo', 'Se deshabilitó el empleado : ' + id, 'success');
					}else{
							swal('Error', response.data , 'error');
	
					}
	
				});
			this.listarMoviles();            

			
		},
		listarMoviles : function(){
			axios.post('http://localhost/tienda/retener.php?proc=busqueda_filtros' , {
				 "xname" : this.xname ,
				 "xlast_name" : this.xlast_name ,
				 "xmail" : this.xmail ,
				 "xphone" : this.xphone ,
		
			}).then(response => {
				  this.moviles = response.data;
				    //console.log(this.moviles);

			});
		},

		mod : function(id){
			
			axios.post('http://localhost/tienda/retener.php?proc=mod_job', {
				idu:id,

			}).then(response => {
				this.lista_modificado = response.data;
				Array.from(this.lista_modificado).forEach((element) => {
					console.log(response.data[0]);
					this.new_name = element.name;
					this.new_last_name = element.last_name;
					this.new_id = id;
					this.new_mail = element.email;
					this.new_phone = element.phone ;
				  });
				$("#exampleModal").modal("show");

                //this.listarMoviles();            

		    });
		},
		agregarEmp : function(){
			var url = "";
			var at = {
				'idu' : '',
				"new_name" : this.new_name ,
				"new_last_name" : this.new_last_name ,
				"new_mail" : this.new_mail ,
				"new_phone" : this.new_phone ,

			};
			var msg = "";
			if(this.new_id != ""){
			    //url = 'http://localhost/tienda/retener.php?proc=modificar_emp'
				at.idu = this.new_id ;
				msg = "Registro "+ this.new_id +" modificado con éxito";
			}else{
				msg = "Registro creado con éxito";
				//url = 'http://localhost/tienda/retener.php?proc=add_emp'

			}
			

			axios.post('http://localhost/tienda/retener.php?proc=nuevo_registro' , at).then(response => {
				  if(response.data == "1") {
				  	 swal('Muy bien', msg, 'success');
				  }else{
				  	 swal('Error', response.data , 'error');

				  }
                this.listarMoviles();            

		    });
			
		},
		limpiarRegistro : function(){
			    this.new_id = "";
				this.new_name = "";
				this.new_last_name = "";
				this.new_mail = "";
				this.new_phone = "";

		}
	},
	created: function(){
		this.listarMoviles();

	},
	computed : {
		filteredEmp : function(){
			return this.moviles.filter((nom)=>{
				var sinom = nom.name.match(this.xname);
				var sil = nom.last_name.match(this.xlast_name);
				var sip = nom.phone.match(this.xphone);
				var sie = nom.email.match(this.xmail);
                return sinom;
				//return (sinom || sil || sip || sie)||(this.xname == "" && this.xlast_name == "" && this.xphone == "" && this.xmail == "");
				
			});
		},
		listarTrabajadores : function(){
			axios.post('http://localhost/tienda/retener.php?proc=busqueda_filtros' , {
				 "xname" : this.xname ,
				 "xlast_name" : this.xlast_name ,
				 "xmail" : this.xmail ,
				 "xphone" : this.xphone ,
		
			}).then(response => {
				  this.moviles = response.data;
				    //console.log(this.moviles);

			});
		},


	},

});
function retornarReg(id){
	var arregloProd ='';
	listaRegistro(id).done(function(data){ arregloProd = data; });
	return arregloProd;
}

function listaRegistro(id){
	return $.ajax({
	    method: 'POST',
	    url: 'http://localhost/tienda/retener.php?proc=mod_job',
		data: {idu : id},
	    success: function(res){
	     if(res.length > 0){
			llenadoObj = res;
	      }else{
	      	swal('Error', 'No se encuentran registros', 'error');
	      }

	    }
	});
}

function retornarLista(){
	var arregloProd ='';
	listaProductos().done(function(data){ arregloProd = data; });
	return arregloProd;
}

function listaProductos(){
	return $.ajax({
	    method: 'GET',
	    url: 'http://localhost/tienda/retener.php?proc=catalogo_prod',
	    success: function(res){
	     if(res.length > 0){
	       llenadoCatalogo = res;
	      }else{
	      	swal('Error', 'No se encuentran registros', 'error');
	      }

	    }
	});
}