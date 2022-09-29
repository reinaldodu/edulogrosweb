<template>
    <div class="overflow-y-auto block h-96 m-5">
        <table v-if="observaciones.length>0" class="table table-compact table-zebra w-full">
            <thead class="sticky top-0">
                <tr>
                    <th class="w-5"></th>
                    <th class="w-5">Tipo</th>
                    <th>Observaciones
                        <!-- Activar edicion de Observaciones -->
                        <div class="tooltip tooltip-right capitalize" :data-tip="[ activarEdicion ? 'Desactivar edición' : 'Activar edición' ]">
                            <button class="btn btn-ghost btn-xs" @click="activarEdicion=!activarEdicion">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-sm">
                <tr v-for="(observacion,i) in  observaciones" :key="i">
                        <td>{{ i+1 }}</td>
                        <td>{{ observacion.tipo.abreviatura }}</td>
                    <td class="whitespace-normal">{{ observacion.observacion }}</td>
                    <td>
                        <div v-show="activarEdicion" class="flex justify-end space-x-2">
                            <!-- Botón Editar -->
                            <div class="tooltip tooltip-left" :data-tip="'Editar observacion ' + (i+1) ">
                                <label for="modal-edita" @click="edita_observacion(observacion)" class="btn btn-ghost btn-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </label>
                            </div>
                            <!-- Botón Eliminar -->

                            <div v-if="!verificaObservacion(observacion.id)" class="tooltip tooltip-left" :data-tip="'Eliminar observacion ' + (i+1) ">
                                <label for="modal-elimina" @click="observacion_num=i+1; observacion_id=observacion.id" class="btn btn-ghost btn-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>    

    <!-- Modal editar observacion -->
    <input type="checkbox" id="modal-edita" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Editar observacion</h3>
            <form class="form-control w-full text-sm" @submit.prevent="form.put(route('admin.observaciones.update', form.id), { onSuccess: closeModal })">
                
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
                
                <input type="text" class="input input-bordered input-sm w-full mt-4" 
                                    :class="{ 'input-error':form.errors.observacion }"
                                    v-model="form.observacion"
                                    maxlength="300">
                <div class="badge badge-warning"  v-if="form.errors.observacion">{{ form.errors.observacion }}</div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary btn-xs" :disabled="form.processing">Guardar</button>
                    <label for="modal-edita" class="btn btn-outline btn-primary btn-xs">Cancelar</label>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Eliminar observacion -->
    <input type="checkbox" id="modal-elimina" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Eliminar observacion</h3>
            <p class="py-4">¿Desea eliminar la observacion #{{ observacion_num }}?</p>
            <div class="modal-action">
                <label @click="elimina_observacion(observacion_id)" for="modal-elimina" class="btn">Si</label>
                <label for="modal-elimina" class="btn">No</label>
            </div>
        </div>
    </div>   
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props = defineProps({
    observaciones: Array,
    observaciones_estudiantes: Array,
    tipos: Array,
});

const activarEdicion = ref(false);
const observacion_num = ref(0);
const observacion_id= ref(0);

const form = useForm({
    id: null,
    observacion: '',
    tipo_id: null,
});

function edita_observacion(data)
{
    form.id = data.id;
    form.observacion = data.observacion;
    form.tipo_id = data.tipo_id;
    form.errors.observacion = null;
    form.errors.tipo_id = null;
}

// Validar si el id de la observacion existe en la tabla de observacion_estudiantes para evitar eliminarla
const verificaObservacion = (id) => {
    return props.observaciones_estudiantes.some(observacion_estudiante => observacion_estudiante.id == id);
}

function elimina_observacion(id) {
    Inertia.delete(route('admin.observaciones.destroy', id), { preserveScroll:true });
}

const closeModal = () => {
    document.getElementById('modal-edita').checked = false;
};

</script>