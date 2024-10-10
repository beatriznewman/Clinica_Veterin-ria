<template>
    <div class="bg-gray-100 min-h-screen flex flex-col">
      <Navbar />

      <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
          <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Clínica Veterinária</h1>

           <!-- Imagem redonda -->
        <div class="flex justify-center mb-8">
          <img src="https://i.pinimg.com/236x/f4/5d/22/f45d22ca31d82fd0bf7101dda9e9e051.jpg" alt="Clínica Veterinária" class="w-40 h-40 rounded-full">
        </div>

          <div class="text-lg text-gray-700 leading-relaxed text-center">
            <p>
              Bem-vindo à Clínica Veterinária!
              Cuidar dos nossos amigos de quatro patas é nossa paixão! Aqui, oferecemos atendimento veterinário de alta qualidade para garantir o bem-estar e a saúde dos seus pets. Desde consultas de rotina até tratamentos especializados, nossa equipe está pronta para cuidar do seu animal com carinho e profissionalismo.
              Além dos cuidados veterinários, também acreditamos em dar uma segunda chance aos animais que precisam de um lar. Nosso programa de adoção é uma oportunidade para você conhecer e se apaixonar por cães e gatos que estão à procura de uma família. Venha nos visitar e faça parte dessa linda jornada de amor e cuidado!
              Serviços oferecidos:
              -Consultas veterinárias
              -Vacinação e prevenção de doenças
              -Cirurgias e cuidados de emergência
              -Programa de adoção
              Nosso compromisso é com a saúde e felicidade dos animais, oferecendo um espaço seguro e acolhedor para que eles possam se sentir em casa.
              Venha nos conhecer e descubra como podemos cuidar do seu pet e, quem sabe, encontrar um novo amigo para sua família
            </p>
            <p class="mt-8">
              <strong>Contate-nos:</strong> Telefone: (19) 98210-1158 / (19) 99274-6359
            </p>
            <p class="mb-12">
              Agende sua consulta hoje e permita-se surpreender com os nossos serviços dedicados ao bem-estar do seu amigo.
            </p>

            <div class="mt-8">
              <strong>Entre em contato</strong>
              <form @submit.prevent="sendEmail" class="mt-4">
                <div class="mb-4">
                  <label for="email" class="block text-gray-700">Email:</label>
                  <input type="email" v-model="email" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" />
                </div>
                <div class="mb-4">
                  <label for="subject" class="block text-gray-700">Assunto:</label>
                  <input type="text" v-model="subject" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" />
                </div>
                <div class="mb-4">
                  <label for="message" class="block text-gray-700">Mensagem:</label>
                  <textarea v-model="message" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Enviar</button>
              </form>
            </div>
          </div>
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
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue';

    defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    });

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