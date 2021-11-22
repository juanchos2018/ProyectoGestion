<template>
    <div>
      <h5>Nuevo Proyecto</h5>
        <div class="form-row">
          <b-form-group    class="col-md-6">
               <label class="control-label font-weight-bold text-info">Nombre Proyecto</label> 
               <div class="el-select border-left rounded-left border-info el-select">               
             <b-form-input
                id="input-30" 
                require
                class="p-2 px-4 btn-xs"
                v-model="nombre_proyecto"
                :state="nombre_proyecto.length >= 10"  >
                </b-form-input>                  
             </div>
            </b-form-group>
       <b-form-group  label="Fecha Inicio"   class="col-md-6">
        <b-form-input
          id="input-7"
          type="date"
          class="p-2 px-4 btn-xs" 
          required          
         v-model="fecha_inicio" ></b-form-input>
      </b-form-group>
    </div>
     <div class="form-row">       
    <b-form-group  label="descripcion"   class="col-md-6">
      <b-form-textarea
          id="textarea-state"
          v-model="descripcion"
          
          :state="descripcion.length >= 10"
          placeholder="Enter at least 10 characters"
          rows="3"
        ></b-form-textarea>
     </b-form-group>
        <b-form-group  label="Fecha Finalizacion"   class="col-md-6">
        <b-form-input
          id="input-7"
          type="date"
          class="p-2 px-4 btn-xs" 
          required          
        v-model="fecha_fin"></b-form-input>
      </b-form-group>
    </div>

     <h5>Datos de la Metodologia</h5><br>
    <div class="form-row">    
       <b-form-group   label="Metodologia :" class="col-md-6">           
          <a-select  style="width: 100%"   @change="handleChange"  v-model="metodologiaId" >              
         <a-select-option v-for="d in metodologias" :key="d.value">
                  {{ d.text }}
          </a-select-option>
        </a-select>   
       </b-form-group>       
    </div>
    <b-form-tags v-model="seleccionados" no-outer-focus class="mb-2"   >
      <template v-slot="{ tags }">       
        <ul
          id="my-custom-tags-list"
          class="list-unstyled d-inline-flex flex-wrap mb-0"
          aria-live="polite"
          aria-atomic="false"
          aria-relevant="additions removals"
        >         
          <b-card
            v-for="tag in tags"
            :key="tag"            
            :id="`my-custom-tags-tag_${tag.replace(/\s/g, '_')}_`"
            tag="li"
            class="mt-1 mr-1"
            bg-variant="primary"
            body-class="py-1 pr-2 text-nowrap"
          >
         <h5 style="color:white" >  {{ tag }}  </h5>           
          </b-card>
        </ul>
      </template>
    </b-form-tags>
    
    <div class="form-row">
      <div class="col-md-12">       
      <b-card no-body>
      <b-tabs card  justified   active-nav-item-class="font-weight-bold text-uppercase text-success">        
        <b-tab v-for="item in fases" :key="item.title" :title="item.title" v-model="tabIndex" >
       <h5>Elementos de configuración</h5>
           <b-table striped hover :items="fases[item.index].tabla" :fields="fields2"  >
              <template  v-slot:cell(acciones)="row">
                <div style="display: flex;">
                  <b-form-checkbox    @change="onPreviewClick(row.index,row.item.id,row.item.NombreElemento,item.id_fase)"            
                ></b-form-checkbox>
                <strong>{{row.item.NombreElemento }}  </strong>  
                </div>
               
              </template>
            </b-table>
        </b-tab>   
        <template #empty>
          <div class="text-center text-muted">
           Lista   Vacia                                                                                                                                                                                            
          </div>
        </template>
      </b-tabs>
    </b-card>  
      </div>      
    </div>      
     <b-button type="button"  @click="RegistrarProyecto" variant="primary"  class="p-2 px-4 btn-xs">
         Crear Proyecto
      </b-button>  
    </div>
