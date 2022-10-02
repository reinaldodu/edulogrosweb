<template>
    <div class="m-5">
        <table v-if="logros.length>0" class="table table-compact table-zebra w-full">
            <thead>
                <tr>
                    <th class="w-5"></th>
                    <th>{{ $page.props.nombre_logros }}
                        <!-- Activar edicion de logros -->
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
                <tr v-for="(logro,i) in  logros" :key="i">
                        <td>{{ i+1 }}</td>
                    <td class="whitespace-normal">{{ logro.logro }}</td>
                    <td>
                        <div v-show="activarEdicion" class="flex justify-end space-x-2">
                            <!-- Botón Editar -->
                            <div class="tooltip" :data-tip="'Editar ' + $page.props.singular_logros + ' ' + (i+1) ">
                                <label for="modal-edita" @click="edita_logro(logro)" class="btn btn-ghost btn-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </label>
                            </div>
                            <!-- Botón Eliminar -->
                            <!-- Validar que no tenga notas asociadas -->

                            <div v-if="logro.notas_logros_count===0  && logro.actividades_logros_count===0" class="tooltip" :data-tip="'Eliminar ' + $page.props.singular_logros + ' ' + (i+1) ">
                                <label for="modal-elimina" @click="logro_num=i+1; logro_id=logro.id" class="btn btn-ghost btn-xs">
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

    <!-- Modal editar logro -->
    <input type="checkbox" id="modal-edita" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Editar {{ $page.props.singular_logros }}</h3>
            <form class="form-control w-full text-sm" @submit.prevent="form.put(route('admin.logros.update', form.id), { onSuccess: closeModal })">
                <input type="text" class="input input-bordered input-sm w-full mt-4" 
                                    :class="{ 'input-error':form.errors.logro }"
                                    v-model="form.logro"
                                    maxlength="255">
                <div class="badge badge-warning"  v-if="form.errors.logro">{{ form.errors.logro }}</div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary btn-xs" :disabled="form.processing">Guardar</button>
                    <label for="modal-edita" class="btn btn-outline btn-primary btn-xs">Cancelar</label>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Eliminar logro -->
    <input type="checkbox" id="modal-elimina" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Eliminar {{ $page.props.singular_logros }}</h3>
            <p class="py-4">¿Desea eliminar el {{ $page.props.singular_logros }} #{{ logro_num }}?</p>
            <div class="modal-action">
                <label @click="elimina_logro(logro_id)" for="modal-elimina" class="btn">Si</label>
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
    logros: Array,    
});

const activarEdicion = ref(false);
const logro_num = ref(0);
const logro_id= ref(0);

const form = useForm({
    id: null,
    logro: '',
});

function edita_logro(data)
{
    form.id = data.id;
    form.logro = data.logro;
    form.errors.logro = null;
}

function elimina_logro(id) {
    Inertia.delete(route('admin.logros.destroy', id));
}

const closeModal = () => {
    document.getElementById('modal-edita').checked = false;
};

</script>