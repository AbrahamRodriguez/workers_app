
$("#login").on("click" , function(e){
  var user  = $('#user').val();
  var clave = $('#clave').val();
  ingresar(user , clave);
});

function ingresar(user , clave){
$.ajax({
    method: 'POST',
    url: 'http://localhost/tienda/loggear.php?proc=log_in',
    data: {name: user, ps: clave},
    success: function(res){
     if(res == '1'){
        newDoc();
      }else{
        swal('Error', 'Error de autenticación', 'error');
      }

    }
});

}

function newDoc() {
  window.location.assign("catalogo.html")
}