</template>
<script>
import axios from  'axios';
import firebase from '@/firebase'
export default {
//el usuaariio jefe tiene que llenarse cuando haga login
    data(){
        return{
           idseleccionadosfases:[],
           Listacronogramafase:[],
           plantillaelemento:[],
           TodasPlantillas:[],
           idseleccionados:[],
           listaElementos:[],
           seleccionados:[],           
           metodologias:[],
           listaenviar:[],
           listaFases:[],
           selected:[],
           fases:[],  
           elementos:{nombre:''},
           nombre_proyecto:'',
           metodologiaId:'', 
           fecha_inicio:'',          
           usuariojefeId:'', 
           descripcion:'', 
           metodologia:'',
           tabCounter: 0,
           fecha_fin:'',
           tabIndex: 0,
           codigo:'',        
           step1: '',
           step2: '',
           cStep: 1,  
           current: 0,           
           fields: [
                   { label:"Acciones", key: 'acciones', sortable: false },
                   { label:"elegir", key: 'elegir', sortable: false } 
             ],
            fields2: [
                  { label:"Acciones", key: 'acciones', sortable: false },
             ],
           tabs: [],        
       
        }
    },
   
    created(){
      this.ListarMetodologias();
      this.ListarTodasPlantillas();
     
    },
    mounted() {    
      if(localStorage.idtipo) this.usuariojefeId = localStorage.id_usuario;          
     },
    methods:{      
       newTab() {
        this.tabs.push(this.tabCounter++)
        },   
        RegistrarProyecto(){  
          this.listaElementos=[];         
         for(var i =0;i<this.seleccionados.length ;i++){           
             this.listaElementos.push({id:this.idseleccionados[i],nombre:this.seleccionados[i],id_fase:this.idseleccionadosfases[i]});
          }
          let codigo=this.codigo;
          let nombre=this.nombre_proyecto;
          let fechaini=this.fecha_inicio;
          let fechater=this.fecha_fin;
          let descripcion=this.descripcion;
          let usuariojefeId=this.usuariojefeId;
          let estado="activo";
          let metodologia=this.metodologiaId;  
          var lista=this.listaFases;
          var cantidad=lista.length;
          var porcentaje=100/parseInt(cantidad); 
          var ListaElementos=this.listaElementos;
          const obj={codigo,nombre,fechaini,fechater,descripcion,estado,metodologia,usuariojefeId,lista,ListaElementos,porcentaje};
        
         console.log("envair bd");
              console.log( obj);
       axios.post('ApiWeb/Proyecto.php/',obj).then(response => {       
                           console.log("arrauy")                
                  console.log(response)
                  this.Listacronogramafase=response.data;
                  this. Confirmacion();
                  this.AgregarCronogramaElemento();
                }).catch(function (error) {
                      console.log(error);
                }) .finally(() => {                     
              })
          },
          handleChange(value) {      
              this.MostarFaseMetodolgia(value);
          },
          AgregarCronogramaElemento(){
               var lista=[];        
               for(var i =0;i<this.seleccionados.length ;i++){            
                  lista.push({id:this.idseleccionados[i],nombre:this.seleccionados[i],id_fase:this.idseleccionadosfases[i]});
               }
               for(var i =0;i<lista.length ;i++){     
                 for (var e =0;e<this.Listacronogramafase.length;e++){
                   if(lista[i].id_fase==this.Listacronogramafase[e].id_fase){
                      this.listaenviar.push({id:lista[i].id,nombre:lista[i].nombre,id_fase:this.Listacronogramafase[e].id_fase,id_cronograma_fase:this.Listacronogramafase[e].id_cronograma_fase});
                   }
                 }
               }
              var listacronogramaelemento=this.listaenviar;
           
              const obj={listacronogramaelemento}
              axios.post('ApiWeb/CronogramaElemento.php/',obj).then(response => {  
                  this.Limpiar();
                }).catch(function (error) {
                      console.log(error);
                }) .finally(() => {                     
             });
          },
          ListarMetodologias(){
                  let me=this;
                  var tipoDcumento=[];
                  axios.get('ApiWeb/Metodologia.php/').then(response => {    
                                              
                    tipoDcumento=response.data.data; 
                    tipoDcumento.map(function(x){
                     me.metodologias.push({text: x.nombre,value:x.id_metodologia});
                   });  
              }).catch(function(error){
                  console.log(error);
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
          MostarFaseMetodolgia(id){
                let me=this;
                me.Limpiar();
                axios.get('ApiWeb/Metodologia.php/?id_meto='+id).then(response => {              
                    me.fases = response.data;                  
                    me.listaFases=[];                 
                    response.data.forEach(item=>{
                        me.listaFases.push({nombre: item.nombre_fase,id_fase:item.id_fase});   
                      });               
                      for(var i=0;i< me.fases.length ;i++){
                          for  (var e=0;e< me.TodasPlantillas.length ;e++){
                              if(me.fases[i].id_fase==me.TodasPlantillas[e].faseId){   
                                  me.fases[i].tabla.push({ NombreElemento:me.TodasPlantillas[e].nombre,id:me.TodasPlantillas[e].id_elemento,id_fase: me.fases[i].id_fase})
                              } 
                          }                    
                        }  
                      }).catch(function (error) {
                          console.log("ERrro");
                          console.log(error);
                  }) .finally(() => {
              })
          },
          onChange(current) {            
              this.current = current;
              var code =this.fases[current].id_fase;          
             
              this.ListarElemtosFase(code);
          },
          ListarElemtosFase(id_fase){
              let me=this;
              axios.get('ApiWeb/PlantillaElemento.php/?faseId='+id_fase).then(response => {                 
                    me.plantillaelemento = response.data;     
                             
                  }).catch(function (error) {
                          console.log(error);
                  }) .finally(() => {
              })
          }, 
          ListarTodasPlantillas(){
                  let me=this;                 
                  axios.get('ApiWeb/PlantillaElemento.php/',).then(function(response){                      
                  me.TodasPlantillas=response.data;    
                
              }).catch(function(error){
                  console.log(error);
              });
          },
           onPreviewClick(data, id, nombre,id_fase) {          
               var existe=null;            
                if(this.Verificar(id,nombre)){                
                  this.Quitar(id,nombre,id_fase);                  
                }else{                
                  this.agregar(id,nombre,id_fase);   
                }        
            },
            Verificar(id,nombre){           
               for(var i =0;i< this.seleccionados.length;i++){
                 if (this.seleccionados[i]==nombre){
                    return true;  
                 }
               }  
              return false;
            },
            agregar(id,nombre,id_fase){
                  this.seleccionados.push(nombre);
                  this.idseleccionados.push(id);
                  this.idseleccionadosfases.push(id_fase);               
            },
            Quitar(id,nombre,id_fase){             
               this.seleccionados.splice(this.seleccionados.indexOf(nombre), 1);
               this.idseleccionados.splice(this.idseleccionados.indexOf(id), 1);
               this.idseleccionadosfases.splice(this.idseleccionadosfases.indexOf(id_fase),1);              
            },
            Limpiar(){
              this.seleccionados=[];
              this.idseleccionados=[];
              this.idseleccionadosfases=[];
              this.listaenviar=[];
            }
    }
}
</script>