<template>
    <AppLayout title="Editar Estudiante">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>                        

        <!-- DATOS DEL ESTUDIANTE -->
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <!-- DATOS GENERALES -->
            <div>
                <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.put(route('admin.estudiantes.update', form.id))">
                
                    <div class="alert alert-info shadow-lg" v-if="form.hasErrors">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Verificar algunos campos del formulario</span>
                        </div>
                    </div>
                    <div class="card w-sm bg-base-100 shadow-xl mt-3">
                        <div class="card-body">
                            <h4 class="card-title">Datos generales</h4>
                            <label class="label" for="nombres">nombres</label>
                            <input type="text" id="nombres" 
                                                class="input input-sm input-bordered w-full max-w-xs"
                                                :class="{ 'input-error':form.errors.nombres }"
                                                v-model="form.nombres">
                            <div class="badge badge-warning"  v-if="form.errors.nombres">{{ form.errors.nombres }}</div>

                            <label class="label" for="apellidos">Apellidos</label>
                            <input type="text" id="apelldos"
                                                class="input input-sm input-bordered w-full max-w-xs"
                                                :class="{ 'input-error':form.errors.apellidos }"
                                                v-model="form.apellidos">
                            <div class="badge badge-warning"  v-if="form.errors.apellidos">{{ form.errors.apellidos }}</div>
                            
                            <!-- Selector grado del estudiante -->
                            <label class="label" for="grado">Grado</label>
                            <select class="select select-sm select-bordered"
                                    :class="{ 'select-error':form.errors.grado_id }"
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

                            <div class="card w-xs bg-base-100 shadow-xl mt-3">
                                <div class="card-body">
                                    <h4 class="card-title">Documento de identificación</h4>
                            
                                    <label class="label" for="documento">Número de documento</label>
                                    <input type="text" id="documento"
                                                        class="input input-sm input-bordered w-full max-w-xs"
                                                        :class="{ 'input-error':form.errors.documento }"
                                                        v-model="form.documento">
                                    <div class="badge badge-warning"  v-if="form.errors.documento">{{ form.errors.documento }}</div>

                                    <!-- Selector del tipo de documento -->
                                    <label class="label" for="tipo_documento">Tipo de documento</label>
                                    <select class="select select-sm select-bordered"
                                            :class="{ 'select-error':form.errors.tipo_documento_id }"
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
                                    <label class="label" for="dpto_exp_doc">Departamento de expedición</label>
                                    <select class="select select-sm select-bordered"
                                            name="dpto_exp_doc" 
                                            id="dpto_exp_doc"
                                            @change="() => form.exp_documento_id=''"
                                            v-model="form.municipio_doc.departamento_id">
                                        <option disabled value="">Seleccione un departamento</option>
                                        <option v-for="(departamento,i) in  departamentos"
                                                :key="i" 
                                                :value="departamento.id"                                   
                                        >{{  departamento.nombre }}</option>
                                    </select>

                                    <!-- Selector del municipio de expedición del documento -->
                                    <label class="label" for="municipio_exp_doc">Municipio de expedición</label>
                                    <select class="select select-sm select-bordered"
                                            :class="{ 'select-error':form.errors.exp_documento_id }"
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

                            <label class="label" for="f_nacimiento">Fecha de nacimiento</label>
                            <input type="date" id="f_nacimiento"
                                                class="input input-sm input-bordered w-full max-w-xs"
                                                :class="{ 'input-error':form.errors.fecha_nacimiento }"
                                                v-model="form.fecha_nacimiento">
                            <div class="badge badge-warning"  v-if="form.errors.fecha_nacimiento">{{ form.errors.fecha_nacimiento }}</div>
                            
                            <!-- Selector del genero -->
                            <label class="label" for="genero">Género</label>
                            <select class="select select-sm select-bordered"
                                    :class="{ 'select-error':form.errors.genero }"
                                    name="genero" 
                                    id="genero"
                                    v-model="form.genero">
                                <option disabled value="">Seleccione un género</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                            </select>
                            <div class="badge badge-warning"  v-if="form.errors.genero">{{ form.errors.genero }}</div>

                            <label class="label" for="direccion">Dirección</label>
                            <input type="text" id="direccion"
                                                class="input input-sm input-bordered w-full max-w-xs"
                                                :class="{ 'input-error':form.errors.direccion }"
                                                v-model="form.direccion">
                            <div class="badge badge-warning"  v-if="form.errors.direccion">{{ form.errors.direccion }}</div>

                            <label class="label" for="barrio">Barrio</label>
                            <input type="text" id="barrio" class="input input-sm input-bordered w-full max-w-xs" v-model="form.barrio">

                            <label class="label" for="telefono">teléfono</label>
                            <input type="text" id="telefono" class="input input-sm input-bordered w-full max-w-xs" v-model="form.telefono">
                            
                            <label class="label" for="celular">celular</label>
                            <input type="text" id="celular"
                                                class="input input-sm input-bordered w-full max-w-xs"
                                                :class="{ 'input-error':form.errors.celular }"
                                                v-model="form.celular">
                            <div class="badge badge-warning"  v-if="form.errors.celular">{{ form.errors.celular }}</div>

                            <label class="label" for="email">email</label>
                            <input type="email" id="email"
                                                class="input input-sm input-bordered w-full max-w-xs"
                                                :class="{ 'input-error':form.errors.email }"
                                                v-model="form.email">
                            <div class="badge badge-warning"  v-if="form.errors.email">{{ form.errors.email }}</div>

                            <div class="card w-xs bg-base-100 shadow-xl mt-3">
                                <div class="card-body">
                                    <h4 class="card-title">Lugar de nacimiento</h4>
                                    <!-- Selector paises -->                            
                                    <label class="label" for="pais">País</label>
                                    <select class="select select-sm select-bordered"
                                            :class="{ 'select-error':form.errors.pais_id }"
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
                                    <label class="label" for="dpto_nacimiento">Departamento de nacimiento</label>
                                    <select class="select select-sm select-bordered"
                                            name="dpto_nacimiento" 
                                            id="dpto_nacimiento"
                                            @change="() => form.mpo_nacimiento_id=''"
                                            v-model="form.municipio_nacimiento.departamento_id">
                                        <option disabled value="">Seleccione un departamento</option>
                                        <option v-for="(departamento,i) in  departamentos" 
                                                :key="i" 
                                                :value="departamento.id"                                        
                                        >{{  departamento.nombre }}</option>
                                    </select>

                                    <!-- Selector del municipio de nacimiento -->
                                    <label class="label" for="municipio_nacimiento">Municipio de nacimiento</label>
                                    <select class="select select-sm select-bordered"
                                            :class="{ 'select-error':form.errors.mpo_nacimiento_id }"
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
                            <input type="text" id="eps"
                                                class="input input-sm input-bordered w-full max-w-xs"
                                                :class="{ 'input-error':form.errors.eps }"
                                                v-model="form.eps">
                            <div class="badge badge-warning"  v-if="form.errors.eps">{{ form.errors.eps }}</div>

                            <label class="label" for="talla">Talla* (Metros)</label>
                            <input type="number" id="talla"
                                                    class="input input-sm input-bordered w-full max-w-xs"
                                                    :class="{ 'input-error':form.errors.talla }"
                                                    step="0.01"
                                                    min="0.3"
                                                    max="2.9"
                                                    v-model="form.talla">
                            <div class="badge badge-warning"  v-if="form.errors.talla">{{ form.errors.talla }}</div>

                            <label class="label" for="peso">Peso* (Kg)</label>
                            <input type="number" id="peso"
                                                    class="input input-sm input-bordered w-full max-w-xs"
                                                    :class="{ 'input-error':form.errors.peso }"
                                                    step="0.1"
                                                    min="0.3"
                                                    max="660"
                                                    v-model="form.peso">
                            <div class="badge badge-warning"  v-if="form.errors.peso">{{ form.errors.peso }}</div>

                            <!-- Selector del RH -->
                            <label class="label" for="rh">RH*</label>
                            <select class="select select-sm select-bordered"
                                    :class="{ 'select-error':form.errors.rh }"
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
                            <input type="text" id="tel_emergencia"
                                                class="input input-sm input-bordered w-full max-w-xs"
                                                :class="{ 'input-error':form.errors.tel_emergencia }"
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
</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props = defineProps({
    estudiante: Object,
    paises: Array,
    departamentos: Array,
    municipios: Array,
    grados: Array,
    tipo_documentos: Array,
});

