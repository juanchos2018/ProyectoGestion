<template>
    <div>
        <h5>Proyectos </h5>                
       <div   class="row" > 
      
        <div class="col-4" v-for="item in proyectos" :key="item.key" style="margin-top:10px">  
            <b-card class="overflow-hidden"  footer-tag="footer" >
                <b-dropdown class="dropdown-icon"   variant="#FFFFF" style="float:right" right >            
                    <b-dropdown-item  @click="Ver(item.id)">Ver</b-dropdown-item>                                           
                </b-dropdown>   
            <b-row no-gutters>
              <b-card-title> <h5>{{item.nombre_proyecto}}</h5> </b-card-title>   <br>
              
            <b-col md="12">
                  <span class="badge badge-success">{{item.estado}}</span> 
                <b-card-body>  
                    
                <b-card-text>                   
                    <h5>{{item.nombre}}</h5>       
                </b-card-text>   
                </b-card-body>                  
                 <div  style="background-color: white; ">                     
                      <b-badge variant="danger">{{item.fecha_inicio}}</b-badge>
                       <b-badge variant="danger" style="margin-left:10px">{{item.fecha_termino}}</b-badge>
                 </div>           
            </b-col>
            </b-row>  
         </b-card>         
        </div>
        </div>                  
         <tarea-editar @CerrarModal="CerrarModal" :DialogoTareaEditar="DialogoTareaEditar"  ></tarea-editar>
    </div>
</template>

<script>
import axios from  'axios';
import TareaEditar from './TareaEditar';
export default {
    name: 'tarea-usuario',
     components: {TareaEditar  },
    data(){
        return{
              tareas:[],
            
              DialogoTareaEditar:false,
              idtipousuario:'',
              idusuario:'',
              proyectos:[],
        }
    },
    created () {
      //  this.ListarTareas();
    },
    mounted() {
     if(localStorage.idtipo) this.idtipousuario = localStorage.idtipo;
      if(localStorage.idtipo) this.idusuario = localStorage.id_usuario;
       this.ListarPoryectos(this.idusuario);   
    },
    methods: {
        ListarPoryectos(idtipousuario){
              let me=this;
              console.log(idtipousuario);
              axios.get('ApiWeb/Usuario.php/?usuario_miembroid='+idtipousuario).then(response => {                    
                      me.proyectos = response.data;     
                      console.log(response.data)                 
                  }).catch(function (error) {
                      console.log(error);
                 }) .finally(() => {                     
            })
        },
       
        Ver(id_responsable){
             this.$router.push({name:"tareaselemento",params:{id_responsable} });
        },
        EditarTarea(){
            this.DialogoTareaEditar=true;
        },
        CerrarModal(){
             this.DialogoTareaEditar=false;
        }
    }
}
</script>