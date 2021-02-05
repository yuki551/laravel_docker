<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My日報一覧
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
                    <section class="postslist-area postslist-unapproved">
                        <div class="postslist-wrap">
                            <div class="postslist-hd">
                                <div class="date">日報日付</div>
                                <div class="hd-contents">日報内容</div>
                                <div class="action"></div>
                            </div>
                            <ul class="postslist-body">
                                <template v-for="row in userPosts">
                                <li class="postslist-item" v-bind:class="{active : accordionOpened.indexOf(row.id) >= 0}">
                                    <div class="postslist-item-hd">
                                        <div class="date">{{ row.created_at | moment("YYYY年MM月DD日") }}</div>
                                        <div class="postslist-item-body">
                                            <div class="pib-inner">
                                                <div class="cmn-item item-am">
                                                    <div class="cmn-item-client" v-if="row.client_name_am">取引先：{{ row.client_name_am }}</div>
                                                    <div class="cmn-item-summary">{{ row.summary_am }}</div>
                                                    <div class="cmn-item-contents" v-show="accordionOpened.indexOf(row.id) >= 0">{{ row.contents_am }}</div>
                                                </div>
                                                <div class="cmn-item item-pm">
                                                    <div class="cmn-item-client" v-if="row.client_name_pm">取引先：{{ row.client_name_pm }}</div>
                                                    <div class="cmn-item-summary">{{ row.summary_pm }}</div>
                                                    <div class="cmn-item-contents" v-show="accordionOpened.indexOf(row.id) >= 0">{{ row.contents_pm }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="action">
                                            <div class="action-btn detail"><button @click="toggleAccordion(row.id)">日報詳細</button></div>
                                            <div class="action-btn detail-modal mt-2" v-show="accordionOpened.indexOf(row.id) >= 0"><button @click="postModal(row)">大きく<br>表示</button></div>
                                        </div>
                                    </div>
                                </li>
                                </template>
                            </ul>
                        </div>
                    </section>

                    <!-- モーダル ここから -->
                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity">
                                <div class="absolute inset-0 bg-gray-500 opacity-75" @click="closeModal()"></div>
                            </div>
                            <!-- This element is to trick the browser into centering the modal contents. -->
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                            <div
                                class="modal-form-wrap inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="modal-headline"
                            >
                                <form class="cmn-form-wrap">
                                    <div class="bg-white px-7 pt-7 pb-7 sm:p-6 sm:pb-4">
                                        <div class="form-inner">
                                            <div class="form-item form-date">報告日時：{{ this.form['created_at'] | moment("YYYY年MM月DD日") }}</div>
                                            <div class="form-item form-team">所属部署：{{ this.form.team_name }}</div>
                                            <div class="form-item form-name">名前：{{ this.form.user_name }}</div>

                                            <div class="form-item form-title"><span class="marker">業務報告(午前)</span></div>
                                            <div class="form-item form-client">取引先：{{ this.form.client_name_am }}</div>
                                            <div class="form-item form-summary">業務：{{ this.form.summary_am }}</div>
                                            <div class="form-item form-contents">{{ this.form.contents_am }}</div>

                                            <div class="form-item form-title"><span class="marker">業務報告(午後)</span></div>
                                            <div class="form-item form-client">取引先：{{ this.form.client_name_pm }}</div>
                                            <div class="form-item form-summary">業務：{{ this.form.summary_pm }}</div>
                                            <div class="form-item form-contents">{{ this.form.contents_pm }}</div>

                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                            <button @click="closeModal()" type="button" class="cmn-formbtn btn-cancel">キャンセル</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- モーダル ここまで -->

                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from './../Layouts/AppLayout';
export default {
    components: {
        AppLayout,
    },
    props: ['data', 'errors', 'conf'],
    data() {
        return {
            editMode: false,
            isOpen: false,
            userPost: [],
            accordionOpened: [],
            form: {
                status: 0,
            },
        };
    },
    computed: {
        // ログインしているユーザーの投稿のみデータを格納。
        userPosts: function() {
            this.userPost = [];
            for (let i = 0; i < this.data.length; i++) {
                if (this.data[i].user == this.$page.user.id) {
                    this.userPost.push(this.data[i]);
                }
            }
            return this.userPost;
        },
    },
    methods: {
        openModal: function() {
            this.isOpen = true;
        },
        closeModal: function() {
            this.isOpen = false;
        },
        toggleAccordion: function(data){
            if (this.accordionOpened.indexOf(data) >= 0) {
                this.accordionOpened = this.accordionOpened.filter(n => n !== data)
            }
            else {
                this.accordionOpened.push(data)
            }
        },
        postModal: function(userPost) {
            this.form = Object.assign({}, userPost);
            this.openModal();
        },
    },
};
</script>
<style></style>
