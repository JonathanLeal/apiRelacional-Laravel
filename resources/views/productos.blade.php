<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script defer>
        //guardar producto
        function guardarProducto() {
            const nombre_pro = this.nombre_pro;
            const cantidad = this.cantidad;
            const precio = this.precio;

            axios.post('http://127.0.0.1:8000/api/productos/save', {
                nombre_pro,
                cantidad,
                precio
            })
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.log(error.response.data);
            });
        }

        function obtenerProductos() {
            return {
                productos: [],
                init: async function(){
                    this.productos = await axios.get('http://127.0.0.1:8000/api/productos/list')
                    .then(response => {
                        console.log(response.data);
                        return response.data;
                    }).catch(error => console.log(error));
                },
                editarProducto(id_producto){
                    //llenar para editar
                },

                eliminarProducto(id_productos){

                },
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <title>Productos</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-4 offset-md-4">
                <div class="d-grid mx-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProductos">
                        Nuevo
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-lg-8 offset-0 offset-lg-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tabla-productos">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">PRODUCTO</th>
                                <th class="text-center">CANTIDAD</th>
                                <th class="text-center">PRECIO</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody x-data='obtenerProductos()'>
                            <template x-for='(producto,index) in productos.datos' :key='index'>
                                <tr>
                                    <td class="text-center" x-text="producto.id_productos"></td>
                                    <td class="text-center" x-text="producto.nombre_pro"></td>
                                    <td class="text-center" x-text="producto.cantidad"></td>
                                    <td class="text-center" x-text="producto.precio"></td>
                                    <td class="text-center">
                                        <button class="btn btn-info" @click="editarProducto(producto.id_productos)">Editar</button>
                                        <button class="btn btn-danger" @click="eliminarProducto(producto.id_productos)">Eliminar</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- INICIO DEL MODAL PRODUCTOS-->
    <div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Informacion del producto</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div x-data="{ nombre_pro: '', cantidad: '', precio: '' }">
                    <form @submit.prevent="guardarProducto">
                        <div class="form-group mt-2">
                            <label for="nombre_pro">Nombre del producto:</label>
                            <input type="text" class="form-control" id="nombre_pro" x-model="nombre_pro">
                        </div>
                        <div class="form-group mt-2">
                            <label for="cantidad">Cantidad:</label>
                            <input class="form-control" type="number" id="cantidad" x-model="cantidad">
                        </div>
                        <div class="form-group mt-2">
                            <label for="precio">Precio:</label>
                            <input class="form-control" type="number" step=".01" id="precio" x-model="precio">
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    <!-- FIN DEL MODAL PRODUCTOS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>