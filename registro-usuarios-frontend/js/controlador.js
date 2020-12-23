// es un array vacio que luego lleno con los usuarios del json
var usuarios = [];
// esta variable la utilizo para obtener el id para actualizar
var usuarioSeleccionado;
const url = '../../registro-usuarios/registro-usuarios-backend/api/usuarios.php';

// cargo usuarios
function obtenerUsuarios(){
    axios({
        method : 'GET',
        url : url,
        responseType : 'json'
    }).then(res=>{
        // me imprime en la consola si sale bien 
        console.log(res.data);
        // asigno los valores a usuarios
        this.usuarios = res.data;
        llenarTabla();
    }).catch(error=>{
        // me imprime el error en la consola si sale mal
        console.error(error);
    });
}
obtenerUsuarios();

// lleno tabla
function llenarTabla(){
    document.querySelector('#tabla-usuarios tbody').innerHTML = '';

    for(let i=0;i<usuarios.length;i++){
        // trabajo con tbody de la tabla usuarios y lo pongo dentro de un cilco
        document.querySelector('#tabla-usuarios tbody').innerHTML +=

        `<tr>
          <td>${usuarios[i].nombre}</td>
          <td>${usuarios[i].apellido}</td>
          <td>${usuarios[i].fechaNacimiento}</td>
          <td>${usuarios[i].pais}</td>
          <td>
            <button class="button" onclick="eliminar(${i})" >eliminar</button>
            <button class="button" onclick="seleccionar(${i})" >editar</button>
          </td>
        </tr>`;
    }

}

function eliminar(indice){
    console.log('Eliminar el elemento con el indice : ' + indice);

    axios({
        method : 'DELETE',
        url : url + `?id=${indice}`,
        responseType : 'json'
    }).then(res=>{
        console.log(res.data);
        // traigo denuevo los usuarios asid esaparecen en tiempo real
        obtenerUsuarios();
    }).catch(error=>{
        console.error(error);
    });
}

function guardar(){
    // deshabikito el boton de guardar hasta que se termine de guardar el nuevo usuario, asi el usuario no apreta muchas veces cuando tarda mucho
    document.getElementById('btn-guardar').disabled = true;
    document.getElementById('btn-guardar').innerHTML = 'Guardando...';
    // creo un json
    let usuario = {
        nombre : document.getElementById('nombre').value,
        apellido : document.getElementById('apellido').value,
        fechaNacimiento : document.getElementById('fechaNacimiento').value,
        pais : document.getElementById('pais').value
    };
    console.log('Usuario a guardar :',usuario);

    axios({
        method : 'POST',
        url : url,
        responseType : 'json',
        data: usuario
    }).then(res=>{
        console.log(res.data);
        limpiar();
        // traigo denuevo los usuarios asid esaparecen en tiempo real
        obtenerUsuarios();
        // habilito el boton
        document.getElementById('btn-guardar').disabled = false;
        document.getElementById('btn-guardar').innerHTML = 'Guardar';
    }).catch(error=>{
        console.error(error);
    });
}

function limpiar(){
        document.getElementById('nombre').value = null;
        document.getElementById('apellido').value = null;
        document.getElementById('fechaNacimiento').value = null;
        document.getElementById('pais').value = null;
        // ahora oculto y muestro botones pertinentes
        document.getElementById('btn-guardar').style.display = 'inline';
        document.getElementById('btn-actualizar').style.display = 'none';
}

function actualizar(){

    // creo un json
    let usuario = {
        nombre : document.getElementById('nombre').value,
        apellido : document.getElementById('apellido').value,
        fechaNacimiento : document.getElementById('fechaNacimiento').value,
        pais : document.getElementById('pais').value
    };
    console.log('Usuario a actualizar :',usuario);

    axios({
        method : 'PUT',
        url : url + `?id=${usuarioSeleccionado}`,
        responseType : 'json',
        data: usuario
    }).then(res=>{
        console.log(res.data);
        limpiar();
        // traigo denuevo los usuarios asid esaparecen en tiempo real
        obtenerUsuarios();
    }).catch(error=>{
        console.error(error);
    });

}

function seleccionar(indice){
    // le doy el indice a esta variable para despues usarla en actualizar
    usuarioSeleccionado = indice;

    console.log('Se selecciono el elemento de indice: ' + indice);

    axios({
        method : 'GET',
        url : url + `?id=${indice}`,
        responseType : 'json',
    }).then(res=>{
        console.log(res);
        // muestro los valores del usuario seleccionado, asignado por el servidor
        document.getElementById('nombre').value = res.data.nombre;
        document.getElementById('apellido').value = res.data.apellido;
        document.getElementById('fechaNacimiento').value = res.data.fechaNacimiento;
        document.getElementById('pais').value = res.data.pais;
        // ahora oculto y muestro botones pertinentes
        document.getElementById('btn-guardar').style.display = 'none';
        document.getElementById('btn-actualizar').style.display = 'inline';
        // traigo denuevo los usuarios asid esaparecen en tiempo real
        obtenerUsuarios();
    }).catch(error=>{
        console.error(error);
    });

}
