<template>
    <AppLayout title="Crear Estudiante">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>                        

        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div>
                <!-- Alert si existe un estudiante en la base de datos -->
                <div v-if="estudianteExiste" class="w-96 text-sm alert alert-warning shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <div class="font-bold">Estudiante existe en la base de datos!</div>
                            <!-- Si estudiante está en la lista del año académico actual, sólo muestra mensaje -->
                            <div v-if="info_estudiante.grados.length>0">
                                <div class="text-xs"><span class="font-semibold">{{ info_estudiante.nombres + ' ' + info_estudiante.apellidos }}</span> está en la lista de estudiantes del año académico actual.</div>
                                <div class="flex justify-end">
                                    <!-- <button class="btn btn-xs" @click="estudianteExiste=false">Cerrar</button> -->
                                    <Link class="btn btn-xs mt-2" :href="route('admin.estudiantes.index')">Cerrar</Link>
                                </div>
                            </div>
                            <!-- Si el estudiante no está en la lista de estudiantes del año académico actual, puede agregarse -->
                            <div v-else>
                                <div class="text-xs">¿Agregar estudiante {{ info_estudiante.nombres + ' ' + info_estudiante.apellidos }} al año académico actual?</div>
                                <div class="flex justify-end mt-2 space-x-2">
                                    <label for="modal-agregar-estudiante" class="btn btn-xs" @click="form2.estudiante_id=info_estudiante.id">Si</label>
                                    <button class="btn btn-xs" @click="estudianteExiste=false">No</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <form class="form-control w-full max-w-sm text-sm" @submit.prevent="form.post(route('admin.estudiantes.store'))">
                
                    <div v-if="form.hasErrors" class="alert alert-info shadow-lg">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Verificar algunos campos del formulario</span>
                        </div>
                    </div>
                    
                    <div class="card w-sm bg-base-100 shadow-xl mt-3">
                        <div class="card-body">
                            <h4 class="card-title">Datos generales</h4>

                            <div class="card w-xs bg-base-100 shadow-xl mt-3">
                                <div class="card-body">
                                    <h4 class="card-title">Documento de identificación</h4>
                            
                                    <label class="label" for="documento">Número de documento*</label>
                                    <input type="text" id="documento" class="input input-sm input-bordered w-full max-w-xs"
                                                                        :class="{ 'input-error': form.errors.documento }"
                                                                        @blur="validarEstudiante"
                                                                        v-model="form.documento">
                                    <div class="badge badge-warning"  v-if="form.errors.documento">{{ form.errors.documento }}</div>

                                    <!-- Selector del tipo de documento -->
                                    <label class="label" for="tipo_documento">Tipo de documento*</label>
                                    <select class="select select-sm select-bordered"
                                            :class="{ 'select-error': form.errors.tipo_documento_id }"
                                            name="tipo_documento" 
                                            id="tipo_documento" 
                                            v-model="form.tipo_documento_id">
                                        <option disabled value="">Seleccione un tipo de documento</option>
                                        <option v-for="(documento,i) in  tipo_documentos" 
                                                :key="i"
                                                :value="documento.id"
                                        >{{  documento.nombre }}</option>
                                    </select>
                                    <div class="badge badge-warning"  v-if="form.errors.tipo_documento_id">{{ form.errors.tipo_documento_id }}</div>

                                    <!-- Selector del deparmento de expedición del documento -->
                                    <label class="label" for="dpto_exp_doc">Departamento de expedición*</label>
                                    <select class="select select-sm select-bordered"                                            
                                            name="dpto_exp_doc" 
                                            id="dpto_exp_doc"
                                            @change="() => form.exp_documento_id=''"
                                            v-model="dpto_exp_id">
                                        <option disabled value="">Seleccione un departamento</option>
                                        <option v-for="(departamento,i) in  departamentos" 
                                                :key="i" 
                                                :value="departamento.id"                                   
                                        >{{  departamento.nombre }}</option>
                                    </select>

                                    <!-- Selector del municipio de expedición del documento -->
                                    <label class="label" for="municipio_exp_doc">Municipio de expedición*</label>
                                    <select class="select select-sm select-bordered"
                                            :class="{ 'select-error': form.errors.exp_documento_id }"
                                            name="municipio_exp_doc" 
                                            id="municipio_exp_doc"
                                            v-model="form.exp_documento_id">
                                        <option disabled value="">Seleccione un municipio</option>
                                        <option v-for="(municipio,i) in  filtro_municipios_exp()"
                                                :key="i" 
                                                :value="municipio.id"
                                        >{{  municipio.nombre }}</option>                                
                                    </select>
                                    <div class="badge badge-warning"  v-if="form.errors.exp_documento_id">{{ form.errors.exp_documento_id }}</div>
                                </div>
                            </div>

                            <label class="label" for="nombres">Nombres*</label>
                            <input type="text" id="Nombres" class="input input-sm input-bordered w-full max-w-xs"
                                                            :class="{ 'input-error':form.errors.nombres }"
                                                            v-model="form.nombres">
                            <div class="badge badge-warning"  v-if="form.errors.nombres">{{ form.errors.nombres }}</div>

                            <label class="label" for="apellidos">Apellidos*</label>
                            <input type="text" id="apellidos"   class="input input-sm input-bordered w-full max-w-xs"
                                                                :class="{ 'input-error': form.errors.apellidos }"
                                                                v-model="form.apellidos">
                            <div class="badge badge-warning"  v-if="form.errors.apellidos">{{ form.errors.apellidos }}</div>

                            <!-- Selector grado del estudiante -->
                            <label class="label" for="grado">Grado*</label>
                            <select class="select select-sm select-bordered"
                                    :class="{ 'select-error': form.errors.grado_id }"
                                    name="grado" 
                                    id="grado" 
                                    v-model="form.grado_id">
                                <option disabled value="">Seleccione un grado</option>
                                <option v-for="(grado,i) in  grados" 
                                        :key="i"
                                        :value="grado.id"                                
                                >{{  grado.nombre }}</option>
                            </select>
                            <div class="badge badge-warning"  v-if="form.errors.grado_id">{{ form.errors.grado_id }}</div>
                           
                            <label class="label" for="f_nacimiento">Fecha de nacimiento*</label>
                            <input type="date" id="f_nacimiento" class="input input-sm input-bordered w-full max-w-xs"
                                                                 :class="{ 'input-error': form.errors.fecha_nacimiento }"
                                                                 v-model="form.fecha_nacimiento">
                            <div class="badge badge-warning"  v-if="form.errors.fecha_nacimiento">{{ form.errors.fecha_nacimiento }}</div>
                            
                            <!-- Selector del genero -->
                            <label class="label" for="genero">Género*</label>
                            <select class="select select-sm select-bordered"
                                    :class="{ 'select-error': form.errors.genero }"
                                    name="genero" 
                                    id="genero"
                                    v-model="form.genero">
                                <option disabled value="">Seleccione un género</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                            </select>
                            <div class="badge badge-warning"  v-if="form.errors.genero">{{ form.errors.genero }}</div>


                            <label class="label" for="direccion">Dirección*</label>
                            <input type="text" id="direccion" class="input input-sm input-bordered w-full max-w-xs"
                                                                 :class="{ 'input-error': form.errors.direccion }"
                                                                 v-model="form.direccion">
                            <div class="badge badge-warning"  v-if="form.errors.direccion">{{ form.errors.direccion }}</div>

                            <label class="label" for="barrio">Barrio</label>
                            <input type="text" id="barrio" class="input input-sm input-bordered w-full max-w-xs" v-model="form.barrio">
                            

                            <label class="label" for="telefono">teléfono</label>
                            <input type="text" id="telefono" class="input input-sm input-bordered w-full max-w-xs" v-model="form.telefono">
                            
                            <label class="label" for="celular">celular*</label>
                            <input type="text" id="celular" class="input input-sm input-bordered w-full max-w-xs"
                                                            :class="{ 'input-error': form.errors.celular }"
                                                            v-model="form.celular">
                            <div class="badge badge-warning"  v-if="form.errors.celular">{{ form.errors.celular }}</div>

                            <label class="label" for="email">email*</label>
                            <input type="email" id="email" class="input input-sm input-bordered w-full max-w-xs"
                                                            :class="{ 'input-error': form.errors.email }"
                                                            v-model="form.email">
                            <div class="badge badge-warning"  v-if="form.errors.email">{{ form.errors.email }}</div>

                            <div class="card w-xs bg-base-100 shadow-xl mt-3">
                                <div class="card-body">
                                    <h4 class="card-title">Lugar de nacimiento</h4>
                                    <!-- Selector paises -->                            
                                    <label class="label" for="pais">País*</label>
                                    <select class="select select-sm select-bordered"
                                            :class="{ 'select-error': form.errors.pais_id }"
                                            name="pais" 
                                            id="pais" 
                                            v-model="form.pais_id">
                                        <option disabled value="">Seleccione un país</option>
                                        <option v-for="(pais,i) in  paises" 
                                                :key="i"
                                                :value="pais.id"
                                        >{{  pais.nombre }}</option>
                                    </select>
                                    <div class="badge badge-warning"  v-if="form.errors.pais_id">{{ form.errors.pais_id }}</div>

                                    <!-- Selector del departamento de nacimiento -->
                                    <label class="label" for="dpto_nacimiento">Departamento de nacimiento*</label>
                                    <select class="select select-sm select-bordered"
                                            name="dpto_nacimiento" 
                                            id="dpto_nacimiento"
                                            @change="() => form.mpo_nacimiento_id=''"
                                            v-model="dpto_nacimiento_id">
                                        <option disabled value="">Seleccione un departamento</option>
                                        <option v-for="(departamento,i) in  departamentos" 
                                                :key="i" 
                                                :value="departamento.id"                                        
                                        >{{  departamento.nombre }}</option>
                                    </select>

                                    <!-- Selector del municipio de nacimiento -->
                                    <label class="label" for="municipio_nacimiento">Municipio de nacimiento*</label>
                                    <select class="select select-sm select-bordered"
                                            :class="{ 'select-error': form.errors.mpo_nacimiento_id }"
                                            name="municipio_nacimiento" 
                                            id="municipio_nacimiento"                                    
                                            v-model="form.mpo_nacimiento_id">
                                        <option disabled value="">Seleccione un municipio</option>
                                        <option v-for="(municipio,i) in  filtro_municipios_nacimiento()"
                                                :key="i" 
                                                :value="municipio.id"
                                        >{{  municipio.nombre }}</option>
                                                
                                    </select>
                                    <div class="badge badge-warning"  v-if="form.errors.mpo_nacimiento_id">{{ form.errors.mpo_nacimiento_id }}</div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card w-xs bg-base-100 shadow-xl mt-3">
                        <div class="card-body">
                            <h4 class="card-title">Ficha médica</h4>

                            <label class="label" for="eps">EPS*</label>
                            <input type="text" id="eps" class="input input-sm input-bordered w-full max-w-xs"
                                                        :class="{ 'input-error': form.errors.eps }"
                                                        v-model="form.eps">
                            <div class="badge badge-warning"  v-if="form.errors.eps">{{ form.errors.eps }}</div>

                            <label class="label" for="talla">Talla* (Metros)</label>
                            <input type="number" id="talla" class="input input-sm input-bordered w-full max-w-xs"
                                                            :class="{ 'input-error': form.errors.talla }"
                                                            step="0.01"
                                                            min="0.3"
                                                            max="2.9"
                                                            v-model="form.talla">
                            <div class="badge badge-warning"  v-if="form.errors.talla">{{ form.errors.talla }}</div>

                            <label class="label" for="peso">Peso* (Kg)</label>
                            <input type="number" id="peso" class="input input-sm input-bordered w-full max-w-xs"
                                                            :class="{ 'input-error': form.errors.peso }"
                                                            step="0.1"
                                                            min="1"
                                                            max="660"
                                                            v-model="form.peso">
                            <div class="badge badge-warning"  v-if="form.errors.peso">{{ form.errors.peso }}</div>

                            <!-- Selector del RH -->
                            <label class="label" for="rh">RH*</label>
                            <select class="select select-sm select-bordered"
                                    :class="{ 'select-error': form.errors.rh }"
                                    name="rh" 
                                    id="rh"
                                    v-model="form.rh">
                                <option disabled value="">Seleccione el RH</option>
                                <option v-for="(rh,i) in  rhs"
                                        :key="i" 
                                        :value="rh"
                                >{{ rh }}</option>                                        
                            </select>
                            <div class="badge badge-warning"  v-if="form.errors.rh">{{ form.errors.rh }}</div>

                            <label class="label" for="clinica">Clínica en caso de emergencia</label>
                            <input type="text" id="clinica" class="input input-sm input-bordered w-full max-w-xs" v-model="form.clinica">
                            
                            <label class="label" for="tel_emergencia">Teléfono en caso de emergencia*</label>
                            <input type="text" id="tel_emergencia" class="input input-sm input-bordered w-full max-w-xs"
                                                                    :class="{ 'input-error': form.errors.tel_emergencia }"
                                                                    v-model="form.tel_emergencia">
                            <div class="badge badge-warning"  v-if="form.errors.tel_emergencia">{{ form.errors.tel_emergencia }}</div>

                            <label class="label" for="alergias">Alergias</label>
                            <input type="text" id="alergias" class="input input-sm input-bordered w-full max-w-xs" v-model="form.alergias">
                            
                            <label class="label" for="observaciones">Observaciones</label>                            
                            <textarea  id="observaciones" rows="3" class="textarea textarea-bordered" v-model="form.observaciones"></textarea>

                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 mt-2">
                        <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>                                
                        <Link class="btn btn-outline btn-primary" :href="route('admin.estudiantes.index')" >Cancelar</Link>
                    </div>
                
                </form>
                
            </div>
        </div> 
    </AppLayout>

    <!-- Modal para agregar estudiante existente al año académico actual -->
    <input type="checkbox" id="modal-agregar-estudiante" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Agregar estudiante</h3>
            <form class="form-control w-full text-sm" @submit.prevent="form2.post(route('admin.estudiantes.vincular', { estudiante_id:form2.estudiante_id, grado_id:form2.grado_id }), { onSuccess: closeModal })">
                <span>Seleccione el grado del estudiante que desea agregar</span>
                <!-- Selector grado del estudiante -->
                <select class="select select-sm select-bordered text-xs mt-2"
                        :class="{ 'select-error': form2.errors.grado_id }"
                        name="grado" 
                        id="grado" 
                        v-model="form2.grado_id">
                    <option disabled value="">Seleccione un grado</option>
                    <option v-for="(grado,i) in  grados" 
                            :key="i"
                            :value="grado.id"
                    >{{  grado.nombre }}</option>
                </select>
                <div class="badge badge-warning"  v-if="form2.errors.grado_id">{{ form2.errors.grado_id }}</div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary btn-xs" :disabled="form2.processing">Agregar</button>
                    <label for="modal-agregar-estudiante" class="btn btn-outline btn-primary btn-xs">Cancelar</label>
                </div>
            </form>
        </div>
    </div>

