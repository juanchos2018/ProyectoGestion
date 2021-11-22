<template>
    <div>
         <div style="width: 200px; float: right; ">
            <label for="">Buscar</label> 
            <b-form-input
                id="input-30" 
                require
                class="p-2 px-4 btn-xs"               
             >
          </b-form-input> 
         </div> <br>
        <div>
            <h5>Listado Informe Cambio</h5>
          <br>
           <b-card>                  
             <b-table :items="items" :fields="fields"  stacked="sm">
              <template v-slot:cell(acciones)="data">
                <div style="display: flex;">
                    <b-button variant="primary"  class="p-2 px-4 btn-xs" @click="Detalle(data.item.id_informe)" >    <b-icon icon="layout-text-sidebar-reverse" ></b-icon> </b-button>
                  
                </div>                            
              </template>
             </b-table>                 
           </b-card>
        </div>
    </div>
</template>

<script>
import axios from  'axios';
export default {
    
    data(){
        return{
            items:[],
            fields: [
                    { label:"N°",       key: 'index',   sortable: false },
                    { label:"Codigo",   key: 'codigo',   sortable: false },    
                    { label:"tiempo",   key: 'tiempo',   sortable: false },
                    { label:"costo",    key: 'costo',    sortable: false },
                    { label:"fecha",    key: 'fecha',    sortable: false },
                    { label:"estado",   key: 'estado',   sortable: false },
                    { label:"Acciones", key: 'acciones', sortable: false },
                ],
        }
    },
    created () {
        this.ListarInformeCambio();
    },
     computed: {
         //   ListaFiltro() {
//return this.items.filter(post => {
               // return post.nombre.toLowerCase().includes(this.search.toLowerCase())
           //   })
         //  }
     },
    methods: {
           ListarInformeCambio(){
              let me=this;
              axios.get('ApiWeb/InformeCambio.php/').then(response => {                    
                      me.items = response.data;    
                      console.log(response.data)                  
                  }).catch(function (error) {
                      console.log(error);
                }) .finally(() => {               
            })
          },

          Detalle(id_informe){
            ///  alert(id_informe)
           this.$router.push({name:"informecambiodetalle",params:{id_informe} });
          }
        
         
    }
}
</script>