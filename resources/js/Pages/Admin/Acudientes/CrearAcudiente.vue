<template>
<div class="card w-xs bg-base-100 shadow-xl">
    <div class="card-body">
        <h2 class="card-title">Nuevo acudiente</h2>
        
        <div class="flex flex-col items-center">
            <div>
                <!-- Alert si existe un acudiente en la base de datos -->
                <div v-if="acudienteExiste" class="form-control w-full max-w-xs text-sm alert alert-info shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <div class="font-bold">Acudiente existe en la base de datos!</div>
                            <div class="text-xs">¿Agregar acudiente {{ info_acudiente.nombres + ' ' + info_acudiente.apellidos }}?</div>
                            <div class="mt-2 space-x-2">
                                <button class="btn btn-xs" @click="AgregaAcudienteExistente">Si</button>
                                <button class="btn btn-xs" @click="ocultar">No</button>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.post(route('admin.acudientes.store'),{ onSuccess: ocultar })">
                  
                    <!-- Mensaje si hay error en el formulario -->
                    <div class="alert alert-info shadow-lg" v-if="form.hasErrors">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Verificar algunos campos del formulario</span>
                        </div>
                    </div>

                    <!-- DATOS GENERALES -->
                    <div class="card w-xs bg-base-100 shadow-xl mt-3">
                        <div class="card-body">                                                

                            <label class="label" for="documento">Número de documento*</label>
                            <input type="text" 
                                   id="documento"
                                   class="input input-sm input-bordered w-full max-w-xs"
                                   :class="{ 'input-error':form.errors.documento }"
                                   @blur="validarAcudiente"
                                   v-model="form.documento">
                            <div class="badge badge-warning"  v-if="form.errors.documento">{{ form.errors.documento }}</div>

                            <!-- Selector del tipo de documento -->
                            <label class="label" for="tipo_documento">Tipo de documento*</label>
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
                        </div>
                    </div>
                    
                    <label class="label" for="nombres">Nombres*</label>
                    <input type="text"  id="Nombres" 
                                        class="input input-sm input-bordered w-full max-w-xs"
                                        :class="{ 'input-error':form.errors.nombres }"
                                        v-model="form.nombres">
                    <div class="badge badge-warning"  v-if="form.errors.nombres">{{ form.errors.nombres }}</div>

                    <label class="label" for="apellidos">Apellidos*</label>
                    <input type="text" id="apellidos" 
                                        class="input input-sm input-bordered w-full max-w-xs"
                                        :class="{ 'input-error':form.errors.apellidos }"
                                        v-model="form.apellidos">
                    <div class="badge badge-warning"  v-if="form.errors.apellidos">{{ form.errors.apellidos }}</div>

                    <!-- Selector del parentesco -->
                    <label class="label" for="parentesco">Parentesco*</label>
                    <select class="select select-sm select-bordered"
                            :class="{ 'select-error':form.errors.parentesco_id }"
                            name="parentesco"
                            id="parentesco" 
                            v-model="form.parentesco_id">
                        <option disabled value="">Seleccione un parentesco</option>
                        <option v-for="(parentesco,i) in  parentescos" 
                                :key="i"
                                :value="parentesco.id"                                
                        >{{  parentesco.nombre }}</option>
                    </select>
                    <div class="badge badge-warning"  v-if="form.errors.parentesco_id">{{ form.errors.parentesco_id }}</div>                    

                    <label class="label" for="f_nacimiento">Fecha de nacimiento*</label>
                    <input type="date" id="f_nacimiento" 
                                        class="input input-sm input-bordered w-full max-w-xs"
                                        :class="{ 'input-error':form.errors.fecha_nacimiento }"
                                        v-model="form.fecha_nacimiento">
                    <div class="badge badge-warning"  v-if="form.errors.fecha_nacimiento">{{ form.errors.fecha_nacimiento }}</div>

                    <!-- Selector paises -->                            
                    <label class="label" for="pais">País de nacimiento*</label>
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
                                        
                    <label class="label" for="direccion">Dirección*</label>
                    <input type="text" id="direccion" 
                                        class="input input-sm input-bordered w-full max-w-xs"
                                        :class="{ 'input-error':form.errors.direccion }"
                                        v-model="form.direccion">
                    <div class="badge badge-warning"  v-if="form.errors.direccion">{{ form.errors.direccion }}</div>

                    <label class="label" for="barrio">Barrio</label>
                    <input type="text" id="barrio" class="input input-sm input-bordered w-full max-w-xs" v-model="form.barrio">
                    
                    <label class="label" for="telefono">teléfono</label>
                    <input type="text" id="telefono" class="input input-sm input-bordered w-full max-w-xs" v-model="form.telefono">
                    
                    <label class="label" for="celular">celular*</label>
                    <input type="text" id="celular" 
                                        class="input input-sm input-bordered w-full max-w-xs" 
                                        :class="{ 'input-error':form.errors.celular }"
                                        v-model="form.celular">
                    <div class="badge badge-warning"  v-if="form.errors.celular">{{ form.errors.celular }}</div>

                    <label class="label" for="email">email*</label>
                    <input type="email" id="email" 
                                        class="input input-sm input-bordered w-full max-w-xs" 
                                        :class="{ 'input-error':form.errors.email }"
                                        v-model="form.email">
                    <div class="badge badge-warning"  v-if="form.errors.email">{{ form.errors.email }}</div>
                    
                    <label class="label" for="profesion">Profesión*</label>
                    <input type="text" id="profesion" 
                                        class="input input-sm input-bordered w-full max-w-xs" 
                                        :class="{ 'input-error':form.errors.profesion }"
                                        v-model="form.profesion">
                    <div class="badge badge-warning"  v-if="form.errors.profesion">{{ form.errors.profesion }}</div>

                    <label class="label" for="cargo">Cargo</label>
                    <input type="text" id="cargo" 
                                        class="input input-sm input-bordered w-full max-w-xs"
                                        :class="{ 'input-error':form.errors.cargo }"
                                        v-model="form.cargo">
                    <div class="badge badge-warning"  v-if="form.errors.cargo">{{ form.errors.cargo }}</div>

                    <label class="label" for="empresa">Empresa</label>
                    <input type="text" id="empresa" 
                                        class="input input-sm input-bordered w-full max-w-xs"
                                        :class="{ 'input-error':form.errors.empresa }"
                                        v-model="form.empresa">
                    <div class="badge badge-warning"  v-if="form.errors.empresa">{{ form.errors.empresa }}</div>

                    <label class="label" for="tel_empresa">Teléfono empresa</label>
                    <input type="text" id="tel_empresa"
                                        class="input input-sm input-bordered w-full max-w-xs"
                                        :class="{ 'input-error':form.errors.tel_empresa }"
                                        v-model="form.tel_empresa">
                    <div class="badge badge-warning"  v-if="form.errors.tel_empresa">{{ form.errors.tel_empresa }}</div>

                    <div class="flex justify-end space-x-2 mt-2">
                        <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                        <a class="btn btn-outline btn-primary" @click="ocultar">Cancelar</a>
                    </div>                
                </form>                
            </div>            
        </div>        
   </div>
