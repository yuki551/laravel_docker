<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                日報登録
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
                    <form class="cmn-form-wrap form-post-create">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="form-inner">
                                <div class="form-item form-date">報告日時：{{ form.date | moment("YYYY年MM月DD日") }}</div>
                                <div class="form-item form-team">所属部署：{{ form.teamname }}</div>
                                <div class="form-item form-name">名前：{{ form.username }}</div>
                                <input type="hidden" v-model="form.date"/>
                                <input type="hidden" v-model="form.team"/>
                                <input type="hidden" v-model="form.user"/>

                                <div class="form-item form-title"><span class="marker">業務報告(午前)</span></div>

                                <div class="form-item form-client">
                                    <label>
                                        取引先：
                                        <select v-model="form.client_am">
                                            <option value='' disabled>選択してください</option>
                                            <option v-for="client in client_am"
                                                v-bind:value="client.id">
                                                {{ client.name }}
                                            </option>
                                        </select>
                                    </label>
                                </div>
                                <div class="form-item form-summary">
                                    <label>
                                        <span>業務：</span>
                                        <textarea class="cmn-form-textarea" v-model="form.summary_am" placeholder="例：打ち合わせ、会議"></textarea>
                                    </label>
                                </div>
                                <div class="form-item form-contents">
                                    <label>
                                        <span>詳細：</span>
                                        <textarea class="cmn-form-textarea" v-model="form.contents_am" placeholder="業務詳細を記入してください"></textarea>
                                    </label>
                                </div>


                                <div class="form-item form-title"><span class="marker">業務報告(午後)</span></div>
                                <div class="form-item form-client">
                                    <label>
                                        取引先：
                                        <select v-model="form.client_pm">
                                            <option value='' disabled>選択してください</option>
                                            <option v-for="client in client_pm"
                                                v-bind:value="client.id">
                                                {{ client.name }}
                                            </option>
                                        </select>
                                    </label>
                                </div>
                                <div class="form-item form-summary">
                                    <label>
                                        <span>業務：</span>
                                        <textarea class="cmn-form-textarea" v-model="form.summary_pm" placeholder="【業務】例：打ち合わせ、会議"></textarea>
                                    </label>
                                </div>
                                <div class="form-item form-contents">
                                    <label>
                                        <span>詳細：</span>
                                        <textarea class="cmn-form-textarea" v-model="form.contents_pm" placeholder="業務詳細を記入してください"></textarea>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- confirm送信input追加 02/02 -->
                        <input type="hidden" v-model="form.status" />
                        <input type="hidden" v-model="form.confirm" />

                        <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <!-- buttonのクリック時のメソッドを変更 02/02 -->
                                <jet-button class="cmn-formbtn"
                                    @click.native="confirm(form)">確認</jet-button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
// import部分のパスをそれぞれ変更 02/02
import FilterableDropdown from './../components/FilterableDropdown.vue';
// 日付取得用
var today = new Date();
var today = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();

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
        FilterableDropdown,
        JetFormSection,
        JetInput,
        JetLabel,
        JetButton,
        JetInputError,
    },
    // olddata  を追加 02/03
    props: ['data', 'olddata', 'errors'],
    data() {
        return {
            editMode: false,
            isOpen: false,
            form: {
                username: this.$page.user.name,
                user: this.$page.user.id,
                teamname: this.$page.user.current_team.name,
                team: this.$page.user.current_team_id,
                date: today,
                contents_am: this.olddata.oldcontents_am,
                contents_pm: this.olddata.oldcontents_pm,
                client_am: this.olddata.oldclient_am,
                client_pm: this.olddata.oldclient_pm,
                summary_am: this.olddata.oldsummary_am,
                summary_pm: this.olddata.oldsummary_pm,
                status: 1,
                confirm: 1,
                // confirm追加 02/02
            },
            created_user_id: this.$page.user.id,
        };
    },
    computed: {
        // computedをdata2からdataに変更 02/02
        client_am: function() {
            return this.data;
        },
        client_pm: function() {
            return this.data;
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
            this.$inertia.post('/posts/' + data.id, data);
            this.reset();
        },
        // confirm追加 02/02
        confirm(data){
            data._method = 'POST';
            this.$inertia.post('/posts/confirm', data);
        },
    },
};
</script>
