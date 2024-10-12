<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const animais = ref([{ especie: '', nome: '' }]); // Inicializa um array para os animais
const form = ref({
    nome: '',
    cep: '',
    endereco: '',
    bairro: '',
    cidade: '',
    estado: '',
    telefone: '',
    username: '',
    password: '',
    temTutor: '',
});
const errors = ref({});
const processing = ref(false);

// Função para adicionar um novo animal
const addAnimal = () => {
    animais.value.push({ especie: '', nome: '' });
};

// Função para remover um animal pelo índice
const removeAnimal = (index) => {
    animais.value.splice(index, 1);
};

const submit = async (event) => {
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
        
};
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
            
            <div class="text-3xl text-gray-700 leading-relaxed text-center">
                <p class="mt-6">Cadastro de Pacientes</p>
            </div>

            <div class="leading-relaxed text-center max-w-md mx-auto">
                <form @submit="submit">
                    <!-- Animais -->
                    <div class="mt-6" v-for="(animal, index) in animais" :key="index">
                        <h3>Animal {{ index + 1 }}</h3>
                        <div class="mt-6">
                            <label for="especie" class="block text-left mb-2">Espécie:</label>
                            <input type="text" v-model="animal.especie" class="w-full px-3 py-2 border rounded" />
                            <span v-if="errors[`animais.${index}.especie`]">{{ errors[`animais.${index}.especie`][0] }}</span>
                        </div>
                        <div class="mt-6">
                            <label for="nomeAnimal" class="block text-left mb-2">Nome:</label>
                            <input type="text" v-model="animal.nome" class="w-full px-3 py-2 border rounded" />
                            <span v-if="errors[`animais.${index}.nome`]">{{ errors[`animais.${index}.nome`][0] }}</span>
                        </div>
                        <button type="button" @click="removeAnimal(index)">Remover Animal</button>
                    </div>
                    <button type="button" @click="addAnimal">Adicionar Animal</button>

                    <!-- Tem tutor? -->
                    <div class="mt-6">
                        <label for="temTutor" class="block text-left mb-2">Tem tutor?</label>
                        <select v-model="form.temTutor" class="block w-full px-4 py-2 mt-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500">
                            <option disabled value="">Selecione uma opção</option>
                            <option value="1">Sem tutor</option>
                            <option value="2">Com tutor</option>
                        </select>
                    </div>

                    <!-- Campos do Paciente -->
                    <div v-if="form.temTutor === '2'">
                        <div class="mt-6">
                            <label for="nome" class="block text-left mb-2">Nome:</label>
                            <input type="text" v-model="form.nome" class="w-full px-3 py-2 border rounded" />
                            <span v-if="errors.nome" class="text-red-500">{{ errors.nome[0] }}</span>
                        </div>
                        <div class="mt-6">
                            <label for="cep" class="block text-left mb-2">CEP:</label>
                            <input type="text" v-model="form.cep" @blur="preencherEndereco" class="w-full px-3 py-2 border rounded" />
                            <span v-if="errors.cep" class="text-red-500">{{ errors.cep[0] }}</span>
                        </div>
                        <div class="mt-6">
                            <label for="endereco" class="block text-left mb-2">Endereço:</label>
                            <input type="text" v-model="form.endereco" class="w-full px-3 py-2 border rounded" />
                            <span v-if="errors.endereco" class="text-red-500">{{ errors.endereco[0] }}</span>
                        </div>
                        <div class="mt-6">
                            <label for="bairro" class="block text-left mb-2">Bairro:</label>
                            <input type="text" v-model="form.bairro" class="w-full px-3 py-2 border rounded" />
                            <span v-if="errors.bairro" class="text-red-500">{{ errors.bairro[0] }}</span>
                        </div>
                        <div class="mt-6">
                            <label for="cidade" class="block text-left mb-2">Cidade:</label>
                            <input type="text" v-model="form.cidade" class="w-full px-3 py-2 border rounded" />
                            <span v-if="errors.cidade" class="text-red-500">{{ errors.cidade[0] }}</span>
                        </div>
                        <div class="mt-6">
                            <label for="estado" class="block text-left mb-2">Estado:</label>
                            <input type="text" v-model="form.estado" class="w-full px-3 py-2 border rounded" />
                            <span v-if="errors.estado" class="text-red-500">{{ errors.estado[0] }}</span>
                        </div>
                        <div class="mt-6">
                            <label for="telefone" class="block text-left mb-2">Telefone:</label>
                            <input type="text" v-model="form.telefone" class="w-full px-3 py-2 border rounded" />
                            <span v-if="errors.telefone" class="text-red-500">{{ errors.telefone[0] }}</span>
                        </div>
                        <div class="mt-6">
                            <label for="username" class="block text-left mb-2">Username:</label>
                            <input type="text" v-model="form.username" class="w-full px-3 py-2 border rounded" />
                            <span v-if="errors.username" class="text-red-500">{{ errors.username[0] }}</span>
                        </div>
                        <div class="mt-6">
                            <label for="password" class="block text-left mb-2">Password:</label>
                            <input type="password" v-model="form.password" class="w-full px-3 py-2 border rounded" />
                            <span v-if="errors.password" class="text-red-500">{{ errors.password[0] }}</span>
                        </div>
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

<style scoped>
.animal-form {
    margin-bottom: 20px;
}
</style>
