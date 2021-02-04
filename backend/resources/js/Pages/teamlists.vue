<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                部署一覧
            </h2>
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
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2" v-if="$page.user.auth_id == 1">編集</th>
                                <th class="px-4 py-2">名前</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in userPosts">

                                <td class="border px-4 py-2" v-if="$page.user.auth_id == 1">
                                    <div>
                                        <a :href="route('teamlist.edit',row.id)">
                                            <jet-button class="bg-blue-700 text-base">編集</jet-button>
                                        </a>
                                    </div>
                                </td>
                                <td class="border px-4 py-2">{{ row.name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from './../Layouts/AppLayout';
import JetButton from "@/Jetstream/Button";

export default {
    components: {
        AppLayout,
        JetButton,
    },
    props: ['data', 'errors', 'conf'],
    data() {
        return {
            editMode: false,
            isOpen: false,
            userPost: [],
            form: {
                status: 0,
            },
        };
    },
    computed: {
        // ログインしているユーザーの投稿のみデータを格納。
        userPosts: function() {
            return this.data;
        },
    },
    methods: {
        // openModal: function() {
        //     this.isOpen = true;
        // },
        // closeModal: function() {
        //     this.isOpen = false;
        //     this.reset();
        //     this.editMode = false;
        // },
        reset: function() {
            this.form = {
                title: null,
                body: null,
            };
        },
        save: function(data) {
            this.$inertia.post('/dashboard', data);
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
            this.$inertia.post('/dashboard/' + data.id, data);
            this.reset();
            this.closeModal();
        },
        replyRow: function(data) {
            data._method = 'PUT';
            data['status'] = 3;
            this.$inertia.post('/dashboard/' + data.id, data);
            console.log(data);
        },
        // deleteRow: function(data) {
        //     if (!confirm('Are you sure want to remove?')) return;
        //     data._method = 'DELETE';
        //     this.$inertia.post('/dashboard/' + data.id, data);
        //     this.reset();
        //     this.closeModal();
        // },
    },
};
</script>
<style></style>
