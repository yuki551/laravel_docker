<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                社員登録
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
                                    社員名:
                                    <input
                                        type="text"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="社員名を入力してください"
                                        v-model="form.name"

                                    />
                                    </label>
                                    <div v-if="$page.errors.name" class="text-red-500">
                                        {{ $page.errors.name[0] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    メールアドレス:
                                    <input
                                        type="text"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="メールアドレスを入力してください"
                                        v-model="form.email"
                                    />
                                    </label>
                                    <div v-if="$page.errors.email" class="text-red-500">
                                        {{ $page.errors.email[0] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    パスワード:
                                    <input
                                        type="text"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="パスワードを入力してください"
                                        v-model="form.password"
                                    />
                                    </label>
                                    <div v-if="$page.errors.password" class="text-red-500">
                                        {{ $page.errors.password[0] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    所属部署:
                                        <select v-model="form.current_team_id">
                                            <option disabled value="">所属部署を選択してください</option>
                                            <option v-for="team in teams"
                                                v-bind:value="team.id">
                                                {{ team.name }}
                                            </option>
                                        </select>
                                    </label>
                                    <div v-if="$page.errors.current_team_id" class="text-red-500">
                                        {{ $page.errors.current_team_id[0] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    役職:
                                        <select v-model="form.role_id">
                                            <option disabled value="">役職を選択してください</option>
                                            <option v-for="role in roles"
                                                v-bind:value="role.role_id">
                                                {{ role.name }}
                                            </option>
                                        </select>
                                    </label>
                                    <div v-if="$page.errors.role_id" class="text-red-500">
                                        {{ $page.errors.role_id[0] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    管理者権限:
                                        <select v-model="form.auth_id">
                                            <option disabled value="">管理者権限を選択してください</option>
                                            <option v-for="auth in authItem"
                                                v-bind:value="auth.id">
                                                {{ auth.name }}
                                            </option>
                                        </select>
                                    </label>
                                    <div v-if="$page.errors.auth_id" class="text-red-500">
                                        {{ $page.errors.auth_id[0] }}
                                    </div>
                                </div>

                                    <input
                                        type="hidden"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        v-model="form.confirm"
                                    />


                            </div>
                        </div>
                        <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button
                                    wire:click.prevent="confirm()"
                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    v-show="!editMode"
                                    @click="confirm(form)">
                                    登録
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
import AppLayout from './../../Layouts/AppLayout';
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import JetButton from "@/Jetstream/Button";
import JetInputError from "@/Jetstream/InputError";

export default {
    components: {
        AppLayout,
        JetFormSection,
        JetInput,
        JetLabel,
        JetButton,
        JetInputError,
    },
    props: ['dataTeam','dataRole'],
    data() {
        return {
            editMode: false,
            isOpen: false,
            form: this.$inertia.form( {

                name: null,
                email: null,
                password: null,
                current_team_id: "",
                role_id: "10",
                auth_id: "0",
                confirm: 1,
            },
            {
                bag: "userCreate",
                resetOnSuccess: false,
            }
            ),
            authItem: [
                { id: 0, name: '無し' },
                { id: 1, name: '有り' },
            ],
        };
    },
    computed: {
        // ログインしているユーザーの投稿のみデータを格納。
        teams: function() {
            return this.dataTeam;
        },
        roles: function() {
            return this.dataRole;
        },
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
            data._method = "POST";
            this.$inertia.post('/users/confirm', data);
            this.reset();
        },
        edit: function(data) {
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.openModal();
        },
        update: function(data) {
            data._method = 'PUT';
            this.$inertia.post('/employee_create/' + data.id, data);
            this.reset();
        },

        createUser(){
            this.form.post(route("user.store"));
        },
        confirm(data){
            data._method = 'POST';
            this.form.post(route('user.confirm'));
        },
    },
};
</script>
