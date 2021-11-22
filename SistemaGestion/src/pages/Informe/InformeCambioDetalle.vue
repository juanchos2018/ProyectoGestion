<template>
  <div>
    <h5>Datos Informe de Cambio</h5>
    <div class="form-row">
      <b-form-group label="Fecha " class="col-md-3">
        <b-form-input class="p-2 px-4 btn-xs" required v-model="fecha"></b-form-input>
      </b-form-group>
       <b-form-group label="Proyecto " class="col-md-3">
        <a-select style="width: 100%" v-model="id_proyecto" disabled>
          <a-select-option v-for="d in itemsproyectos" :key="d.value">
            {{ d.text }}
          </a-select-option>
        </a-select>
      </b-form-group>
      <b-form-group label="Costo Economico " class="col-md-3">
        <b-form-input class="p-2 px-4 btn-xs" required v-model="costoeconomico"></b-form-input>
      </b-form-group>
      <b-form-group label="Tiempo Estimado " class="col-md-3">
        <b-form-input class="p-2 px-4 btn-xs" required v-model="tiempoestimado"></b-form-input>
      </b-form-group>
    </div>
    <div class="form-row">
      <b-form-group label="descripcion" class="col-md-6">
        <b-form-textarea placeholder="Enter at least 10 characters" rows="3" v-model="descripcion"></b-form-textarea>
      </b-form-group>
      <b-form-group label="Inpacto del Problema" class="col-md-6">
        <b-form-textarea placeholder="Enter at least 10 characters" rows="3" v-model="impactoproblema"></b-form-textarea>
      </b-form-group>
    </div>
    <h5>Detalle de Informe</h5>
    <div class="form-row">
     
      <!-- <b-form-group label="Estado" class="col-md-6">
        <h5>{{Estado}}</h5>
      </b-form-group> -->
      <!-- <b-button
        type="button"
        variant="primary"
        @click="AgregarDetalle"
        class="p-2 px-4 btn-xs"
      >
        Agregar
      </b-button> -->
      <br />
    </div>
    <br />
    <div class="form-row">
      <b-form-group class="col-md-12">
        <b-card>
          <b-table :items="detalle" :fields="fields" stacked="sm">

          </b-table>
        </b-card>
      </b-form-group>
    </div>
    <b-button type="button" variant="primary" v-if="esAdministrador" @click="Responder" class="p-2 px-4 btn-xs">
      Responder
    </b-button>
  </div>
</template>
<script>
import axios from "axios";
//import Swal from 'vue-sweetalert2';
const Swal = require("sweetalert2");

