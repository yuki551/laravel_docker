<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                部署編集
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <div
                        class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                        role="alert"
                        v-if="$page.flash.message">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ $page.flash.message }}</p>
                            </div>
                        </div>
                    </div>
                    <form>
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    部署名:
                                    <input
                                        type="text"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="登録する顧客名を入力してください"
                                        v-model="form.name"
                                    />
                                    </label>
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button
                                    wire:click.prevent="update()"
                                    type="button"
                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    v-show="!editMode"
                                    @click="edit(form)">
                                    更新
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
// vue
import AppLayout from './../Layouts/AppLayout';
export default {
    components: {
        AppLayout,
    },
    props: ['data'],
    data() {
        return {
            editMode: false,
            isOpen: false,
            form: {
                id: this.data.id,
                name: this.data.name,
            },
        };
    },
    methods: {
        openModal: function() {
            this.isOpen = true;
        },
        reset: function() {
            this.form = {
                title: null,
                body: null,
            };
        },
        save: function(data) {
            this.$inertia.post('/clients_create', data);
            this.reset();
            this.editMode = false;
        },
        edit: function(data) {
            data._method = 'PUT';
            this.$inertia.put('/teamlists/' + data.id, data);
            this.editMode = true;
            this.openModal();
        },
        update: function(data) {
            data._method = 'PUT';
            this.$inertia.post('/clients_create/' + data.id, data);
            this.reset();
        },
        editUser: function(data){
            data._method = 'PUT';
            this.$inertia.put('/users/' + data.id, data);
            this.reset();
        },
    },
};
</script>
