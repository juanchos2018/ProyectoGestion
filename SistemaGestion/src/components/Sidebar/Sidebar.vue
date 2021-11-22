<template>
  <div class="sidebar-wrapper">
    <nav
        :class="{sidebar: true, sidebarStatic, sidebarOpened}"
        @mouseenter="sidebarMouseEnter"
        @mouseleave="sidebarMouseLeave"
    >
      <header class="logo">
         <img src="../../assets/logo/logo1.png" width="30%" alt=""><br>       
          <span class="primary-word"  >  SGC  </span>
          <h5 style="color:white">{{tipoUsuario}}</h5>
      </header>
      <ul class="nav">
        <NavLink
            :activeItem="activeItem"
            header="Inicio"
            link="/app/inicio"
            iconName="flaticon-home"
            index="inicio"
            isHeader
        />
          <NavLink
            v-if="esJefe"
            :activeItem="activeItem"
            header="ECS"
            link="/app/elemento"
            iconName="flaticon-home"
            index="elemento"
            isHeader
        />
         <NavLink
             v-if="esJefe"
            :activeItem="activeItem"
            header="Metodologias"
            link="/app/metodologia"
            iconName="flaticon-home"
            index="metodologia"
            isHeader
        />
         
<!--
           <NavLink
            :activeItem="activeItem"
            header="Proyecto"
            link="/app/proyecto"
            iconName="flaticon-network"
            index="proyecto"
            isHeader
           
        />-->
          <NavLink
           v-if="esJefe"
            :activeItem="activeItem"
            header="Proyectos"
            link="/app/proyecto"
            iconName="flaticon-network"
            index="proyecto"
            :childrenLinks="[
              { header: 'Agregar', link: '/app/components/agregar' },
              { header: 'Listar', link: '/app/components/listar' },
            
             ]"
        />
        <NavLink
            v-if="esAdministrador"
            :activeItem="activeItem"
            header="Proyectos"
            link="/app/proyecto"
            iconName="flaticon-network"
            index="proyecto"
            :childrenLinks="[            
              { header: 'Listar', link: '/app/components/listarproyecto' }
             ]"
        />
          <NavLink
             v-if="esJefe"      
            :activeItem="activeItem"
            header="Solicitud de Cambio"
            link="/app/solicitud"
            iconName="flaticon-network"
            index="solicitud"
            :childrenLinks="[           
              { header: 'Listar Solicitudes', link: '/app/components/solicitudlista' },
              { header: 'Listar Informes', link: '/app/components/informelistar' }
            ]"
           />


            <NavLink
             v-if="esMiembro"
      
            :activeItem="activeItem"
            header="Solicitud de Cambio"
            link="/app/solicitud"
            iconName="flaticon-network"
            index="solicitud"
            :childrenLinks="[
              { header: 'Agregar', link: '/app/components/solicitudnueva' },
              { header: 'Listar', link: '/app/components/solicitudlista' }
            ]"
           />


    <!--     <NavLink
             v-if="esMiembro"
            :activeItem="activeItem"
            header="Solicitud"
            link="/app/solicitudnueva"
            iconName="flaticon-network"
            index="solicitud"
             isHeader           
        />
      <NavLink
            :activeItem="activeItem"
            header="ListaSolicitud"
            link="/app/solicitudlista"
            iconName="flaticon-network"
            index="solicitudlista"
            isHeader           
        />
           <NavLink
            :activeItem="activeItem"
            header="Informecambio"
            link="/app/informecambio"
            iconName="flaticon-network"
            index="informecambio"
            isHeader           
        />  
        -->
            
          <NavLink
             v-if="esAdministrador"
            :activeItem="activeItem"
            header="Informe Cambio"
            link="/app/informe"
            iconName="flaticon-network"
            index="informe"
            :childrenLinks="[
              { header: 'Listar', link: '/app/components/informelistar' },
              
            ]"
           />
           <NavLink
            v-if="esAdministrador"
            :activeItem="activeItem"
            header="Usuario"
            link="/app/usuario"
            iconName="flaticon-network"
            index="usuario"
            isHeader
           
        />
          
           <NavLink
           v-if="esMiembro"
            :activeItem="activeItem"
            header="MisTareas"
            link="/app/tareausuario"
            iconName="flaticon-network"
            index="tareausuario"
            isHeader
           
        />
      
         
      </ul>
      
    </nav>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import isScreen from '@/core/screenHelper';
import NavLink from './NavLink/NavLink';

export default {
  name: 'Sidebar',
  components: { NavLink },
  data() {
    return {
     tipoUsuario:'',
    }
  },
    mounted() {
    
      if(localStorage.tipousuario) this.tipoUsuario = localStorage.tipousuario;
     
    },
  methods: {
    ...mapActions('layout', ['changeSidebarActive', 'switchSidebar']),
    setActiveByRoute() {
      const paths = this.$route.fullPath.split('/');
      paths.pop();
      this.changeSidebarActive(paths.join('/'));
    },
    sidebarMouseEnter() {
      if (!this.sidebarStatic && (isScreen('lg') || isScreen('xl'))) {
        this.switchSidebar(false);
        this.setActiveByRoute();
      }
    },
    sidebarMouseLeave() {
      if (!this.sidebarStatic && (isScreen('lg') || isScreen('xl'))) {
        this.switchSidebar(true);
        this.changeSidebarActive(null);
      }
    },
  },
  created() {
    this.setActiveByRoute();
  },
  computed: {
    ...mapState('layout', {
      sidebarStatic: state => state.sidebarStatic,
      sidebarOpened: state => !state.sidebarClose,
      activeItem: state => state.sidebarActiveElement,
    }),

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
};
</script>

<!-- Sidebar styles should be scoped -->
<style src="./Sidebar.scss" lang="scss" scoped/>
