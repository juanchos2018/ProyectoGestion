<template>
  <b-modal  v-model="Show" @hide="CerrarModal"
  title="Agregar Version" hide-footer   body-class="myDiv">
     <form action="">
       <div class="form-row">                 
               <b-form-group  label="Fase:"  class="col-md-12">
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "                >
               </b-input>
             </b-form-group>                
          </div>
          <div class="form-row"> 
              <b-form-group  label="Elmento de Confuguracion:"  class="col-md-12">
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
                >
               </b-input>
             </b-form-group> 
          </div>       
           <div class="form-row"> 
              <b-form-group  label="Numero de Version:"  class="col-md-12">
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
               >
               </b-input>
             </b-form-group> 
          </div>  
             <div class="form-row"> 
              <b-form-group  label="Fecha Inicio"  class="col-md-6">
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
               >
               </b-input>
             </b-form-group> 
              <b-form-group  label="Fecha Fin"  class="col-md-6">
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "               >
               </b-input>
             </b-form-group> 
          </div> 

          <div class="form-row">
                <!--<b-form-group   label="Responsble :" class="col-md-12">           
                        <a-select  style="width: 100%"    >              
                        <a-select-option >
                               hola
                        </a-select-option>
                        </a-select>   
                  </b-form-group>  -->
          </div>
         <hr>
        <div class="float-right" >              
          <b-button type="button"  @click="CerrarModal"  variant="light"  class="p-2 px-4 btn-xs">Cancelar</b-button>
          <b-button type="button"   variant="primary"  class="p-2 px-4 btn-xs">
              <beat-loader :loading="isLoading" :color="'#68d391'" :size="8" />
             <span v-show="!isLoading">Crear Version</span>
            </b-button>
        </div>
     </form>    
  </b-modal>
</template>

<script>

import axios from  'axios';
export default {
    name: 'elemento-version',
    props:{
      DialogoElementoVersion: {       
        type: Boolean,
        required: true,
        default: false
      },idlemennto: [String, String],
        idmetodo: [String, String]      
    },
    data() {
        return {
          Show:this.DialogoElementoVersion,
          elemntoconfiguracionID:'',
          miembroresponsableID:'', 
          CodeMetodologia:'M', 
          fecha_inicio:'',
          fecha_termino:'',
          isLoading:false,  
          contador:0,
          version:'',           
        }
    },
    watch: {
      DialogoElementoVersion(){
        this.Show = this.DialogoElementoVersion
      }
    },
    created () {    

    },
    computed: {
     
    },
    methods: {
      RegistrarVersion(){         
          let elemntoconfiguracionID=this.nombre;
          let version=this.codigo;     
          let fecha_inicio=this.codigo;    
          let fecha_termino=this.codigo;    
          let miembroresponsableID=this.codigo;          
          const obj={codigo_elemento,nombre};
          axios.post('Backphp/ProcesoVersion.php/',obj).then(response => {   
              this.Confirmacion();
          }).catch(function (error) {
              console.log(error);
          }) .finally(() => {
              
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
              text:'se ha registrado con exito',
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

