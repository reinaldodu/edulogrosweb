<template>    
    <table class="table table-compact table-zebra w-full border-collapse">
        <thead>            
            <!-- Si se evalua por actividades se muestran las columnas de evaluación de actividades -->
            <template v-if="evaluacion.evalua_actividades===1">
                <th class="w-1/2">{{ evaluacion.tipo_evaluacion.nombre }}</th>
                <th class="w-1/2">Actividades</th>
            </template>
            <!-- Si se evalua por logro se muestran las columnas de evaluación de logros -->
            <template v-else>
                <th class="w-1/2">{{ evaluacion.tipo_evaluacion.nombre }}</th>
                <th class="w-1/4"></th>
                <th class="w-1/4">Evaluados</th>
            </template>
        </thead>
        <tbody>                                        
            <tr v-for="(logro,j) in logros" :key="j">               
                <!-- Si se evalua por actividades se crean las filas de evaluación de actividades -->
                <template v-if="evaluacion.evalua_actividades===1">
                    <td class="whitespace-normal">
                        {{ logro.logro }} <br />
                        <label for="modal-crea" @click="crearActividad(logro.id);" class="btn btn-outline btn-secondary btn-xs mt-2">Crear actividad</label>
                    </td>
                    <td>
                        <!-- Por cada logro se crea una tabla de actividades -->
                        <table class="w-full">
                            <th >Actividad</th>
                            <th></th>
                            <th>Evaluados</th>
                            <th></th>
                            <tbody>
                                <tr v-for="(actividad,k) in logro.actividades_logros" :key="k">
                                    <td class="whitespace-normal">
                                        {{ actividad.nombre }}
                                        <br><span class="text-gray-400 text-xs">Fecha:{{ actividad.fecha }} </span>                                    
                                    </td>
                                    <td>
                                        <Link :href="route('admin.evaluar-logros.show', { logro:logro.id, actividad:actividad.id })" class="btn btn-outline btn-xs rounded-full mt-2">Evaluar</Link>
                                    </td>

                                    <td>
                                        {{ ttl_notas(logro,actividad) }} de {{ estudiantes.length }}
                                        <!--Muestra banderita verde si todos los estudiantes están evaluados-->
                                        <span class="justify-center" v-if="ttl_notas(logro,actividad)===estudiantes.length">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="green" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                                            </svg>
                                        </span>
                                    </td>
                                    <!-- Opciones para editar o eliminar una actividad -->
                                    <td>
                                        <div class="dropdown dropdown-left dropdown-end">
                                            <label tabindex="0" class="btn btn-ghost btn-xs m-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                </svg>
                                            </label>                                            
                                            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                                <!-- Editar actividad -->
                                                <li>
                                                    <label for="modal-edita" class="text-sm" @click="editarActividad(actividad)">
                                                        Editar actividad
                                                    </label>
                                                </li>
                                                <!-- Eliminar actividad -->
                                                <li v-if="ttl_notas(logro,actividad)===0">
                                                    <label for="modal-elimina" class="text-sm" @click="dataActividad=actividad">
                                                        Eliminar actividad
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </template>
                <!-- Si se evalua por logros se crean las filas de evaluación de logros -->
                <template v-else>
                    <td class="whitespace-normal">{{ logro.logro }}</td>
                    <td>
                        <Link :href="route('admin.evaluar-logros.show', { logro:logro.id })" class="btn btn-outline btn-xs rounded-full mt-2">Evaluar</Link>
                    </td>
                    <td>
                        {{ ttl_notas(logro,null) }} de {{ estudiantes.length }}
                        <!--Muestra banderita verde si todos los estudiantes están evaluados-->
                        <span class="justify-center" v-if="ttl_notas(logro,null) === estudiantes.length">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="green" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                            </svg>
                        </span>
                    </td>
                </template>                                            
            </tr>
        </tbody>
    </table>

    <!-- Modal crear actividad -->
   <input type="checkbox" id="modal-crea" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Crear Actividad</h3>
            <form class="form-control w-full text-sm" @submit.prevent="form.post(route('admin.actividad-logros.store'), { onSuccess: closeModalCrea, preserveScroll:true })">
                
                <label class="label">Nombre*:</label>
                <input type="text" 
                                    class="input input-bordered input-sm w-full mt-4" 
                                    :class="{ 'input-error':form.errors.nombre }"
                                    v-model="form.nombre"
                                    maxlength="100">
                <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>
                
                <label class="label">Descripción:</label>
                <input type="text" 
                                    class="input input-bordered input-sm w-full mt-4" 
                                    v-model="form.descripcion"
                                    maxlength="250">

                <label class="label">Fecha*:</label>
                <input type="date" 
                                    class="input input-bordered input-sm w-full mt-4" 
                                    :class="{ 'input-error':form.errors.fecha }"
                                    v-model="form.fecha">
                <div class="badge badge-warning"  v-if="form.errors.fecha">{{ form.errors.fecha }}</div>

                <div class="modal-action">
                    <button type="submit" class="btn btn-primary btn-xs" :disabled="form.processing">Guardar</button>
                    <label for="modal-crea" class="btn btn-outline btn-primary btn-xs">Cancelar</label>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal editar actividad -->
   <input type="checkbox" id="modal-edita" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Editar Actividad</h3>
            <form class="form-control w-full text-sm" @submit.prevent="form2.put(route('admin.actividad-logros.update',form2.id), { onSuccess: closeModalEdita, preserveScroll:true })">
                
                <label class="label">Nombre*:</label>
                <input type="text" 
                                    class="input input-bordered input-sm w-full mt-4" 
                                    :class="{ 'input-error':form2.errors.nombre }"
                                    v-model="form2.nombre"
                                    maxlength="100">
                <div class="badge badge-warning"  v-if="form2.errors.nombre">{{ form2.errors.nombre }}</div>
                
                <label class="label">Descripción:</label>
                <input type="text" 
                                    class="input input-bordered input-sm w-full mt-4"
                                    :class="{ 'input-error':form2.errors.descripcion }"
                                    v-model="form2.descripcion"
                                    maxlength="250">
                <div class="badge badge-warning"  v-if="form2.errors.descripcion">{{ form2.errors.descripcion }}</div>

                <label class="label">Fecha*:</label>
                <input type="date" 
                                    class="input input-bordered input-sm w-full mt-4" 
                                    :class="{ 'input-error':form2.errors.fecha }"
                                    v-model="form2.fecha">
                <div class="badge badge-warning"  v-if="form2.errors.fecha">{{ form2.errors.fecha }}</div>

                <div class="modal-action">
                    <button type="submit" class="btn btn-primary btn-xs" :disabled="form2.processing">Guardar</button>
                    <label for="modal-edita" class="btn btn-outline btn-primary btn-xs">Cancelar</label>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Eliminar actividad -->
    <input type="checkbox" id="modal-elimina" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Eliminar actividad</h3>
            <p class="py-4">¿Desea eliminar la actividad "{{ dataActividad.nombre }}"?</p>
            <div class="modal-action">
                <label @click="eliminarActividad(dataActividad.id)" for="modal-elimina" class="btn">Si</label>
                <label for="modal-elimina" class="btn">No</label>
            </div>
        </div>
    </div>   

