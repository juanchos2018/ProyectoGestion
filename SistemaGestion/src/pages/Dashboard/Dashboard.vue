<template>
  <div>
    <div>
      <Widget
        title="<h5> <span class='fw-semi-bold'> Proyectos</span></h5>"
        close
        collapse
        customHeader
      >
        <VueApexCharts
          type="bar"
          height="350"
          :options="grafico1.chartOptions"
          :series="grafico1.series"
        ></VueApexCharts>
      </Widget>
    </div>
    <div class="row">
      <!-- <p>{{agrupados}}</p> -->
      <div class="col-5" v-for="item in agrupados" :key="item.key">
        <Widget
          class="h-100 mb-6"
          title="<h5> <span class='fw-semi-bold'> </span></h5>"
          close
          collapse
          customHeader
        >
          <h5>{{ item.nombre_proyecto }}</h5>

          <VueApexCharts
            width="350"
            type="donut"
            :options="agrupados[item.index].charOptions"
            :series="agrupados[item.index].series"
            @dataPointSelection="dataPointSelectionHandler"
            @click="Detalle(item.id_proyecto, item.index)"
          ></VueApexCharts>

          <!-- <b-button
            type="button"
            style="float:right"
            variant="primary"
            @click="DetalleGrafico(item.id_proyecto)"
            class="p-2 px-4 btn-xs"
          >
            Detalle
            <b-icon icon="forward"></b-icon>
          </b-button> -->
        </Widget>
      </div>
    </div>

    <b-modal
      v-model="DialogoDetalle"
      hide-footer
      title="Tareas Proyecto"
      body-class="myDiv"
    >
      <div>
        <b-table :items="listaTareas" :fields="fields" stacked="sm"> </b-table>
      </div>
    </b-modal>
  </div>
</template>

<script>
import Widget from "@/components/Widget/Widget";
import moment from "moment";
import axios from "axios";
import VueApexCharts from "vue-apexcharts";

