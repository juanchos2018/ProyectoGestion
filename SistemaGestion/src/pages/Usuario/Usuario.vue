<template>
    <div>
      <div>
         <b-button type="button"  class="m-1 p-2 px-4 btn-xs" variant="primary" @click="DialogUsuario=true"> 
            <i class="fa fa-plus-circle"></i> Nuevo Usuario
          </b-button>
          <br>           
        </div>
    <div >   
      <div class="row" >             
       <div class="col-4" v-for="item in items" :key="item.key">  
              
         <b-card no-body class="overflow-hidden"    border-variant="primary" footer-tag="footer">
            <b-row no-gutters>
            <b-col md="3">
                <div class="UserAvatar__IconImage-hmym9w-1 jtNJTZ" >
                    <center>              
                   <div style="font-size: 4rem;">                  
                      <div v-if="item.tipo=='Miembro'">
                         <b-icon icon="person-circle" animation="fade" font-scale="1" ></b-icon> 
                      </div> 
                       <div v-else>
                          <b-icon icon="person-bounding-box" animation="fade" font-scale="1" ></b-icon> 
                      </div>  
                </div>
                    </center>
                </div>     
            </b-col>
            <b-col md="6">
                <b-card-body >                   
                <b-card-title>{{item.nombre}}</b-card-title>                    
                <b-card-text> 
                   {{item.apellido}} <br>
                   <span class="badge badge-success">{{item.tipo}}</span> 
                </b-card-text>                
                </b-card-body>                
            </b-col>
            </b-row>          
            <!--  
                <template #footer>
                     <div class="float:right">
                       <b-button variant="success" @click="Tareas" > Ver</b-button>
                     </div>                     
                </template>-->
         </b-card>
         <br>
       </div>
      </div>
    </div>

         <usuario-nuevo @CerrarModal="CerrarModal" :DialogUsuario="DialogUsuario" v-on:Listar-Emit-Usuario="ListaUsuarios" ></usuario-nuevo>
    
    </div>
</template>

<script>
import axios from  'axios';
import firebase from '@/firebase'
import UsuarioNuevo from './UsuarioNuevo';

export default {
 components: {  UsuarioNuevo },

 data(){
     return{
          items:[],
          DialogUsuario:false,
              }
 },
 created(){
      this. ListaUsuarios();   
    },
 methods:{
       CerrarModal() {
           this.DialogUsuario = false;             
       },
       ListaUsuarios(){
           let me=this;
              axios.get('ApiWeb/Usuario.php/').then(response => {                     
                      me.items = response.data.data;                      
                  }).catch(function (error) {
                      console.log(error);
                  }) .finally(() => {
                     
            })
       },
      Listar(){
            firebase.database().ref('Usuario').on('value', (data) => {   
              this.items=[];             
                  data.forEach((doc) => {
                    var item = doc.val()
                    item.key = doc.key  
                    this.items.push(item)
             });
         });
       },
       Tareas(){
          this.$router.push('/app/usuariotareas');
       },
       
  }

}
</script>

<style src="./stile.scss" lang="scss" scoped />
