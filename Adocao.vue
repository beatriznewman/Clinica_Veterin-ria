<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Variável reativa para armazenar os animais sem dono
const animaisSemDono = ref([]);

// Função para buscar os animais sem dono
const fetchAnimaisSemDono = async () => {
    try {
        const response = await axios.get('/api/animais/sem-dono');
        animaisSemDono.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar animais para adoção:', error);
    }
};

// Função para solicitar a adoção de um animal
const adotarAnimal = async (animalId) => {
    try {
        // Chama a API para solicitar a adoção
        const response = await axios.post('/api/animais/adotar', { animal_id: animalId });

        if (response.status === 200) {
            alert('Solicitação de adoção enviada com sucesso! Aguardando autorização da secretária.');
            // Recarrega a lista de animais sem dono
            await fetchAnimaisSemDono();
        }
    } catch (error) {
        console.error('Erro ao solicitar a adoção:', error);
        alert('Ocorreu um erro ao solicitar a adoção. Tente novamente.');
    }
};

// Chama a função ao montar o componente
onMounted(() => {
    fetchAnimaisSemDono();
});
</script>

<template>
    <div>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-6">
            Adote um animal
        </h2>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-bold text-lg mb-4">Lista de Animais para adoção</h3>
                    
                    <ul v-if="animaisSemDono.length > 0">
                        <li v-for="animal in animaisSemDono" :key="animal.id" class="mt-4">
                            <strong>Espécie:</strong> {{ animal.especie }} <br />
                            <strong>Nome:</strong> {{ animal.nome }} <br />
                            <button 
                                @click="adotarAnimal(animal.id)"
                                class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Quero Adotar
                            </button>
                        </li>
                    </ul>

                    <p v-else class="text-gray-500">Nenhum animal para adoção encontrado.</p>
                </div>
            </div>
        </div>
    </div>
</template>
