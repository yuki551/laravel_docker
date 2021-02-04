<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                社員情報確認
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

                                <div v-if="form.confirm == 2">
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">
                                        名前:{{ form.user }}
                                        <input
                                            type="hidden"
                                            class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                            placeholder="社員名を入力してください"
                                            v-model="form.user"
                                        />
                                        </label>
                                        <div v-if="$page.errors.title" class="text-red-500">
                                            {{ $page.errors.id[0] }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    報告日時:{{form.date}}
                                    <input
                                        type="hidden"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="社員名を入力してください"
                                        v-model="form.date"

                                    />
                                    </label>
                                    <div v-if="$page.errors.name" class="text-red-500">
                                        {{ $page.errors.name[0] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    所属部署:{{form.team}}
                                    <input
                                        type="hidden"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="社員名を入力してください"
                                        v-model="form.team"

                                    />
                                    </label>
                                    <div v-if="$page.errors.name" class="text-red-500">
                                        {{ $page.errors.name[0] }}
                                    </div>
                                </div>

                                


                                <hr>
                                <div class="mt-4 block text-gray-700 text-sm font-bold mb-2">業務報告(午前):</div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    顧客名:{{ form.client_am_name }}
                                    <input
                                        type="hidden"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="メールアドレスを入力してください"
                                        v-model="form.client_am"
                                    />
                                    </label>
                                    <div v-if="$page.errors.email" class="text-red-500">
                                        {{ $page.errors.email[0] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    業務:{{form.summary_am}}
                                    <input
                                        type="hidden"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="パスワードを入力してください"
                                        v-model="form.summary_am"
                                    />
                                    </label>
                                    <div v-if="$page.errors.password" class="text-red-500">
                                        {{ $page.errors.password[0] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    内容:{{form.contents_am}}
                                    <input
                                        type="hidden"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="パスワードを入力してください"
                                        v-model="form.contents_am"
                                    />
                                    </label>
                                    <div v-if="$page.errors.current_team_id" class="text-red-500">
                                        {{ $page.errors.current_team_id[0] }}
                                    </div>
                                </div>

                                <hr>
                                <div class="mt-4 block text-gray-700 text-sm font-bold mb-2">業務報告(午後):</div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    顧客名:{{ form.client_pm_name }}
                                    <input
                                        type="hidden"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="メールアドレスを入力してください"
                                        v-model="form.client_pm"
                                    />
                                    </label>
                                    <div v-if="$page.errors.email" class="text-red-500">
                                        {{ $page.errors.email[0] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    業務:{{form.summary_pm}}
                                    <input
                                        type="hidden"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="パスワードを入力してください"
                                        v-model="form.summary_pm"
                                    />
                                    </label>
                                    <div v-if="$page.errors.password" class="text-red-500">
                                        {{ $page.errors.password[0] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                    内容:{{form.contents_pm}}
                                    <input
                                        type="hidden"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                                        placeholder="パスワードを入力してください"
                                        v-model="form.contents_pm"
                                    />
                                    </label>
                                    <div v-if="$page.errors.current_team_id" class="text-red-500">
                                        {{ $page.errors.current_team_id[0] }}
                                    </div>
                                </div>

                            </div>
                        </div>



                            <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                    <button
                                        wire:click.prevent="store()"
                                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                        v-show="!editMode"
                                        @click="save(form)">
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
import AppLayout from './../Layouts/AppLayout';
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
    props: ['confirmpost'],
    data() {
        return {
            editMode: false,
            isOpen: false,
            form: this.$inertia.form( {
                user: this.confirmpost.user,
                team: this.confirmpost.team,

                date: this.confirmpost.date,
                client_am: this.confirmpost.client_am,
                summary_am: this.confirmpost.summary_am,
                contents_am: this.confirmpost.contents_am,
                client_pm: this.confirmpost.client_pm,
                summary_pm: this.confirmpost.summary_pm,
                contents_pm: this.confirmpost.contents_pm,
                status: this.confirmpost.status,
                teamname: this.confirmpost.teamname,
                client_am_name: this.confirmpost.client_am_name,
                client_pm_name: this.confirmpost.client_pm_name,
                confirm: this.confirmpost.confirm,
            },
            ),
        };
    },
    computed: {
        // ログインしているユーザーの投稿のみデータを格納。

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
            this.$inertia.post('/posts', data);
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

        createUser(){
            this.form.post(route("user.store"));
        },

        editUser: function(data){
            data._method = 'PUT';
            this.$inertia.put('/users/' + data.id, data);
            this.reset();
        },
    },
};
</script>
