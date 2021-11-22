<template>
  <b-modal id="modal-cliente" v-model="Show" @hide="CerrarModal"
  title="Nuevo Usuario" hide-footer   body-class="myDiv " >
     <form action="">
       <div class="form-row">   
             <b-form-group id="input-group-3" label="Nombre:" label-for="NroDocumento" class="col-md-12">
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
                v-model="nombre"  >
               </b-input>
             </b-form-group>
          </div>
          <div class="form-row">
             <b-form-group id="input-group-3" label="Apellidpo:" label-for="NroDocumento" class="col-md-12">
                   <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
                 v-model="apellido">
               </b-input>
             </b-form-group> 
          </div>
          <div class="form-row">
              <b-form-group id="input-group-3" label="Correo:" class="col-md-12">              
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
                 v-model="correo">
               </b-input>
             </b-form-group> 
          </div>

          <div class="form-row">
            <b-form-group id="input-group-3" label="tipo Usuario:" label-for="NroDocumento" class="col-md-12">
              <a-select    v-model="id_tipo_usuario" >              
                 <a-select-option v-for="d in tipoUsuario" :key="d.value">
                {{ d.text }}
              </a-select-option>
               </a-select> 
             </b-form-group> 
                 
          </div>
         <hr>
        <div class="float-right" >              
          <b-button type="button"  @click="CerrarModal"  variant="light"  class="p-2 px-4 btn-xs">Cancelar</b-button>
          <b-button type="button"  @click="RegistrarUsuario" variant="primary"  class="p-2 px-4 btn-xs">
              <beat-loader :loading="isLoading" :color="'#68d391'" :size="8" />
             <span v-show="!isLoading">Crear Usuario</span>
            </b-button>
         <!--     <b-button type="button"  @click="buscar" variant="primary"  class="p-2 px-4 btn-xs">
             
            buscar
            </b-button>-->
        </div>
     </form>
  </b-modal>
</template>

<script>

import axios from  'axios';
import Swal from 'sweetalert2'
//DialogMetodologia|
export default {
    name: 'usuario-nuevo',
    props:{
      DialogUsuario: {
        type: Boolean,
        required: true,
        default: false
      },
      
    },
    data() {
        return {
          codigo:'',
          nombre:'',
          apellido:'',
          correo:'',
          rol:'',            
          isLoading:false,          
          Show:this.DialogUsuario,
          tipoUsuario:[],
          id_tipo_usuario:'',

        }
    },
    watch: {
      DialogUsuario(){
        this.Show = this.DialogUsuario
      }
    },
    created () {
          this.ListarTipoUsuario();
    },
    computed: {
     
    },
    methods: {
       ListarTipoUsuario(){
              let me=this;
                  var tipos=[];
                  axios.get('ApiWeb/TipoUsuario.php/',).then(function(response){                      
                  tipos=response.data.data;    
                  console.log(response.data);              
                  tipos.map(function(x){
                        me.tipoUsuario.push({text: x.nombre,value:x.id_tipo});
                 });  
              }).catch(function(error){
                  console.log(error);
              });
         },
         RegistrarUsuario(){
          let nombre=this.nombre;
          let apellido=this.apellido;
          let correo=this.correo;
          let password="123456";
          let tiposusuarioId=this.id_tipo_usuario;             
          const obj={nombre,apellido,correo,password,tiposusuarioId};
           axios.post('ApiWeb/Usuario.php/',obj).then(response => {
                       
                //  console.log(response.data.mensaje);
                  var estado =response.data.mensaje;
                  if(estado=="Existe"){
                    this.Existe();
                  }else{
                   this. Confirmacion();
                   this.ListarUsuarios();
                  }
                  
                }).catch(function (error) {
                      console.log(error);
                }) .finally(() => {
                     
              })
         },
         buscar(){
           var correo="jorge@gmail.com";
            axios.get('ApiWeb/Usuario.php/?correo='+correo).then(response => {
                       
                  console.log(response.data);
                  
                }).catch(function (error) {
                      console.log(error);
                }) .finally(() => {
                     
              })
         },
         Existe(){
          Swal.fire({
            title: '<strong>Alerta </strong>',
            icon: 'info',
            html:
              'Este correo ya esta en uso ' ,
          
          })
       }, 
        Guardar(){    
              let newData = firebase.database().ref('Usuario/').push();
              newData.set({                 
                  codigo: this.codigo,
                  nombre: this.nombre,
                  rol:this.rol,
                  fecha: Date(),
                  //key:key
              });
            
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
          ListarUsuarios(){
             this.$emit('Listar-Emit-Usuario');
           },
          CerrarModal(){
              //this.DialogCliente=false            
              this.$emit('CerrarModal');
          }
    }
};
</script>
<style scoped>
  ::v-deep .myDiv {
    background-color: 	#FFFFFF;
  }

</style>