</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    logros: Object,
    estudiantes: Array,
    evaluacion: Object,
});

const form = useForm({
        nombre:'',
        descripcion:'',
        fecha:'',
        logro_id: '',
});

const form2 = useForm({
        id:'',
        nombre:'',
        descripcion:'',
        fecha:'',
        logro_id: '',
});

const dataActividad = ref({});

//Total de notas del grupo de estudiantes
const ttl_notas = (logro, actividad) => {
    let total = 0;
    let notas = [];
    props.estudiantes.forEach(estudiante => {
        //filtrar notas generales del estudiante por logro
        notas = estudiante.notas_logros.filter(notas_estudiante => (notas_estudiante.logro_id === logro.id));
        if(notas.length > 0){
            notas.forEach(nota => {
                if (props.evaluacion.evalua_actividades===1) { //Si se evalua por actividades
                    if ((nota.actividad_id === actividad.id) && (nota.nota !== null)) {
                        total++;
                    } 
                } else {  //Si se evalua por logros sin actividades
                    if ((nota.actividad_id === null) && (nota.nota !== null)) {
                        total++;
                    } 
                }
            });
        }
    });
    return total;
};

const crearActividad = (logroId) => {
    form.errors = {};
    form.nombre = '';
    form.descripcion = '';
    form.fecha = '';
    form.logro_id = logroId;
}

const editarActividad = (data) => {
    form2.errors = {};
    form2.id = data.id;
    form2.nombre = data.nombre;
    form2.descripcion = data.descripcion;
    form2.fecha = data.fecha;
    form2.logro_id = data.logro_id;
}

const eliminarActividad = (id) => {
    Inertia.delete(route('admin.actividad-logros.destroy', id));
}

const closeModalCrea = () => {
    document.getElementById('modal-crea').checked = false;    
};

const closeModalEdita = () => {
    document.getElementById('modal-edita').checked = false;    
};

</script>