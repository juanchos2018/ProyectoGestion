<template>
    <div>
        <div class="row">
         <div class="col-5" v-for="item in fasesproyecto" :key="item.key"> 
             
         <Widget class="h-100 mb-6"  title="<h5> <span class='fw-semi-bold'> </span></h5>"  close collapse customHeader>
         <h5>{{item.nombre_fase}}</h5>
               <apexchart type="bar" height="350" :options="fasesproyecto[item.index].chartOptions" :series="fasesproyecto[item.index].series"></apexchart>
         </Widget>   
         <br>   
        </div>
        <br>
        </div>       
    </div>
</template>
<script>

import VueApexCharts from 'vue-apexcharts'
import axios from  'axios';

export default {
    name: '',
    components: {
          apexchart: VueApexCharts,
        },
     data(){
         return{
            fasesproyecto:[], 
            tareafases:[],
            id_proyecto:'',
            varaa:'',

         }
     },
     created () {

     },
     mounted() {
      this.GetDatos();
     
    },
     methods:{
        GetDatos(){
           var id = this.$route.params.id_proyecto
          if(id){         
            this.id_proyecto=id;
            this.ListaTareaFases(id); 
            this.ListaFasesProyecto(id);        
          
          }  
        },
         ListaTareaFases(id){
              let me=this;
              axios.get('ApiWeb/Consulta.php/?id='+id).then(response => {              
                  me.tareafases = response.data;  
               }).catch(function (error) {
                      console.log(error);  
              }) .finally(() => {
           })
         },
         ListaFasesProyecto(id){
          let me=this;
          axios.get('ApiWeb/Proyecto.php/?id_proyecto='+id).then(response => {              
                  me.fasesproyecto = response.data;  
                  var lista =[];
                //  me.listagrafico.fases=response.data; 
                  for(var i=0;i< me.fasesproyecto.length ;i++){
                            for  (var e=0;e< me.tareafases.length ;e++){
                                if(me.fasesproyecto[i].nombre_fase==me.tareafases[e].nombre){                                      
                                      me.fasesproyecto[i].chartOptions.xaxis.categories.push(me.tareafases[e].estado)                       
                                      me.fasesproyecto[i].series[0].data.push(parseInt( me.tareafases[e].cantidad))
                                   } else{
                                        console.log("no hay igual")
                             }

                       }                    
                  }                         
               }).catch(function (error) {
                      console.log(error);  
              }) .finally(() => {
           })
         },        
     
     }

}
</script>