const rhs = ref(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);

const form = useForm ({
    id: props.estudiante.id,
    nombres: props.estudiante.nombres,
    apellidos: props.estudiante.apellidos,
    grado_id: props.estudiante.grados[0].id,
    documento: props.estudiante.documento,
    tipo_documento_id: props.estudiante.tipo_documento_id,
    exp_documento_id: props.estudiante.exp_documento_id,
    municipio_nacimiento: props.estudiante.municipio_nacimiento,
    municipio_doc: props.estudiante.municipio_doc,
    fecha_nacimiento: props.estudiante.fecha_nacimiento,
    genero: props.estudiante.genero,
    direccion: props.estudiante.direccion,
    barrio: props.estudiante.barrio,
    telefono: props.estudiante.telefono,
    celular: props.estudiante.celular,
    email: props.estudiante.user.email,
    pais_id: props.estudiante.pais_id,
    mpo_nacimiento_id: props.estudiante.mpo_nacimiento_id,
    eps: props.estudiante.eps,
    talla: props.estudiante.talla,
    peso: props.estudiante.peso,
    rh: props.estudiante.rh,
    clinica: props.estudiante.clinica,
    tel_emergencia: props.estudiante.tel_emergencia,
    alergias: props.estudiante.alergias,
    observaciones: props.estudiante.observaciones,
    user_id: props.estudiante.user_id,
    grado_old: props.estudiante.grados[0].id,
})
const title = ref('Editar Estudiante');

function filtro_municipios_nacimiento()
{       
    return props.municipios.filter(municipio => municipio.departamento_id == form.municipio_nacimiento.departamento_id);
}
 
function filtro_municipios_exp()
{       
    return props.municipios.filter(municipio => municipio.departamento_id == form.municipio_doc.departamento_id);
}   
</script>