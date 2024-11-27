<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Animais Cadastrados
      </h2>
    </template>

    <div class="py-10">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <!-- Verifique se os dados estão sendo recebidos corretamente -->
            <div v-if="!animals || animals.length === 0" class="text-center text-gray-600">
              Não há animais cadastrados.
            </div>
            <div v-else class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Espécie</th>
                    <th scope="col" class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagem</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tutor</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="animal in animals" :key="animal.id">
                    <td class="px-3 py-4 text-sm text-gray-500">{{ animal.id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ animal.nome }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ animal.especie }}</td>
                    <td class="px-8 py-4 text-sm text-gray-500">{{ animal.descricao }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                      <img
                        v-if="animal.imagem"
                        :src="`/storage/${animal.imagem}`"
                        alt="Foto do animal"
                        class="w-16 h-16 object-cover rounded-full cursor-pointer"
                        @click="openModal(`/storage/${animal.imagem}`)"
                      />
                      <span v-else>Sem imagem</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                      {{ animal.paciente ? animal.paciente.nome : 'Sem dono' }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="modalImage" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm sm:max-w-md lg:max-w-lg relative">
        <button
          @click="closeModal"
          class="absolute top-3 right-3 text-gray-600 hover:text-gray-800 focus:outline-none"
        >
          ✖
        </button>
        <img :src="modalImage" alt="Foto ampliada do animal" class="w-full h-auto rounded-lg" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Props para receber os animais do backend
const props = defineProps({
  animals: Array,
});

// Estado para controlar o modal
const modalImage = ref(null);

// Função para abrir o modal
const openModal = (image) => {
  modalImage.value = image;
};

// Função para fechar o modal
const closeModal = () => {
  modalImage.value = null;
};
</script>

<style scoped>
/* Estilização para o modal */
.fixed {
  backdrop-filter: blur(5px);
}
</style>
