<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="flex justify-center mt-5">
            <div class="card w-96 bg-base-100 shadow-xl">
                <div class="card-actions justify-end mr-5 mt-5">
                        <Link class="btn btn-square btn-sm" :href="route('admin.profesores.index')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </Link>
                    </div>
                <figure class="px-10">
                    <img :src="profesor.foto" alt="foto" class="w-32 rounded-full" />
                </figure>
                <div class="card-body">            
                    <h2 class="card-title justify-center">{{ profesor.nombres + ' ' + profesor.apellidos }}</h2>      
                    <p><span class="font-semibold">Documento:</span> {{ profesor.tipo_documento.abreviatura + ' ' + 
                                        profesor.documento }}</p>
                    <p><span class="font-semibold">Fecha de nacimiento:</span> {{ profesor.fecha_nacimiento }} <span class="badge badge-xs text-xs">{{ profesor.edad }} años</span></p>
                    <p><span class="font-semibold">Nacionalidad:</span> {{ profesor.pais.gentilicio }}</p>
                    <p><span class="font-semibold">Email:</span> {{ profesor.user.email }}</p>
                    <p><span class="font-semibold">Teléfono:</span> {{ profesor.telefono }}</p>
                    <p><span class="font-semibold">Celular:</span> {{ profesor.celular }}</p>
                    <p><span class="font-semibold">Dirección:</span> {{ profesor.direccion }}</p>
                    <p><span class="font-semibold">Profesión:</span> {{ profesor.profesion }}</p>
                    <p><span class="font-semibold">Cargo:</span> {{ profesor.cargo }}</p>            
                </div>              
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const title = ref('Consultar Profesor');

const props = defineProps({
    profesor: Object,
    paises: Array,    
    tipo_documentos: Array,
});

</script>