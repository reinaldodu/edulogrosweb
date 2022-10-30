<template>
    <AppLayout title="Editar datos institución">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">            
            <div class="flex">
                <div>
                    <div class="card w-96 bg-base-100 shadow-xl">        
                        <figure class="mt-5">
                            <img :src="verImagen" :alt="'Logo ' + institucion.nombre" class="rounded-full h-32 w-32" />
                        </figure>
                        <div class="card-body">            
                            <h2 class="card-title justify-center">{{ institucion.nombre }}</h2>
                            <p><span class="font-semibold">Slogan:</span> {{ institucion.slogan }}</p>
                            <p><span class="font-semibold">Descripcion:</span> {{ institucion.descripcion }}</p>
                            <p><span class="font-semibold">Resolucion:</span> {{ institucion.resolucion }}</p>                            
                            <p><span class="font-semibold">Dirección:</span> {{ institucion.direccion }}</p>
                            <p><span class="font-semibold">Teléfono:</span> {{ institucion.telefono }}</p>
                            <p><span class="font-semibold">Email:</span> {{ institucion.email }}</p>
                            <p><span class="font-semibold">Rector:</span> {{ institucion.rector }}</p>
                            <p><span class="font-semibold">Web:</span> {{ institucion.web }}</p>
                            <div class="card-actions justify-end">                        
                                <Link :href="route('admin.institucion.edit')" class="btn btn-xs btn-outline btn-primary rounded-full mt-2">Editar datos</Link>
                            </div>
                        </div>              
                    </div>      
                </div>                
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from '@vue/reactivity';

const title = ref('Datos de la institución');

const props = defineProps({
    institucion: Object,
});

// Se modifica la url del logo para que se pueda ver la nueva imagen sin problema de caché 
const verImagen = ref(props.institucion.logo + '?t=' +  new Date().getTime());

</script>