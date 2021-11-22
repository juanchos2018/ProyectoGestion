<template>
<div>
          <div class="form-row">             
          <b-form-group    class="col-md-3">  
            <Widget class="h-100 mb-6"   >
               <a-steps :current="current"   direction="vertical" @change="onChange" >
                 <a-step v-for="item in timeline" :key="item.id_timeline" :title="item.fecha" :sub-title="item.hora" :description="item.descripcion"  />              
                <a-popover slot="progressDot" slot-scope="{  prefixCls }">                 
                   <span :class="`${prefixCls}-icon-dot`" />
                </a-popover>             
            </a-steps>               
           </Widget>   
            </b-form-group>
             <b-form-group   class="col-md-9">  
               <div>
                <b-card>                   
                  <a-progress
                      :stroke-color="{
                            '0%': '#108ee9',
                            '100%': '#87d068',
                          }"
                          :percent="parseInt(porcentajeavance)"
                     />      
                   <h5 style="float:right; margin-right:20px">{{estado1}}</h5>           
                    <a-descriptions :title="descripcion">
                        <a-descriptions-item label="Nombre" >
                          {{nombre_miembro}}
                        </a-descriptions-item>
                        <a-descriptions-item label="Fecha Inicio">
                          {{fecha_inicio}}
                        </a-descriptions-item>
                        <a-descriptions-item label="Fecha Termino">
                            {{fecha_termino}}
                        </a-descriptions-item>
                        <a-descriptions-item label="Estado">
                          {{estado}}
                        </a-descriptions-item>
                        <a-descriptions-item label="Url Evidencia">
                         <!-- <b-link href="urlevidencia">link</b-link>-->   
                         <div v-if="urlevidencia=='nulo'"> 
                           <a href="#"  >Link</a>
                          </div>
                          <div v-else>
                            <a :href="urlevidencia"  target="_blank">Link</a>
                          </div>                
                         
                        </a-descriptions-item>
                      </a-descriptions>
                
                  <label for="">Comentario :</label>
                  <p> {{comnentario}}</p>
                  <div style="float:right;margin-right:20px; display:flex ">                  
                  <h5 style="margin-right:20px;  ">   {{estado2}}</h5>
                  <div v-if="estado2=='Aprobado'"> 
                      <b-icon icon="check-square" scale="2" variant="success"></b-icon>
                  </div>
                  <div v-else-if="estado2 == 'Revision'"> 
                     <b-icon icon="hourglass-split" scale="2" variant="success"></b-icon>
                  </div>
                  <div v-else-if="estado2 == 'Observado'">
                      <b-icon icon="exclamation-triangle-fill" scale="2" variant="warning" v-b-tooltip.hover title="Observado"></b-icon>
                  </div> 
                  <div v-else-if="estado2 == null">                 
                     <h4>-</h4>
                  </div> 
                  </div>                
                  
                </b-card>
              </div>
              <br>
                <div style="float:right">
               <!-- <b-button variant="danger"  class="p-2 px-4 btn-xs">Rechazar</b-button> -->
             
              <div v-if="esJefe">
                    
                    <b-button  v-if="estado1=='Terminado'" variant="success"  class="p-2 px-4 btn-xs" @click="MostrarMensaje" style="margin-left:5px">Responder</b-button>
               </div>

              </div>
            </b-form-group>    
        </div>  
        <hr>     
  </div>
</template>

<script>

