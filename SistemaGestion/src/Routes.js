import Vue from 'vue';
import Router from 'vue-router';
import Layout from '@/components/Layout/Layout';
import Login from '@/pages/Login/Login';
import ErrorPage from '@/pages/Error/Error';
// Main
import AnalyticsPage from '@/pages/Dashboard/Dashboard';
import DetalleGrafico from '@/pages/Dashboard/DetalleGrafico';
import Usuario from '@/pages/Usuario/Usuario';
import UsuarioTareas from '@/pages/Usuario/UsuarioTareas';

import Metodologia from '@/pages/Metodologias/Metodologia';
import Fases from '@/pages/Fases/Fases';
import Proyecto from '@/pages/Proyecto/Proyecto';
import ProyectoLista from '@/pages/Proyecto/ProyectoLista';
import ProyectoNuevo from '@/pages/Proyecto/ProyectoNuevo';
import ProyectoDetalle from '@/pages/Proyecto/ProyectoDetalle';
import ProyectoMiembros from '@/pages/Proyecto/ProyectoMiembros';

import Solicitud from '@/pages/Solicitud/SolicitudCambio';
import SolicitudNueva from '@/pages/SolicitudCambio/SolicitudNueva';
import SolicitudLista from '@/pages/SolicitudCambio/SolicitudLista';
import Elemento from '@/pages/Elemento/Elemento';
import MiembroTareas from '@/pages/Miembro/MiembroTareas';
import TareaElemento from '@/pages/Tarea/TareaElemento';
import TareaElementoMiembro from '@/pages/Tarea/TareaElementoMiembro';
import TareaDetalle from '@/pages/Tarea/TareaDetalle';
import TareaUsuario from '@/pages/Tarea/TareaUsuario';
import InformeCambio from '@/pages/Informe/InformeCambio';
import InformeCambioLista from '@/pages/Informe/InformeCambioLista';
import store from './store/index'


import InformeCambioDetalle from '@/pages/Informe/InformeCambioDetalle';

Vue.use(Router);

//export default new Router({

var router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [{
            path: '/login',
            name: 'Login',
            component: Login,
            meta: {
                libre: true
            }
        },
        {
            path: '/error',
            name: 'Error',
            component: ErrorPage,
        },
        {
            path: '/app',
            name: 'Layout',
            component: Layout,
            children: [{
                    path: 'inicio',
                    name: 'AnalyticsPage',
                    component: AnalyticsPage,
                    meta: {
                        libre: true
                    }
                },
                {
                    path: 'detallegrafico:id_proyecto',
                    name: 'detallegrafico',
                    component: DetalleGrafico,
                    meta: {
                        libre: true,
                        Jefe: true
                    }
                },
                {
                    path: 'usuario',
                    name: 'usuario',
                    component: Usuario,
                    meta: {
                        Administrador: true,
                    }
                },
                {
                    path: 'miembrotareas:id_proyecto',
                    name: 'miembrotareas',
                    component: MiembroTareas,
                    meta: {
                        libre: true,
                        Jefe: true
                    }
                },
                {
                    path: 'usuariotareas:id_proyecto',
                    name: 'usuariotareas',
                    component: UsuarioTareas,
                },
                {
                    path: 'metodologia',
                    name: 'metodologias',
                    component: Metodologia,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'fases/:item',
                    name: 'fases',
                    component: Fases,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'proyectomiembro:id_proyecto',
                    name: 'proyectomiembro',
                    component: ProyectoMiembros,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'proyectodetalle:id_proyecto',
                    name: 'proyectodetalle',
                    component: ProyectoDetalle,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'solicitud',
                    name: 'solicitud',
                    component: Solicitud,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'components/solicitudnueva',
                    name: 'solicitudnueva',
                    component: SolicitudNueva,
                    meta: {
                        Miembro: true,
                    }
                },
                {
                    path: 'components/solicitudlista',
                    name: 'solicitudlista',
                    component: SolicitudLista,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'components/informelistar',
                    name: 'informelista',
                    component: InformeCambioLista,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'elemento',
                    name: 'elemento',
                    component: Elemento,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'components/agregar',
                    name: 'nuevo',
                    component: ProyectoNuevo,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'components/listar',
                    name: 'listar',
                    component: Proyecto,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'components/listarproyecto',
                    name: 'listar',
                    component: ProyectoLista,
                    meta: {
                        Administrador: true,
                    }
                },
                //ProyectoLista
                {
                    path: 'components/tarealemento:datos',
                    name: 'tarealemento',
                    component: TareaElemento,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'tareausuario',
                    name: 'tareausuario',
                    component: TareaUsuario,
                    meta: {
                        Miembro: true,
                    }
                },
                {
                    path: 'tareaselemento:id_responsable',
                    name: 'tareaselemento',
                    component: TareaElementoMiembro,
                    meta: {
                        Miembro: true,
                    }
                },
                {
                    path: 'tareadetalle:id_tarea',
                    name: 'tareadetalle',
                    component: TareaDetalle,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'informecambio:datos',
                    name: 'informecambio',
                    component: InformeCambio,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
                {
                    path: 'informecambiodetalle:id_informe',
                    name: 'informecambiodetalle',
                    component: InformeCambioDetalle,
                    meta: {
                        Administrador: true,
                        Jefe: true
                    }
                },
            ],
        },
    ],
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.libre)) {
        next()
    } else if (store.state.tipousuario == 'Administrador') {
        if (to.matched.some(record => record.meta.Administrador)) {
            next()
        }
    } else if (store.state.tipousuario == 'Jefe') {
        if (to.matched.some(record => record.meta.Jefe)) {
            next()
        }
    } else if (store.state.tipousuario == 'Miembro') {
        if (to.matched.some(record => record.meta.Miembro)) {
            next()
        }
    } else {
        next({
            name: 'Login'
        })
    }
})


export default router