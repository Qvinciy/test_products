<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <button @click="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create New Product</button>
                    <button @click="updateGoogleSheets()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded my-3 ml-9">Обновить из “Google Sheets”</button>
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-20">id</th>
                                <th class="px-4 py-2">name</th>
                                <th class="px-4 py-2">qty</th>
                                <th class="px-4 py-2">desc</th>
                                <th class="px-4 py-2">price</th>
                                <th class="px-4 py-2">img</th>
                                <th class="px-4 py-2">availability</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in products">
                                <td class="border px-4 py-2">{{ row.id }}</td>
                                <td class="border px-4 py-2">{{ row.name }}</td>
                                <td class="border px-4 py-2">{{ row.qty }}</td>
                                <td class="border px-4 py-2">{{ row.description }}</td>
                                <td class="border px-4 py-2">{{ row.price }}</td>
                                <td class="border px-4 py-2"> <img
                                                                    class="p-4 max-w-full" :alt="row.name"
                                                                    :src="row.image"
                                                                /></td>
                                <td class="border px-4 py-2">{{ row.availability }}</td>
                                <td class="border px-4 py-2">
                                    <button @click="edit(row)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                                    <button @click="deleteRow(row)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                        <div class="fixed inset-0 transition-opacity">
                          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <!-- This element is to trick the browser into centering the modal contents. -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                          <form>
                          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="">
                                  <div class="mb-4">
                                      <label for="name" class="block text-gray-700 text-sm font-bold mb-2">name:</label>
                                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" placeholder="Enter name" v-model="form.name">
                                  </div>

                                  <div class="mb-4">
                                      <label for="qty" class="block text-gray-700 text-sm font-bold mb-2">qty:</label>
                                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="qty" placeholder="Enter qty" v-model="form.qty">
                                  </div>

                                  <div class="mb-4">
                                      <label for="description" class="block text-gray-700 text-sm font-bold mb-2">desc:</label>
                                      <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" v-model="form.description" placeholder="Enter desc"></textarea>
                                  </div>

                                  <div class="mb-4">
                                      <label for="price" class="block text-gray-700 text-sm font-bold mb-2">price:</label>
                                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" placeholder="Enter price" v-model="form.price">
                                  </div>

                                  <div class="mb-4">
                                      <label for="image" class="block text-gray-700 text-sm font-bold mb-2">img:</label>
                                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" placeholder="Enter img" v-model="form.image">
                                  </div>

                                  <div class="mb-4">
                                      <label for="availability" class="block text-gray-700 text-sm font-bold mb-2">availability:</label>
                                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="availability" placeholder="Enter availability" v-model="form.availability">
                                  </div>
                            </div>
                          </div>
                          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="!editMode" @click="save(form)">
                                Save
                              </button>
                            </span>
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode" @click="update(form)">
                                Update
                              </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                              <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cancel
                              </button>
                            </span>
                          </div>
                          </form>

                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    export default {
        props: ['data', 'errors'],
        data() {
            return {
                editMode: false,
                isOpen: false,
                form: {
                    name: null,
                    qty: null,
                    description: null,
                    price: null,
                    image: null,
                    availability: null,
                },
                products: null,
            }
        },
        methods: {
            updateGoogleSheets: function () {
                this.$inertia.post('/update_google_sheets');
                this.reset();
            },
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
            },
            reset: function () {
                this.form = {
                    name: null,
                    qty: null,
                    description: null,
                    price: null,
                    image: null,
                    availability: null,
                };
                (async () => {
                    this.products = (await axios.get("/api/list")).data;
                })();
            },
            save: function (data) {
                this.$inertia.post('/products', data);
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function (data) {
                data._method = 'PUT';
                this.$inertia.post('/products/' + data.id, data);
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Are you sure want to remove?')) return;
                data._method = 'DELETE';
                this.$inertia.post('/products/' + data.id, data);
                this.reset();
                this.closeModal();
            }
        },
        async beforeCreate() {
              this.products = (await axios.get("/api/list")).data;
        }
    }
</script>
