<template>
    <AppLayout title="Editar Usuario">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="card w-xs bg-base-100 shadow-xl">
                <div class="card-body">
                    
                    <div class="flex flex-col items-center">
                        <div>                
                            <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.put(route('admin.usuarios.update', form.id))">

                                <div class="alert alert-info shadow-lg" v-if="form.hasErrors">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span>Verificar algunos campos del formulario</span>
                                    </div>
                                </div>                    
                                
                                <span class="font-semibold text-xl">{{ usuario.name }}</span>                                
                                <span class="text-gray-400">Rol: {{ usuario.rol.nombre }}</span>
                                <span class="text-gray-400 text-xs">Fecha de creación: {{ usuario.created_at }}</span>
                                <div class="divider m-0"></div> 
                                <label class="label" for="email">Email:*</label>
                                <input type="text" id="email" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.email }" v-model="form.email">
                                <div class="badge badge-warning"  v-if="form.errors.email">{{ form.errors.email }}</div>

                                <!-- Botón cambiar contraseña -->
                                <label class="btn btn-xs btn-outline btn-secondary my-4" for="modal-passwd">Cambiar contraseña</label>

                                <label class="label" for="estado">{{ 'Usuario ' + txt_activo(form.activo) }}</label>
                                <input type="checkbox"
                                       id="estado"
                                       class="toggle mb-4"
                                       v-model="form.activo"
                                />                                

                                <div class="flex justify-end space-x-2 mt-2">
                                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                    <Link class="btn btn-outline btn-primary" :href="route('dashboard')" >Cancelar</Link>
                                </div>               
                            </form>                
                        </div>
                    </div>        
                </div>
            </div>
        </div>

        <!-- Modal cambiar contraseña -->
        <input type="checkbox" id="modal-passwd" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Cambiar contraseña</h3>
                <form class="form-control w-full text-sm" @submit.prevent="form2.put(route('admin.usuarios.password', form2.id), { onSuccess: closeModal })">
                    <input type="password" class="input input-bordered input-sm w-full mt-4" 
                                        :class="{ 'input-error':form2.errors.password }"                                        
                                        placeholder="Nueva contraseña - mínimo 8 caracteres"
                                        min="8"
                                        maxlength="50"
                                        v-model="form2.password"
                    />
                    <div class="badge badge-warning"  v-if="form2.errors.password">{{ form2.errors.password }}</div>
                    
                    <!-- Escribir nuevamente el password para validar -->
                    <input type="password" class="input input-bordered input-sm w-full mt-4" 
                                        :class="{ 'input-error':form2.errors.password_confirmation }"
                                        placeholder="Confirme nuevamente la nueva contraseña"
                                        min="8"
                                        maxlength="50"
                                        v-model="form2.password_confirmation"
                    />
                    <div class="badge badge-warning"  v-if="form2.errors.password_confirmation">{{ form2.errors.password_confirmation }}</div>
                    
                    <div class="modal-action">
                        <button type="submit" class="btn btn-xs" :disabled="form2.processing">Guardar</button>
                        <label for="modal-passwd" class="btn btn-outline btn-xs" @click="limpiar">Cancelar</label>
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
    usuario: Object,
});

const title = ref('Editar usuario');

const form = useForm({
    id: props.usuario.id,
    email: props.usuario.email,
    activo: props.usuario.activo === 1 ? true : false,
});

const form2 = useForm({
    id: props.usuario.id,
    password: '',
    password_confirmation: '',
});

const txt_activo = (valor) => valor ? 'activo' : 'inactivo';

const closeModal = () => {
    document.getElementById('modal-passwd').checked = false;
};

// Limpiar campos del formulario2 - cambio de password
const limpiar = () => {
    form2.reset();
    form2.clearErrors();
};

</script>