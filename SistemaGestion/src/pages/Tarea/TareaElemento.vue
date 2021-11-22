<template>
    <div>
        <div>
          <b-card>               
                <div class="row">               
                  <b-form-group    class="col-md-12">               
                <div class="">               
                <h5>{{nombre_elemento}}</h5>                  
                </div>
                </b-form-group>     
            </div>  
              <div  class="form-row">  
                <b-form-group    class="col-md-4">
                <label class="control-label font-weight-bold text-info">Fase</label> 
                <div class="">               
                <label for="">{{ nombre_fase}}</label>                 
                </div>
                </b-form-group>
                <b-form-group    class="col-md-4">
                <label class="control-label font-weight-bold text-info">Proyecto</label> 
                <div class="">               
                <label for="">{{ nombre_proyecto}}</label>                 
                </div>
                </b-form-group>
                </div>            
              <br>          
          </b-card>
        </div>
        <div>
         <br>
        <b-card no-body>
          <b-tabs
                active-nav-item-class="font-weight-bold text-uppercase text-danger"
                active-tab-class="font-weight-bold text-success"
                content-class="mt-3" >
                <b-tab title="Tareas" active>
                    <div class="float-right">
                            <div v-if="esJefe">                                       
                                    <b-button @click="AbrirModal" variant="primary"  class="p-2 px-4 btn-xs"> Agregar Tarea </b-button>
                               </div>
                    </div> <br> <br>
               <div class="row" >             
                    <div class="col-4" v-for="item in tareasversion" :key="item.key">                
                        <b-card no-body class="overflow-hidden"  footer-tag="footer">
                            <b-row no-gutters>
                            <b-col md="3">
                                <div class="UserAvatar__IconImage-hmym9w-1 jtNJTZ" >
                                    <center> 
                                    <img src="../../assets/tarea.png" alt="Avatar" class="avatar1"/> 
                                    </center>
                                </div>     
                            </b-col>
                            <b-col md="8">
                                <b-card-body >                   
                                <b-card-title> <h5> {{item.descripcion}}</h5> </b-card-title>                    
                                <b-card-text>
                                    <h5>{{item.estado1}}</h5>
                                   <a-progress :percent="parseInt(item.porcentajeavance)" /> 
                                   <h5>Res. : {{item.nombre}}</h5>
                                </b-card-text>                
                                </b-card-body>                
                            </b-col>      
                             </b-row>      
                                  <template #footer  footer-class="myDiv">
                                    <div  style="background-color: white; float:right;">
                                    <b-button variant="success" v-b-tooltip.hover title="Detalle"  @click="DetalleTarea(item.id_tarea)"> <b-icon icon="card-list" animation="fade" font-scale="1" ></b-icon> </b-button>
                                   </div>                                          
                                </template>
                        </b-card>
                        <br>
                    </div>
                    </div>                                
                </b-tab>
                <b-tab title="Terminado">
                     <div class="row" >             
                    <div class="col-4" v-for="item in tareasterminadas" :key="item.key">                
                        <b-card no-body class="overflow-hidden"  footer-tag="footer">
                            <b-row no-gutters>
                            <b-col md="3">
                                <div class="UserAvatar__IconImage-hmym9w-1 jtNJTZ" >
                                    <center> 
                                    <img src="../../assets/tarea.png" alt="Avatar" class="avatar1"/> 
                                    </center>
                                </div>     
                            </b-col>
                            <b-col md="8">
                                <b-card-body >                   
                                <b-card-title> <h5> {{item.descripcion}}</h5> </b-card-title>                    
                                <b-card-text>
                                    <h5>{{item.estado1}}</h5>
                                     <div style="display: flex;">
                                   <a-progress :percent="parseInt(item.porcentajeavance)" /> 
                                    <div v-if="item.estado2=='Aprobado'">
                                   <b-icon icon="check-square" scale="2" variant="success" v-b-tooltip.hover title="Aprobado"></b-icon>
                                  </div>    
                                  <div v-else-if="item.estado2 == 'Revision'">
                                       <b-icon icon="hourglass-split" scale="2" variant="primary" v-b-tooltip.hover title="Revision"></b-icon>
                                   </div>   
                                    <div v-else-if="item.estado2 == 'Observado'">
                                        <b-icon icon="exclamation-triangle-fill" scale="2" variant="warning" v-b-tooltip.hover title="Observado"></b-icon>
                                   </div>                      
                                   <div v-else>
                                       <b-icon icon="x-circle" scale="2" variant="danger"></b-icon>
                                  </div> 
                                   </div>
                                   <h5>Res. : {{item.nombre}}</h5>
                                </b-card-text>                
                                </b-card-body>                
                            </b-col>      
                             </b-row>      
                                  <template #footer  footer-class="myDiv">
                                    <div  style="background-color: white; float:right;">
                                    <b-button variant="success" v-b-tooltip.hover title="Detalle"  @click="DetalleTarea(item.id_tarea)"> <b-icon icon="card-list" animation="fade" font-scale="1" ></b-icon> </b-button>
                                   </div>                                          
                                </template>
                        </b-card>
                        <br>
                    </div>
                    </div>  
                </b-tab>             
            </b-tabs>
          </b-card>  
       </div>
       <!--Modal -->
        <tarea-nueva @CerrarModal="CerrarModal" :DialogoTarea="DialogoTarea" v-bind:miembros="miembros"  v-bind:id_version="id_version"  v-on:Listar-Tarea="ListarTareasVersion"></tarea-nueva>
       
    </div>
