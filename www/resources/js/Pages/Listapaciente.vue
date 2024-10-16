<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Olá, {{ $page.props.auth.user.nome }}
      </h2>
    </template>
    <div class="container mx-auto py-8">
      <h1 class="text-2xl font-bold mb-4 text-center">Lista de Pacientes</h1>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
          <thead>
            <tr>
              <th class="px-4 py-2 border">Nome Tutor</th>
              <th class="px-4 py-2 border">Nome Animal</th>
              <th class="px-4 py-2 border">Especie</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(animal, index) in uniqueAnimals" :key="index" class="hover:bg-gray-100 text-center">
              <td class="px-4 py-2 border">{{ animal.tutorNome }}</td>
              <td class="px-4 py-2 border">{{ animal.nome }}</td>
              <td class="px-4 py-2 border">{{ animal.especie }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';

const consultas = ref([]);

onMounted(() => {
  fetchConsultas();
});

const fetchConsultas = () => {
  axios.get('/consultas')
    .then(response => {
      consultas.value = response.data.map(consulta => ({ ...consulta, editing: false }));
    })
    .catch(error => {
      console.error('Error fetching consultations:', error);
    });
};

// Computed property para obter animais únicos
const uniqueAnimals = computed(() => {
  const seen = new Set();
  return consultas.value
    .map(consulta => ({
      tutorNome: consulta.paciente.nome,
      nome: consulta.animal.nome,
      especie: consulta.animal.especie,
    }))
    .filter(animal => {
      const identifier = `${animal.tutorNome}-${animal.nome}`;
      if (seen.has(identifier)) {
        return false; // já visto
      }
      seen.add(identifier);
      return true; // novo
    });
});
</script>
