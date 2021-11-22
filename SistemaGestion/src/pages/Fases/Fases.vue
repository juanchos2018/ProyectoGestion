<template>
    <div>   
  <div >
  <b-button type="button"  class="m-1 p-2 px-4 btn-xs" variant="primary" @click="DialogoFase=true"> 
              <i class="fa fa-plus-circle"></i> Nueva Fase
            </b-button>
            <b-button variant="outline-primary" class="m-1 p-2 px-4 btn-xs"   @click="DialogoFaseElemento=true">  <i class="fa fa-plus-circle"></i> ECS </b-button>
  </div> <br>
  <h4> Fases de la Metodologia  <strong>  {{nombremetodologia}}</strong>  </h4> 
  <br>
  
  <wizard
      ref="wizard"      
      :steps="items"         
      @click="click"
      :onNext="nextClicked" 
      :onBack="backClicked"
      v-on:RecibeStep="RecibeStep"   >
     
       <div slot="page1">
          <h4>Elementos de Configuración</h4>       
          <div style="width: 200px;float; float: right; display: inline-block;">
            <label for="">Buscar</label> 
            <b-form-input
                id="input-30" 
                require
                class="p-2 px-4 btn-xs"               
               v-model="search"  >
          </b-form-input> 
         </div>   
         
           <b-table striped hover :items="ListaFiltro" :fields="fields">
            <template v-slot:cell(acciones)="data">                      
                 <b-button variant="primary" size="sm" @click="MensajeEliminar(data.item.id_plantilla)" ><b-icon icon="trash" animation="fade" font-scale="1"></b-icon> </b-button>
              </template>  
                 <template #empty>
                  <div class="text-center text-muted">
                  Lista   Vacia                                                                                                                                                                                            
                  </div>
                </template>
            </b-table>   
        </div>       
    </wizard> 


  <fase-nueva @CerrarModal="CerrarModal" :DialogoFase="DialogoFase"  v-bind:idmetodologia="datos.id_metodologia" v-on:Listar-Fase="ListarFasePorMetodologia"></fase-nueva>
  
  <fases-elemento @CerrarModal="CerrarModal" :data="items"   :DialogoFaseElemento="DialogoFaseElemento" v-bind:idmetodologia="datos.id_metodologia" > </fases-elemento>
    
   </div>

</template>

<script>
import axios from  'axios';
import Wizard from './Wizard.vue';
import FaseNueva from './FaseNueva';
import FasesElemento from './FasesElemento';

export default {
     components: { Wizard,FaseNueva,FasesElemento },
     
    data(){
        return{
           fields: [
                    { label:"Id", key: 'id_elemento', sortable: false },
                    { label:"Nombre Elemento", key: 'nombre', sortable: false },  
                    { label:"Acciones", key: 'acciones', sortable: false },
                ],           
            DialogoFaseElemento:false,    
            DialogoFase:false,
            nombremetodologia:'',
            id_metodologia:'',
            items:[],
            current: 0,
            search: '',
            detalle2:[],
            datos:{
                 id_metodologia:"",
                 nombre:""               
              },
                   
        }
    },
    created(){   
          this.$eventHub.$on('Listar-Fase', this.ListarFasePorMetodologia);
    },
    mounted(){
          this.GetDatos()
    },
     computed: {
            ListaFiltro() {
                return this.detalle2.filter(post => {
                return post.nombre.toLowerCase().includes(this.search.toLowerCase())
            })
        }
     },
    methods:{    
       onChange(current) {
        console.log('onChange:', current);
        this.current = current;
       },
       GetDatos(){
         var item = this.$route.params.item
          if(item){          
            var val = item.split("-")
            this.datos.id_metodologia = val[0]
            this.id_metodologia=val[0];
            this.datos.nombre=val[1]   
            this.nombremetodologia=val[1];
            this.ListarFasePorMetodologia(val[0]);  
          }         
       },
       ListarFasePorMetodologia(metodologiaId){    
         let me=this;
         axios.get('ApiWeb/Fase.php/?metodologiaId='+metodologiaId).then(response => {              
                 me.items = response.data;
                 me.ListarElemtosFase(me.items[0].id_fase);   
               }).catch(function (error) {
                    console.log(error);
              }) .finally(() => {
           })
       },
       CerrarModal() {
           this.DialogoFase = false;    
           this.DialogoFaseElemento = false;           
       },
       ListarElemtosFase(faseId){
          let me=this;
          axios.get('ApiWeb/PlantillaElemento.php/?faseId='+faseId).then(response => {    
            console.log(response.data)             
                 me.detalle2 = response.data;                
               }).catch(function (error) {
                   console.log(error);
             }) .finally(() => {
         })
       },     
       MensajeEliminar(id){
            this.$swal.fire({
                        title: 'Elminar ?',
                        text: "Ya no podras revertir!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                          this.Eliminar(id);
                        
                  }
             })
       },  
       Eliminar(id){       
         var id_plantilla=id;
          const obj={id_plantilla};
          axios.get('ApiWeb/PlantillaElemento.php/?id_plantilla='+id_plantilla).then(response => {                       
                 console.log(response);
                   this.$swal.fire(
                            'Eliminado!',
                            'Has Eliminado.',
                            'success'
                        )
                }).catch(function (error) {
                      console.log(error);
                }) .finally(() => {                     
              })
       },
       alerta(){        
           this.$refs.popover.$emit('open')
       },
    
       nextClicked(currentPage) {
               
        let me =this;
        var code =this.items[currentPage+1].id_fase;
        me.ListarElemtosFase(code);      
        return true;
        },
        RecibeStep(e){
          console.log("REcibinedo step")
           console.log(e);
        
        },
        backClicked(currentPage) {         
          let me =this;
          var code =this.items[currentPage-1].id_fase;
        
          me.ListarElemtosFase(code);
        
         return true; //return false if you want to prevent moving to previous page
        },
        enableSave() {
          this.steps[3].options.nextDisabled = false;
        },
        go() {
          this.$refs.wizard.goTo(this.cStep++);
        },
       
    }
}
</script>


<style src="./fases.scss" lang="scss"  scoped />