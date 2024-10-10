<template>
  <div class="bg-gray-100 min-h-screen flex flex-col">
    <Navbar />

    <div class="container mx-auto px-4 py-12">
      <h1 class="text-5xl font-bold text-gray-800 text-center mb-8">Clínica Veterinária</h1>

      <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <p class="text-lg text-gray-700 leading-relaxed mb-6 text-center">
          Na Clínica Veterinária, nossa missão é proporcionar o melhor cuidado para os seus pets.
          Contamos com uma equipe de veterinários experientes prontos para atender a todas as necessidades de saúde do seu animal de estimação.
        </p>
      </div>

      <h2 class="text-3xl font-bold text-gray-800 mt-8 text-center">Nossos Serviços:</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h3 class="font-semibold text-xl text-gray-800">Consulta Veterinária</h3>
          <p class="text-gray-700">Consultas para avaliar a saúde do seu pet.</p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h3 class="font-semibold text-xl text-gray-800">Vacinação e Vermifugação</h3>
          <p class="text-gray-700">Manutenção da saúde com vacinas e vermífugos.</p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h3 class="font-semibold text-xl text-gray-800">Exames e Diagnósticos</h3>
          <p class="text-gray-700">Exames laboratoriais para um diagnóstico preciso.</p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h3 class="font-semibold text-xl text-gray-800">Adoção de Animais</h3>
          <p class="text-gray-700">Encontre seu novo melhor amigo!</p>
        </div>
      </div>

      <div class="mt-8">
        <strong class="text-xl">Entre em contato</strong>
        <form @submit.prevent="sendEmail" class="mt-4 space-y-4">
          <div>
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" v-model="email" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" />
          </div>
          <div>
            <label for="subject" class="block text-gray-700">Assunto:</label>
            <input type="text" v-model="subject" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" />
          </div>
          <div>
            <label for="message" class="block text-gray-700">Mensagem:</label>
            <textarea v-model="message" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500"></textarea>
          </div>
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition">Enviar</button>
        </form>
      </div>
    </div>

    <p id="contatos" class="mt-8">
      <Fimdapagina />
    </p>
  </div>
</template>

<script setup>
import Navbar from './Navbar.vue';
import Fimdapagina from './Fimdapagina.vue';
import { ref } from 'vue';
import axios from 'axios';

const email = ref('');
const subject = ref('');
const message = ref('');

const sendEmail = async () => {
  try {
    const response = await axios.post('/send-email', {
      email: email.value,
      subject: subject.value,
      message: message.value,
    });
    alert(response.data.message);
  } catch (error) {
    console.error('Erro ao enviar email:', error);
    alert('Erro ao enviar email');
  }
};
</script>

<style scoped>
.container {
  /* Ajuste a largura e as margens conforme necessário */
}
</style>