</div>    
</template>


<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { inject, ref } from 'vue';
import axios from 'axios';

const props = defineProps({    
    paises: Array,    
    parentescos: Array,
    tipo_documentos: Array,
    estudiante_id: Number,
});

const show = inject('show');

const ocultar = () => {
    show.value.lista_acudientes = true;
    show.value.crear_acudiente = false;
};

const form = useForm({
    apellidos:'',
    nombres:'',
    parentesco_id:'',
    documento:'',
    tipo_documento_id:'',
    fecha_nacimiento:'',
    pais_id:43,
    direccion:'',
    barrio:'',
    telefono:'',
    celular:'',
    email:'',
    profesion: '',
    cargo: '',
    empresa: '',
    tel_empresa: '',
    estudianteId: props.estudiante_id
});

const info_acudiente = ref({
    documento:'',
    nombres:'',
    apellidos:''
});

const acudienteExiste = ref(false);

// Si el acudiente existe en la base de datos, se muestra alerta para agregarlo a la lista de acudientes
function validarAcudiente() {
    acudienteExiste.value = false;
    if (form.documento) {
        axios.get(route('admin.acudientes.doc', form.documento))
        .then(res => {            
            if (res.data) { 
                //Mostrar alerta de acudiente existente
                acudienteExiste.value = true;
                info_acudiente.value.documento = res.data.documento;
                info_acudiente.value.nombres = res.data.nombres;
                info_acudiente.value.apellidos = res.data.apellidos;
            }
        });
    }
}

function AgregaAcudienteExistente() {
    ocultar();
    Inertia.post(route('admin.acudientes.vincular', { doc: info_acudiente.value.documento, estudiante: props.estudiante_id } ));
}

</script>