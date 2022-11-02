<template>
    <div class="card w-ws  bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Acudientes</h2>
            <div>
                <table v-if ="acudientes.length!=0" class="table table-compact w-auto">        
                    <thead>
                    <tr>                    
                        <th>Nombre</th>
                        <th>Parentesco</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>        
                    <tr class="hover" v-for="(ver_acudiente,i) in acudientes" :key="i" >
                        <td>
                            <label for="modal-consulta" @click="consulta_acudiente(ver_acudiente)" class="hover:underline">{{ ver_acudiente.nombres  + ' ' + ver_acudiente.apellidos }}</label>
                        </td>
                        <td>{{ ver_acudiente.parentesco.nombre }}</td>
                        <td>
                            <div class="dropdown dropdown-left">                         
                                <label tabindex="0" class="btn btn-square btn-ghost">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                </label>
                                <ul tabindex="0" class="dropdown-content menu menu-compact p-2 shadow bg-base-100 rounded-box w-52">
                                    <li><label @click="edita_acudiente(ver_acudiente)">
                                        Editar acudiente
                                        </label>
                                    </li>
                                    <li>
                                        <label  for="modal-elimina"
                                                @click="acudiente=ver_acudiente"
                                        >Eliminar acudiente
                                        </label>
                                    </li>
                                    <li>
                                        <Link :href="route('admin.usuarios.edit', ver_acudiente.user_id)">
                                            Opciones de Usuario
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </td>                    
                    </tr>       
                    </tbody>
                </table>
                <span v-else>No existen acudientes para el estudiante</span>
            </div>
            <div class="card-actions justify-end">
                <div class="tooltip tooltip-left" data-tip="Agregar acudiente">
                    <button class="btn btn-circle mt-2" @click="crea_acudiente">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /> </svg>
                    </button>
                </div>
            </div>
        </div>        
    </div>
    
     <!-- Modal eliminar acudiente -->
    <input type="checkbox" id="modal-elimina" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Eliminar Acudiente</h3>
            <p class="py-4">¿Desea eliminar el acudiente {{ acudiente.nombres + ' ' + acudiente.apellidos }}?</p>
            <div class="modal-action">
                <label @click="elimina_acudiente(acudiente.id)" for="modal-elimina" class="btn">Si</label>
                <label for="modal-elimina" class="btn">No</label>
            </div>
        </div>
    </div>

    <!-- Modal consultar acudiente -->
    <input type="checkbox" id="modal-consulta" class="modal-toggle" />
    <div class="modal">
    <div class="modal-box relative">
        <label for="modal-consulta" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
        <h3 class="text-lg font-bold">{{ info_acudiente.nombres  + ' ' + info_acudiente.apellidos + ' (' + info_acudiente.parentesco + ')' }}</h3>        
        <div class="divider"></div> 
        <p class="text-sm"><span class="font-semibold">Documento:</span> {{ info_acudiente.tipo_documento + ' ' + info_acudiente.documento }}</p>
        <p class="text-sm"><span class="font-semibold">Teléfono:</span> {{ info_acudiente.telefono  }}
                           <span class="font-semibold">Celular:</span> {{ info_acudiente.celular  }}
        </p>
        <p class="text-sm"><span class="font-semibold">Email:</span> {{ info_acudiente.email }}</p>
        <p class="text-sm"><span class="font-semibold">Profesión:</span> {{ info_acudiente.profesion }}</p>
    </div>
    </div>

</template>

<script setup>
import { inject, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({    
     acudientes: Array,
     estudianteId: Number,
 });

const info_acudiente = ref({    
    nombres: '',
    apellidos: '',
    tipo_documento: '',
    documento: '',
    telefono: '',
    celular: '',
    profesion: '',    
    parentesco: '',
    email: ''
});

const show = inject('show');
const acudiente= inject('acudiente');

const crea_acudiente = () => {
    show.value.lista_acudientes=false;
    show.value.crear_acudiente=true;
}

const edita_acudiente = (data) => {
    show.value.lista_acudientes=false;
    show.value.editar_acudiente=true;
    //pasar los datos del acudiente a editar
    acudiente.value=data;
}

function consulta_acudiente(data)
{        
    info_acudiente.value.nombres=data.nombres;
    info_acudiente.value.apellidos=data.apellidos;
    info_acudiente.value.tipo_documento=data.tipo_documento.abreviatura;
    info_acudiente.value.documento=data.documento;
    info_acudiente.value.telefono=data.telefono;
    info_acudiente.value.celular=data.celular;
    info_acudiente.value.profesion=data.profesion;    
    info_acudiente.value.parentesco=data.parentesco.nombre;
    info_acudiente.value.email=data.user.email;
}

function elimina_acudiente(id_acudiente)
{
    Inertia.delete(route('admin.acudientes.destroy', { acudiente:id_acudiente, estudianteId:props.estudianteId }));
}

</script>