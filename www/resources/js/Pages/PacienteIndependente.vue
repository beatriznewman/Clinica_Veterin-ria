<script setup>
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>

    <!--comando abaixo verifica quais sao os roles e permission do user logado-->
    <!--
    <div>
        {{ $page.props }}
    </div>
    -->
    <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:mt-6 sm:-my-px sm:ml-10 sm:flex">
                                <a :href="route('dashboard')">Ir para Login</a>
                            </div>
                        </div>
                    </div>
                </div>

            </nav>

            <div class="text-3xl text-gray-700 leading-relaxed text-center">
                <p class="mt-6">Cadastro de Tutor</p>
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
                        <label for="complemento" class="block text-left mb-2">Complemento:</label>
                        <input type="text" v-model="form.complemento" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.complemento" class="text-red-500">{{ errors.complemento[0] }}</span>
                    </div>

                    <div class="mt-2">
                        <label for="telefone" class="block text-left mb-2">Telefone:</label>
                        <input type="text" v-model="form.telefone" @input="formatarTelefone" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.telefone" class="text-red-500">{{ errors.telefone[0] }}</span>
                    </div>

                   <div class="mt-2">
                        <label for="username" class="block text-left mb-2">Usuario:</label>
                        <input type="text" v-model="form.username" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.username" class="text-red-500">{{ errors.username[0] }}</span>
                    </div>

                    <div class="mt-2">
                        <label for="password" class="block text-left mb-2">Senha:</label>
                        <input type="password" v-model="form.password" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.password" class="text-red-500">{{ errors.password[0] }}</span>
                    </div> 

                    <div class="mt-2">
                        <label for="password_confirmation" class="block text-left mb-2">Confirmar Senha:</label>
                        <input type="password" v-model="form.password_confirmation" class="w-full px-3 py-2 border rounded" />
                        <span v-if="errors.password_confirmation" class="text-red-500">{{ errors.password_confirmation[0] }}</span>
                    </div>

                    <div class="mt-2">
                        <button class="ml-4" :class="{ 'opacity-25': processing }" :disabled="processing">
                            Cadastrar
                        </button>
                    </div>
                </form>
            </div>

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
                complemento:'',
                telefone: '',
                username: '',
                password: '',
                password_confirmation: ''
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
        formatarTelefone(event) {
            // Remove todos os caracteres que não são números
            const valorSomenteNumeros = event.target.value.replace(/\D/g, '');
            // Atualiza o valor no modelo
            this.form.telefone = valorSomenteNumeros;
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
};
</script>