export default {
  name: "informe-cambio",
  data() {
    return {
      items: [],
      fields: [
        { label: "N°", key: "index", sortable: false },
        { label: "ESC", key: "nombreelemento", sortable: false },
        { label: "Tiempo", key: "tiempo", sortable: false },
        { label: "Costo", key: "costo", sortable: false },
      ],
      costo: "",
      costoeconomico: "",
      fecha: "",
      codigo: "",
      tiempo: "",
      tiempoestimado: "",
      id_proyecto: "",
      id_solicitud: "",
      id_fase: "",
      cro_ecs_Id: "",
      impactoproblema: "",
      fasesproyecto: [],
      elementosConfi: [],
      nombre_elemento: "",
      miembrojefeId: "",
      id_usuario: "",
      descripcion: "",
      decripcioninforme: "",
      detalle: [],
      itemsproyectos: [],
      Estado: "Nuevo",
      id_informe:0
    };
  },
  created() {},
  mounted() {
    this.ListarProyecto();
    if (localStorage.idtipo) this.id_usuario = localStorage.id_usuario;
    //  this.GetDatos();
    this.GetDato2();
  },
  computed:{
     esAdministrador(){
      return this.$store.state.tipousuario =='Administrador';
    },
     esMiembro(){
      return  this.$store.state.tipousuario =='Miembro';
    },
    esJefe(){
      return  this.$store.state.tipousuario =='Jefe';
    }
  },
  methods: {
    GetDatos() {
      var datos = this.$route.params.datos;
      if (datos) {
        var dato = datos.split("|");
        this.fecha = dato[0];
        this.codigo = dato[1];
        this.id_proyecto = dato[2];
        this.id_solicitud = dato[3];
        this.MostarFaseMetodolgiaProyecto(dato[2]);
        this.ObtenerIdMiembro(dato[2]);
      }
    },

    GetDato2() {
      var datos = this.$route.params.id_informe;
      if (datos) {
        this.DatosInforme(datos);
        this.id_informe=datos;
      }
    },
    ListarProyecto() {
      let me = this;
      axios
        .get("ApiWeb/Proyecto.php/")
        .then((response) => {
          //   me.itemsproyectos = response.data;
          let previa = response.data;
          previa.map(function (x) {
            me.itemsproyectos.push({
              text: x.nombre_proyecto,
              value: x.id_proyecto,
            });
          });
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },

    MostarFaseMetodolgiaProyecto(id) {
      let me = this;
      var previa = [];
      axios
        .get("ApiWeb/Proyecto.php/?id_proyecto=" + id)
        .then((response) => {
          previa = response.data;
          previa.map(function (x) {
            me.fasesproyecto.push({ text: x.nombre_fase, value: x.id_fase });
          });
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    ObtenerIdMiembro(proyectoId) {
      // var id="1";
      axios
        .get(
          "ApiWeb/Usuario.php/?proyectoId=" +
            proyectoId +
            "&usuario_miembroid=" +
            this.id_usuario
        )
        .then((response) => {
          console.log(response.data);
          //   this.usuario_miembroid=response.data.id;
          this.miembrojefeId = response.data.idusuarioJefe;
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    ElentosFaseProyecto(id_fase) {
      let me = this;
      var previa = [];
      axios
        .get(
          "ApiWeb/Proyecto.php/?parametro1=" +
            me.id_proyecto +
            "&id_fase=" +
            id_fase
        )
        .then((response) => {
          previa = response.data;
          previa.map(function (x) {
            me.elementosConfi.push({
              text: x.nombre_elemento,
              value: x.id_cronograma_elemento,
            });
          });
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    change(e) {
      //    console.log(this.id_elemento.nombre_elemento);
      //  var key = event.target.value; // example: 1
      this.nombre_elemento = event.target.textContent; // example: One
      console.log("name ", this.nombre_elemento);
    },
    GurdarInforme() {
      this.listaElementos = [];

      let codigo = this.codigo;
      let solicitudcambioId = this.id_solicitud;
      let descripcion = this.decripcioninforme;
      let tiempo = this.tiempoestimado;
      let costo = this.costoeconomico;
      let impactoproblema = this.impactoproblema;
      let fecha = this.fecha;
      let miembrojefeId = this.miembrojefeId;
      var estado = "Nuevo";
      var ListaDetalle = this.detalle;
      const obj = {
        codigo,
        solicitudcambioId,
        descripcion,
        tiempo,
        costo,
        impactoproblema,
        fecha,
        miembrojefeId,
        estado,
        ListaDetalle,
      };
      axios
        .post("ApiWeb/InformeCambio.php/", obj)
        .then((response) => {
          console.log(response);
          this.Confirmacion();
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    Confirmacion() {
      this.$swal({
        position: "top-end",
        icon: "success",
        title: "Registrado",
        text: "texto",
        showConfirmButton: false,
        timer: 3000,
      });
      this.LimpiarVista();
    },
    AgregarDetalle() {
      // this.$set(this.PreVenta, 'DetallePreVenta', datos)
      var nu = this.detalle.length + 1;
      this.detalle.push({
        numero: nu,
        ecs: this.nombre_elemento,
        cronogramaelemetoId: this.cro_ecs_Id,
        tiempo: this.tiempo,
        costo: this.costo,
        descripcion: this.descripcion,
        porcentajeavance: "0",
        fechainicio: "fecha",
        fechatermino: "fechatermino",
      });
    },
    DatosInforme(id_informe) {
      let me = this;
      axios
        .get("ApiWeb/InformeCambio.php?id_informe=" + id_informe)
        .then((response) => {
          console.log(response);
          me.codigo = response.data.codigo;
          me.descripcion = response.data.informe.descripcion;
          me.id_informe = response.data.informe.id_informe;
          me.tiempoestimado = response.data.informe.tiempo;
          me.costoeconomico = response.data.informe.costo;
          me.impactoproblema = response.data.informe.impactoproblema;
          me.fecha = response.data.informe.fecha;
          me.miembrojefeId = response.data.informe.miembrojefeId;
          me.id_proyecto = response.data.informe.id_proyecto;
          me.tiempo = response.data.informe.tiempo;
          me.detalle = response.data.detalle;
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(() => {});
    },
    LimpiarVista() {
      this.detalle = [];
      this.codigo = "";
      this.decripcioninforme = "";
      this.tiempoestimado = "";
      this.costoeconomico = "";
      this.impactoproblema = "";
      this.fecha = "";
      this.miembrojefeId = "";
    }, 
    Responder() {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger",
        },
        buttonsStyling: true,
      });
      swalWithBootstrapButtons
        .fire({
          title: "Informe Cambio",
          text: "Responder a esta Informe !",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Aprobar !",
          cancelButtonText: "Rechazar !",
          cancelButtonColor: "#d33",
          reverseButtons: true,
        })
        .then((result) => {
          if (result.isConfirmed) {        
              this.Aprobar();
          } else if (result.dismiss === Swal.DismissReason.cancel) {             
              this.Rechazar();
           }
         
        });
    },
    Aprobar(){         
          let id_informe=this.id_informe;
          let estado="Aprobado";            
          const obj={id_informe,estado};
          axios.put('ApiWeb/InformeCambio.php/',obj).then(response => {         
            console.log(response)             
          
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Aprobado Con Exito',
              showConfirmButton: false,
              timer: 1500
            })
          }).catch(function (error) {
              console.log(error);
          }) .finally(() => {              
         })
     },
     Rechazar(){         
          let id_informe=this.id_informe;
          let estado="Rechazado";            
          const obj={id_informe,estado};
          axios.put('ApiWeb/InformeCambio.php/',obj).then(response => {            
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Registrado Con Exito',
              showConfirmButton: false,
              timer: 1500
            })
          }).catch(function (error) {
              console.log(error);
          }) .finally(() => {              
         })
     },
    handleChange(value) {
      this.elementosConfi = [];
      this.ElentosFaseProyecto(value);
    },
  },
};
</script>
