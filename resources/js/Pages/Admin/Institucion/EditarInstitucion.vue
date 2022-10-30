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
                    <div class="card w-xs bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title">Editar datos institución</h2>        
                            
                            <div class="flex flex-col items-center">
                                <div>                
                                    <!--Se usa método POST en la actualización, ya que es necesario en Inertia para poder subir la imagen del logo-->
                                    <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.post(route('admin.institucion.update'))">
                                        
                                        <label class="label" for="nombre">Nombre*</label>
                                        <input type="text" id="nombre" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.nombre }" v-model="form.nombre">
                                        <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

                                        <label class="label" for="logo">Logo</label>
                                        <img class="rounded-full h-20 w-20" id="logo" :src="verImagen" alt="Logo institución">
                                        
                                        <input class="mt-2 block w-full text-sm text-slate-500
                                                    file:mr-4 file:py-2 file:px-4
                                                    file:rounded-full file:border-0
                                                    file:text-sm file:font-semibold
                                                    file:bg-violet-50 file:text-violet-700
                                                    hover:file:bg-violet-100"
                                                type="file" 
                                                @input="form.logo = $event.target.files[0]" />
                                        <progress v-if="form.progress" class="progress w-56" :value="form.progress.percentage" max="100">
                                        {{ form.progress.percentage }}%
                                        </progress>
                                        <div class="badge badge-warning"  v-if="form.errors.logo">{{ form.errors.logo }}</div>

                                        <label class="label" for="slogan">Slogan</label>
                                        <input type="text" id="slogan" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.slogan }" v-model="form.slogan">
                                        <div class="badge badge-warning"  v-if="form.errors.slogan">{{ form.errors.slogan }}</div>

                                        <label class="label" for="descripcion">Descripción</label>
                                        <input type="text" id="descripcion" class="input input-sm input-bordered w-full max-w-xs" v-model="form.descripcion">
                                        <div class="badge badge-warning"  v-if="form.errors.descripcion">{{ form.errors.descripcion }}</div>

                                        <label class="label" for="resolucion">Resolución</label>
                                        <input type="text" id="resolucion" class="input input-sm input-bordered w-full max-w-xs" v-model="form.resolucion">
                                        <div class="badge badge-warning"  v-if="form.errors.resolucion">{{ form.errors.resolucion }}</div>
                                                                                
                                        <label class="label" for="direccion">Dirección*</label>
                                        <input type="text" id="direccion" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.direccion }" v-model="form.direccion">
                                        <div class="badge badge-warning"  v-if="form.errors.direccion">{{ form.errors.direccion }}</div>

                                        <label class="label" for="telefono">Teléfono*</label>
                                        <input type="text" id="telefono" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.telefono }" v-model="form.telefono">
                                        <div class="badge badge-warning"  v-if="form.errors.telefono">{{ form.errors.telefono }}</div>

                                        <label class="label" for="email">Email*</label>
                                        <input type="email" id="email" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.email }" v-model="form.email">
                                        <div class="badge badge-warning"  v-if="form.errors.email">{{ form.errors.email }}</div>

                                        <label class="label" for="rector">Rector*</label>
                                        <input type="text" id="rector" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.rector }" v-model="form.rector">
                                        <div class="badge badge-warning"  v-if="form.errors.rector">{{ form.errors.rector }}</div>

                                        <label class="label" for="web">Web</label>
                                        <input type="text" id="web" class="input input-sm input-bordered w-full max-w-xs" v-model="form.web">
                                        <div class="badge badge-warning"  v-if="form.errors.web">{{ form.errors.web }}</div>
                                                                        
                                        <div class="flex justify-end space-x-2 mt-2">
                                            <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                            <Link :href="route('admin.institucion.show')" class="btn btn-outline btn-primary">Cancelar</Link>
                                            
                                        </div>               
                                    </form>                
                                </div>
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
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { ref } from '@vue/reactivity';

const props = defineProps({
    institucion: Object,
});

const title = ref('Editar información ' + props.institucion.nombre);
const form = useForm({
    _method: 'PUT',
    nombre: props.institucion.nombre,
    slogan: props.institucion.slogan,
    descripcion: props.institucion.descripcion,
    resolucion: props.institucion.resolucion,
    direccion: props.institucion.direccion,
    telefono: props.institucion.telefono,
    email: props.institucion.email,
    rector: props.institucion.rector,
    web: props.institucion.web,
    logo: null,
});

// Se modifica la url del logo para que se pueda ver la nueva imagen sin problema de caché 
const verImagen = ref(props.institucion.logo + '?t=' +  new Date().getTime());

</script>