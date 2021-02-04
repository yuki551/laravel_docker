<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                日報内容確認
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
                    <form class="cmn-form-wrap">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="form-note">※日報内容を確認後、登録ボタンを押してください。</div>
                            <div class="form-inner">
                                <div class="form-item form-date">報告日時：{{ form.date | moment("YYYY年MM月DD日") }}</div>
                                <div class="form-item form-team">所属部署：{{ form.teamname }}</div>
                                <div class="form-item form-name">名前：{{ form.username }}</div>

                                <div class="form-item form-title"><span class="marker">業務報告(午前)</span></div>
                                <div class="form-item form-client">取引先：{{ form.client_am_name }}</div>
                                <div class="form-item form-summary">業務：{{form.summary_am}}</div>
                                <div class="form-item form-contents">{{form.contents_am}}</div>

                                <div class="form-item form-title"><span class="marker">業務報告(午後)</span></div>
                                <div class="form-item form-client">取引先：{{ form.client_pm_name }}</div>
                                <div class="form-item form-summary">業務：{{form.summary_pm}}</div>
                                <div class="form-item form-contents">{{form.contents_pm}}</div>

                                <input type="hidden" v-model="form.date"/>
                                <input type="hidden" v-model="form.team"/>
                                <input type="hidden" v-model="form.user"/>
                                <input type="hidden" v-model="form.client_am"/>
                                <input type="hidden" v-model="form.summary_am"/>
                                <input type="hidden" v-model="form.contents_am"/>
                                <input type="hidden" v-model="form.client_pm"/>
                                <input type="hidden" v-model="form.summary_pm"/>
                                <input type="hidden" v-model="form.contents_pm"/>
                                <input type="hidden" v-model="form.status" />
                                <input type="hidden" v-model="form.confirm" />
                                <input type="hidden" v-model="form.message" />

                            </div>
                        </div>

                        <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <!-- buttonのクリック時のメソッドを変更 02/02 -->
                                <button
                                    wire:click.prevent="store()"
                                    class="cmn-formbtn cmn-formbtn-main"
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
    props: ['confirmpost'],
    data() {
        return {
            editMode: false,
            isOpen: false,
            form: this.$inertia.form( {

                user: this.confirmpost.user,
                team: this.confirmpost.team,
                username: this.confirmpost.username,
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
                status: 1,
                confirm: 2,
                message: "日報を提出しました。",
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
                contents_am: null,
                contents_pm: null,
                summary_am: null,
                summary_pm: null,
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
