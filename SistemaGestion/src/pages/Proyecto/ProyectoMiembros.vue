<template>
    <div>
      <h4>Miembros</h4>
      <div>      
        <div style="width: 200px;  display: inline-block;">
            <label for="">Buscar</label> 
            <b-form-input
                id="input-30" 
                require
                class="p-2 px-4 btn-xs"               
               v-model="search"
                autocomplete="off"    >
          </b-form-input> 
         </div> 
          <br>       
          <br>    
        </div>
    <div >         
      <div class="row" >             
       <div class="col-4" v-for="item in ListaFiltro" :key="item.key">  
              
        <b-card no-body class="overflow-hidden"    border-variant="primary" footer-tag="footer">
            <b-row no-gutters>
            <b-col md="3">
                <div class="UserAvatar__IconImage-hmym9w-1 jtNJTZ" >
                    <center>  
                      <div v-if="item.nombre_rol=='Jefe de Proyecto'">
                         <img src="../../assets/logojefe2.png" alt="Avatar" class="avatar1"/>  
                      </div> 
                       <div v-else>
                          <img src="../../assets/loguusu1.png" alt="Avatar" class="avatar1"/>  
                      </div>  
                    </center>
                </div>     
            </b-col>
            <b-col md="9">
                <b-card-body >                   
                <b-card-title > {{item.nombre}}</b-card-title>                    
                <b-card-text>                    
                      <span class="badge badge-success">  {{item.nombre_rol}}</span>
                      <h5>  {{item.correo}}</h5>
                </b-card-text>                
                </b-card-body>                
            </b-col>
            </b-row>            
                <template #footer>
                     <div style="float:right">
                       <!-- <b-button variant="success" @click="Tareas(item.proyectoId+'-'+item.usuario_miembroid)" > <b-icon icon="list-task" animation="fade" font-scale="1"></b-icon> </b-button> -->
                       <b-button variant="success" style="margin-left:5px" v-b-tooltip.hover title="Editar" @click="AbrirDialogo(item.id,item.nombre)" >    <b-icon icon="pencil-square" animation="fade" font-scale="1" ></b-icon>   </b-button>
                     </div>                     
                </template>
         </b-card>
         <br>
       </div>
      </div>
    </div>  
      <editar-rol @CerrarModal="CerrarModal"   :DialogoModificar="DialogoModificar"  v-bind:id="id"  v-bind:nombre="nombremiembro" > </editar-rol>
   
    </div>
</template>

<script>

import axios from  'axios';
import EditarRol from '@/pages/Miembro/EditarRol';

export default {
    components: { EditarRol  },

    data(){
        return{  
              DialogoModificar:false,
              DialogUsuario:false,
              nombremiembro:'',
              search: '',
              items:[],
              id:'',
             }
      },
      created(){
        
          },
      mounted(){
          this.GetDatos()
          },
      computed: {
            ListaFiltro() {
                return this.items.filter(post => {
                return post.nombre.toLowerCase().includes(this.search.toLowerCase())
            })
          }
      },
      methods:{
          GetDatos(){
            var item = this.$route.params.id_proyecto
              if(item){        
                  this.ListarMiembrosProyecto(item);                   
              }   
          },
          AbrirDialogo(id,nombre){
            this.id=id;
            this.nombremiembro=nombre;
            this.DialogoModificar=true;  

          },
          ListarMiembrosProyecto(id){
              let me=this;
                axios.get('ApiWeb/Miembro.php/?id_proyecto='+id).then(response => {                         
                      me.items = response.data;          
                    }).catch(function (error) {
                            console.log(error);
                    }) .finally(() => {
                })
            },
            CerrarModal() {
                this.DialogUsuario = false;
                this.DialogoModificar=false;             
            },          
             Tareas(id_proyecto){   
          //   alert("tareas")           
                this.$router.push({name:"miembrotareas",params:{id_proyecto} });
            }
    }

}
</script>
<style src="./proyecto.scss" lang="scss" scoped />