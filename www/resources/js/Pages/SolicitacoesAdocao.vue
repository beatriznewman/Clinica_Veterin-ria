<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const solicitacoes = ref([]);
const loading = ref(true);

const carregarSolicitacoes = async () => {
    try {
        const response = await axios.get('/api/solicitacoes-adocao');
        solicitacoes.value = response.data;
    } catch (error) {
        console.error('Erro ao carregar as solicitações de adoção:', error);
    } finally {
        loading.value = false;
    }
};

const aceitarSolicitacao = async (id) => {
    try {
        await axios.post(`/api/solicitacoes-adocao/${id}/atualizar`, { status: 'confirmado' });
        solicitacoes.value = solicitacoes.value.filter(solicitacao => solicitacao.id !== id);
        alert('Solicitação aceita com sucesso!');
    } catch (error) {
        console.error('Erro ao aceitar a solicitação:', error);
    }
};

const negarSolicitacao = async (id) => {
    try {
        await axios.post(`/api/solicitacoes-adocao/${id}/atualizar`, { status: 'negado' });
        solicitacoes.value = solicitacoes.value.filter(solicitacao => solicitacao.id !== id);
        alert('Solicitação negada.');
    } catch (error) {
        console.error('Erro ao negar a solicitação:', error);
    }
};

onMounted(() => {
    carregarSolicitacoes();
});
</script>

<template>
    <div>
        <h1 class="text-xl font-bold mb-4">Solicitações de Adoção</h1>

        <div v-if="loading" class="text-center">
            <p>Carregando solicitações...</p>
        </div>

        <div v-else>
            <div v-if="solicitacoes.length === 0">
                <p>Não há solicitações de adoção no momento.</p>
            </div>

            <div v-else>
                <ul>
                    <li v-for="solicitacao in solicitacoes" :key="solicitacao.id" class="mb-4 p-4 bg-gray-100 rounded shadow-sm">
                        <p><strong>Animal:</strong> {{ solicitacao.animal.nome }}</p>
                        <p><strong>Tutor:</strong> {{ solicitacao.cliente.nome }}</p>
                        <p><strong>Data da Solicitação:</strong> {{ solicitacao.created_at }}</p>

                        <div class="mt-4">
                            <button @click="aceitarSolicitacao(solicitacao.id)" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700 mr-2">Aceitar</button>
                            <button @click="negarSolicitacao(solicitacao.id)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Negar</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
