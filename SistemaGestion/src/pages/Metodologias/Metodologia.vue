<template>
  <div>
    <div class="form-row">
      <b-form-group class="col-md-4">
        <b-button
          type="button"
          class="m-1 p-2 px-4 btn-xs"
          variant="primary"
          @click="DialogMetodologia = true"
        >
          <i class="fa fa-plus-circle"></i> Nueva Metodologia
        </b-button>
      </b-form-group>
      <b-form-group class="col-md-6">
        <b-form-input
          id="input-30"
          require
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

    <div class="inner-content">
      <div v-if="Vergrilla">
        <b-card>
          <b-table
            striped
            hover
            :items="filteredList"
            :fields="fields"
            stacked="sm"
          >
            <template v-slot:cell(accion)="item">
              <b-button
                variant="primary"
                class="m-1 p-2 px-4 btn-xs"
                @click="
                  Detalle(item.item.id_metodologia + '-' + item.item.nombre)
                "
                >Ver</b-button
              >
              <b-button
                type="button"
                size="lg"
                class="m-1 p-2 px-4 btn-xs"
                v-b-tooltip.hover
                title="Editar"
                @click="AbrirModalEditar(item.item.id_metodologia)"
                variant="primary"
              >
                <b-icon
                  icon="pencil-square"
                  animation="fade"
                  font-scale="1"
                ></b-icon>
              </b-button>
            </template>
          </b-table>
        </b-card>
      </div>
      <div v-if="VerCard">
        <div class="row">
          <div class="col-3" v-for="item in filteredList" :key="item.key">
            <b-card
              text-variant="primary"
              border-variant="primary"
              header-bg-variant="primary"
              header-text-variant="white"
              header="Metodologia"
              class="text-center"
            >
              <img
                class="img-fluid"
                src="../../assets/logometo.png"
                width="140px"
                alt="Card image cap"
              />
              <div class="card-body">
                <h4 class="card-title">{{ item.nombre }}</h4>
                <b-button
                  type="button"
                  size="lg"
                  class="m-1 p-2 px-4 btn-xs"
                  @click="Detalle(item.id_metodologia + '-' + item.nombre)"
                  variant="primary"
                >
                  Ver
                </b-button>
                <b-button
                  type="button"
                  size="lg"
                  class="m-1 p-2 px-4 btn-xs"
                  v-b-tooltip.hover
                  title="Editar"
                  @click="AbrirModalEditar(item.id_metodologia,item.nombre)"
                  variant="primary"
                >
                  <b-icon
                    icon="pencil-square"
                    animation="fade"
                    font-scale="1"
                  ></b-icon>
                </b-button>
              </div>
            </b-card>
            <br />
          </div>
        </div>
      </div>
    </div>
    <metodologia-nueva
      @CerrarModal="CerrarModal"
      :DialogMetodologia="DialogMetodologia"
      v-on:Listar-Emit="ListarMetodologia"
    ></metodologia-nueva>

    <metodologia-editar
      @CerrarModal="CerrarModal"
      :DialogoModificar="DialogoModificar"
      v-bind:id_metodologia="id_metodologia"
       v-bind:Nombre="nombre"
      v-on:Listar-Emit="ListarMetodologia"
    ></metodologia-editar>
  </div>
</template>

<script>
import axios from "axios";
import MetodologiaNueva from "./MetodologiaNueva";
import MetodologiaEditar from "./MetodologiaEditar";
export default {
  components: { MetodologiaNueva, MetodologiaEditar },
  data() {
    return {
      fields: [
        { label: "codigo", key: "id_metodologia", sortable: false },
        { label: "Nombre", key: "nombre", sortable: false },
        { label: "Acciones", key: "accion", sortable: false },
      ],
      data: { type: "", nickname: "", message: "" },
      DialogMetodologia: false,
      DialogoModificar: false,
      id_metodologia: "",
      Vergrilla: false,
      VerCard: true,
      nombre: "",
      items: [],
      search: "",
    };
  },
  created() {
    this.ListarMetodologia();
  },
  computed: {
    filteredList() {
      return this.items.filter((post) => {
        return post.nombre.toLowerCase().includes(this.search.toLowerCase());
      });
    },
  },
  methods: {   
    Detalle(item) {
      this.$router.push({ name: "fases", params: { item } });
    },
    CerrarModal() {
      this.DialogMetodologia = false;
      this.DialogoModificar = false;
    },
    ListarMetodologia() {
      let me = this;
      axios
        .get("ApiWeb/Metodologia.php/")
        .then((response) => {
          me.items = response.data.data;
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
    AbrirModalEditar(id,nombre) {
      this.id_metodologia = id;
      this.nombre=nombre
      this.DialogoModificar = true;
    },
  },
};
</script>
