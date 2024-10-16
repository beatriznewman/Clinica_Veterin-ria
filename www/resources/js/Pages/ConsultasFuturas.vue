<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Consultas Futuras
      </h2>
    </template>

    <div class="py-10">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="mb-4">
              <label for="animal" class="block text-sm font-medium text-gray-700">Selecione o Animal</label>
              <select v-model="selectedAnimalId" @change="filtrarPorAnimal" class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Todos os Animais</option>
                <option v-for="animal in animals" :key="animal.id" :value="animal.id">
                  {{ animal.nome }}
                </option>
              </select>
            </div>
            
            <div class="divide-y divide-gray-200">
              <template v-if="consultas.length === 0">
                <div class="py-2 text-center text-gray-800 text-base">
                  Não há consultas futuras para este animal.
                </div>
              </template>
              <template v-else v-for="consulta in consultas" :key="consulta.id">
                <div class="py-4 flex space-x-3">
                  <div class="flex-1">
                    <p class="text-sm text-gray-500">{{ formatDate(consulta.data) }}</p>
                    <h3 class="text-lg font-medium text-gray-900">
                      {{ formatTime(consulta.horario_inicio) }} às {{ formatTime(consulta.horario_fim) }}
                    </h3>
                    <p class="text-gray-500">Dr(a). {{ consulta.user.nome }}</p>
                    <p class="text-sm text-gray-500">Animal: {{ consulta.animal.nome }}</p>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, defineProps } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  consultas: Array,
  animals: Array,
  selected_animal_id: Number,
});

// Armazenar o ID do animal selecionado
const selectedAnimalId = ref(props.selected_animal_id || null);

// Função para redirecionar e filtrar as consultas por animal
const filtrarPorAnimal = () => {
  // Inicia a requisição com o animal selecionado
  Inertia.get(route('consultas.futuras'), { animal_id: selectedAnimalId.value }, { preserveState: true });
};

// Funções de formatação
const formatDate = (date) => {
  // Cria um objeto Date considerando o fuso horário local
  const localDate = new Date(date + 'T00:00:00'); // Ajusta para a meia-noite do dia
  return localDate.toLocaleDateString('pt-BR');
};

const formatTime = (time) => time.slice(0, 5);

</script>
