<template>
    <AppLayout title="Datos Estudiante">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>        

        <!-- DATOS DEL ESTUDIANTE -->
        <div class="flex">
        
            <div  class="mt-10 ml-10 mb-10">
                <VerEstudiante :estudiante="estudiante" />
            </div>

            <!-- DATOS DEL ACUDIENTE -->
            <div class="m-10">               
                <div class="flex flex-col" v-if="show.lista_acudientes">
                    <div>
                        <!-- Ver lista de acudientes -->
                        <VerAcudientes :acudientes="acudientes" :estudianteId="estudiante.id" />
                    </div>

                    <div class= "mt-10" v-if="hermanos.length!=0">
                        <!-- Ver lista de hermanos -->
                        <VerHermanos :hermanos="hermanos" />
                    </div>

                </div>
                <!-- CREAR ACUDIENTE -->
                <div v-if="show.crear_acudiente">
                    <!-- Ver formulario para crear acudiente -->
                    <CrearAcudiente
                        :estudiante_id="estudiante.id"
                        :paises="paises"
                        :parentescos="parentescos"
                        :tipo_documentos="tipo_documentos"
                    />
                </div>

                <!-- EDITAR ACUDIENTE -->
                <div v-if="show.editar_acudiente">
                    <!-- Ver formulario para editar acudiente -->
                    <EditarAcudiente
                        :paises="paises"
                        :parentescos="parentescos"
                        :tipo_documentos="tipo_documentos"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import VerEstudiante from "@/Pages/Admin/Estudiantes/VerEstudiante.vue";
import VerHermanos from "@/Pages/Admin/Estudiantes/VerHermanos.vue";
import VerAcudientes from "@/Pages/Admin/Acudientes/VerAcudientes.vue";
import CrearAcudiente from "@/Pages/Admin/Acudientes/CrearAcudiente.vue";
import EditarAcudiente from "@/Pages/Admin/Acudientes/EditarAcudiente.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { provide, ref } from "vue";

const props = defineProps({
    estudiante: Object,
    paises: Array,
    parentescos: Array,
    tipo_documentos: Array,
    acudientes: Array,
    hermanos: Array,
});

const acudiente = ref('');
const title = ref("Consultar Estudiante");

// Objeto para ocultar/ver los acudientes al crear/editar
const show = ref({
    lista_acudientes: true,
    crear_acudiente: false,
    editar_acudiente: false,
});

provide('acudiente', acudiente);
provide('show', show);

</script>
