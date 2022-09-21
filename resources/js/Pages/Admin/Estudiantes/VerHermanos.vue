<template>   
    <div class="card w-ws  bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Hermanos</h2>
            <div>
                <table class="table table-compact w-auto">        
                    <thead>
                    <tr>                    
                        <th>Nombre</th>                        
                    </tr>
                    </thead>
                    <tbody>        
                    <tr class="hover" v-for="(hermano,i) in hermanos" :key="i" >
                        <td>
                            <Link class="btn btn-ghost btn-xs" :href="route('admin.estudiantes.show', hermano.estudiante_id)">
                                    {{ hermano.nombres  + ' ' + hermano.apellidos }}
                            </Link>                            
                        </td>                        
                    </tr>       
                    </tbody>
                </table>                
            </div>            
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
const props = defineProps({
     hermanos: Array,
 });

</script>