<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                社員編集
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
                                    ID:{{ form.id }}
                                    <input
                                        type="hidden"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="社員名を入力してください"
                                        v-model="form.id"
                                    />
                                    </label>
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
                                    </div>
                                </div>


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
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
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
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
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
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
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
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
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
                                    <div v-if="$page.errors.title" class="text-red-500">
                                        {{ $page.errors.title[0] }}
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
                                    
                                    <jet-button class="bg-green-700 text-base"
                                    @click.native="confirm(form)">更新</jet-button>
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
    props: ['data', 'dataTeam', 'dataRole'],
    data() {
        return {
            editMode: false,
            isOpen: false,
            form: this.$inertia.form( {
                _method: "PUT",
                id: this.data.id,
                name: this.data.name,
                email: this.data.email,
                // password: "",
                current_team_id: this.data.current_team_id,
                role_id: this.data.role_id,
                auth_id: this.data.auth_id,
                confirm: 2,
            },
            {
                bag: "userUpdate",
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
            this.$inertia.post('/employee_create', data);
            this.reset();
            this.editMode = false;
        },
        edit: function(data) {
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.openModal();
        },
        update: function(data) {
            data._method = 'PUT';
            this.$inertia.post('/user/' + data.id, data);
            this.reset();
        },

        editUser: function(data){
            data._method = 'PUT';
            this.$inertia.put('/users/' + data.id, data);
            this.reset();
        },

        createUser(){
            this.form.post(route("user.store"));
        },

        confirm(data){
            data._method = 'POST';
            // this.form.post(route('user.confirm'));
            this.$inertia.post(route('user.confirm'), data);
        },
    },
};
</script>