</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({    
    paises: Array,
    departamentos: Array,
    municipios: Array,
    grados: Array,
    tipo_documentos: Array,
});

const form = useForm({
    //Datos generales del estudiante
    apellidos:'',
    nombres:'',
    grado_id:'',
    documento:'',
    tipo_documento_id:'',
    exp_documento_id:'',
    fecha_nacimiento:'',
    genero:'',
    direccion:'',
    barrio:'',
    telefono:'',
    celular:'',
    email:'',
    pais_id:43,
    mpo_nacimiento_id:'',
    //Datos de la ficha médica del estudiante
    eps:'',
    talla:'',
    peso:'',
    rh:'',
    clinica:'',
    tel_emergencia:'',
    alergias:'',    
    observaciones:''
});

const form2 = useForm({
    estudiante_id:'',
    grado_id:''
});

const title = ref('Crear Estudiante');
const dpto_exp_id = ref('');
const dpto_nacimiento_id = ref('');
const rhs = ref(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);

const estudianteExiste = ref(false);
const info_estudiante = ref({});

function filtro_municipios_nacimiento()
{       
    return props.municipios.filter(municipio => municipio.departamento_id == dpto_nacimiento_id.value);
}
 
function filtro_municipios_exp()
{       
    return props.municipios.filter(municipio => municipio.departamento_id == dpto_exp_id.value);
}

// Si el estudiante existe en la base de datos, se muestra alerta
function validarEstudiante() {
    estudianteExiste.value = false;
    if (form.documento) {
        axios.get(route('admin.estudiantes.doc', form.documento))
        .then(res => {
            if (res.data) {
                //Mostrar alerta de estudiante existente
                estudianteExiste.value = true;
                info_estudiante.value = res.data;
            }
        });
    }
}

const closeModal = () => {
    document.getElementById('modal-agregar-estudiante').checked = false;
};
</script>