<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
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

                    <!-- Animal -->
                    <div class="mt-6">
                        <label for="nomeAnimal" class="block text-left mb-2">Especie:</label>
                        <input type="text" v-model="form.especie" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.especie" class="text-red-500">{{ errors.especie[0] }}</span>
                    </div>

                    <!-- Nome -->
                    <div class="mt-6">
                        <label for="nomeanimal" class="block text-left mb-2">Nome:</label>
                        <input type="text" v-model="form.nomeAnimal" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.nomeAnimal" class="text-red-500">{{ errors.nomeAnimal[0] }}</span>
                    </div>

                    <!-- Tem tutor? -->
                    <div class="mt-6">
                        <label for="temTutor" class="block text-left mb-2">Tem tutor?</label>
                        <select v-model="form.temTutor" class="block w-full px-4 py-2 mt-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500">
                            <option disabled value="">Selecione uma opção</option>
                            <option value="1">Sem tutor</option>
                            <option value="2">Com tutor</option>
                        </select>
                    </div>

                    <!-- Campos adicionais para tutor -->
                    <div v-if="form.temTutor === '2'" class="mt-6">
                        <label for="nome" class="block text-left mb-2">Nome:</label>
                        <input type="text" v-model="form.nome" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.nome" class="text-red-500">{{ errors.nome[0] }}</span>
                   
                        <label for="cep" class="block text-left mb-2">CEP:</label>
                        <input type="text" v-model="form.cep" @blur="preencherEndereco" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.cep" class="text-red-500">{{ errors.cep[0] }}</span>
                    
                        <label for="endereco" class="block text-left mb-2">Endereço:</label>
                        <input type="text" v-model="form.endereco" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.endereco" class="text-red-500">{{ errors.endereco[0] }}</span>
                   
                        <label for="bairro" class="block text-left mb-2">Bairro:</label>
                        <input type="text" v-model="form.bairro" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.bairro" class="text-red-500">{{ errors.bairro[0] }}</span>
                   
                        <label for="cidade" class="block text-left mb-2">Cidade:</label>
                        <input type="text" v-model="form.cidade" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.cidade" class="text-red-500">{{ errors.cidade[0] }}</span>
                  
                        <label for="estado" class="block text-left mb-2">Estado:</label>
                        <input type="text" v-model="form.estado" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.estado" class="text-red-500">{{ errors.estado[0] }}</span>
                   
                        <label for="telefone" class="block text-left mb-2">Telefone:</label>
                        <input type="text" v-model="form.telefone" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.telefone" class="text-red-500">{{ errors.telefone[0] }}</span>
                 
                        <label for="username" class="block text-left mb-2">Username:</label>
                        <input type="text" v-model="form.username" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.username" class="text-red-500">{{ errors.username[0] }}</span>
                    
                        <label for="password" class="block text-left mb-2">Password:</label>
                        <input type="password" v-model="form.password" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.password" class="text-red-500">{{ errors.password[0] }}</span>
                    
                    </div>

                    <!-- Botão de cadastro -->
                    <div class="mt-6">
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
                nomeAnimal: '',
                nome: '',
                temTutor: '', // Adiciona um campo para armazenar a escolha sobre o tutor
                paciente_id: '', // ou o valor correto

            },
            errors: {},
            processing: false
        };
    },
    methods: {
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
};
</script>