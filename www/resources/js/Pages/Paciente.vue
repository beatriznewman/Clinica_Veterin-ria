<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Cadastro de Pacientes" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Cadastro de Pacientes
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
                        <div v-if="errorMessage" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            {{ errorMessage }}
                        </div>

                        <form @submit.prevent="submitForm" class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <label for="nome" class="w-32 text-right">Nome:</label>
                                <input type="text" v-model="form.nome" id="nome" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" />
                                <span v-if="errors.nome" class="text-red-500 text-left">{{ errors.nome[0] }}</span>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label for="cep" class="w-32 text-right">CEP:</label>
                                <input type="text" v-model="form.cep" id="cep" @blur="preencherEndereco" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" />
                                <span v-if="errors.cep" class="text-red-500 text-left">{{ errors.cep[0] }}</span>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label for="endereco" class="w-32 text-right">Endereço:</label>
                                <input type="text" v-model="form.endereco" id="endereco" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" />
                                <span v-if="errors.endereco" class="text-red-500 text-left">{{ errors.endereco[0] }}</span>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label for="bairro" class="w-32 text-right">Bairro:</label>
                                <input type="text" v-model="form.bairro" id="bairro" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" />
                                <span v-if="errors.bairro" class="text-red-500 text-left">{{ errors.bairro[0] }}</span>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label for="cidade" class="w-32 text-right">Cidade:</label>
                                <input type="text" v-model="form.cidade" id="cidade" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" />
                                <span v-if="errors.cidade" class="text-red-500 text-left">{{ errors.cidade[0] }}</span>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label for="estado" class="w-32 text-right">Estado:</label>
                                <input type="text" v-model="form.estado" id="estado" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" />
                                <span v-if="errors.estado" class="text-red-500 text-left">{{ errors.estado[0] }}</span>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label for="telefone" class="w-32 text-right">Telefone:</label>
                                <input type="text" v-model="form.telefone" id="telefone" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" />
                                <span v-if="errors.telefone" class="text-red-500 text-left">{{ errors.telefone[0] }}</span>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label for="username" class="w-32 text-right">Username:</label>
                                <input type="text" v-model="form.username" id="username" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" />
                                <span v-if="errors.username" class="text-red-500 text-left">{{ errors.username[0] }}</span>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label for="password" class="w-32 text-right">Password:</label>
                                <input type="password" v-model="form.password" id="password" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" />
                                <span v-if="errors.password" class="text-red-500 text-left">{{ errors.password[0] }}</span>
                            </div> 

                            <div class="flex justify-end mt-4 mb-4">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">
                                    Cadastrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </AuthenticatedLayout>
</template>

<script>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

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
            processing: false, 
            message: '',
            errorMessage: ''
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
                        this.form.endereco = data.logradouro || '';
                        this.form.bairro = data.bairro || '';
                        this.form.cidade = data.localidade || '';
                        this.form.estado = data.uf || '';
                    }
                } catch (error) {
                    console.error('Erro ao preencher endereço:', error);
                }
            }
        },
        async submitForm() {
            this.message = '';
            this.errorMessage = '';
            try {
                const response = await Inertia.post('/pacientes', this.form);
                this.message = 'Paciente cadastrado com sucesso!';
                this.resetForm();
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
            } finally {
                this.processing = false;
            }
        },
        resetForm() {
            this.form.nome = '';
            this.form.cep = '';
            this.form.endereco = '';
            this.form.bairro = '';
            this.form.cidade = '';
            this.form.estado = '';
            this.form.telefone = '';
            this.form.username = '';
            this.form.password = '';
        }
    }
};
</script>
