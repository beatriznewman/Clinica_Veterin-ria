<<<<<<< HEAD
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
=======
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>

    <!--comando abaixo verifica quais sao os roles e permission do user logado-->
    <!--
    <div>
        {{ $page.props }}
    </div>
    -->

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Olá, {{ $page.props.auth.user.nome }}
            </h2>
        </template>

        <div v-if="$page.props.user.roles.includes('secretaria')">

            <Head title="Secretaria"></Head>
            
            <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>

            <div class="text-3xl text-gray-700 leading-relaxed text-center">
                <p class="mt-6">Cadastro de Pacientes</p>
            </div>

            <div class="leading-relaxed text-center max-w-md mx-auto">
                <form @submit="submit">
                    <div class="mt-6">
                        <label for="nome" class="block text-left mb-2">Nome:</label>
                        <input type="text" v-model="form.nome" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.nome" class="text-red-500">{{ errors.nome[0] }}</span>
                    </div>

                    <div class="mt-2">
                        <label for="cep" class="block text-left mb-2">CEP:</label>
                        <input type="text" v-model="form.cep" @blur="preencherEndereco" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.cep" class="text-red-500">{{ errors.cep[0] }}</span>
                    </div>

                    <div class="mt-2">
                        <label for="endereco" class="block text-left mb-2">Endereço:</label>
                        <input type="text" v-model="form.endereco" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.endereco" class="text-red-500">{{ errors.endereco[0] }}</span>
                    </div>

                    <div class="mt-2">
                        <label for="bairro" class="block text-left mb-2">Bairro:</label>
                        <input type="text" v-model="form.bairro" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.bairro" class="text-red-500">{{ errors.bairro[0] }}</span>
                    </div>

                    <div class="mt-2">
                        <label for="cidade" class="block text-left mb-2">Cidade:</label>
                        <input type="text" v-model="form.cidade" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.cidade" class="text-red-500">{{ errors.cidade[0] }}</span>
                    </div>

                    <div class="mt-2">
                        <label for="estado" class="block text-left mb-2">Estado:</label>
                        <input type="text" v-model="form.estado" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.estado" class="text-red-500">{{ errors.estado[0] }}</span>
                    </div>

                    <div class="mt-2">
                        <label for="telefone" class="block text-left mb-2">Telefone:</label>
                        <input type="text" v-model="form.telefone" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.telefone" class="text-red-500">{{ errors.telefone[0] }}</span>
                    </div>

                   <div class="mt-2">
                        <label for="username" class="block text-left mb-2">Username:</label>
                        <input type="text" v-model="form.username" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.username" class="text-red-500">{{ errors.username[0] }}</span>
                    </div>

                    <div class="mt-2">
                        <label for="password" class="block text-left mb-2">Password:</label>
                        <input type="password" v-model="form.password" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.password" class="text-red-500">{{ errors.password[0] }}</span>
                    </div> 

                    <div class="mt-2">
                        <button class="ml-4" :class="{ 'opacity-25': processing }" :disabled="processing">
                            Cadastrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>


<script>
export default {
    data() {
        return {
            form: {
                nome: '',
                cep: '',
                endereco: '',
                bairro: '',
                cidade: '',
                estado: '',
                telefone: '',
                username: '',
                password: ''
            },
            errors: {},
            processing: false
        };
    },
    methods: {
        async preencherEndereco() {
            if (this.form.cep.length === 8) {
                try {
                    const response = await fetch(`https://viacep.com.br/ws/${this.form.cep}/json/`);
                    const data = await response.json();
                    if (data.erro) {
                        this.errors.cep = ['CEP inválido.'];
                    } else {
                        this.form.endereco = data.logradouro;
                        this.form.bairro = data.bairro;
                        this.form.cidade = data.localidade;
                        this.form.estado = data.uf;
                    }
                } catch (error) {
                    console.error('Erro ao preencher endereço:', error);
                }
            }
        },
        async submit(event) {
            event.preventDefault();
            this.processing = true;
            try {
                const response = await axios.post('/pacientes', this.form);
                alert(response.data.message);
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
            } finally {
                this.processing = false;
            }
        }
    }
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
};
</script>
