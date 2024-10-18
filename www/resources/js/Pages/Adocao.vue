<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Variável reativa para armazenar os animais sem dono
const animaisSemDono = ref([]);

// Variáveis reativas para controle do modal e do animal selecionado
const mostrarModal = ref(false);
const animalSelecionado = ref({ nome: '', especie: '' });

// Função para buscar os animais sem dono
const fetchAnimaisSemDono = async () => {
    try {
        const response = await axios.get('/api/animais/sem-dono');
        animaisSemDono.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar animais para adoção:', error);
    }
};

// Função para abrir o modal com os dados do animal selecionado
const abrirModal = (animal) => {
    animalSelecionado.value = animal;
    mostrarModal.value = true;
};

// Função para fechar o modal
const fecharModal = () => {
    mostrarModal.value = false;
};

// Chama a função ao montar o componente
onMounted(() => {
    fetchAnimaisSemDono();
});
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Adote um Animal
      </h2>
    </template>

    <div class="py-10">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <h3 class="font-bold text-lg mb-4">Lista de Animais para adoção</h3>

            <ul v-if="animaisSemDono.length > 0">
              <li v-for="animal in animaisSemDono" :key="animal.id" class="mt-4 flex justify-between items-center">
                <div>
                  <strong>Espécie:</strong> {{ animal.especie }} <br />
                  <strong>Nome:</strong> {{ animal.nome }}
                </div>
                <!-- Botão Adotar -->
                <button @click="abrirModal(animal)" class="px-4 py-2 bg-blue-500 text-white rounded">
                  Adotar
                </button>
              </li>
            </ul>

            <p v-else class="text-gray-500">Nenhum animal para adoção encontrado.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de confirmação de adoção -->
    <div v-if="mostrarModal" class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-lg p-6">
          <h3 class="text-lg font-bold mb-4">Confirmar Adoção</h3>
          <p><strong>Espécie:</strong> {{ animalSelecionado.especie }}</p>
          <p><strong>Nome:</strong> {{ animalSelecionado.nome }}</p>

          <div class="mt-4 flex space-x-2">
            <!-- Botão para confirmar a adoção -->
            <button class="px-3 py-1 bg-blue-500 text-white rounded">
              Confirmar Adoção
            </button>

            <!-- Botão para fechar o modal -->
            <button @click="fecharModal" class="px-3 py-1 bg-gray-500 text-white rounded">
              Cancelar
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
/* Estilos adicionais conforme necessário */
</style>
