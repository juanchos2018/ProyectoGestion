<template>
  <div class="bg-light">
    <b-card border-variant="primary">
      <div class="container">

        <div class="form-row">
          <b-form-group class="col-md-4">
            <h4>{{ nombreProyecto}}</h4>
            <span class="badge badge-success">{{estado}}</span>
          </b-form-group>
          <b-form-group class="col-md-8">
            <a-progress :percent="parseInt(TotalProcentajeProyecto)" status="active" />
          </b-form-group>
        </div>
        <div class="form-row">
          <b-form-group class="col-md-12">
            <p>{{descripcion}}</p>
          </b-form-group>
        </div>
        <div class="form-row">
          <b-form-group class="col-md-4">
            <label class="control-label font-weight-bold text-info">Fecha Inicio</label>
            <div class="">
              <label for="">{{ fecha_inicio}}</label>
            </div>
          </b-form-group>
          <b-form-group class="col-md-4">
            <label class="control-label font-weight-bold text-info">Fecha Termino</label>
            <div class="">
              <label for="">{{ fecha_termino}}</label>
            </div>
          </b-form-group>
        </div>
      </div>
    </b-card>
    <br>
    <div class="form-row">
      <b-form-group class="col-md-4">
        <Widget class="h-100 mb-6">
          <div style="display: flex;">
            <div>
              <div style="font-size: 4rem;">
                <b-icon icon="card-list" animation="fade" font-scale="1"></b-icon>
              </div>
            </div>
            <div style="margin-top:20px;margin-left:5%">
              <h5>Nuevo</h5>
              <h5>{{TareaNuevas}}</h5>
            </div>
          </div>
        </Widget>
      </b-form-group>
      <b-form-group class="col-md-4">
        <Widget class="h-100 mb-6">
          <div style="display: flex;">
            <div>
              <div style="font-size: 4rem;">
                <b-icon icon="hourglass-split" animation="fade" font-scale="1"></b-icon>
              </div>
            </div>
            <div style="margin-top:20px;margin-left:5%">
              <h5>Progreso</h5>
              <h5>{{TareaProceso}}</h5>
            </div>
          </div>
        </Widget>
      </b-form-group>
      <b-form-group class="col-md-4">
        <Widget class="h-100 mb-6">
          <div style="display: flex;">
            <div>
              <div style="font-size: 4rem;">
                <b-icon icon="shield-fill-check" animation="fade" font-scale="1"></b-icon>
              </div>
            </div>
            <div style="margin-top:20px;margin-left:5%">
              <h5>Terminado</h5>
              <h5>{{TareaTerminada}}</h5>

            </div>
          </div>
        </Widget>
      </b-form-group>
      {{rangoAnterior}}
    </div>

    <div>
      <b-card header="Primary" header-text-variant="white" header-bg-variant="primary" header-tag="header" footer-tag="footer">
        <template #header>
          <h4 class="mb-0" style="color:#FFFFFF">Metodologia : {{metodologia}}</h4>
        </template>
        <a-steps :current="current" @change="onChange" :style="stepStyle" type="navigation">

          <a-step v-for="item in fases" :key="item.title" :title="item.title" />
          <br>
        </a-steps>
        <div class="row">
          <div class="col-3" v-for="item in fases" :key="item.key">
            <div>
              <a-progress :percent="parseInt(item.porcentaje_avance)" status="active" />
            </div>
            <div>
              <a-button type="primary" @click="DialogoRango(item.porcentaje_avance,item.id_cronograma_fase,item.porcentaje)">
                Editar
              </a-button>
            </div>
          </div>
        </div>
        <hr>
        <div>
          <!--   <div style="width:25%">
         <a-progress :percent="50" status="active" />
      </div> {{ steps[current].content  sub-title="00:00:05"  }}   <b-icon icon="caret-right"> </b-icon>   <div class="col-4" v-for="item in items" :key="item.key"> -->
          <b-table :items="elementosConfi" sort-icon-left :fields="fields" responsive="sm" v-model="currentItems" show-empty>
            <template v-slot:cell(nombre_elemento)="{ detailsShowing, item }">
              <b-button variant="outline-primary" style="margin-right:10px" @click="toggleDetails(item)">
                <div v-if="detailsShowing">
                  <b-icon icon="chevron-down"> </b-icon>
                </div>
                <div v-else>
                  <b-icon icon="chevron-right"> </b-icon>
                </div>
              </b-button>
              <strong>{{item.nombre_elemento }} -{{item.id_cronograma_elemento }} </strong>
            </template>
            <template v-slot:row-details="">
              <a-list item-layout="horizontal" :data-source="listaversiones">
                <a-list-item slot="renderItem" slot-scope="item">
                  <a-card style="width: 100%" border-variant="primary">
                    <div style="float:right">
                      <b-button class="m-1 p-2 px-4 btn-xs float-right" variant="primary" @click="Tarea(item.id_version,item.miembroresponsableID)"> Seleccionar </b-button>
                    </div>
                    <div style="  display: flex;align-items: center;">
                      <b-icon icon="play-fill"></b-icon>
                      <h5 style="margin-left:5px">Version {{ item.version }}</h5>
                      <h5 style="margin-left:20px">{{ item.nombre }}</h5>
                    </div>
                  </a-card>
                </a-list-item>
              </a-list>
            </template>
            <template v-slot:cell(version)="data">
              <div v-if="esJefe">
                <b-button type="button" class="m-1 p-2 px-4 btn-xs float-right" @click="NuevaVersion(data.item.id_cronograma_elemento,data.item.nombre_elemento)" variant="primary">
                  <i class="fa fa-plus-circle"></i> Agregar Version
                </b-button>
              </div>

            </template>

            <template v-slot: empty="scope">
              <h4> Lista Vacia </h4>
            </template>
            <template v-slot: emptyfiltered="scope">
              <h4> No hay Nada</h4>
            </template>
          </b-table>

        </div>
      </b-card>
    </div>
    <b-modal v-model="DialogoElementoVersion" @hide="CerrarModal" title="Agregar Version" hide-footer body-class="myDiv">
      <form action="">
        <div class="form-row">
          <b-form-group label="Fase:" class="col-md-12">
            <b-input aria-describedby="input-live-help input-live-feedback" class="p-2 px-4 btn-xs " v-model="nombre_fase">
            </b-input>
          </b-form-group>
        </div>
        <div class="form-row">
          <b-form-group label="Elmento de Configuración:" class="col-md-12">
            <b-input aria-describedby="input-live-help input-live-feedback" class="p-2 px-4 btn-xs " v-model="nombre_elemento">
            </b-input>
          </b-form-group>
        </div>
        <div class="form-row">
          <b-form-group label="Numero de Version:" class="col-md-12">
            <b-input aria-describedby="input-live-help input-live-feedback" class="p-2 px-4 btn-xs " v-model="version">
            </b-input>
          </b-form-group>
        </div>
        <div class="form-row">
          <b-form-group label="Fecha Inicio" class="col-md-6">
            <b-form-input type="date" class="p-2 px-4 btn-xs" required v-model="fecha_inicio"></b-form-input>
          </b-form-group>
          <b-form-group label="Fecha Fin" class="col-md-6">
            <b-form-input type="date" class="p-2 px-4 btn-xs" required v-model="fecha_termino"></b-form-input>
          </b-form-group>
        </div>

        <div class="form-row">
          <b-form-group label="Responsble :" class="col-md-12">
            <a-select style="width: 100%" v-model="id_miembro">
              <a-select-option v-for="d in miembros" :key="d.value">
                {{ d.text }}
              </a-select-option>
            </a-select>
          </b-form-group>
        </div>
        <hr>
        <div class="float-right">
          <b-button type="button" @click="CerrarModal" variant="light" class="p-2 px-4 btn-xs">Cancelar</b-button>
          <b-button type="button" variant="primary" class="p-2 px-4 btn-xs" @click="CrearVersion">
            Crear Version
          </b-button>
        </div>
      </form>
    </b-modal>

  </div>
