<template>
  <b-navbar class="header d-print-none app-header">
    <b-nav>
      <b-nav-item>
        <a class="d-md-down-none px-2" href="#" @click="toggleSidebarMethod" id="barsTooltip">
          <i class='la la-bars la-lg' />
        </a>
        <a class="fs-lg d-lg-none" href="#" @click="switchSidebarMethod">
          <i class="la la-bars la-lg" />
        </a>    
         <div class="site-branding-text d-md-down-none">
            <h5 class="site-title"  style="font-size:1.30vw; margin-left:15px" > <strong> Gestion de la Configuración Software</strong></h5>
            <p class="site-description" style="font-size:1.0vw; color:#808080" ></p>
          </div>
      </b-nav-item>      
    </b-nav>

    
    <b-nav class="ml-auto">  
      <!--   
      <b-nav-item href="#"> 
         <span style="font-size:1.0vw;" >{{NombreUsuario}}</span>       
       </b-nav-item> -->
      <b-nav-item-dropdown
            class="notificationsMenu d-md-down-none mr-2"
            menu-class="notificationsWrapper py-0 animate__animated animate__animated-fast animate__fadeIn"
            right>
            <template slot="button-content">
              <span class="avatar rounded-circle thumb-sm float-left mr-2">
                <img class="rounded-circle" src="../../assets/logo/userlogo.png" alt="..." />
              </span>
              <span class="small">{{NombreUsuario}}</span>
        
            </template>
            <Notifications />
          </b-nav-item-dropdown>

      <b-nav-item-dropdown id="v-step-2" class="settingsDropdown d-sm-down-none" no-caret right>
        <template slot="button-content">
          <i class="la la-cog px-2" />
        </template>
        <b-dropdown-item><i class="la la-user" /> {{NombreUsuario}}</b-dropdown-item>
        <b-dropdown-divider />   
        <b-dropdown-item-button @click="logout">
          <i class="la la-sign-out" /> Salir
        </b-dropdown-item-button>
      </b-nav-item-dropdown>
    </b-nav>
  </b-navbar>
</template>

<script>
import { mapState, mapActions } from 'vuex';

import Notifications from '@/components/Notifications/Notifications';

export default {
  name: 'Header',
  props:['name','ru'],
   data() {
    return {
       NombreUsuario:'',
       nameusu:'',
       Token:''
      
    };
  },
 components: { Notifications },
   mounted() {
    if(localStorage.nombre) this.NombreUsuario = localStorage.nombre;
     // this.datosUsuario=decode(this.Token)     
     // this.NombreUsuario=this.datosUsuario.Nombre;
  },
  computed: {
    ...mapState('layout', ['sidebarClose', 'sidebarStatic']),
  },

  created(){    
     //   this.NombreUsuario=  this.$store.state.nombreUsuario
     //   console.log("hieader"+this.$store.state.nombreUsuario)
  },
  methods: {
    ...mapActions('layout', ['toggleSidebar', 'switchSidebar', 'changeSidebarActive']),
    switchSidebarMethod() {
      if (!this.sidebarClose) {
        this.switchSidebar(true);
        this.changeSidebarActive(null);
      } else {
        this.switchSidebar(false);
        const paths = this.$route.fullPath.split('/');
        paths.pop();
        this.changeSidebarActive(paths.join('/'));
      }
    },
    toggleSidebarMethod() {
      if (this.sidebarStatic) {
        this.toggleSidebar();
        this.changeSidebarActive(null);
      } else {
        this.toggleSidebar();
        const paths = this.$route.fullPath.split('/');
        paths.pop();
        this.changeSidebarActive(paths.join('/'));
      }
    },
    logout() {
   //   this.$session.destroy();
      window.localStorage.setItem('authenticated', false);
      window.localStorage.clear();
      this.$router.push('/login');
    },
    CerrarSesion(){
        window.localStorage.setItem('authenticated', false);
        this.$router.push('/login');
    }
  }
};
</script>

<style src="./Header.scss" lang="scss"></style>
