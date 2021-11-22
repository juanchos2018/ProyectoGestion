<template>
  <div >
    <h5>Tareas de usuario</h5>
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
          <b-button variant="primary" >Agregar</b-button>
        <div   class="row" >        
        <!--  {{ steps[current].content  sub-title="00:00:05"  }}-->
        <div class="col-4" v-for="item in tareas" :key="item.key" style="margin-top:10px">  
            <b-card class="overflow-hidden"  footer-tag="footer">
                <b-dropdown class="dropdown-icon"   variant="#FFFFF" style="float:right" right >            
                    <b-dropdown-item >OPpcion 1</b-dropdown-item>
                    <b-dropdown-item >OPpcion 1</b-dropdown-item>
                    <b-dropdown-item >OPpcion 1</b-dropdown-item>           
                </b-dropdown>   
            <b-row no-gutters>
              <b-card-title> <h5> tarea de algo</h5> </b-card-title>   
            <b-col md="8">
                <b-card-body >               
                              
                <b-card-text>
                texto
                </b-card-text>                
                </b-card-body>                
            </b-col>
            </b-row>            
                <template #footer  footer-class="myDiv">
                     <div  style="background-color: white; float:right;">                     
                      <b-badge variant="danger">12/12/12</b-badge>
                     </div>                                          
                </template>
         </b-card>
         
        </div>
        </div>
      
          </b-card>

          <div>
                <div class="timeline-wrapper"> 
                <ul class="StepProgress"> 
                <li  v-for="schedule in timeline" :key="schedule.key"  class="StepProgress-item"  >
                  <div class="bold time"> {{schedule.fecha}}   </div> 
                  <b-card class="mb-2"  style="max-width: 20rem; margin-left:55px">  
                  <div style="margin: 0 0 0 30px;" class="bold">{{schedule.nombre}}</div>
                  <div style="margin: 0 0 0 30px">{{schedule.descripcion}}</div>
                  </b-card>
                </li>
              </ul>
            </div>   
          </div>
 
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
  </div>
</template>

<script>
import Widget from '@/components/Widget/Widget';
import moment from 'moment'
import firebase from '@/firebase'
import axios from  'axios';

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
  name: 'usuario-tarea',
  components: {    Widget,   },
  props: ['items'],

  data() {
        return {
        
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
            stepStyle: {
            marginBottom: '10px',
            boxShadow: '0px -1px 0 0 #e8e8e8 inset',
            tareas:[],
            tareasAcabadas:[],
              timeline:[],
            
          },   
        
        };
      },
      created(){
         this.Listar();
      },
      mounted() {
          this.GetDatos();
      },
      methods: {
         GetDatos(){
         var item = this.$route.params.id_tarea
          if(item){     
              this.ListarTimliene(item);  
          }         
       },
           ListarTimliene(id_tarea){
           let me=this;
            axios.get('ApiWeb/Timeline.php/?id_tarea='+id_tarea).then(response => {              
                 me.timeline = response.data.data;    
                 console.log(response.data)            
               }).catch(function (error) {
                    console.log(error);
              }) .finally(() => {
           })
         },
           MostarFaseMetodolgiaProyecto(id){
              let me=this;
              axios.get('ProcesoProyecto.php/?id_proyecto='+id).then(response => {              
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
          Listar(){
              var vm = this
                  firebase.database().ref('Tareas').on('value', (data) => {   
                    this.tareas=[];             
                        data.forEach((doc) => {
                          var item = doc.val()
                          item.key = doc.key  
                          this.tareas.push(item)
                     //    vm.schedules.push(Object.assign({}, obj))
                  });
              });
           },  
           onChange(current) {
              console.log('onChange:', current);
              this.current = current;
              var code =this.fases[current].id_fase;
              console.log(code);
            },
        
      }
};
</script>

<style src="./stile.scss" lang="scss" scoped />
