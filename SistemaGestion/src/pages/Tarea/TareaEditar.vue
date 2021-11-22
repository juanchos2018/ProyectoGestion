<template>
  <b-modal  v-model="Show" @hide="CerrarModal"
      title="Editar Tarea" hide-footer   body-class="myDiv">
     <form action="">
       <div class="form-row">                 
               <b-form-group  label="Nombre Tarea:"  class="col-md-12">
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
                  v-model="descripcion">
               </b-input>
             </b-form-group>                
          </div>  
            <div class="form-row">                
               <b-form-group  label="Porcentaje Avance:"  class="col-md-12">   
                 <div v-if="estadotarea=='Terminado'">
                   <a-slider v-model="rango"  @change="addNumber"  disabled />  
                 </div>        
                <div v-else>
                   <a-slider v-model="rango"  @change="addNumber"  />  
                 </div>               
                 {{rango}}                     
              </b-form-group>                      
          </div>
          
          <div class="form-row"> 
                <b-form-group  label="Url Evidencia"  class="col-md-12">
                        <b-form-input 
                          class="p-2 px-4 btn-xs" 
                          required          
                          v-model="urlevidencia" >
                        </b-form-input>
                </b-form-group>                                                 
          </div>             
          <div class="form-row">
            <b-form-group  label="descripcion"   class="col-md-12">
            <b-form-textarea              
                v-model="descripcion_avance"              
                placeholder="Enter at least 10 characters"
                rows="2"
              ></b-form-textarea>
          </b-form-group>
            </div>         
         <hr>
        <div class="float-right" >              
          <b-button type="button"  @click="CerrarModal"  variant="light"  class="p-2 px-4 btn-xs">Cancelar</b-button>
          <b-button type="button"   variant="primary"  @click="RegistrarAvance" class="p-2 px-4 btn-xs">
              <beat-loader :loading="isLoading" :color="'#68d391'" :size="8" />
              <span v-show="!isLoading"> Registra Avance</span>
            </b-button>           
        </div>
     </form>    
  </b-modal>
</template>

<script>

import axios from  'axios';
import moment from 'moment'

export default {
    name: 'tarea-editar',  
    props:{
      DialogoTareaEditar: {       
        type: Boolean,
        required: true,
        default: false
      },id_tarea: [String, String],descripcion: [String, String] ,porcentaje:{type:Number},id_responsable:[String, String],estadotarea:[String,String] 
      
    },
    data() {
        return {
          contador:0,
          CodeMetodologia:'M',
          codigo:'',
          nombre:'',            
          isLoading:false,          
          Show:this.DialogoTareaEditar,
          id_miembro:'',       
          fecha_inicio:'',
          fecha_termino:'',
          miembroreponsableID:'',
          urlevidencia:'',
          rango:this.porcentaje, 
          fecha_actual:moment().format('DD/MM/YYYY'),
          hora_actual:moment().format('HH:mm:ss'),
          estado_tarea:'',
          disabled: false,
          descripcion_avance:'',
          
        }
    },
    mounted: function () {
  //    this.rango=this.porcentaje;
     },
    watch: {
      DialogoTareaEditar(){
        this.Show = this.DialogoTareaEditar
      },   
      porcentaje(){
        this.rango = this.porcentaje;
      },  
    },
    created () {    
         
    },
    computed: {
     
    },
    methods: {
            addNumber() {
              let myNumber = this.rango;       
              this.$emit("update-number", myNumber);
            },
            RegistrarAvance(){
                 var estadota='';
                 var estado1='';
                  let id_tarea=this.id_tarea;
                  let urlevidencia=this.urlevidencia;
                  let porcentajeavance=this.rango;    
                
                  if(this.rango==100){
                      estadota="Proceso"
                      estado1="Terminado";
                  }else{
                      estadota="Proceso";
                      estado1="Proceso";
                  }
                  let estado=estadota;  
                  const obj={id_tarea,urlevidencia,porcentajeavance,estado,estado1};
                  axios.put('ApiWeb/Tarea.php/',obj).then(response => {     
                      console.log(response.data)   
                      this.Confirmacion();
                      this.ListarTareas(this.id_responsable); 
                      this.RegistrarTimeline(estadota);
                  }).catch(function (error) {
                      console.log(error);
                  }) .finally(() => {              
                })                
              // this.RegistrarTimeline(estadota);
            },     
            RegistrarTimeline(estadota){
                  let miembroresponsableID=this.id_responsable;
                  let fecha=this.fecha_actual;
                  let hora=this.hora_actual;    
                  let estado=estadota;   
                  let id_tarea=this.id_tarea;  
                  let descripcion_avance=this.descripcion_avance;  
                  let porcentajeavance=this.rango;  
                  let urlevidencia=this.urlevidencia;

                  const obj={miembroresponsableID,fecha,hora,estado,id_tarea,porcentajeavance,urlevidencia,descripcion_avance};

                  axios.post('ApiWeb/Timeline.php/',obj).then(response => {    
                           console.log(response.data)               
                     }).catch(function (error) {
                      console.log(error);
                  }) .finally(() => {              
                })
            },                 
            ListarTareas(id){           
                this.$emit('ListarTareas-Emit',id);
            },  
             onChange(value) {
              console.log('change: ', value);
            },
            onAfterChange(value) {
              console.log('afterChange: ', value);
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
.code-box-demo .ant-slider {
  margin-bottom: 16px;
}
</style>

