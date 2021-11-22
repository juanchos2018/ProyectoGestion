<template>
  <b-modal  v-model="Show" @hide="CerrarModal"
      title="Tarea Nueva" hide-footer   body-class="myDiv">
     <form action="">
       <div class="form-row">          
       
               <b-form-group  label="Nombre Tarea:"  class="col-md-12">
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
                 v-model="nombre_tarea">
               </b-input>
             </b-form-group>                
          </div>
             <div class="form-row">                 
               <b-form-group  label="Justificacion:"  class="col-md-12">
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
                 v-model="justificacion">
               </b-input>
             </b-form-group>                
          </div>
          <div class="form-row"> 
               <b-form-group  label="Fecha Inicio"  class="col-md-6">
                        <b-form-input                                          
                          type="date"
                          class="p-2 px-4 btn-xs" 
                          required          
                          v-model="fecha_inicio" >
                        </b-form-input>
                   </b-form-group> 
                    <b-form-group  label="Fecha Fin"  class="col-md-6">
                          <b-form-input                       
                          type="date"
                          class="p-2 px-4 btn-xs" 
                          required          
                        v-model="fecha_termino">
                      </b-form-input>
                </b-form-group> 
          </div>  
          <div class="form-row">
                   <b-form-group   label="Responsble :" class="col-md-12">           
                           <a-select  style="width: 100%"  v-model="id_miembro"  >              
                           <a-select-option v-for="d in miembros" :key="d.value">
                                    {{ d.text }}
                           </a-select-option>
                           </a-select>   
                     </b-form-group>  
          </div>     
         <hr>
        <div class="float-right" >              
          <b-button type="button"  @click="CerrarModal"  variant="light"  class="p-2 px-4 btn-xs">Cancelar</b-button>
          <b-button type="button"  @click="RegistrarTarea"  variant="primary"  class="p-2 px-4 btn-xs">
              <beat-loader :loading="isLoading" :color="'#68d391'" :size="8" />
             <span v-show="!isLoading">Crear Tarea</span>
            </b-button>
        </div>
     </form>    
  </b-modal>
</template>

<script>

import axios from  'axios';
export default {
    name: 'tarea-nueva',  
    props:{
      DialogoTarea: {       
        type: Boolean,
        required: true,
        default: false
      },miembros:{type:Array},id_version:[String,String]
      
    },
    data() {
        return {
          contador:0,
          CodeMetodologia:'M',
          codigo:'',
          nombre:'',            
          isLoading:false,          
          Show:this.DialogoTarea,
          id_miembro:'',
          nombre_tarea:'',
          justificacion:'',
          fecha_inicio:'',
          fecha_termino:'',
          miembroreponsableID:'',
          modelo:{}
         // miembros:[],
          
        }
    },
    watch: {
      DialogoTarea(){
        this.Show = this.DialogoTarea
      }
    },
    created () {    
         
    },
    computed: {
     
    },
    methods: {
            RegistrarTarea(){         
                let verionID=this.id_version;
                let miembroresponsableID=this.id_miembro;    
                let fecha_inicio=this.fecha_inicio;
                let fecha_termino=this.fecha_termino;  
                let descripcion=this.nombre_tarea;
                let porcentajeavance="0";   
                let urlevidencia="nulo";     
                let estado="Nuevo"; 
                let estado1="Nuevo"; 

                const obj={verionID,miembroresponsableID,fecha_inicio,fecha_termino,descripcion,porcentajeavance,urlevidencia,estado,estado1};
               console.log(obj);
               this.modelo={...obj}
                    axios.post('ApiWeb/Tarea.php/',obj).then(response => {                      
              
                    this.Confirmacion();    
                    this.ListarTarea();                
                
                }).catch(function (error) {
                    console.log(error);
                }) .finally(() => {
                    
                })
            },
            ListarTarea(){
                this.$emit('Listar-Tarea',this.id_version);
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

