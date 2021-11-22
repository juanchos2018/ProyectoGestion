<template>
  <b-modal id="modal-fase" v-model="Show" @hide="CerrarModal"
      title="Nueva Fase" hide-footer  body-class="myDiv" >
     <form action="">
       <div class="form-row">                 
              <b-form-group id="input-group-3" label="Nombre Fase:" class="col-md-12">
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
                   v-model="nombre">
               </b-input>
             </b-form-group>   
          </div>        
         <hr>
        <div class="float-right" >              
          <b-button type="button"  @click="CerrarModal"  variant="light"  class="p-2 px-4 btn-xs">Cancelar</b-button>
          <b-button type="button"  @click="RegistrarFase" variant="primary"  class="p-2 px-4 btn-xs">
              <beat-loader :loading="isLoading" :color="'#68d391'" :size="8" />
             <span v-show="!isLoading">Crear Fase</span>
            </b-button>
        </div>
     </form>
  </b-modal>
</template>

<script>

import axios from  'axios';
import Swal from 'sweetalert2'
export default {
    name: 'fase-nueva', 
    props:{
      DialogoFase: {       
        type: Boolean,
        required: true,
        default: false
      }, idmetodologia: [String, String],
            
    },
    data() {
        return {
          Show:this.DialogoFase,
          CodeMetodologia:'M',
          isLoading:false, 
          contador:0,        
          codigo:'',
          nombre:'',  
          }
    },
    watch: {
      DialogoFase(){
        this.Show = this.DialogoFase
      }
    },
    created () {
    
    },
    computed: {
     
    },
    methods: {
      RegistrarFase(){         
          let nombre_fase=this.nombre;      
          let metodologiaId=this.idmetodologia;    
          const obj={nombre_fase,metodologiaId};
           axios.post('ApiWeb/Fase.php/',obj).then(response => {
             var estado=response.data.mensaje;
             if(estado=="Existe"){
               this.Existe(); 
             } else{
              this.Confirmacion();
              this.ListarFases(this.idmetodologia)
             }
         
          }).catch(function (error) {
              console.log(error);
          }) .finally(() => {
              
         })
      },  
      ListarFases(idmeto){
          this.$emit('Listar-Fase',idmeto);
      },
      CerrarModal(){              
          this.$emit('CerrarModal');
      },
      Existe(){
          Swal.fire({
            title: '<strong>Alerta </strong>',
            icon: 'info',
            html:
              'Este fase existe  ' ,          
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
};
</script>
<style scoped>
  ::v-deep .myDiv {
    background-color: 	#FFFFFF;
  }

</style>

