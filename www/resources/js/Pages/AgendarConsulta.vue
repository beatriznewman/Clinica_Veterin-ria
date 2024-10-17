<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
  <Head title="Pagina do Cliente" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Agendar Consulta
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
            <div class="flex items-center mb-2">
              <label for="animal" class="w-1/3 text-right">Animal:</label>
              <select v-model="form.animal_id" id="animal" required class="ml-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-2/3">
                <option value="" disabled selected>Selecione um animal</option>
                <option v-for="animal in animals" :key="animal.id" :value="animal.id">
                  {{ animal.nome }}
                </option>
              </select>
            </div>

            <div class="flex items-center mb-2">
              <label for="user" class="w-1/3 text-right">Veterinário:</label>
              <select v-model="form.user_id" id="user" required class="ml-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-2/3">
                <option v-for="user in users" :key="user.id" :value="user.id">
                  {{ user.nome }}
                </option>
              </select>
            </div>

            <div class="flex items-center mb-2">
              <label for="data" class="w-1/3 text-right">Data:</label>
              <input type="date" v-model="form.data" id="data" required class="ml-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-2/3">
            </div>

            <div class="flex items-center mb-2">
              <label for="horario_inicio" class="w-1/3 text-right">Horário de Início:</label>
              <select v-model="form.horario_inicio" id="horario_inicio" @change="calcularHorarioFim" required class="ml-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-2/3">
                <option v-for="horario in horarios" :key="horario" :value="horario">
                  {{ horario }}
                </option>
              </select>
            </div>

            <p v-if="horarioFimCalculado" class="mt-4">Horário de Fim: {{ horarioFimCalculado }}</p>

            <div class="flex justify-center mt-4 mb-2">
              <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">
                Agendar Consulta
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
  props: {
    users: Array,
    animals: Array,
    success: String,
    error: String,
  },
  data() {
    return {
      form: {
        user_id: '',
        animal_id: '',
        data: '',
        horario_inicio: '',
        horario_fim: ''
      },
      horarioFimCalculado: '',
      horarios: this.horariosDisponiveis(),
      message: this.success || '',
      errorMessage: this.error || ''
    };
  },
  methods: {
    horariosDisponiveis() {
      const horarios = [];
      for (let i = 8; i < 20; i++) {
        const hora = i.toString().padStart(2, '0');
        horarios.push(`${hora}:00`);
        horarios.push(`${hora}:30`);
      }
      return horarios;
    },
    calcularHorarioFim() {
      if (this.form.horario_inicio) {
        const inicio = new Date(`1970-01-01T${this.form.horario_inicio}`);
        const fim = new Date(inicio.getTime() + 45 * 60000); // Adiciona 45 minutos
        this.horarioFimCalculado = fim.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        this.form.horario_fim = this.horarioFimCalculado;
      }
    },
    async submitForm() {
      this.message = '';
      this.errorMessage = '';
      try {
        await Inertia.post(route('consultas.store'), this.form, {
          onSuccess: (response) => {
            console.log('Resposta de sucesso:', response);
            this.message = 'Consulta agendada com sucesso!';
            this.resetForm();
          },
          onError: (error) => {
            console.log('Erro recebido:', error);
            this.errorMessage = error.error || 'Erro ao agendar a consulta.';
          }
        });
      } catch (error) {
        console.error('Erro inesperado:', error);
        this.errorMessage = 'Erro inesperado ao agendar.';
      }
    },
    resetForm() {
      this.form.user_id = '';
      this.form.data = '';
      this.form.horario_inicio = '';
      this.horarioFimCalculado = '';
    }
  }
};
</script>
