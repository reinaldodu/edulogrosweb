<template>
    <AppLayout title="Evaluación">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="w-full">
                <div>
                    <p>
                        <span class="font-semibold">Asignatura: </span>
                        <span>{{ asignatura.nombre }}</span>
                        <span class="font-semibold"> - Periodo: </span>
                        <span>{{ periodo.nombre }}</span>
                    </p>
                    <p>
                        <span class="font-semibold">{{ $page.props.singular_logros }}: </span>
                        <span>{{ logro.logro }}</span>
                    </p>

                    <p v-if="actividad">
                        <span class="font-semibold">Actividad: </span>
                        <span>{{ actividad.nombre }}</span>
                    </p>
                </div>
                <!-- Botones de copiar y pegar evaluaciones -->
                <div v-if="btnsCopiaPega" class="flex justify-end space-x-2 mr-2">
                    <!-- Botón para copiar evaluaciones -->
                    <div class="tooltip" data-tip="Copiar evaluaciones">
                        <button class="btn btn-outline btn-sm btn-circle" @click.prevent="copiaTexto">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                            </svg>
                        </button>
                    </div>
                    <!-- Botón para pegar evaluaciones -->
                    <div class="tooltip" data-tip="Pegar evaluaciones">
                        <button class="btn btn-outline btn-sm btn-circle" @click.prevent="pegaTexto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                        </button>
                    </div>
                </div>
                <form class="form-control w-full" @submit.prevent="form.post(route('admin.evaluar-logros.store', { logro:logro.id, actividad:actividad ? actividad.id : null }))">
                    <div class="alert alert-info shadow-lg" v-if="form.hasErrors">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>La información no se guardó. Verificar las evaluaciones.</span>
                        </div>
                    </div>
                    <table class="table table-compact table-zebra w-full border-collapse mt-3">
                        <thead>
                            <tr>
                                <th class="w-5"></th>
                                <th>Apellidos y nombres</th>
                                <th>Evaluación</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr v-for="(estudiante,i) in  estudiantes" :key="i" :id="estudiante.id">
                                    <td class="font-semibold">{{ i+1 }}</td>
                                <td>
                                    {{ estudiante.apellidos + ' ' + estudiante.nombres }}
                                </td>
                                <td>
                                    <input type="number" 
                                            class="input input-bordered input-sm w-20"
                                            :class="{ 'input-error':form.errors[`notas.${estudiante.id}`] }"
                                            v-model="form.notas[estudiante.id]"
                                            @focus="lineaActiva(estudiante.id)"
                                            @blur="lineaDesactiva(estudiante.id)"
                                            :min="rangoInicial" 
                                            :max="rangoFinal"
                                    />
                                    <div class="badge badge-warning"  v-if="form.errors[`notas.${estudiante.id}`]">{{ form.errors[`notas.${estudiante.id}`] }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="flex mt-3 space-x-3">
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="form.processing">Guardar</button>
                        <button class="btn btn-outline btn-primary btn-sm" @click.prevent="cancelar">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { ref } from "vue";

const props = defineProps({
    estudiantes: Array,
    logro: Object,
    actividad: Object,
    asignatura: Object,
    periodo: Object,
    notas: Object,
    rangoInicial: Number,
    rangoFinal: Number,
});

const title = ref('Evaluación ' + props.logro.grupo.nombre);

const form = useForm({
    notas: props.notas,
});

const btnsCopiaPega = ref(navigator.clipboard);  // Validar si el navegador soporta copiar y pegar

function copiaTexto() {      
    //recorrer el objeto notas y copiar el valor de cada nota en el portapapeles en el orden de los estudiantes
    let texto = '';
    for (let i = 0; i < props.estudiantes.length; i++) {
        if (form.notas[props.estudiantes[i].id]===null) {
            texto += '\n';
        } else {
            texto += form.notas[props.estudiantes[i].id] + '\n';
        }
    }
    navigator.clipboard.writeText(texto).then( () => console.log('Notas copiadas!'));
}

function pegaTexto() {    
    navigator.clipboard.readText().then( (texto) => {        
        //split de texto por saltos de línea sin el retorno de carro
        let notas = texto.split(/\r?\n/);
        notas.pop(); //eliminar el último elemento que es un salto de línea
        //si el número de notas es diferente al número de estudiantes, no se hace nada
        if (notas.length !== props.estudiantes.length) {
            return alert("El número de notas que se van a pegar no coincide con el número de estudiantes. Por favor verificar");
        }
        for (let i = 0; i < props.estudiantes.length; i++) {
            //si no es un número se deja la nota en blanco
            if (isNaN(notas[i])) {
                form.notas[props.estudiantes[i].id] = '';
            } else {
                form.notas[props.estudiantes[i].id] = notas[i];
            }
        }
    });
}

function cancelar()
{
    Inertia.visit(route('admin.panel-evaluaciones.show', { periodo:props.logro.periodo_id, grupo:props.logro.grupo_id, asignatura:props.logro.asignatura_id }));
}

const lineaActiva = (id) => {
    document.getElementById(id).classList.add('active');
}

const lineaDesactiva = (id) => {
    document.getElementById(id).classList.remove('active'); 
}

</script>