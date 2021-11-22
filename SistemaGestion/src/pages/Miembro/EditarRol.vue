<template>
  <b-modal  v-model="Show" @hide="CerrarModal"
  title="Editar" hide-footer   body-class="myDiv">
     <form action="">
       <div class="form-row">                 
               <b-form-group  label="Nombre Miembro:"  class="col-md-12">
               <b-input                  
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
                  disabled
                  v-model="nombre" >
               </b-input>
             </b-form-group>                
          </div>
          <div class="form-row"> 
              <b-form-group  label="Nombre Rol:"  class="col-md-12">
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
          <b-button type="button"  variant="primary"  @click="ModificarRol" class="p-2 px-4 btn-xs">
              <beat-loader :loading="isLoading" :color="'#68d391'" :size="8" />
             <span v-show="!isLoading">Guardar Cambios</span>
            </b-button>
        </div>
     </form>    
  </b-modal>
</template>

<script>

import axios from  'axios';
export default {
    name: 'editar-rol',
    props:{
      DialogoModificar: {       
        type: Boolean,
        required: true,
        default: false
      },id: [String, String],nombre: [String, String]
      
    },
    data() {
        return {
          contador:0,
          CodeMetodologia:'M',
          codigo:'',
                   
          isLoading:false,          
          Show:this.DialogoModificar,
          roles:[],
          id_rol:'',   
             
        }
    },
    watch: {
      DialogoModificar(){
        this.Show = this.DialogoModificar
      }
    },
    created () {    
          this.ListarRoles();
    },
    computed: {
     
    },
    methods: {
       ListarRoles(){
                  let me=this;
                  var elementos=[];
                  axios.get('ApiWeb/Rol.php/',).then(function(response){                      
                  elementos=response.data.data;   
                  console.log(response.data)
                  elementos.map(function(x){
                    //    me.roles.push({text: x.nombre,value:x.id_rol});
                      if (x.nombre!="Jefe de Proyecto"){
                         me.roles.push({text: x.nombre,value:x.id_rol});
                       } 
                 });  
              }).catch(function(error){
                  console.log(error);
           });       
       },  
      ModificarRol(){    
          let rolId=this.id_rol;       
          let id=this.id;                 
          const obj={rolId,id};
          axios.put('ApiWeb/Miembro.php/',obj).then(response => {                       
              console.log(response);
              //  this.ListarElemetos();
               this.Confirmacion();
          }).catch(function (error) {
              console.log(error);
          }) .finally(() => {              
         })
      },   
      CerrarModal(){              
           this.$emit('CerrarModal');
      },     
      Confirmacion(){
          this.$swal({
              position: 'top-end',
              icon: 'success',
              title: 'Modificado',
              text:'se ha modificado con exito',
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

