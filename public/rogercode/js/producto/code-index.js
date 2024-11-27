console.log("Starting");
const btnAddProducto = document.querySelector("#btnAddproducto");
const formProducto = document.querySelector("#form-producto");
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const btnClose = document.querySelector("#btnModalClose");

const selectCategory = document.querySelector("#categoria");

const selectMarca = document.querySelector("#marca");

const selectCentrocosto = document.querySelector("#centrocosto");
const producto_id = document.querySelector("#productoId");
const contentform = document.querySelector("#contentDisable");

const fechaalistamiento = document.querySelector("#fecha");


$(document).ready(function () {
    $(function () {
        $("#tableProducto").DataTable({
            paging: true,
            pageLength: 5,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "/showproducto",
                type: "GET",
            },
            columns: [
                { data: "id", name: "id" },
                { data: "namecategorias", name: "namecategorias" },
                { data: "namefamilia", name: "namefamilia" }, 
                { data: "name", name: "name" },         
                { data: "code", name: "code" },                
                {
                    data: "price_fama",
                    name: "price_fama",
                    render: function (data, type, row) {
                        return "$" + formatCantidadSinCero(data);
                    },
                },
                {
                    data: "iva",
                    name: "iva",
                    render: function (data, type, row) {
                        return formatCantidadSinCero(data) + "%";
                    },
                },
                {
                    data: "otro_impuesto",
                    name: "otro_impuesto",
                    render: function (data, type, row) {
                        return formatCantidadSinCero(data) + "%";
                    },
                },                            
                { data: "action", name: "action" },
            ],
            order: [[0, "DESC"]],
            language: {
                processing: "Procesando...",
                lengthMenu: "Mostrar _MENU_ registros",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "Ningún dato disponible en esta tabla",
                sInfo: "Mostrando del _START_ al _END_ de total _TOTAL_ registros",
                infoEmpty:
                    "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                search: "Buscar:",
                infoThousands: ",",
                loadingRecords: "Cargando...",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior",
                },
            },
        });
    });
    $(".selectMarca").select2({
        placeholder: "Busca un proveedor",
        width: "100%",
        theme: "bootstrap-5",
        allowClear: true,
    });
});

const edit = async (id) => {
    console.log(id);
    const response = await fetch(`/producto-edit/${id}`);
    const data = await response.json();
    console.log(data);
    if (contentform.hasAttribute("disabled")) {
        contentform.removeAttribute("disabled");

        $("#cliente").prop("disabled", false);
    }
    showForm(data);
};

const showForm = (data) => {
    let resp = data.listadoproductos;
    console.log(resp);
    producto_id.value = resp.id;
    
    $("#categoria").val(resp.category_id).trigger("change");
    $("#marca").val(resp.proveedor_id).trigger("change");
    $("#nivel").val(resp.level_product_id).trigger("change");
    $("#presentacion").val(resp.unitofmeasure_id).trigger("change");
    $("#familia").val(resp.meatcut_id).trigger("change");
    $("#subfamilia").val(resp.name).trigger("change");
    $("#code").val(resp.code).trigger("change");
    $("#codigobarra").val(resp.barcode).trigger("change");
    $("#stockalerta").val(resp.alerts).trigger("change");
    $("#impuestoiva").val(resp.iva).trigger("change");
    $("#isa").val(resp.otro_impuesto).trigger("change");   

    const modal = new bootstrap.Modal(
        document.getElementById("modal-create-producto")
    );
    modal.show();
};

const send = async (dataform, ruta) => {
    let response = await fetch(ruta, {
        headers: {
            "X-CSRF-TOKEN": token,
        },
        method: "POST",
        body: dataform,
    });
    let data = await response.json();
    //console.log(data);
    return data;
};

const refresh_table = () => {
    let table = $("#tableProducto").dataTable();
    table.fnDraw(false);
};

// Limpiar mensajes de error al cerrar la ventana modal
$('#modal-create-producto').on('hidden.bs.modal', function () {
    $('.error-message').text('');
});
