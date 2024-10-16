<template>
    <Head title="Cadastro de Animal" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Cadastro de Animal
                </h2>
            </div>
        </template>

        <div class="py-6 flex items-center justify-center"> 
            <div class="bg-white overflow-hidden shadow-sm rounded-lg w-full max-w-lg p-6 mx-auto">
                <div class="leading-relaxed text-center">
                    <!-- Exibir mensagem de sucesso -->
                    <div v-if="message" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        {{ message }}
                    </div>

                    <!-- Exibir mensagem de erro -->
                    <div v-if="errormessage" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        {{ errormessage }}
                    </div>

                    <form @submit.prevent="cadastrarAnimais">
                        <div v-for="(animal, index) in animals" :key="index" class="animal-entry mb-2"> <!-- Reduzido para mb-2 -->
                            <h3>Animal {{ index + 1 }}</h3> <!-- Título para cada animal -->
                            
                            <div class="mt-2"> <!-- Reduzido para mt-2 -->
                                <label for="especie" class="block text-left mb-1">Espécie:</label>
                                <input type="text" v-model="animal.especie" required class="w-full px-3 py-2 border rounded" />
                            </div>

                            <div class="mt-2"> <!-- Reduzido para mt-2 -->
                                <label for="nome" class="block text-left mb-1">Nome:</label>
                                <input type="text" v-model="animal.nome" required class="w-full px-3 py-2 border rounded" />
                            </div>

                            <div class="mt-2"> <!-- Reduzido para mt-2 -->
                                <label for="tutor" class="block text-left mb-1">Tutor:</label>
                                <select v-model="animal.paciente_id" @change="atualizarPacienteId(index)" class="w-full px-3 py-2 border rounded">
                                    <option value="">Selecione um Tutor</option>
                                    <option value="null">Sem Tutor</option>
                                    <option v-for="user in usuarios" :key="user.id" :value="user.paciente_id">
                                        {{ user.username }}
                                    </option>
                                </select>
                            </div>

                            <div class="mt-2">
                                <button type="button" @click="removerAnimal(index)" class="text-black-500 underline hover:text-black-700">Remover Animal</button>
                            </div>
                        </div>

                        <div class="mt-2"> <!-- Reduzido para mt-2 -->
                            <button type="button" @click="adicionarAnimal" class="text-black-500 underline hover:text-black-700">Adicionar Outro Animal</button>
                        </div>

                        <div class="flex justify-center mt-4 mb-2"> <!-- Centralizar o botão -->
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">Cadastrar Animais</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';

export default {
    components: {
        AuthenticatedLayout,
        Head,
    },
    data() {
        return {
            animals: [
                {
                    especie: '',
                    nome: '',
                    paciente_id: null,
                },
            ],
            usuarios: [],
            message: '',
            errormessage: '',
            loading: true,
            error: null,
        };
    },
    mounted() {
        this.carregarUsuarios();
    },
    methods: {
        async carregarUsuarios() {
            try {
                const response = await axios.get('/users'); // Certifique-se de que a URL está correta
                this.usuarios = response.data;
            } catch (error) {
                console.error('Erro ao carregar usuários:', error);
                this.error = 'Erro ao carregar usuários';
            } finally {
                this.loading = false;
            }
        },
        atualizarPacienteId(index) {
            // Se a opção "Sem Tutor" for selecionada, setar paciente_id como null
            if (this.animals[index].paciente_id === "null") {
                this.animals[index].paciente_id = null;
            }
        },
        adicionarAnimal() {
            // Adiciona um novo objeto de animal à lista
            this.animals.push({
                especie: '',
                nome: '',
                paciente_id: null,
            });
        },
        removerAnimal(index) {
            this.animals.splice(index, 1); // Remover animal na posição index
        },
        async cadastrarAnimais() {
            this.message = '';
            this.errormessage = ''; // Corrigido para errormessage
            try {
                // Itera sobre a lista de animais e envia cada um
                for (const animal of this.animals) {
                    const response = await axios.post('/cadastro-animal', {
                        especie: animal.especie,
                        nome: animal.nome,
                        paciente_id: animal.paciente_id,
                    });
                    console.log('Animal cadastrado:', response.data);
                }
                this.message = 'Animais cadastrados com sucesso!'; // Mensagem de sucesso
                // Limpar a lista após o cadastro
                this.animals = [{
                    especie: '',
                    nome: '',
                    paciente_id: null,
                }];
            } catch (error) {
                console.error('Erro ao cadastrar animais:', error.response.data);
                this.errormessage = error.response.data.message; // Exibe a mensagem de erro
            }
        }
    },
};
</script>
