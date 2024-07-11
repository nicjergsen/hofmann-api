<template>
    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <table class="rounded-t-lg mt-5 min-w-full mx-auto bg-gray-800 text-gray-100">
                        <thead>
                        <tr class="text-left border-b border-gray-300">
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Código</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">Monto</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="bg-gray-700 border-b border-gray-600 text-gray-200">
                        <tr v-for="user in users" :key="user.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium">{{ user.id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">{{ user.code }}</div>                    
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">{{ formatAmount(user.amount) }}</div>                    
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">{{ formatDate(user.date) }}</div>                    
                            </td>
                            <td class="flex m-2">     
                                <button @click="openEditModal(user)" class="flex-shrink-0 bg-purple-600 text-white text-base font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-purple-200">Editar</button>                      
                            </td>
                        </tr>   
                        </tbody>
                    </table>

                </div>    
            </div>
       </div>
       <!-- Modal de Edición -->
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <h2 class="text-2xl font-semibold mb-4">Editar Usuario</h2>
            <form @submit.prevent="updateUser">
            <div class="mb-4">
                <label for="editId" class="block text-sm font-medium text-gray-700">ID</label>
                <input id="editId" type="text" v-model="editedUser.id" disabled class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="editCode" class="block text-sm font-medium text-gray-700">Código</label>
                <select id="editCode" v-model="editedUser.code" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option v-for="code in userCodes" :key="code.id" :value="code.code">{{ code.code }}</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="editAmount" class="block text-sm font-medium text-gray-700">Monto</label>
                <input id="editAmount" type="text" v-model="editedUser.amount" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="editDate" class="block text-sm font-medium text-gray-700">Fecha</label>
                <input id="editDate" type="date" v-model="fechaISO" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="text-right">
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-purple-200">Guardar Cambios</button>
                <button type="button" @click="closeModal" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md ml-2 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-200">Cancelar</button>
            </div>
            </form>
        </div>
        </div>    
    </AppLayout>
  </template>
  
  <script>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    props: {
        users: Array
    },
    components: {
      AppLayout,
    },
    data() {
        return {
            showModal: false,
            editedUser: {
                id: '',
                code: '',
                amount: '',
                date: ''
            },
            userCodes: []
        };
    },
    mounted() {
        this.fetchUserCodes();
    },
    computed: {
        fechaISO() {
            if (this.editedUser.date) {
                const [day, month, year] = this.editedUser.date.split('-');
                return `${year}-${month}-${day}`;
            }
            return '';
        }
    },
    methods: {
        async fetchUserCodes() {
            try {
                const response = await axios.get('api/getuserscode');
                this.userCodes = response.data;
                console.log('Códigos de usuarios obtenidos:', this.userCodes);
            } catch (error) {
                console.error('Error al obtener los códigos de usuarios:', error);
            }
        },
        openEditModal(user) {
            this.editedUser = { ...user, date: this.formatDate(user.date) };
            console.log(this.editedUser);
            this.showModal = true;
        },
        updateUser() {
            const githubUser = 'nicjergsen';
            const formattedDate = this.formatDateTime(this.editedUser.date);
            
            const userPayload = {
                id: this.editedUser.id,
                code: this.editedUser.code,
                amount: this.editedUser.amount,
                date: formattedDate,
                github: `https://github.com/${githubUser}`
            };

            this.sendUserData(userPayload);
            this.closeModal();
        },
        async sendUserData(payload) {
            try {
                const response = await axios.post('api/senduser', payload);
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación exitosa!',
                    text: 'Los cambios se guardaron correctamente.',
                    confirmButtonText: 'Aceptar'
                });
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al procesar la solicitud.',
                    confirmButtonText: 'Aceptar'
                });
            }
        },
        closeModal() {
            this.showModal = false;
        },
        formatDate(dateToFormat) {
            if (dateToFormat) {
                const date = new Date(dateToFormat);
                const day = date.getDate().toString().padStart(2, '0');
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            }
            return '';
        },
        formatAmount(amountToFormat) {
            if (amountToFormat !== undefined && amountToFormat !== null) {
                return new Intl.NumberFormat('es-CL').format(amountToFormat)
            }
            return '';
        },
        formatDateTime(dateToFormat) {
            const [day, month, year] = dateToFormat.split('-');
            const formattedDate = `${year}-${month}-${day}`;
            const currentTime = new Date().toISOString().split('T')[1];
            const combinedDateTime = new Date(`${formattedDate}T${currentTime}`);

            return combinedDateTime.toISOString();
        },
    }
};
</script>