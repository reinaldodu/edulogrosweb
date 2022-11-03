<template>
    <div class="card w-xs bg-base-100 shadow-xl">
        <figure class="px-10 pt-10">
            <img :src="estudiante.foto ? estudiante.foto : '/storage/images/sin_foto.png'" alt="foto" class="w-32 rounded-full" />
        </figure>
        <div class="card-body">
            <h2 class="card-title justify-center">{{ estudiante.nombres + ' ' + estudiante.apellidos }}<span class="badge badge-primary badge-outline">{{ estudiante.grados[0].nombre }}</span></h2>
      
            <p><span class="font-semibold">Documento:</span> {{ estudiante.tipo_documento.abreviatura + ' ' + 
                                estudiante.documento + ' (' + 
                                estudiante.municipio_doc.nombre + ')'  }}</p>
            <p><span class="font-semibold">Fecha de nacimiento:</span> {{ estudiante.fecha_nacimiento }} <span class="badge badge-xs text-xs">{{ estudiante.edad }} años</span></p>
            <p><span class="font-semibold">Nacionalidad:</span> {{ estudiante.pais.gentilicio + ' (' + estudiante.municipio_nacimiento.nombre + ')' }}</p>
            <p><span class="font-semibold">Email:</span> {{ estudiante.user.email }}</p>
            <p><span class="font-semibold">Teléfono:</span> {{ estudiante.telefono }}</p>
            <p><span class="font-semibold">Celular:</span> {{ estudiante.celular }}</p>
            <p><span class="font-semibold">Dirección:</span> {{ estudiante.direccion + ' (' + estudiante.barrio + ')' }}</p>      
            
            <div class="divider font-semibold"><div class="badge badge-info">Ficha médica</div></div>
            <p><span class="font-semibold">EPS:</span> {{ estudiante.eps }}</p>
            <p><span class="font-semibold">Talla:</span> {{ estudiante.talla }} <span class="font-semibold"> Peso:</span> {{ estudiante.peso }} <span class="font-semibold"> RH:</span> {{ estudiante.rh }}</p>
            <p><span class="font-semibold">Clínica en caso de emergencia:</span> {{ estudiante.clinica }}</p>
            <p><span class="font-semibold">Teléfono en caso de emergencia:</span> {{ estudiante.tel_emergencia }}</p>
            <p><span class="font-semibold">Alergias:</span> {{ estudiante.alergias }}</p>
            <p><span class="font-semibold">Observaciones:</span> {{ estudiante.observaciones }}</p>

            <div class="card-actions justify-end">                        
                <Link :href="route('admin.estudiantes.edit', estudiante.id)" class="btn btn-xs btn-success rounded-full mt-2">Editar estudiante</Link>
            </div>
            
        </div>              
    </div>      
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    estudiante: Object,
});

</script>