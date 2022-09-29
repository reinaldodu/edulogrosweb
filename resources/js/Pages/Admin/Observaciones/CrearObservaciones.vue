<template>
    <div class="flex ml-4 mt-4">        
        <!-- Botón para agregar observacion -->
        <div v-if="!ocultaAgregarObservacion">
            <div class="tooltip" data-tip="Agregar observacion">
                <button class="btn btn-sm btn-circle mt-2 mr-5" @click="agregaObservacion">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /> </svg>
                </button>
            </div>
            <!-- Botón para pegar observaciones -->
            <div class="tooltip" data-tip="Pegar observaciones">
                <label for="modal-pegar" class="btn btn-sm btn-circle mt-2 mr-5" @click="limpiaForm2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                    </svg>
                </label>
            </div>

        </div>
        <!-- Form para guardar observación -->
        <div v-if="ocultaAgregarObservacion" class="mt-5">
            <form @submit.prevent="form.post(route('admin.observaciones.store', { grupo:grupo, asignatura:asignatura }), { onSuccess: () => form.observacion='' })">
                <!-- Selector tipos de observación -->
                <select class="select select-sm select-bordered mr-4"
                        :class="{ 'select-error': form.errors.tipo_id }"
                        name="tipo" 
                        id="tipo" 
                        v-model="form.tipo_id">
                    <option disabled value="">Tipo</option>
                    <option v-for="(tipo) in  tipos"
                            :key="tipo.id"
                            :value="tipo.id"                                
                    >{{  tipo.nombre }}</option>
                </select>
                <div class="badge badge-warning"  v-if="form.errors.tipo_id">{{ form.errors.tipo_id }}</div>
                
                <input type="text" class="input input-sm w-96 mr-2" 
                                    :class="{ 'input-error':form.errors.observacion }"
                                    v-model="form.observacion"
                                    maxlength="300"
                                    placeholder="Escriba su nueva observacion" >
                <div class="badge badge-warning"  v-if="form.errors.observacion">{{ form.errors.observacion }}</div>
                <button type="submit" class="btn btn-sm mr-2" :disabled="form.processing">Guardar</button>
                <button class="btn btn-sm" @click.prevent="ocultaAgregarObservacion=false">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Modal para pegar observaciones -->
    <input type="checkbox" id="modal-pegar" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Pegar observaciones</h3>
            <form class="form-control w-full text-sm" @submit.prevent="form2.post(route('admin.observaciones.store', { grupo:grupo, asignatura:asignatura }), { onSuccess: closeModal })">
                
                <!-- Selector tipos de observación -->
                <select class="select select-sm select-bordered mt-2"
                        :class="{ 'select-error': form2.errors.tipo_id }"
                        name="tipo" 
                        id="tipo" 
                        v-model="form2.tipo_id">
                    <option disabled value="">Tipo</option>
                    <option v-for="(tipo) in  tipos"
                            :key="tipo.id"
                            :value="tipo.id"                                
                    >{{  tipo.nombre }}</option>
                </select>
                <div class="badge badge-warning"  v-if="form2.errors.tipo_id">{{ form2.errors.tipo_id }}</div>
                
                <textarea type="text" class="textarea textarea-bordered mt-4" 
                                    :class="{ 'input-error':form2.errors.observacion }"
                                    v-model="form2.observacion"
                                    rows="5"
                                    placeholder="Pegue aquí sus observaciones"
                                    ></textarea>
                <div class="badge badge-warning"  v-if="form2.errors.observacion">{{ form2.errors.observacion }}</div>
                <!-- Check para eliminar y reemplazar las observaciones existentes por tipo  -->
                <div v-if="observaciones_estudiantes.length === 0" class="flex mt-2 items-center">
                    <span class="text-xs mr-2">Eliminar y reemplazar las observaciones existentes de este tipo</span>
                    <input type="checkbox" class="checkbox checkbox-xs" v-model="form2.check_delete" /> 
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary btn-xs" :disabled="form2.processing">Guardar</button>
                    <label for="modal-pegar" class="btn btn-outline btn-primary btn-xs">Cancelar</label>
                </div>
            </form>
        </div>
    </div>

</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { inject } from 'vue';

const props = defineProps({
    tipos: Array,
    grupo: Number,
    asignatura: Number,
    observaciones_estudiantes: Array,
});

const ocultaAgregarObservacion = inject('ocultaAgregarObservacion');

//Formulario para agregar una observación
const form = useForm({
    observacion: '',
    tipo_id: '',
});

//Formulario para pegar observaciones
const form2 = useForm({
    observacion: '',
    tipo_id: '',
    check_delete: false,
});

const agregaObservacion = () => {
    ocultaAgregarObservacion.value = true;
    //Limpiar form
    form.observacion='';
    form.tipo_id='';
    //Borrar errores
    form.errors.tipo_id='';
    form.errors.observacion='';    
}

const limpiaForm2 = () => {
    //Limpiar form
    form2.observacion='';
    form2.tipo_id='';
    form2.check_delete=false;
    //Borrar errores
    form2.errors.tipo_id='';
    form2.errors.observacion='';
}

const closeModal = () => {
    document.getElementById('modal-pegar').checked = false;
};

</script>