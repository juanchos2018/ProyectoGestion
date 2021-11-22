<template>
  <b-modal id="modal-cliente" size="lg" v-model="Show" @hide="CerrarModal"
  title="Nuevo Cliente" hide-footer  body-class="myDiv " >

     <form action="">
       <div class="form-row">       
          {{Cliente}}
            <b-form-group id="input-group-3"  label="Tipo Documento" label-for="input-1" class="col-md-4">
                <b-form-select
                id="TipoDocumento" 
                value-field="idCodigo"
                text-field="descripcion"               
                :options="TipoDocumentos"
                v-model="Cliente.TipoDocumentos"
                 :state="EstadoTipoDocumento" 
                required    class="p-2 px-4 btn-xs"  >
                 </b-form-select>
            </b-form-group>

             <b-form-group id="input-group-3" label="Numero Documento:" label-for="NroDocumento" class="col-md-8">
               <b-form inline>
               <b-input 
                  id="NroDocumento" 
                  :state="EstadoNroDocumento"  
                  v-model="Cliente.IdCliente" 
                  aria-describedby="input-live-help input-live-feedback"
                  class="p-2 px-4 btn-xs "
                  v-bind:class="MostrarBoton" >
               </b-input>
                <span v-if="Cliente.TipoDocumentos==='1'" class="col-md-3">
                 <b-button type="button"  class="  btn-xs " variant="primary" > 
                   <b-img left :src="imageReniec" aria-hidden="true" class="m-1"></b-img> <span class="m-1 align-middle">Reniec</span>
                </b-button>
                </span>
                <span  v-if="Cliente.TipoDocumentos==='6'"  class="col-md-3">
                  <b-button type="button"  class="btn-xs " variant="primary" > 
                    <b-img left :src="imageSunat" aria-hidden="true" class="m-1"></b-img> <span class="m-1 align-middle">Sunat</span>
                  </b-button>
                </span>
            </b-form>

                   
              
             </b-form-group>      
          </div>
        <div class="form-row">
            <b-form-group id="input-group-3" label="Nombre:" label-for="input-2" class="col-md-6">
               <b-input class="p-2 px-4 btn-xs"  v-model="Cliente.Nombre"  :state="EstadoNombre" >
               </b-input>
            </b-form-group>
        
            <b-form-group id="input-group-3" label="Nombre Comercial:" label-for="input-NombreComercial" class="col-md-6">
               <b-input class="p-2 px-4 btn-xs"  v-model="Cliente.NombreComercial"   >
               </b-input>
            </b-form-group>
     
              <b-form-group id="input-group-3"  label="Direccion" label-for="input-1" class="col-md-6">
               <b-form-input
                id="Direccion"                
                v-model="Cliente.Direccion"
                required    class="p-2 px-4 btn-xs"  >
                </b-form-input>
            </b-form-group>
            <b-form-group id="input-group-3"  label="Telefono" label-for="input-1" class="col-md-3">
                <b-form-input
                id="Telefono"                
                v-model="Cliente.Telefono"
                required    class="p-2 px-4 btn-xs"  >
                </b-form-input>
                
            </b-form-group>
            <b-form-group id="input-group-3"  label="Telefono" label-for="input-1" class="col-md-3">
                <b-form-input
                id="Fax"                
                v-model="Cliente.Fax"
                required    class="p-2 px-4 btn-xs"  >
                </b-form-input>
                
            </b-form-group>
            <b-form-group id="input-group-3"  label="Coreo Electronico" label-for="input-1" class="col-md-6">
                <b-form-input
                id="Email"            
                v-model="Cliente.Email"
                required    class="p-2 px-4 btn-xs"  >
                </b-form-input>
              </b-form-group> 
             <b-form-group id="input-group-3"  label="Comentario" label-for="input-1" class="col-md-6">
                <b-form-input
                id="Comentario"            
                v-model="Cliente.Comentario"
                required    class="p-2 px-4 btn-xs"  >
                </b-form-input>
              </b-form-group> 

              <b-form-group id="input-group-3"  label="Tipo de Cliente" label-for="input-1" class="col-md-6">
                <b-form-select
                  id="TipoCliente" 
                  value-field="idCodigo"
                  text-field="descripcion"               
                  :options="TipoCliente"
                  v-model="Cliente.TipoCliente"
                   class="p-2 px-4 btn-xs"  >
                  </b-form-select>
              </b-form-group> 

              <b-form-group id="input-group-3"  label="Tipo de Precio" label-for="input-1" class="col-md-6">
                <b-form-select
                  id="TipoPrecio" 
                  value-field="idCodigo"
                  text-field="descripcion"               
                  :options="TipoPrecio"
                  v-model="Cliente.TipoPrecio"
                   class="p-2 px-4 btn-xs"  >
                  </b-form-select>
              </b-form-group> 

             <b-form-group id="input-group-3"  label="Pais" label-for="input-1" class="col-md-3">
                <b-form-select
                id="Pais"     
                v-model="Cliente.Pais"           
                :options="Pais"
                required    class="p-2 px-4 btn-xs"  >
                 </b-form-select>
            </b-form-group>
              <b-form-group id="input-group-3"  label="Departamento" label-for="input-1" class="col-md-3">
                                        
                <b-form-select
                id="Departamento"  
                v-model="Cliente.Departamento"                 
                :options="Departamento"
                required    class="p-2 px-4 btn-xs"  >
                 </b-form-select>
                
            </b-form-group>
              <b-form-group id="input-group-3"  label="Provincia" label-for="input-1" class="col-md-3">
                <b-form-select
                id="Provincia"   
                v-model="Cliente.Provincia"                 
                :options="Provincia"
                required    class="p-2 px-4 btn-xs"  >
                 </b-form-select>
                
            </b-form-group>
             <b-form-group id="input-group-3"  label="Distrito" label-for="input-1" class="col-md-3">
                <b-form-select
                id="Distrito"    
                v-model="Cliente.Distrito"            
                :options="Distrito"
                required    class="p-2 px-4 btn-xs"  >
                </b-form-select>
            </b-form-group>

        </div>
         <hr>
        <div class="float-right" >              
          <b-button type="button"  @click="CerrarModal"  variant="light"  class="p-2 px-4 btn-xs">Cancelar</b-button>
          <b-button type="button" :disabled="EstadoBoton" @click="GuardarCliente" variant="primary"  class="p-2 px-4 btn-xs">
              <beat-loader :loading="isLoading" :color="'#68d391'" :size="8" />
             <span v-show="!isLoading">Guardar</span>
            </b-button>
        </div>
     </form>
  </b-modal>
