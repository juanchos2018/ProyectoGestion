<template>
  <b-modal id="modal-cliente" v-model="Show" @hide="CerrarModal"
  title="Nuevo Miembro" hide-footer   body-class="myDiv">

     <form action="">
          <div class="form-row">                 
          <b-form-group  label="Miembro:"  class="col-md-12">              
               <a-select     v-model="id_usuario" >              
                 <a-select-option v-for="d in usuarios" :key="d.value">
                  {{ d.text }}
              </a-select-option>
               </a-select>             
             </b-form-group>                
          </div>
          <div class="form-row"> 
              <b-form-group  label=" Rol:"  class="col-md-12">
             <a-select    v-model="id_rol" >              
                 <a-select-option v-for="d in roles" :key="d.value">
                {{ d.text }}
              </a-select-option>
               </a-select>  
             </b-form-group> 
          </div> 
        
         <hr>
        <div class="float-right" >              
          <b-button type="button"  @click="CerrarModal"  variant="light"  class="p-2 px-4 btn-xs">Cancelar</b-button>
          <b-button type="button"   variant="primary"  class="p-2 px-4 btn-xs" @click="RegistrarMiembro">
              <beat-loader :loading="isLoading" :color="'#68d391'" :size="8" />
             <span v-show="!isLoading">Agregar Miembro</span>
            </b-button>
        </div>
     </form>    
  </b-modal>
</template>

<script>

//DialogMetodologia
import axios from  'axios';
import Swal from 'sweetalert2'
export default {
    name: 'miembro-nuevo',
    props:{
      DialogMiembro: {       
        type: Boolean,
        required: true,
        default: false
      }, id_proyecto: [String, String],id_usuario_jefe: [String, String]
      
    },
    data() {
        return {
          contador:0,
          CodeMetodologia:'M',
          codigo:'',
          nombre:'',            
          isLoading:false,          
          Show:this.DialogMiembro,         
          usuarios:[],
          roles:[],
          id_rol:'',
          id_usuario:'',
         
        }
    },
    watch: {
      DialogMiembro(){
        this.Show = this.DialogMiembro
      }
    },
    created() {    
          this.ListarUsuario();
          this.ListarRoles();
    },
    computed: {
     
    },
    methods: {
      RegistrarMiembro(){    
          let me =this;     
          let usuario_miembroid=me.id_usuario;     
          let rolId=me.id_rol;     
          let proyectoId=me.id_proyecto;   
          const obj={usuario_miembroid:usuario_miembroid,rolId:rolId,proyectoId:proyectoId};
           axios.post('ApiWeb/Miembro.php/',obj).then(response => {                       
                          
              var estado=response.data.msg;
              if (estado=="Existe"){
                 me.ExisteMiembro(); 
              } else{
                me.Confirmacion();  
                me.ListarProyectos(me.id_usuario_jefe);
              }
             //                     
          }).catch(function (error) {
              console.log(error);
          }) .finally(() => {
              
          })
      },
      ListarProyectos(id_usuario_jefe){
          this.$emit('Listar-Proyecto-Emit',id_usuario_jefe);
      },   
      ListarUsuario(){
                  let me=this;
                  var elementos=[];
                  axios.get('ApiWeb/Usuario.php/').then(function(response){                      
                  elementos=response.data.data;   

             //     console.log(response.data)
                  elementos.map(function(x){
                    if(x.tipo=="Miembro"){
                         me.usuarios.push({text: x.nombre,value:x.id_usuario});
                    }
                      
                 });  
              }).catch(function(error){
                  console.log(error);
           });       
      },  
      ListarRoles(){
             let me=this;
                  var elementos=[];
                  axios.get('ApiWeb/Rol.php/',).then(function(response){                      
                  elementos=response.data.data;   
                  elementos.map(function(x){
                    if (x.nombre!="Jefe de Proyecto"){
                         me.roles.push({text: x.nombre,value:x.id_rol});
                    } 
                       
                 });  
              }).catch(function(error){
                  console.log(error);
           });       
       },         
       CerrarModal(){              
              this.$emit('CerrarModal');
       },     
       ExisteMiembro(){
          Swal.fire({
            title: '<strong>Alerta </strong>',
            icon: 'info',
            html:
              'Este usuario ya es miembro ' ,
          
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