export default {
  name: "Dashboard",
  components: { Widget, VueApexCharts },
  props: ["items"],

  data() {
    return {
      fields: [
        { label: "Fase", key: "nombre", sortable: false },
        { label: "Descripcion", key: "descripcion", sortable: false },
        { label: "Estado", key: "estado", sortable: false },
      ],
      DialogoDetalle: false,
      indexproyecto: "",
      ArrayOptions: [],
      listaTareas: [],
      agrupados2: [],
      agrupados: [],
      proyectos: [],
      estadotarea: "",
      idpro: "",
      grafico1: {},

      series: [
        {
          name: "Porcentaje",
          data: [12, 18],
        },
      ],
      chartOptions: {
        chart: {
          height: 350,
          type: "bar",
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            columnWidth: "50%",
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          width: 2,
        },
        grid: {
          row: {
            colors: ["#fff", "#f2f2f2"],
          },
        },
        xaxis: {
          labels: {
            rotate: -45,
          },
          categories: ["proe1", "pee"],
        },
        fill: {
          type: "gradient",
          gradient: {
            shade: "light",
            type: "horizontal",
            shadeIntensity: 0.25,
            gradientToColors: undefined,
            inverseColors: true,
            opacityFrom: 0.85,
            opacityTo: 0.85,
            stops: [50, 0, 100],
          },
        },
      },
    };
  },
  created() {
    this.Lista();
    this.ListarListaTareas();
    this.ListaDeProyectos2();

    //  this.series[0].data.push(10);
    //  this.series[0].data.push(20);
    //   this.chartOptions.xaxis.categories.push("proyecto ");
    //   this.chartOptions.xaxis.categories.push("prerroo");
    //  this.ListaDeProyectos();
  },
  methods: {
    Lista() {
      let me = this;
      let tipo = "grafico1";
      axios
        .get("ApiWeb/Graficos.php?tipo=" + tipo)
        .then((response) => {
          console.log(response);
          me.grafico1 = response.data;
          // response.data.forEach(item=>{
          //       this.series[0].data.push(parseInt(item.porcentaje));
          //       this.chartOptions.xaxis.categories.push(item.nombre_proyecto);
          //         console.log("entra")
          // })
        })
        .catch(function(error) {
          console.log(error);
        })
        .finally(() => {});
    },
    ListarListaTareas() {
      let me = this;
      axios
        .get("ApiWeb/Consulta.php/")
        .then((response) => {
          me.ArrayOptions = response.data.data;
        })
        .catch(function(error) {
          console.log(error);
        })
        .finally(() => {});
    },
    ListaDeProyectos() {
      let me = this;
      axios
        .get("ApiWeb/Proyecto.php/")
        .then((response) => {
          me.agrupados = response.data;
          for (var i = 0; i < me.ArrayOptions.length; i++) {
            for (var e = 0; e < me.agrupados.length; e++) {
              if (
                me.ArrayOptions[i].id_proyecto == me.agrupados[e].id_proyecto
              ) {
                me.agrupados[e].series.push(
                  parseInt(me.ArrayOptions[i].cantidad)
                );
                me.agrupados[e].charOptions.labels.push(
                  me.ArrayOptions[i].estado_tarea
                );
              }
            }
          }
        })
        .catch(function(error) {
          console.log(error);
        })
        .finally(() => {});
    },
    ListaDeProyectos2() {
      let me = this;
      axios
        .get("ApiWeb/Proyecto.php/")
        .then((response) => {
          me.agrupados = response.data;
          //      console.log(response.data);
          for (var i = 0; i < me.ArrayOptions.length; i++) {
            for (var e = 0; e < me.agrupados.length; e++) {
              if (
                me.ArrayOptions[i].id_proyecto == me.agrupados[e].id_proyecto
              ) {
                me.agrupados[e].series.push(
                  parseInt(me.ArrayOptions[i].cantidad)
                );
                me.agrupados[e].charOptions.labels.push(
                  me.ArrayOptions[i].estado_tarea
                );

                //   me.series[0].data.push(parseInt(me.agrupados[e].porcentaje));
                //  me.chartOptions.xaxis.categories.push(me.agrupados[e].nombre_proyecto);
              }
            }
          }
          for (let index = 0; index < me.agrupados.length; index++) {
            if (me.agrupados[index].series.length == 0) {
              me.agrupados.splice(index, 1);
            }
          }

          for (let index = 1; index < 3; index++) {
            // me.series[0].data.push(index*3);
            //     me.chartOptions.xaxis.categories.push("proyecto "+index);
          }
        })
        .catch(function(error) {
          console.log(error);
        })
        .finally(() => {});
    },
    Detalle(id_proyecto, index) {
      this.indexproyecto = id_proyecto;
    },
    datos(nombreEstado) {
      this.estadotarea = nombreEstado;
      this.idpro = this.indexproyecto;
      this.ListarTareasFase(this.idpro, nombreEstado);
      this.DialogoDetalle = true;
    },
    dataPointSelectionHandler(e, chartContext, config) {
      var nombreEstado = config.w.config.labels[config.dataPointIndex];
      setTimeout(() => {
        this.datos(nombreEstado);
      }, 3);
    },
    DetalleDialogo() {
      this.DialogoDetalle = true;
    },
    DetalleGrafico(id_proyecto) {
      this.$router.push({ name: "detallegrafico", params: { id_proyecto } });
    },
    ListarTareasFase(idpro, esta) {
      let id_proyecto = idpro;
      let estado = esta;
      const obj = { id_proyecto, estado };
      axios
        .post("ApiWeb/Consulta.php/", obj)
        .then((response) => {
          //     console.log(response.data);
          this.listaTareas = response.data.data;
        })
        .catch(function(error) {
          console.log(error);
        })
        .finally(() => {});
    },
  },
};
</script>
<style scoped>
::v-deep .myDiv {
  background-color: #ffffff;
}
</style>
