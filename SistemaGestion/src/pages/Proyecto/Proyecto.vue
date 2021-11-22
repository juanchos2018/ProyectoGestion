<template>
    <div>
       <div>      
          <div style="width: 200px;  display: inline-block;">
            <label for="">Buscar</label> 
            <b-form-input
                id="input-30" 
                autocomplete=off
                require
                class="p-2 px-4 btn-xs"               
                v-model="search"  >
          </b-form-input> 
         </div> 
          <br>    
          <br>       
        </div>
       <div class="row" >          
        <div class="col-4" v-for="item in filteredList" :key="item.key">
        <b-card  border-variant="primary" >
            <b-dropdown no-caret  variant="#FFFFF" style="float:right;font-weight: 400" right >      
                 <template slot="button-content">
                    <i class="py-0 fa fa-cog"></i>
                  
                </template>      
                    <b-dropdown-item @click="AbrirDialogo(item.id_proyecto)">Nuevo Miembro</b-dropdown-item>
                    <b-dropdown-item @click="Miembros(item.id_proyecto)">Miembros</b-dropdown-item>                   
                    <!-- <b-dropdown-item >Editar</b-dropdown-item>      -->
                </b-dropdown>             
            <b-card-title>{{item.nombre_proyecto}}</b-card-title>  
            <br>    
            <b-card-text>
                Fecha Inicio :  {{item.fecha_inicio}} <br>
                Fecha Termino:  {{item.fecha_termino}}<br>
                Estado:  <span class="badge badge-success">{{item.estado}}</span>  <br>
                 <br>
                <div class="row"  style="margin-left:4px;margin-top:2px" >
                    <br>
                  <div  style=" display: flex;" v-for="item in filteredList[item.index].listaMiembro" :key="item.key"> 
                    <b-avatar :variant="item.color" :text="item.inicial"  v-b-tooltip.hover :title="item.nombre" style="margin-left:3px" ></b-avatar>
                   
                 </div>
                 </div>    
                  <b-button type="button"  style="float:right" variant="primary"  @click="Detalle(item.id_proyecto)" class="p-2 px-4 btn-xs">
                        Detalle
                    <b-icon icon="forward"></b-icon>
                     </b-button>           
            </b-card-text>       
          <!--  
              chevron-double-right
               <b-card-text class="small text-muted">Ultima Actualizacion hace 3 min</b-card-text>-->
            </b-card>
            <br>
            </div>
        </div>
  
        <miembro-nuevo @CerrarModal="CerrarModal"   v-bind:id_proyecto="id_proyecto" :DialogMiembro="DialogMiembro" v-bind:id_usuario_jefe="idusuario" v-on:Listar-Proyecto-Emit="ListarPoryectosUsuario" > </miembro-nuevo>

    </div>
</template>
<script>

import axios from  'axios';
import MiembroNuevo from '@/pages/Miembro/MiembroNuevo';
export default {
    components: { MiembroNuevo },
    data(){
        return{
             colores:['primary','success','info','warning','dark','secondary'],
              mycolor: '#'+(Math.random()*0xFFFFFF<<0).toString(16),
              DialogMiembro:false,
              listaMiembros:[],             
              selectedImage: '',
              idtipousuario:'',
              id_proyecto:'',                                  
              search: '',
              idusuario:'',
              items:[],  
              
        }
    },
    created(){
      
    },
     computed: {
      filteredList() {
        return this.items.filter(post => {
          return post.nombre_proyecto.toLowerCase().includes(this.search.toLowerCase())
        })
      }
    },
    mounted() {
      if(localStorage.idtipo) this.idtipousuario = localStorage.idtipo;
      if(localStorage.idtipo) this.idusuario = localStorage.id_usuario;
       this.ListarPoryectosUsuario(this.idusuario);   
    },
    methods:{
        Nuevo(){
             this.$router.push('/app/proyectonuevo');
        },
        Detalle(id_proyecto){           
             this.$router.push({name:"proyectodetalle",params:{id_proyecto} });            
        },
        Miembros(id_proyecto){           
             this.$router.push({name:"proyectomiembro",params:{id_proyecto} });
        },
        AbrirDialogo(id){
             this.DialogMiembro=true,
             this.id_proyecto=id;
        },               
        ListarPoryectosUsuario(idtipousuario){
              let me=this;            
              axios.get('ApiWeb/Usuario.php/?usuario_miembroid='+idtipousuario).then(response => {                    
                       me.items = response.data;  
                        me.LisrarMiembrosProyecto();               
                  }).catch(function (error) {
                      console.log(error);
                 }) .finally(() => {                     
            })
        },
        LisrarMiembrosProyecto(){           
              let me=this;              
              axios.get('ApiWeb/Miembro.php/').then(response => {                    
                      me.listaMiembros = response.data;                         
                        for(var i=0;i< me.items.length ;i++){
                            for  (var e=0;e< me.listaMiembros.length ;e++){
                                if(me.items[i].id_proyecto==me.listaMiembros[e].id_proyecto){   
                                    var color='';
                                    var idx = Math.floor(Math.random() * this.colores.length);
                                        color= this.colores[idx];
                                      me.items[i].listaMiembro.push({ nombre: me.listaMiembros[e].nombre,inicial:me.listaMiembros[e].inicial,color:color})
                                    
                                   } 
                               }                    
                           } 
                  }).catch(function (error) {
                      console.log(error);
                }) .finally(() => {                     
            })
        },
       CerrarModal() {
           this.DialogMiembro = false;  
       },
    }
}
</script>

<style src="./proyecto.scss" lang="scss" scoped />
