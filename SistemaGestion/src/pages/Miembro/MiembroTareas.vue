<template>
  <div >
    <h5>Tareas de Miembro :  {{nombre_miembro }} {{apellido_miembro}}</h5>
  
    <h5> Rol {{rol_miembro}} </h5>
          <b-card   
            header="Primary" 
            header-text-variant="white"
            header-bg-variant="primary"           
            header-tag="header" footer-tag="footer"> 
        <template #header>
            <h6 class="mb-0" style="color:#FFFFFF">Header Slot</h6>
          </template>
        <a-steps :current="current" @change="onChange" :style="stepStyle"  type="navigation" >
          <a-step v-for="item in fases" :key="item.title" :title="item.title"  />
        </a-steps>
        

<!--
  <b-button variant="primary"  @click="DetalleTarea">Agregar</b-button>

          <a-steps direction="vertical"  :current="current1"  @change="onChange1">
              <a-step title="nuevo" description="This is a description." />
              <a-step title="en progredo" description="This is a description." />
              <a-step title="terminado" description="This is a description." />
            </a-steps>  
                        <div class="steps-content">
                {{current1}}
              </div>-->
       <b-tabs pills card vertical nav-wrapper-class="w-45">
            <b-tab title="Nuevo" active><b-card-text>
                
        <div   class="row" > 
        <!--  {{ steps[current].content  sub-title="00:00:05"  }}-->
        <div class="col-4" v-for="item in tareas" :key="item.key" style="margin-top:10px" @click="DetalleTarea" >  
            <b-card class="overflow-hidden"  footer-tag="footer" >
                <b-dropdown class="dropdown-icon"   variant="#FFFFF" style="float:right" right >            
                    <b-dropdown-item >OPpcion 1</b-dropdown-item>
                    <b-dropdown-item >OPpcion 1</b-dropdown-item>
                    <b-dropdown-item >OPpcion 1</b-dropdown-item>           
                </b-dropdown>   
            <b-row no-gutters>
              <b-card-title> <h5>Nueva  tarea </h5> </b-card-title>   
            <b-col md="12">
                <b-card-body>  
                <b-card-text>
                texto
                </b-card-text>   
                </b-card-body>                  
                 <div  style="background-color: white; float:right;">                     
                      <b-badge variant="danger">12/12/12</b-badge>
                   </div>           
            </b-col>
            </b-row>  
         </b-card>         
        </div>
        </div>  
               
               </b-card-text></b-tab>
              <b-tab title="Progreso"><b-card-text>
                
                Tab contents 2
                
                </b-card-text></b-tab>
              <b-tab title="Finalizado"><b-card-text>
                Tab contents 3
                
                
                </b-card-text></b-tab>
            </b-tabs> 
        
       </b-card>
 
      <!--<div class="timeline-wrapper"> 
        <ul class="StepProgress"> 
      <li  v-for="schedule in schedules" :key="schedule.key"  class="StepProgress-item"  >
        <div class="bold time"> {{schedule.start}}   </div> 
        <b-card class="mb-2"  style="max-width: 20rem; margin-left:55px">  
        <div style="margin: 0 0 0 30px;" class="bold">{{schedule.title}}</div>
        <div style="margin: 0 0 0 30px">{{schedule.description}}</div>
         </b-card>
      </li>
    </ul>
   </div>-->
    <tarea-detalle @CerrarModal="CerrarModal"   :DialogoDetalleTarea="DialogoDetalleTarea" > </tarea-detalle>
  
  </div>
</template>

<script>
import Widget from '@/components/Widget/Widget';
import moment from 'moment'

import axios from  'axios';
import TareaDetalle from '@/pages/Tarea/TareaDetalle';
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    return [year, month, day].join('-');
}
var today=formatDate(Date.now())

export default {
  name: 'miembro-tareas',
  components: {    Widget, TareaDetalle  },
 
  data() {
        return {
        
            DialogoDetalleTarea:false,
            d : new Date(),
            valor:'',
            moment: moment,
            now: new Date().getTime(),
            schedules:[],
            range:{
              // start: `${this.addZero(this.d.getHours())}:${this.addZero(this.d.getMinutes())}`,
                //end: `${this.addZero(this.d.getHours())}:${vm.addZero(this.d.getMinutes())}`
            },
            description: '',
            title:'',
            t: '1em',
            current: 0,
            fases:[],
             current1: 0,
            stepStyle: {
            marginBottom: '10px',
            boxShadow: '0px -1px 0 0 #e8e8e8 inset',            
             },   
             tareas:[],
            tareasAcabadas:[],
            nombre_miembro:'',
            apellido_miembro:'',
            rol_miembro:'',
            usuario_miembroid:'',
            id_usuario:'',
        
        };
      },
      created(){
         this.ListarUsuario();
      },
      mounted() {
          this.GetDatos();
      },
      methods: {
         GetDatos(){
            var item = this.$route.params.id_proyecto
              if(item){     
                var datos=item.split('-');   
                var id_proye=datos[0];
                var id_miembro=datos[1];
                this.MostarFaseMetodolgiaProyecto(id_proye);  
                this.DatosMiembro(id_miembro);
              }   
          },         
          ListarUsuario(){
             let me=this;
                  var elementos=[];
                  axios.get('Backphp/ProcesoUsuario.php/',).then(function(response){                      
                  me.tareas=response.data;   
                   
              }).catch(function(error){
                  console.log(error);
            });       
        }, 
        DatosMiembro(id_miembro){
            let me=this;            
            axios.get('Backphp/ProcesoMiembro.php/?miembro_id='+id_miembro).then(response => {              
                // me.fases = response.data;
                             
                 me.nombre_miembro=response.data[0].nombre;
                 me.apellido_miembro=response.data[0].apellido;
                 me.rol_miembro =response.data[0].nombre_rol;
                 me.usuario_miembroid =response.data[0].usuario_miembroid;
              
                            
               }).catch(function (error) {
                      console.log(error);
              }) .finally(() => {
           })
        },
        MostarFaseMetodolgiaProyecto(id){
              let me=this;
              axios.get('Backphp/ProcesoProyecto.php/?id_proyecto='+id).then(response => {              
                    me.fases = response.data;
                                  
               }).catch(function (error) {
                      console.log(error);
              }) .finally(() => {
              })
          },
          addZero(i) {
          if (i < 10) {
            i = "0" + i;
          }
          return i;
          },
          addSchedule(){
            var vm = this 
            var obj={};
            var  fecha=moment.date;
            console.log(fecha);
              obj.start=today;
            
              obj.description=vm.description;
              obj.title = vm.title
              vm.schedules.push(Object.assign({}, obj))
          },
           
           onChange(current) {
              console.log('onChange:', current);
              this.current = current;
              var code =this.fases[current].id_fase;
              console.log(code);
          },
           onChange1(current1) {
              console.log('onChange:', current1);
              this.current1 = current1;
            },
          CerrarModal() {
           this.DialogoDetalleTarea = false;    
                  
          },
          DetalleTarea(){
                this.DialogoDetalleTarea=true;
          }
        
      }
};
</script>

<style src="./stile.scss" lang="scss" scoped />