//DialogMetodologia
import Widget from '@/components/Widget/Widget';
import moment from 'moment'
import firebase from '@/firebase'
import axios from  'axios';
import Swal from 'sweetalert2'
// CommonJS
//const Swal = require('sweetalert2')
export default {
    name: 'tarea-detalle',       
    data() {
        return {               
          
          nombre_miembro:'',
          fecha_inicio:'',
          fecha_termino:'',
          descripcion:'',
          porcentajeavance:null,
          urlevidencia:'',
          estado:'',   
          estado1:'',
          estado2:'',
          id_usuario:'',
          comnentario:'',
          timeline:[],
          current: 0,
          id_tareamiembro:'',
          mensaje:'',
        }
    },
    watch: {
    
    },
    created () {
    
    },
    computed: {  
        esAdministrador(){
        return this.$store.state.tipousuario =='Administrador';
        },
        esMiembro(){
        return  this.$store.state.tipousuario =='Miembro';
        },
        esJefe(){
           return  this.$store.state.tipousuario =='Jefe';
        }
     },
     mounted(){
      this.GetDatos()
    },
    methods: {
        GetDatos(){
         var item = this.$route.params.id_tarea
          if(item){     
            this.id_tareamiembro=item;
              this.ListarTimliene(item);  
              this.BuscarTarea(item);
          }         
       },
       ListarTimliene(id_tarea){
           let me=this;
            axios.get('ApiWeb/Timeline.php/?id_tarea='+id_tarea).then(response => {              
                 me.timeline = response.data;    
                 console.log(response.data)            
               }).catch(function (error) {
                    console.log(error);
              }) .finally(() => {
           })
         },
        BuscarTarea(id_tarea1){
           let me=this;
            axios.get('ApiWeb/Tarea.php/?id_tarea1='+id_tarea1).then(response => {   
              console.log(response.data)
                 me.nombre_miembro=response.data.nombre; 
                 me.fecha_inicio=response.data.fecha_inicio;
                 me.fecha_termino=response.data.fecha_termino   
                 me.descripcion=response.data.descripcion   
                 me.porcentajeavance=response.data.porcentajeavance         
                 me.urlevidencia=response.data.urlevidencia   
                 me.estado=response.data.estado
                 me.estado1=response.data.estado1    
                 me.estado2=response.data.estado2
               }).catch(function (error) {
                    console.log(error);
              }) .finally(() => {
           })
        },
        MostrarMensaje(){
          if(this.estado2=="Aprobado"){
            this.MensajeTareaAprobada();
          }else{
            this.Responder();
          }
        },
        Responder(){
          const swalWithBootstrapButtons =  this.$swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true
              })
              swalWithBootstrapButtons.fire({
                title: this.descripcion,
                text: "Responder a esta  Tarea !",
                icon: 'warning',
                showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 confirmButtonText: 'Aprobar !',
                cancelButtonText: 'Rechazar !',
                cancelButtonColor: '#d33',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {
                    this.EditarTareaMiembro(this.id_tareamiembro,"Terminado","Terminado","Aprobado");
                } else if (result.dismiss === Swal.DismissReason.cancel  ) {                  
                     this.RecharzarTarea();
                }
           })
        },     
        onChange(current) {
          console.log('onChange:', current);
           var id_timelinea =this.timeline[current].id_timeline;
           console.log('id :', id_timelinea);
           this.ListarComit(id_timelinea);
           this.current = current;
        },
        ListarComit(id_timelinea){
           let me=this;
            axios.get('ApiWeb/Historial.php/?id_timeline='+id_timelinea).then(response => {            
             
                if(response.data.length>0){
                   me.comnentario=response.data[0].descripcion;
                   me.urlevidencia=response.data[0].urlevidencia;
                }else{
                   me.comnentario="";
                }  
               }).catch(function (error) {
                    console.log(error);
              }) .finally(() => {
           })
        },
        CerrarModal(){              
           this.$emit('CerrarModal');
        },   
        EditarTareaMiembro(idtarea,esta,esta1,esta2){
                  let id_tarea=idtarea; 
                  let estado=esta;  
                  let estado1=esta1;  
                  let estado2=esta2;  
                  let respuesta="Aprobado"; 
                  const obj={id_tarea,estado,estado1,estado2,respuesta};
                  axios.put('ApiWeb/Historial.php/',obj).then(response => {     
                      console.log(response.data)   
                          this.$swal.fire(
                          'Aprobado!',
                          'Your file has been deleted.',
                          'success'
                        )
                  }).catch(function (error) {
                      console.log(error);
                }) .finally(() => {              
             }) 
        },   
        RecharzarTarea(){
         let me =this;
         this.$swal.fire({
            title: 'Mensaje',
            input: 'textarea',
            confirmButtonText: 'Enviar !',
          }).then(function(result) {
            if (result.value) {             
                 me.EnviarMensaje(result.value);
            }
          })
        },       
        MensajeTareaAprobada(){
           Swal.fire('Esta Tarea ya esta Aprobada');
        },
        EnviarMensaje(mensaje){
          // this.EditarTareaMiembro(this.id_tareamiembro,"Terminado","Terminado","Aprobado");
                  let id_tarea=this.id_tareamiembro; 
                  let estado="Proceso";  
                  let estado1="Terminado";  
                  let estado2="Observado";  
                  let respuesta=mensaje; 
                  const obj={id_tarea,estado,estado1,estado2,respuesta};
                  axios.put('ApiWeb/Historial.php/',obj).then(response => {     
                      console.log(response.data)   
                          this.$swal.fire(
                          'Observado!',
                          'Enviado Obervacion.',
                          'success'
                        )
                  }).catch(function (error) {
                      console.log(error);
                  }) .finally(() => {              
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

<style src="./tarea.scss" lang="scss" scoped />
