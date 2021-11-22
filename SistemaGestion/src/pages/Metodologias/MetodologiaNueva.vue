<template>
  <b-modal id="modal-cliente" v-model="Show" @hide="CerrarModal"
  title="Nuevo Metodologia" hide-footer   body-class="myDiv">

     <form action="">
       <div class="form-row">   
              
              <b-form-group id="input-group-3" label="Nombre Metodlogia:" label-for="NroDocumento" class="col-md-12">
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
          <b-button type="button"  @click="RegistrarMetodologia" variant="primary"  class="p-2 px-4 btn-xs">
              <beat-loader :loading="isLoading" :color="'#68d391'" :size="8" />
             <span v-show="!isLoading">Crear Metodologia</span>
            </b-button>
        </div>
     </form>
    
  </b-modal>
</template>

<script>
import firebase from '@/firebase'
//DialogMetodologia

import axios from  'axios';
export default {
    name: 'metodologia-nueva',
    props:{
      DialogMetodologia: {       
        type: Boolean,
        required: true,
        default: false
      },
      
    },
    data() {
        return {
          Show:this.DialogCliente,
          isLoading:false,  
          contador:0,       
          codigo:'',
          nombre:'',   
        }
    },
    watch: {
      DialogMetodologia(){
        this.Show = this.DialogMetodologia
      }
    },
    created () {  
    },
    computed: {
     
    },
    methods: {
      RegistrarMetodologia(){
          let nombre=this.nombre;         
          const obj={nombre};
           axios.post('ApiWeb/Metodologia.php/',obj).then(response => {                       
              console.log(response);
              this.Confirmacion();
              this.ListarMetodologia();           
          }).catch(function (error) {
              console.log(error);
          }) .finally(() => {
              
          })
      },   
      ListarMetodologia(){
          this.$emit('Listar-Emit');
      },     
      makeToast(msg,color) {
            this.toastCount++
            this.$bvToast.toast(msg, {
              title: 'Mensaje Cliente',
              variant:color,
              autoHideDelay: 3000,
              appendToast: false
            })
       },
        CerrarModal(){              
              this.$emit('CerrarModal');
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

