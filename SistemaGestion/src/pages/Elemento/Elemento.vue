<template>
  <div>
    <div class="form-row">
      <b-form-group class="col-md-4">
        <b-button
          type="button"
          class="m-1 p-2 px-4 btn-xs"
          variant="primary"
          @click="DialogoElemento = true"
        >
          <i class="fa fa-plus-circle"></i> Agregar
        </b-button>
      </b-form-group>
      <b-form-group class="col-md-6">
        <b-form-input
          id="input-30"
          autocomplete="off"
          class="p-2 px-4 btn-xs"
          v-model="search"
        >
        </b-form-input>
      </b-form-group>
      <b-form-group class="col-md-2">
        <div class="float-right">
          <a href="#" @click="Grilla"
            ><i
              class="fa fa-th-list"
              style="font-size:28px;margin-right:5px"
            ></i
          ></a>
          <a href="#" @click="Card"
            ><i class="fa fa-th x2" style="font-size:28px"></i
          ></a>
        </div>
      </b-form-group>
    </div>
    <div>
      <div v-if="Vergrilla">
        <b-table :items="filteredList" :fields="fields" stacked="sm">
          <template v-slot:cell(accion)="item">
            <b-button
              variant="primary"
              @click="Detalle(item.item.id + '-' + item.item.nombre)"
              >Ver</b-button
            >
          </template>
        </b-table>
      </div>

      <div v-if="VerCard">
        <div class="row">
          <div class="col-4" v-for="item in filteredList" :key="item.key">
            <b-card no-body class="overflow-hidden" footer-tag="footer">
              <b-row no-gutters>
                <b-col md="3">
                  <div class="UserAvatar__IconImage-hmym9w-1 jtNJTZ">
                    <center>
                      <img
                        src="../../assets/logoelemento.png"
                        alt="Avatar"
                        class="avatar1 img-fluid"
                      />
                    </center>
                  </div>
                </b-col>
                <b-col md="8">
                  <b-card-body>
                    <b-card-title>
                      <h5>{{ item.nombre }}</h5>
                    </b-card-title>
                    <b-card-text>
                      texto
                    </b-card-text>
                  </b-card-body>
                </b-col>
              </b-row>
              <template #footer footer-class="myDiv">
                <div style="background-color: white; float:right;">
                  <b-button variant="success" v-b-tooltip.hover title="Editar">
                    <b-icon
                      icon="pencil-square"
                      animation="fade"
                      font-scale="1"
                      @click="AbrirModalEditar(item.id_elemento, item.nombre)"
                    ></b-icon>
                  </b-button>
                  <b-button
                    variant="danger"
                    style="margin-left:2px"
                    @click="MensajeEliminar(item.id_elemento)"
                    v-b-tooltip.hover
                    title="Eliminar"
                  >
                    <b-icon
                      icon="trash"
                      animation="fade"
                      font-scale="1"
                    ></b-icon>
                  </b-button>
                </div>
              </template>
            </b-card>
            <br />
          </div>
        </div>
      </div>
    </div>

    <elemento-nuevo
      @CerrarModal="CerrarModal"
      :DialogoElemento="DialogoElemento"
      v-on:ListarElemento-Emit="ListaElemento"
    ></elemento-nuevo>
    <elemento-editar
      @CerrarModal="CerrarModal"
      :DialogoModificar="DialogoModificar"
      v-bind:id_elemento="id_elemento"
        v-bind:Nombre="Nombre"
      v-on:ListarElemento-Emit="ListaElemento"
    ></elemento-editar>
  </div>
</template>

<script>
import ElementoNuevo from "./ElementoNuevo";
import ElementoEditar from "./ElementoEditar";
import axios from "axios";
export default {
  components: { ElementoNuevo, ElementoEditar },
  data() {
    return {
      fields: [
        { label: "codigo", key: "id_elemento", sortable: false },
        { label: "Nombre", key: "nombre", sortable: false },
        { label: "Acciones", key: "accion", sortable: false },
      ],
      DialogoElemento: false,
      DialogoModificar: false,
      Vergrilla: false,
      VerCard: true,
      id_elemento: "",
      items: [],
      search: "",
      Nombre: "",
    };
  },
  created() {
    this.ListaElemento();
  },
  methods: {
    CerrarModal() {
      this.DialogoElemento = false;
      this.DialogoModificar = false;
    },
    AbrirModalEditar(id,nombre) {
      this.id_elemento = id;
      this.DialogoModificar = true;
      this.Nombre=nombre
    },
    ListaElemento() {
      let me = this;
      axios
        .get("ApiWeb/Elemento.php/")
        .then((response) => {
          me.items = response.data.data;
        })
        .catch(function(error) {
          console.log(error);
        })
        .finally(() => {});
    },
    MensajeEliminar(id) {
      this.$swal
        .fire({
          title: "Elminar ?",
          text: "Ya no podras revertir!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, Eliminar!",
        })
        .then((result) => {
          if (result.isConfirmed) {
          }
        });
    },
    Eliminar(id) {
      var id_elemento = id;
      const obj = { id_elemento };
      axios
        .get("ApiWeb/Elemento.php/?id_elemento=" + id_elemento)
        .then((response) => {
          console.log(response);
          this.$swal.fire("Eliminado!", "Has Eliminado.", "success");
        })
        .catch(function(error) {
          console.log(error);
        })
        .finally(() => {});
    },
    Grilla() {
      this.Vergrilla = true;
      this.VerCard = false;
    },
    Card() {
      this.Vergrilla = false;
      this.VerCard = true;
    },
  },
  computed: {
    filteredList() {
      return this.items.filter((post) => {
        return post.nombre.toLowerCase().includes(this.search.toLowerCase());
      });
    },
  },
};
</script>
<style src="./elemento.scss" lang="scss" scoped />