</template>

<script>
import StepProgressBar from "./StepProgressBarComponent.vue";
import axios from "axios";
import Swal from "sweetalert2";

export default {
  name: "proyecto-detalle",
  components: { "step-progress-bar": StepProgressBar },
  props: ["items"],

  data() {
    return {
      animate: true,
      fases: [],
      listaversiones: [],
      currentItems: [],
      miembros: [],
      elementosConfi: [],
      fields: [
        { label: "Elementos de Configuración ", key: "nombre_elemento" },
        { label: "", key: "version" },
      ],
      current: 0,
      stepStyle: {
        marginBottom: "10px",
        boxShadow: "0px -1px 0 0 #e8e8e8 inset",
      },
      //variables
      DialogoElementoVersion: false,
      nombre_fase: "",
      nombre_elemento: "",
      nombreProyecto: "",
      TotalProcentajeProyecto: "",
      id_proyecto: "",
      id_miembro: "",
      idcronogramamalemento: "",
      id_cronograma_fase: "",
      fecha_inicio: "",
      fecha_termino: "",
      descripcion: "",
      estado: "",
      version: "",
      metodologia: "",
      TareaNuevas: "",
      TareaProceso: "",
      TareaTerminada: "",
      RangoFase: "",
      rangoAnterior: "",
    };
  },
  created() {
    // this.stepProgressBarParams.currentStep =3
  },
  computed: {
    esAdministrador() {
      return this.$store.state.tipousuario == "Administrador";
    },
    esMiembro() {
      return this.$store.state.tipousuario == "Miembro";
    },
    esJefe() {
      return this.$store.state.tipousuario == "Jefe";
    },
  },
  mounted() {
    this.GetDatos();
  },
  methods: {
    GetDatos() {
      var id = this.$route.params.id_proyecto;
      if (id) {
        this.id_proyecto = id;
        this.MostarFaseMetodolgiaProyecto(id);
        this.DatosProyecto(id);
        this.ListaMiembros(id);
        this.ProyectoTotalTareas(id);
      }
    },
    MostarFaseMetodolgiaProyecto(id) {
      let me = this;
      axios
        .get("ApiWeb/Proyecto.php/?id_proyecto=" + id)
        .then((response) => {
          me.fases = response.data;
          console.log(response.data);
          me.ElentosFaseProyecto(me.id_proyecto, me.fases[0].id_fase);
          me.nombre_fase = me.fases[0].nombre_fase;
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    ElentosFaseProyecto(id_proyecto, id_fase) {
      let me = this;
      axios
        .get(
          "ApiWeb/Proyecto.php/?parametro1=" +
            id_proyecto +
            "&id_fase=" +
            id_fase
        )
        .then((response) => {
          me.elementosConfi = response.data;
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    onChange(current) {
      this.current = current;
      var code = this.fases[current].id_fase;
      this.nombre_fase = this.fases[current].nombre_fase;
      this.ElentosFaseProyecto(this.id_proyecto, code);
    },
    DatosProyecto(id) {
      let me = this;
      axios
        .get("ApiWeb/Proyecto.php/?id_proyect=" + id)
        .then((response) => {
          me.nombreProyecto = response.data[0].nombre_proyecto;
          me.fecha_inicio = response.data[0].fecha_inicio;
          me.fecha_termino = response.data[0].fecha_termino;
          me.metodologia = response.data[0].nombre_metodologia;
          me.estado = response.data[0].estado;
          me.descripcion = response.data[0].descripcion;
          me.TotalProcentajeProyecto = response.data[0].porcentaje;
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    ProyectoTotalTareas(id_proyecto) {
      let me = this;
      axios
        .get("ApiWeb/Consulta.php/?id_proyecto=" + id_proyecto)
        .then((response) => {
          if (response.data.length == 0) {
            me.TareaNuevas = "0";
            me.TareaProceso = "0";
            me.TareaTerminada = "0";
          } else {
            me.TareaNuevas = response.data[0].cantidad;
            if (response.data.length > 1) {
              me.TareaProceso = response.data[1].cantidad;
            } else {
              me.TareaProceso = "0";
            }
            if (response.data.length > 2) {
              me.TareaTerminada = response.data[2].cantidad;
            } else {
              me.TareaTerminada = "0";
            }
          }
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    NuevaVersion(idcromograma, nombre) {
      this.idcronogramamalemento = idcromograma;
      this.nombre_elemento = nombre;
      this.DialogoElementoVersion = true;
    },
    CrearVersion() {
      let elemntoconfiguracionID = this.idcronogramamalemento;
      let version = this.version;
      let fecha_inicio = this.fecha_inicio;
      let fecha_termino = this.fecha_termino;
      let miembroresponsableID = this.id_miembro;

      const obj = {
        elemntoconfiguracionID,
        version,
        fecha_inicio,
        fecha_termino,
        miembroresponsableID,
      };
      axios
        .post("ApiWeb/Version.php/", obj)
        .then((response) => {
          this.Confirmacion();
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    DatosElemento(item) {
      console.log(item);
    },
    toggleDetails(row) {
      if (row._showDetails) {
        this.$set(row, "_showDetails", false);
      } else {
        this.currentItems.forEach((item) => {
          this.$set(item, "_showDetails", false);
        });
        //  console.log(row.id_cronograma_elemento);
        this.nombre_elemento = row.nombre_elemento;
        this.ListaVersiones(row.id_cronograma_elemento);
        this.$nextTick(() => {
          this.$set(row, "_showDetails", true);
        });
      }
    },
    ListaVersiones(id_elemento) {
      let me = this;
      // alert(id_elemento)
      axios
        .get("ApiWeb/Version.php/?id_elemento=" + id_elemento)
        .then((response) => {
          me.listaversiones = response.data;
          console.log(response.data);
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    ListaMiembros(id) {
      let me = this;
      var previa = [];
      axios
        .get("ApiWeb/Miembro.php/?id_proyecto=" + id)
        .then((response) => {
          previa = response.data;
          previa.map(function (x) {
            if (x.nombre_rol != "Jefe de Proyecto") {
              me.miembros.push({ text: x.nombre, value: x.id });
              //me.miembros.push({text: x.nombre,value:x.id_usuario});
              //  me.usuarios.push({text: x.nombre,value:x.id_usuario});
            }
            //  me.miembros.push({text: x.nombre,value:x.id});
          });
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    Tarea(id_version, miembro_id) {
      var element = this.nombre_elemento;
      var proyect = this.nombreProyecto;
      var fase = this.nombre_fase;
      var id_proyect = this.id_proyecto;
      var datos =
        element +
        "-" +
        fase +
        "-" +
        id_version +
        "-" +
        miembro_id +
        "-" +
        proyect +
        "-" +
        id_proyect;

      this.$router.push({ name: "tarealemento", params: { datos } });
    },
    DialogoRango(porce_avnce, id_cronograma_fase, porcentaje) {
      //DialogoRango(item.porcentaje_avance,item.id_cronograma_fase,item.porcentaje)
      let me = this;
      me.rangoAnterior = porce_avnce;
      me.id_cronograma_fase = id_cronograma_fase;
      Swal.fire({
        title: "Avance  Fase",
        icon: "question",
        input: "range",
        inputLabel: "Porcentaje",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Avance!",
        inputAttributes: {
          min: 0,
          max: 100,
          step: 1,
        },
        inputValue: porce_avnce,
        preConfirm: function (value) {
          me.RangoFase = value;
        },
      }).then((result) => {
        if (result.isConfirmed) {
          // alert( me.RangoFase)
          me.EditarPorcentajeFase(
            me.id_cronograma_fase,
            me.RangoFase,
            porcentaje
          );
          ///id_cronograma_fase
        }
      });
    },
    Confirmacion() {
      this.$swal({
        position: "top-end",
        icon: "success",
        title: "Registrado Version",
        text: "texto",
        showConfirmButton: false,
        timer: 3000,
      });
    },
    EditarPorcentajeProyecto(porcentajeProyeto) {
      let id_proyecto = this.id_proyecto;
      let porcentaje = porcentajeProyeto;
      const obj = { id_proyecto, porcentaje };
      axios
        .put("ApiWeb/Proyecto.php/", obj)
        .then((response) => {
          console.log(response.data);
          this.DatosProyecto(id_proyecto);
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    EditarPorcentajeFase(id_cronograma_f, RangoFase, porce) {
      let id_cronograma_fase = id_cronograma_f;
      let porcentaje = RangoFase;
      //  console.log(porcentajeProyeto);
      var porcentajeVerdadero = RangoFase - this.rangoAnterior;

      var porcentajeProyeto = (porcentajeVerdadero * porce) / 100;
      //console.log(porcentajeVerdadero);
      const obj = { id_cronograma_fase, porcentaje };
      console.log("porcentaje proyecto: " + porcentajeProyeto);
      axios
        .put("ApiWeb/CronogramaFase.php/", obj)
        .then((response) => {
          this.EditarPorcentajeProyecto(porcentajeProyeto);
          this.Confirmacion();
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    Obntener() {
      //Borrar esto we
      var prueba = "43";
      axios
        .get("ApiWeb/Proyecto.php/?prueba=" + prueba)
        .then((response) => {
          console.log(response.data);
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    CerrarModal() {
      this.DialogoElementoVersion = false;
    },
  },
  watch: {},
};
</script>

<style scoped>
::v-deep .myDiv {
  background-color: #ffffff;
}
</style>
