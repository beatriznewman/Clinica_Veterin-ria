<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const animaisSemDono = ref([]);
const mostrarModal = ref(false);
const animalSelecionado = ref({ nome: '', especie: '' });
const mensagemSucesso = ref('');
const mensagemErro = ref('');
const pacienteLogadoId = ref(null);
const isLoading = ref(false);
const caminhoImagemBase = '/storage/'; // Caminho base para as imagens

defineProps({
    pacienteLogadoId: {
        type: Number,
        required: true
    }
});

const fetchAnimaisSemDono = async () => {
    try {
        const response = await axios.get('/api/animais/sem-dono');
        animaisSemDono.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar animais para adoção:', error);
        mensagemErro.value = 'Erro ao carregar a lista de animais';
    }
};

const abrirModal = (animal) => {
    if (animal.paciente_id !== null) {
        mensagemErro.value = 'Este animal já foi adotado.';
        return;
    }
    animalSelecionado.value = animal;
    mostrarModal.value = true;
};

const fecharModal = () => {
    mostrarModal.value = false;
};

const confirmarAdocao = async () => {
    isLoading.value = true;
    try {
        const response = await axios.post('/animais/adotar', {
            animal_id: animalSelecionado.value.id,
            paciente_id: pacienteLogadoId.value
        });

        mensagemSucesso.value = 'Adoção confirmada com sucesso!';
        fecharModal();
        animalSelecionado.value = {};  // Limpa o animal selecionado após adoção
        setTimeout(() => {
            mensagemSucesso.value = '';
        }, 3000);

        await fetchAnimaisSemDono();
    } catch (error) {
        if (error.response) {
            mensagemErro.value = 'Erro no servidor: ' + (error.response.data.message || 'Erro desconhecido');
        } else if (error.request) {
            mensagemErro.value = 'Sem resposta do servidor. Tente novamente mais tarde.';
        } else {
            mensagemErro.value = 'Erro ao configurar a requisição: ' + error.message;
        }
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchAnimaisSemDono();
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Adote um Animal</h2>
        </template>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="font-bold text-lg mb-4">Lista de Animais para adoção</h3>

                        <ul v-if="animaisSemDono.length > 0">
                            <li v-for="animal in animaisSemDono" :key="animal.id" class="mt-4 flex justify-between items-center">
                                <div>
                                    <strong>Espécie:</strong> {{ animal.especie }} <br />
                                    <strong>Nome:</strong> {{ animal.nome }}
                                    <!-- Exibindo a imagem do animal -->
                                    <img :src="`/storage/${animal.imagem}`" alt="Imagem do animal" class="mt-2 w-32 h-32 object-cover rounded" />
                                </div>
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

        <div v-if="mostrarModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Confirmar Adoção</h3>
                    <p><strong>Espécie:</strong> {{ animalSelecionado.especie }}</p>
                    <p><strong>Nome:</strong> {{ animalSelecionado.nome }}</p>

                    <!-- Exibindo a imagem do animal no modal -->
                    <img :src="`/storage/${animalSelecionado.imagem}`" alt="Imagem do animal selecionado" class="mt-4 w-32 h-32 object-cover rounded" />

                    <div class="mt-4 flex space-x-2">
                        <button @click="confirmarAdocao" class="px-3 py-1 bg-blue-500 text-white rounded" :disabled="isLoading">
                            <span v-if="isLoading">Processando...</span>
                            <span v-else>Confirmar Adoção</span>
                        </button>
                        <button @click="fecharModal" class="px-3 py-1 bg-gray-500 text-white rounded">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="mensagemSucesso" class="fixed bottom-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg">
            {{ mensagemSucesso }}
        </div>

        <div v-if="mensagemErro" class="fixed bottom-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg">
            {{ mensagemErro }}
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Estilos adicionais conforme necessário */
</style>
