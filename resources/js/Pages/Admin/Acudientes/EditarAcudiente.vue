<template>
<div class="card w-ws bg-base-100 shadow-xl">
    <div class="card-body">
        <h2 class="card-title">Editar acudiente</h2>        
        
        <div class="flex flex-col items-center">
            <!-- DATOS GENERALES -->
            <div>
                <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.put(route('admin.acudientes.update', form.id),{ onSuccess: ocultar })">
                
                    <div class="alert alert-info shadow-lg" v-if="form.hasErrors">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Verificar algunos campos del formulario</span>
                        </div>
                    </div>
                    
                    <label class="label" for="nombres">Nombres</label>
                    <input type="text" id="Nombres" 
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

                    <!-- Selector del parentesco -->
                    <label class="label" for="parentesco">Parentesco</label>
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
                        </div>
                    </div>

                    <label class="label" for="f_nacimiento">Fecha de nacimiento</label>
                    <input type="date" id="f_nacimiento" 
                                        class="input input-sm input-bordered w-full max-w-xs"
                                        :class="{ 'input-error':form.errors.fecha_nacimiento }"
                                        v-model="form.fecha_nacimiento">
                    <div class="badge badge-warning"  v-if="form.errors.fecha_nacimiento">{{ form.errors.fecha_nacimiento }}</div>

                    <!-- Selector paises -->                            
                    <label class="label" for="pais">País de nacimiento</label>
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
                    
                    <label class="label" for="email">Email</label>
                    <input type="text" id="email" 
                                        class="input input-sm input-bordered w-full max-w-xs"
                                        :class="{ 'input-error':form.errors.email }"
                                        v-model="form.email">
                    <div class="badge badge-warning"  v-if="form.errors.email">{{ form.errors.email }}</div>
                    
                    <label class="label" for="celular">celular</label>
                    <input type="text" id="celular" 
                                        class="input input-sm input-bordered w-full max-w-xs"
                                        :class="{ 'input-error':form.errors.celular }"
                                        v-model="form.celular">
                    <div class="badge badge-warning"  v-if="form.errors.celular">{{ form.errors.celular }}</div>
                                       
                    <label class="label" for="profesion">Profesión</label>
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

                    <div class="flex justify-end space-x-2 mt-5">
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
import { inject } from 'vue';

const props = defineProps({    
    paises: Array,    
    tipo_documentos: Array,
    parentescos: Array,
});

const show = inject('show');
const acudiente = inject('acudiente');

const ocultar = () => {
    show.value.lista_acudientes = true;
    show.value.editar_acudiente = false;
};

// agregar datos al form para editar
const form = useForm({
    id: acudiente.value.id,
    apellidos:acudiente.value.apellidos,
    nombres:acudiente.value.nombres,
    parentesco_id:acudiente.value.parentesco_id,
    documento:acudiente.value.documento,
    tipo_documento_id:acudiente.value.tipo_documento_id,
    fecha_nacimiento:acudiente.value.fecha_nacimiento,
    pais_id:acudiente.value.pais_id,
    direccion:acudiente.value.direccion,
    barrio:acudiente.value.barrio,
    telefono:acudiente.value.telefono,
    celular:acudiente.value.celular,
    email:acudiente.value.user.email,
    profesion:acudiente.value.profesion,
    cargo:acudiente.value.cargo,
    empresa:acudiente.value.empresa,
    tel_empresa:acudiente.value.tel_empresa,
    user_id:acudiente.value.user_id
});

</script>