<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"></h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <div
                        class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                        role="alert"
                        v-if="$page.flash.message"
                    >
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
                                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2"
                                        >名前:
                                    </label>
                                    <input
                                        type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="exampleFormControlInput1"
                                        placeholder="Enter Title"
                                        v-model="form.name"
                                    />
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2"
                                        >報告日時:</label
                                    >
                                    <input
                                        type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="exampleFormControlInput1"
                                        placeholder="Enter Title"
                                        v-model="form.date"
                                    />
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2"
                                        >所属部署:</label
                                    >
                                    <input
                                        type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="exampleFormControlInput1"
                                        placeholder="Enter Title"
                                        v-model="form.team"
                                    />
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2"
                                        >業務報告(午前):</label
                                    >
                                    <div>
                                        <p>Selected: {{ selectedValue }}</p>
                                        <FilterableDropdown
                                            v-model="selectedValue"
                                            :items="items"
                                            :showEmptyItem="true"
                                            :disabled="false"
                                            :ignoreCase="true"
                                            emptyItemValue="SAMPLE_EMPTY_VALUE"
                                            emptyItemText=""
                                            placeholder="業務内容を選択してください。"
                                            name="fruit"
                                            idKey="id"
                                            valueKey="name"
                                            textKey="name"
                                            filterTargetKey="name"
                                        />
                                    </div>
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <textarea
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="exampleFormControlInput2"
                                        v-model="form.body"
                                        placeholder="内容"
                                    ></textarea>
                                    <div v-if="$page.errors.body" class="text-red-500">
                                        {{ $page.errors.body[0] }}
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2"
                                        >業務報告(午後):</label
                                    >
                                    <div>
                                        <p>Selected: {{ selectedValue }}</p>
                                        <FilterableDropdown
                                            v-model="selectedValue"
                                            :items="items"
                                            :showEmptyItem="true"
                                            :disabled="false"
                                            :ignoreCase="true"
                                            emptyItemValue="SAMPLE_EMPTY_VALUE"
                                            emptyItemText=""
                                            placeholder="業務内容を選択してください。"
                                            name="fruit"
                                            idKey="id"
                                            valueKey="name"
                                            textKey="name"
                                            filterTargetKey="name"
                                        />
                                    </div>
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2"
                                        >業務内容(フリーワード):</label
                                    >
                                    <input
                                        type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="exampleFormControlInput1"
                                        placeholder="Enter Title"
                                        v-model="form.title"
                                    />
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <textarea
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="exampleFormControlInput2"
                                        v-model="form.body"
                                        placeholder="内容"
                                    ></textarea>
                                    <div v-if="$page.errors.body" class="text-red-500">
                                        {{ $page.errors.body[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button
                                    wire:click.prevent="store()"
                                    type="button"
                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    v-show="!editMode"
                                    @click="save(form)"
                                >
                                    Save
                                </button>
                            </span>
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button
                                    wire:click.prevent="store()"
                                    type="button"
                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    v-show="editMode"
                                    @click="update(form)"
                                >
                                    Update
                                </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button
                                    @click="closeModal()"
                                    type="button"
                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                >
                                    Cancel
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
import FilterableDropdown from './components/FilterableDropdown.vue';

// 日付取得用
var today = new Date();
var today = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();

// vue
import AppLayout from './../Layouts/AppLayout';
import Welcome from './../Jetstream/Welcome';
export default {
    components: {
        AppLayout,
        Welcome,
        FilterableDropdown,
    },
    props: ['data', 'errors'],
    data() {
        return {
            editMode: false,
            isOpen: false,
            form: {
                name: this.$page.user.name,
                team: this.$page.user.current_team.name,
                date: today,
                title: null,
                body: null,
            },
            selectedValue: null,
            items: [
                { id: 1, name: '出張' },
                { id: 2, name: '会議' },
            ],
        };
    },
    methods: {
        openModal: function() {
            this.isOpen = true;
        },
        closeModal: function() {
            this.isOpen = false;
            this.reset();
            this.editMode = false;
        },
        reset: function() {
            this.form = {
                title: null,
                body: null,
            };
        },
        save: function(data) {
            this.$inertia.post('/posts', data);
            this.reset();
            this.closeModal();
            this.editMode = false;
        },
        edit: function(data) {
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.openModal();
        },
        update: function(data) {
            data._method = 'PUT';
            this.$inertia.post('/posts/' + data.id, data);
            this.reset();
            this.closeModal();
        },
        deleteRow: function(data) {
            if (!confirm('Are you sure want to remove?')) return;
            data._method = 'DELETE';
            this.$inertia.post('/posts/' + data.id, data);
            this.reset();
            this.closeModal();
        },
    },
};
</script>
