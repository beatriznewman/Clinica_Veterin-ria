<template>
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Pacientes Cadastrados
        </h2>
      </template>
  
      <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              <!-- Exibe uma mensagem se não houver pacientes -->
              <div v-if="!pacientes || pacientes.length === 0" class="text-center text-gray-600">
                Não há pacientes cadastrados.
              </div>
              <div v-else class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CEP</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Endereço</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bairro</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cidade</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Complemento</th>
                      <th scope="col" class="px-10 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animais</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="paciente in pacientes" :key="paciente.id">
                      <td class="px-3 py-4 text-sm text-gray-500">{{ paciente.id }}</td>
                      <td class="px-6 py-4 text-sm text-gray-900">{{ paciente.nome }}</td>
                      <td class="px-6 py-4 text-sm text-gray-500">{{ paciente.cep || 'Não informado' }}</td>
                      <td class="px-6 py-4 text-sm text-gray-500">{{ paciente.endereco || 'Não informado' }}</td>
                      <td class="px-6 py-4 text-sm text-gray-500">{{ paciente.bairro || 'Não informado' }}</td>
                      <td class="px-6 py-4 text-sm text-gray-500">{{ paciente.cidade || 'Não informado' }}</td>
                      <td class="px-6 py-4 text-sm text-gray-500">{{ paciente.estado || 'Não informado' }}</td>
                      <td class="px-6 py-4 text-sm text-gray-500">{{ paciente.complemento || 'Não informado' }}</td>
                      <td class="px-10 py-4 text-sm text-gray-500">
                        {{ formatPhone(paciente.telefone) || 'Não informado' }}
                      </td>
                      <td class="px-6 py-4 text-sm text-gray-500">
                        <ul>
                          <li v-for="animal in paciente.animals" :key="animal.id">
                            {{ animal.nome }}
                          </li>
                        </ul>
                        <span v-if="!paciente.animals || paciente.animals.length === 0">Sem animais</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { ref, defineProps } from 'vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  
  // Propriedades recebidas do backend
  const props = defineProps({
    pacientes: Array, // Lista de pacientes recebida do backend
  });
  
  // Função para formatar telefone
  const formatPhone = (phone) => {
    if (!phone) return '';
    return phone.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
  };
  </script>
  