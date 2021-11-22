<template>
  <div>  
<img class="wave" src="../../assets/wave1.png">
	<div class="container">	      
		<div class="img">
			<img src="../../assets/loginsvg.svg">       
		</div>  
		<div class="login-content">
			<form @submit.prevent="Loguear">
         <h4>Gestion de la Configuración de software</h4>
         <b-card>
				<img src="../../assets/avatar.svg">
				<h2 class="title">Bienvenido</h2>
           		<div class="input-div one">
           		   <div class="i">           		 
                     <i class="fal fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<input  ref="email" required type="text" name="email"  v-on:keyup.enter="nextPlease" placeholder="usuario" >
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    <input  ref="password" v-model="password" required type="password" id="password" name="password"   v-on:keyup="validateEnter" placeholder="Contraseña">
				   </div>
            	</div>   
              <b-button type="submit" style="padding: 10px 10px 10px;                            
                                border-radius: 4px;
                                font-size: 17px;
                                font-weight: bold;
                                line-height: 20px;    
                                margin-bottom: 24px;"
                                >
						<div class="float-left">
							<pulse-loader  v-if="loanding"  color="#F2E6E4" ></pulse-loader>
						</div>							
						Ingresar
			     </b-button>        
         </b-card>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import Widget from '@/components/Widget/Widget';
import axios from  'axios';
export default {
  name: 'LoginPage',
  components: { Widget },
  data() {
    return {
      errorMessage: null,
      loanding:false,    
      password:'123456',
      alias:''
    };
  },
  methods: {      
    Loguear(){     
           let  correo =this.$refs.email.value;
           let  password =this.$refs.password.value;         
            let config = {
                      header : {
                      'Access-Control-Allow-Origin': '*',
                      'Access-Control-Allow-Headers': 'Origin, X-Requested-With, Content-Type, Accept',
                       'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE'
                      }
                    }
            axios.get('ApiWeb/Login.php/?correo='+correo+'&password='+password,config).then(response => {   
                console.log(response.data)
                //this.$session.start()
                this.$store.dispatch("guardarDatos",response.data[0].nombre)      
                this.$store.dispatch("guardarTipo",response.data[0].id_tipo)    
                this.$store.dispatch("guardarTipoUsuario",response.data[0].tiposusuario)    
                this.$store.dispatch("guardarIdUsuario",response.data[0].id_usuario)      
                 window.localStorage.setItem('authenticated', true);
                 this.$router.push('/app/inicio').catch(err => {         
                  if ( err.name !== 'NavigationDuplicated' && !err.message.includes('Avoided redundant navigation to current location')) {                     
                      console.log(err);
                     }
                 });
                   
              }).catch(function (error) {
                      console.log(error);
             }) .finally(() => {
                     
            })
    },   
    nextPlease: function (event) {
       		 document.getElementById('password').focus();
     },
    validateEnter: function(e) {
      if (e.keyCode === 13) {
        this.ingresar();
      } else if (e.keyCode === 50) {
        //alert('@ was pressed');
      }      
      this.log += e.key;
      }, 
    },
    created() {
        if (window.localStorage.getItem('authenticated') === 'true') {
          this.$router.push('/app/inicio').catch(err => {
        // Ignore the vuex err regarding  navigating to the page they are already on.
                if (
                  err.name !== 'NavigationDuplicated' &&
                  !err.message.includes('Avoided redundant navigation to current location')
                ) {
                  // But print any other errors to the console
                  console.log(err)
                
                }
          });
     }
  },
};
</script>
<style src="./stilo.scss" scoped lang="scss" ></style>