</template>

<script>


import axios from  'axios';
import TareaNueva from './TareaNueva';

export default {
    name: 'tarea-elemento',
    components: {TareaNueva },
    data(){
      return{
          nombre_proyecto:'',
          nombre_fase:'',
          nombre_elemento:'',
          id_elemento:'',
          id_miembro:'',
          id_version:'',
          miembros:[],
          tareasversion:[],
          tareasterminadas:[],
          DialogoTarea:false,
          DialogoDetalleTarea:false,
      }
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
            this.DatosId();    
    },
    methods: {
            DatosId(){
                var dato = this.$route.params.datos               
                if(dato){
                    this.editable = true
                    var val = dato.split("-")
                    this.nombre_elemento= val[0]
                    this.nombre_fase=val[1]
                    this.id_version=val[2]
                    this.id_miembro=val[3]
                    this.nombre_proyecto=val[4]
                    this.ListaMiembros(val[5]);
                    this.ListarTareasVersion(val[2]);                
                }
            },
            ListaMiembros(id){
                    let me=this;
                    var previa=[];
                     axios.get('ApiWeb/Miembro.php/?id_proyecto='+id).then(response => {                      
                            previa=response.data;  
                          //  console.log(response.data)
                            previa.map(function(x){
                              me.miembros.push({text: x.nombre,value:x.id});
                            })
                            }).catch(function (error) {
                                console.log(error);
                      }) .finally(() => {
                  })       
            },
            ListarTareasVersion(id){

                    let me=this; 
                    me.tareasterminadas =[];    
                    me.tareasversion =[];            
                    axios.get('ApiWeb/Tarea.php/?id_tarea='+id).then(response => {                          
                            response.data.forEach(elem => {
                                if (elem.estado1=="Terminado") {
                                    me.tareasterminadas.push({                                        
                                        id_tarea:elem.id_tarea,
                                        descripcion: elem.descripcion,
                                        porcentajeavance: elem.porcentajeavance,
                                        fecha_inicio:elem.fecha_inicio,
                                        fecha_termino: elem.fecha_termino,
                                        nombre:elem.nombre,
                                        estado:elem.estado,   
                                        estado1:elem.estado1, 
                                        estado2:elem.estado2,                  
                                    })
                            }else{
                                    me.tareasversion.push({
                                        id_tarea:elem.id_tarea,
                                        descripcion: elem.descripcion,
                                        porcentajeavance: elem.porcentajeavance,
                                        fecha_inicio:elem.fecha_inicio,
                                        fecha_termino: elem.fecha_termino,
                                        estado:elem.estado,  
                                        nombre:elem.nombre,
                                        estado1:elem.estado1, 
                                        estado2:elem.estado2,                  
                                  })
                                 }                        
                             }); 
                           console.log(response.data)                            
                            }).catch(function (error) {
                               console.log(error);
                     }) .finally(() => {
               }) 
            },
            DetalleTarea(id_tarea){
                this.$router.push({name:"tareadetalle",params:{id_tarea} });
            },
            AbrirModal(){
                this.DialogoTarea=true
            },
            CerrarModal(){
                this.DialogoTarea=false
            }
    }
}
</script>
<style src="./tarea.scss" lang="scss" scoped  />