</template>

<script>
import axios from  'axios';
import reniec from "@/assets/reniec_16x16.png" 
import sunat from "@/assets/sunat_16x16.png" 
 

export default {
    name: 'cliente-nuevo',
    props:{
      DialogCliente: {
        type: Boolean,
        required: true,
        default: false
      },
      
    },
    data() {
        return {
                isLoading:false,
                Show:this.DialogCliente,
                // imagenes
                  imageSunat: sunat,
                  imageReniec:reniec, 
                   // validaciones
                  EstadoNombre:null,
                  EstadoNroDocumento:null,
                  EstadoTipoDocumento:null,
                  EstadoBoton:false,
                  
                  // Lista de Paises 
                  Pais:['Perú'],
                  Departamento:['Tacna'],
                  Provincia:['Tacna'],
                  Distrito:['Tacna'],
                  TipoDocumentos:[],
                  TipoCliente:[],
                  TipoPrecio:[],
                Cliente:{
                  Pais:"Perú",
                  Departamento:"Tacna",
                  Provincia:"Tacna",
                  Distrito:"Tacna",
                  TipoDocumentos: "1",
                  Direccion: "",
                  Telefono: "",
                  Fax: "",
                  Email: "",
                  Nombre:"",
                  NombreComecial:"",
                  IdCliente:"",
                  NombreComercial:"",
                  Comentario:"",
                  TipoPrecio:"",
                  TipoCliente:"",
                },
        }
    },
    watch: {
      DialogCliente(){
        this.Show = this.DialogCliente
      }
    },
     created () {
          this.GetTipoDocumentos();
          this.GetTipoCliente();
          this.GetTipoPrecio();
    },
    computed: {
     
        MostrarBoton: function() {
          if(this.Cliente.TipoDocumentos==='1' || this.Cliente.TipoDocumentos==='6')
          { return 'col-md-9'; }
          else{ return 'col-md-12'; }
       },
    },
    methods: {

       ValidarForm(){
         var estado = true;
         if(this.Cliente.IdCliente.length<8){ this.EstadoNroDocumento=estado=false; } else { this.EstadoNroDocumento=true;  }
         if(this.Cliente.Nombre.length<=3){ this.EstadoNombre=estado=false; } else { this.EstadoNombre=true; } 
         return estado;
       },

        GuardarCliente(){
              if(this.ValidarForm()){
                  let me = this;
                  this.isLoading = true;
                  this.EstadoBoton = true
                  axios({
                      method: 'post',
                      url: 'Cliente/SetCliente',
                      data:me.Cliente,
                  })
                  .then(response => {
                      
                      if(response.data.estado=="ERROR"){
                        this.makeToast(response.data.mensaje,'warning');
                      }else{
                        this.makeToast(response.data.mensaje,'success');
                      }
                  }).catch(function (error) {
                      console.log(error);
                  }) .finally(() => {
                      this.isLoading = false;
                      this.EstadoBoton = false;
                  })
              }

          },
          ListaTipoDocumento(){
               let me = this;
                  axios({
                      method: 'post',
                      url: 'TipoDocumento',
                      data: { }
                  })
                  .then(response => {
                      //console.log(response);
                      me.TipoDocumentos = response.data.data;
                  }).catch(function (error) {
                      console.log(error);
                  });
          },
         makeToast(msg,color) {
            this.toastCount++
            this.$bvToast.toast(msg, {
              title: 'Mensaje Cliente',
              variant:color,
              autoHideDelay: 3000,
              appendToast: false
            })
          },
          GetTipoDocumentos(){
                  let me = this;
                  axios({
                      method: 'post',
                      url: 'TipoDocumentoSunat/GetLista',
                      data: {
                          Buscar1:"",
                          Pagina:1,
                          TamanoPagina:50
                      }
                  })
                  .then(response => {
                      //console.log(response.data);
                      me.TipoDocumentos = response.data;
                  }).catch(function (error) {
                      console.log(error); 
                  });
          },
          GetTipoCliente(){
                  let me = this;
                  axios({
                      method: 'post',
                      url: 'TipoCliente/GetLista',
                  })
                  .then(response => {
                      //console.log(response.data);
                      me.TipoCliente  = response.data;
                  }).catch(function (error) {
                      console.log(error); 
                  });
          },
           GetTipoPrecio(){
                  let me = this;
                  axios({
                      method: 'post',
                      url: 'TipoPrecio/GetLista',
                  })
                  .then(response => {
                      //console.log(response.data);
                      me.TipoPrecio  = response.data;
                  }).catch(function (error) {
                      console.log(error); 
                  });
          },
          CerrarModal(){
              //this.DialogCliente=false
              //this.Show
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

