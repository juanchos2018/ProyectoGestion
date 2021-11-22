<template>
    <div>
        <div>
          <!-- Menu Opciones -->
        <b-nav pills>
           <b-button type="button"  class="m-1 p-2 px-4 btn-xs" variant="primary" @click="DialogCliente=true"> 
            <i class="fa fa-plus-circle"></i> Nuevo
         </b-button>
          <b-button type="button"  class="m-1 p-2 px-4 btn-xs"  variant="primary" > 
            <i class="glyphicon glyphicon-download-alt"> </i> Exportar</b-button>
        </b-nav>
        <!-- Fin Menu Opcionesv -->
      </div>
      <div>  
           <b-card class="mt-3" header="Listado de Clientes"             
            header-text-variant="white"
            header-tag="header"
            header-bg-variant="primary" >     
            
            <b-form inline v-on:submit.prevent="GetClientes">
              <label class="mr-sm-2" for="inline-form-custom-select-pref">Filtro </label>
              <b-form-input v-model="Buscar" class="m-2" placeholder="Nombre de Cliente"></b-form-input>
              <b-button variant="primary" v-on:click="GetClientes">Buscar</b-button>
            </b-form>
        
             <!-- Listado tabla clienes -->
        
            <div class="">
              <b-table hover :items="items" :fields="fields">
                     <template v-slot:cell(fechaInscripcion)="data">
                       <template  v-if="data.item.fechaInscripcion">
                         {{  data.item.fechaInscripcion | moment("DD-MM-YYYY")  }}
                       </template>
                      </template>
                      <template v-slot:cell(zonaVenta)="data">
                        <b-button variant="primary" size="sm" class="m-1">PreVenta</b-button>
                        <b-button variant="primary" size="sm" @click="ClienteComprobante(data.item.idCliente)" >Comporbante</b-button>
                      </template>
              </b-table>
            </div>
               <b-pagination
                v-model="Pagina"
                :total-rows="TotalRegistros"
                :per-page="TamanoPagina"
                first-number
                @change="GetClientesPagina"
              ></b-pagination>
            <!-- Fin tabla -->
             </b-card> 
        </div>
      <div>

</div>

<div>
  <!-- Nuevo de Cliente-->
   <cliente-nuevo @CerrarModal="CerrarModal" :DialogCliente="DialogCliente"></cliente-nuevo>
 
  </div>
 </div>
</template>
<script>

import axios from  'axios';
import ClienteNuevo from './ClienteNuevo';

export default{
        components: {
             ClienteNuevo
        },
        data(){
            return{
            
                fields: [
                         { label:"DOC", key: 'idCliente', sortable: false },
                         { label:"Nombre o Razon Social", key: 'nombre', sortable: false },
                         { label:"Dirección", key: 'direccion', sortable: false },
                         { label:"Email", key: 'email', sortable: false },
                         { label:"Estado", key: 'estado', sortable: false },
                         { label:"Fecha Inscripción", key: 'fechaInscripcion', sortable: false },
                         { label:"Acciones", key: 'zonaVenta', sortable: false },
                ],
                 Pagina:1,
                TamanoPagina:50,
                TotalRegistros:100,
                items:[],
                Buscar:"",
                DialogCliente:false,
            }
        },

        created () {
          this.GetClientes();
        },

        methods:{
          CerrarModal() {
              this.DialogCliente = false
              this.GetClientes()
          },
          GetClientes(){
                  let me = this;
                  axios({
                      method: 'post',
                      url: 'Cliente/GetLista',
                      data: {
                          Buscar1:me.Buscar,
                          Pagina:1,
                          TamanoPagina:50
                      }
                  })
                  .then(response => {
                      //console.log(response.data.totalRegistros);
                      me.items = response.data.data;
                      me.Pagina = response.data.pagina;
                      me.TamanoPagina = response.data.tamanoPagina;
                      me.TotalRegistros = response.data.totalRegistros;

                  }).catch(function (error) {
                      console.log(error);
                  });
          },
          ClienteComprobante(idcliente){
              //console.log(idcliente); 
            //  clientecomprobante/:id
            this.$router.push('/app/clientecomprobante/'+idcliente);
          },   
          GetClientesPagina(value){
                  let me = this;
                  //console.log(value)
                  axios({
                      method: 'post',
                      url: 'Cliente/GetLista',
                      data: {
                          Buscar1:me.Buscar,
                          Pagina:value,
                          TamanoPagina:50
                      }
                  })
                  .then(response => {
                      //console.log(response.data);
                      me.items = response.data.data;
                      me.Pagina = response.data.pagina;
                      me.TamanoPagina = response.data.tamanoPagina;
                      me.TotalRegistros = response.data.totalRegistros;

                  }).catch(function (error) {
                      console.log(error);
                  });
          },   
 
    }

}
</script>

<style scoped>
  ::v-deep .my-class {
    background: black;
    color: white;
  }

  ::v-deep .my-second-class > .modal-dialog > .modal-content > .modal-header {
    background: black;
    color: white;
  }

  ::v-deep .myDiv {
      background-color: 	#FFFFFF;
  }
</style>