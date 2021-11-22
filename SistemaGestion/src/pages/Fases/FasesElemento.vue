<template>
    <div>
  <b-modal  v-model="Show" @hide="CerrarModal"
            title="Nuevo Elemento Configuración" hide-footer   body-class="myDiv">
     <form action="">
       <div class="form-row">     
                   
          <b-form-group  label="Fase :"  class="col-md-12">
               <a-select   @change="handleChange"  v-model="idfase" >              
                 <a-select-option v-for="d in data" :key="d.id_fase">
                  {{ d.nombre_fase }}
              </a-select-option>
               </a-select>             
             </b-form-group>                
          </div>
          <div class="form-row"> 
              <b-form-group  label=" Elemento:"  class="col-md-12">
             <a-select   @change="handleChange"  v-model="id_elemento" >              
                 <a-select-option v-for="d in elentosConfi" :key="d.value">
                {{ d.text }}
              </a-select-option>
               </a-select>  
             </b-form-group> 
          </div>      
         <hr>
        <div class="float-right" >              
          <b-button type="button"  @click="CerrarModal"  variant="light"  class="p-2 px-4 btn-xs">Cancelar</b-button>
          <b-button type="button"  variant="primary"  class="p-2 px-4 btn-xs" @click="Registrar">
              <beat-loader :loading="isLoading" :color="'#68d391'" :size="8" />
             <span v-show="!isLoading">Crear Elemento</span>
            </b-button>
        </div>
     </form>    
  </b-modal> 
    </div>
</template> 
<script>
import axios from  'axios';
import Swal from 'sweetalert2'
export default {
  name: 'fases-elemento',
     props:{
      DialogoFaseElemento: {       
        type: Boolean,
        required: true,
        default: false,        
      },
      data: {
				type: Array,
				default: () => [],
			},
      
      idmetodologia: [String, String]            
    },
    data(){
        return{   
             Show:this.DialogoFaseElemento, 
             fasesmetodologia:[],
             elentosConfi:[],
             isLoading:false,
             id_elemento:'',
             nombre:'',
             idfase:'',
             
        }
    },
    created(){
        this.ListarElementos();
    },
    watch: {
       DialogoFaseElemento(){
        this.Show = this.DialogoFaseElemento
       }
    },
    mounted() {  
      // this.$nextTick(() => {
      //      this.ListarFase(this.idmetodologia)
      //  });
    },
    methods:{
        handleChange(value) {
            console.log(`selected ${value}`);
        },
        CerrarModal(){              
            this.$emit('CerrarModal');
        },
        ListarElementos(){
             let me=this;
                  var elementos=[];
                  axios.get('ApiWeb/Elemento.php/').then(response => { 
                  elementos=response.data.data;   
                  elementos.map(function(x){
                        me.elentosConfi.push({text: x.nombre,value:x.id_elemento});
                 });  
              }).catch(function(error){
                  console.log(error);
           });       
        },
        ListarFase(metodologiaId){           
         let me=this;        
         var fases=[];
           axios.get('ApiWeb/Fase.php/?metodologiaId='+metodologiaId).then(response => { 
                 fases= response.data;                              
                 fases.map(function(x){
                    me.fasesmetodologia.push({text: x.nombre_fase,value:x.id_fase});                      
                  }); 
               }).catch(function (error) {
                      console.log(error);
              }) .finally(() => {
           })
        },
        Registrar(){
                let faseId=this.idfase;
                let elementoId=this.id_elemento;                
                const obj={faseId,elementoId};
                axios.post('ApiWeb/PlantillaElemento.php/',obj).then(response => {   
                  var estado=response.data.mensaje;
                  if(estado=="Existe"){
                    this.Existe(); 
                  } else{
                    this.Confirmacion();
                  // this.ListarFases(this.idmetodologia)
                  }
                 
                }).catch(function (error) {
                      console.log(error);
                }) .finally(() => {
                     
            })
        },
        Existe(){
          Swal.fire({
            title: '<strong>Alerta </strong>',
            icon: 'info',
            html:
              'Ya existe este elemento en esta fase ' ,
          })
       },
        Confirmacion(){
            this.$swal({
                position: 'top-end',
                icon: 'success',
                title: 'Registrado',
                text:'texto',
                showConfirmButton: false,
                timer: 3000
            })
         },
    }
}
</script>
<style scoped>
  ::v-deep .myDiv {
    background-color: 	#FFFFFF;
  }

</style>
