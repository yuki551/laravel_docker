<template>
    <app-layout>
        <!-- {{ usrPosNull }} -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div v-if="notifyTask" class="bg-blue-400 shadow">
            <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    未承認の日報があります。
                </h2>
            </div>
        </div>
        <div v-if="notifyReply" class="bg-red-400 shadow">
            <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    差戻しの日報があります。
                </h2>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dashboard-contents bg-white overflow-hidden shadow-xl sm:rounded-lg px-7 py-4">
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

                    <!-- 社長　ここから -->
                    <template v-if="this.$page.user.role_id == 3">
                    <section v-if="!notifyTask">未承認の日報はありません</section>
                    <section v-if="notifyTask" class="postslist-area postslist-unapproved">
                        <h2 class="postslist-title">未承認日報</h2>
                        <div class="postslist-wrap">
                            <div class="postslist-hd">
                                <div class="date">日報日付</div>
                                <div class="name">提出者</div>
                                <div class="hd-contents">日報内容</div>
                                <div class="action"></div>
                            </div>
                            <ul class="postslist-body">
                                <template v-for="(row, index) in unapprovedPosts">
                                <li class="postslist-item" v-bind:class="{active : accordionOpened.indexOf(row.id) >= 0}">
                                    <div class="postslist-item-hd">
                                        <div class="date">{{ row.created_at | moment("YYYY年MM月DD日") }}</div>
                                        <div class="name">{{ row.user_name }}</div>
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
                                            <div class="action" v-show="accordionOpened.indexOf(row.id) >= 0">
                                                <div class="action-wrap">
                                                    <div class="action-btn retry">
                                                        <button v-if="replyFlag(index)" @click="edit(row)">差戻し</button>
                                                    </div>
                                                    <div class="action-btn approval">
                                                        <button v-if="aprFlags(index)"
                                                    wire:click.prevent="update()"
                                                    @click="approve(row)">承認</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="action">
                                            <div class="action-btn detail"><button @click="toggleAccordion(row.id)">日報詳細</button></div>
                                        </div>
                                    </div>
                                </li>
                                </template>
                            </ul>
                        </div>
                    </section>
                    </template>
                    <!-- 社長　ここまで -->
                    <!-- 部長　ここから -->
                    <template v-else-if="this.$page.user.role_id == 5">
                    <section v-if="!notifyReply && !notifyTask && !notifyWait">未承認の日報はありません</section>
                    <section v-if="notifyReply" class="postslist-area postslist-remand">
                        <h2 class="postslist-title">差戻し日報</h2>
                        <div class="postslist-wrap">
                            <div class="postslist-hd">
                                <div class="date">日報日付</div>
                                <div class="comment">差戻コメント</div>
                                <div class="action"></div>
                            </div>
                            <ul class="postslist-body">
                                <template v-for="(row, index) in remandPosts">
                                <li class="postslist-item" v-bind:class="{active : accordionOpened.indexOf(row.id) >= 0}">
                                    <div class="postslist-item-hd">
                                        <div class="date">{{ row.created_at | moment("YYYY年MM月DD日") }}</div>
                                        <div class="comment">{{ row.comment }}</div>
                                        <div class="action">
                                            <div class="action-btn detail"><button @click="toggleAccordion(row.id)">日報詳細</button></div>
                                            <div class="action-btn retry">
                                                <button @click="edit(row)">再提出</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="postslist-item-body"  v-show="accordionOpened.indexOf(row.id) >= 0">
                                        <div class="cmn-item item-am">
                                            <div class="cmn-item-client" v-if="row.client_name_am">取引先：{{ row.client_name_am }}</div>
                                            <div class="cmn-item-summary">{{ row.summary_am }}</div>
                                            <div class="cmn-item-contents">{{ row.contents_am }}</div>
                                        </div>
                                        <div class="cmn-item item-pm">
                                            <div class="cmn-item-client" v-if="row.client_name_pm">取引先：{{ row.client_name_pm }}</div>
                                            <div class="cmn-item-summary">{{ row.summary_pm }}</div>
                                            <div class="cmn-item-contents">{{ row.contents_pm }}</div>
                                        </div>
                                    </div>
                                </li>
                                </template>
                            </ul>
                        </div>
                    </section>
                    <section v-if="notifyTask" class="postslist-area postslist-unapproved">
                        <h2 class="postslist-title">未承認日報</h2>
                        <div class="postslist-wrap">
                            <div class="postslist-hd">
                                <div class="date">日報日付</div>
                                <div class="name">提出者</div>
                                <div class="hd-contents">日報内容</div>
                                <div class="action"></div>
                            </div>
                            <ul class="postslist-body">
                                <template v-for="(row, index) in userPosts">
                                <li class="postslist-item" v-if="row.role_id == 10" v-bind:class="{active : accordionOpened.indexOf(row.id) >= 0}">
                                    <div class="postslist-item-hd">
                                        <div class="date">{{ row.created_at | moment("YYYY年MM月DD日") }}</div>
                                        <div class="name">{{ row.user_name }}</div>
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
                                            <div class="action" v-show="accordionOpened.indexOf(row.id) >= 0">
                                                <div class="action-wrap">
                                                    <div class="action-btn retry">
                                                        <button v-if="replyFlag(index)" @click="edit(row)">差戻し</button>
                                                    </div>
                                                    <div class="action-btn approval">
                                                        <button v-if="aprFlags(index)" @click="approveModal(row)">承認</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="action">
                                            <div class="action-btn detail"><button @click="toggleAccordion(row.id)">日報詳細</button></div>
                                        </div>
                                    </div>
                                </li>
                                </template>
                            </ul>
                        </div>
                    </section>
                    <section v-if="notifyWait" class="postslist-area postslist-unapproved-mine">
                        <h2 class="postslist-title">承認待ち日報</h2>
                        <div class="postslist-wrap">
                            <div class="postslist-hd">
                                <div class="date">日報日付</div>
                                <div class="hd-contents">日報内容</div>
                                <div class="action"></div>
                            </div>
                            <ul class="postslist-body">
                                <template v-for="(row, index) in unapprovedPostsMine">
                                <li class="postslist-item" v-bind:class="{active : accordionOpened.indexOf(row.id) >= 0}">
                                    <div class="postslist-item-hd">
                                        <div class="date">{{ row.created_at | moment("YYYY年MM月DD日") }}</div>
                                        <div class="postslist-item-body">
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
                                        <div class="action">
                                            <div class="action-btn detail"><button  @click="toggleAccordion(row.id)">日報詳細</button></div>
                                        </div>
                                    </div>
                                </li>
                                </template>
                            </ul>
                        </div>
                    </section>
                    </template>
                    <!-- 部長　ここまで -->
                    <!-- 一般社員　ここから -->
                    <template v-else-if="this.$page.user.role_id == 10">
                    <section v-if="!notifyReply && !notifyWait">未承認の日報はありません</section>
                    <section v-if="notifyReply" class="postslist-area postslist-remand">
                        <h2 class="postslist-title">差戻し日報</h2>
                        <div class="postslist-wrap">
                            <div class="postslist-hd">
                                <div class="date">日報日付</div>
                                <div class="comment">差戻コメント</div>
                                <div class="action"></div>
                            </div>
                            <ul class="postslist-body">
                                <template v-for="(row, index) in remandPosts">
                                <li class="postslist-item" v-bind:class="{active : accordionOpened.indexOf(row.id) >= 0}">
                                    <div class="postslist-item-hd">
                                        <div class="date">{{ row.created_at | moment("YYYY年MM月DD日") }}</div>
                                        <div class="comment">{{ row.comment }}</div>
                                        <div class="action">
                                            <div class="action-btn detail"><button  @click="toggleAccordion(row.id)">日報詳細</button></div>
                                            <div class="action-btn retry">
                                                <button @click="edit(row)">再提出</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="postslist-item-body"  v-show="accordionOpened.indexOf(row.id) >= 0">
                                        <div class="cmn-item item-am">
                                            <div class="cmn-item-client" v-if="row.client_name_am">取引先：{{ row.client_name_am }}</div>
                                            <div class="cmn-item-summary">{{ row.summary_am }}</div>
                                            <div class="cmn-item-contents">{{ row.contents_am }}</div>
                                        </div>
                                        <div class="cmn-item item-pm">
                                            <div class="cmn-item-client" v-if="row.client_name_pm">取引先：{{ row.client_name_pm }}</div>
                                            <div class="cmn-item-summary">{{ row.summary_pm }}</div>
                                            <div class="cmn-item-contents">{{ row.contents_pm }}</div>
                                        </div>
                                    </div>
                                </li>
                                </template>
                            </ul>
                        </div>
                    </section>
                    <section v-if="notifyWait" class="postslist-area postslist-unapproved-mine">
                        <h2 class="postslist-title">承認待ち日報</h2>
                        <div class="postslist-wrap">
                            <div class="postslist-hd">
                                <div class="date">日報日付</div>
                                <div class="hd-contents">日報内容</div>
                                <div class="action"></div>
                            </div>
                            <ul class="postslist-body">
                                <template v-for="(row, index) in unapprovedPosts">
                                <li class="postslist-item" v-bind:class="{active : accordionOpened.indexOf(row.id) >= 0}">
                                    <div class="postslist-item-hd">
                                        <div class="date">{{ row.created_at | moment("YYYY年MM月DD日") }}</div>
                                        <div class="postslist-item-body">
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
                                        <div class="action">
                                            <div class="action-btn detail"><button  @click="toggleAccordion(row.id)">日報詳細</button></div>
                                        </div>
                                    </div>
                                </li>
                                </template>
                            </ul>
                        </div>
                    </section>
                    </template>
                    <!-- 一般社員　ここまで -->
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
                                <!-- 再提出フォーム -->
                                <form v-if="resForm()" class="cmn-form-wrap form-resubmit">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="form-inner">
                                            <div class="form-item form-date">報告日時：{{ this.form['created_at'] | moment("YYYY年MM月DD日") }}</div>
                                            <div class="form-item form-team">所属部署：{{ this.form.team_name }}</div>
                                            <div class="form-item form-name">名前：{{ this.form.user_name }}</div>
                                            <input type="hidden" v-model="form.date"/>
                                            <input type="hidden" v-model="form.team"/>
                                            <input type="hidden" v-model="form.user"/>

                                            <div class="form-item form-title"><span class="marker">業務報告(午前)</span></div>
                                            <div class="form-item form-client">
                                                <label>
                                                    取引先：
                                                    <select v-model="form.client_am">
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
                                                    <textarea class="cmn-form-textarea" v-model="form.summary_am" placeholder="【業務】例：打ち合わせ、会議"></textarea>
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
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                            <button
                                                wire:click.prevent="retryPost()"
                                                @click="submission(form)"
                                                type="button"
                                                class="cmn-formbtn btn-submission">再提出</button>
                                        </span>
                                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                            <button @click="closeModal()" type="button" class="cmn-formbtn btn-cancel">キャンセル</button>
                                        </span>
                                    </div>
                                </form>
                                <!-- 承認確認 -->
                                <form v-else-if="approveFlag" class="cmn-form-wrap  form-approve">
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

                                            <input type="hidden" v-model="form.date"/>
                                            <input type="hidden" v-model="form.team"/>
                                            <input type="hidden" v-model="form.user"/>
                                            <input type="hidden" v-model="form.client_am"/>
                                            <input type="hidden" v-model="form.summary_am"/>
                                            <input type="hidden" v-model="form.contents_am"/>
                                            <input type="hidden" v-model="form.client_pm"/>
                                            <input type="hidden" v-model="form.summary_pm"/>
                                            <input type="hidden" v-model="form.contents_pm"/>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                            <button
                                                wire:click.prevent="update()"
                                                @click="approve(form)"
                                                type="button"
                                                class="cmn-formbtn btn-approve"
                                            >承認</button>
                                        </span>
                                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                            <button @click="closeModal()" type="button" class="cmn-formbtn btn-cancel">キャンセル</button>
                                        </span>
                                    </div>
                                </form>
                                <!-- 差戻しフォーム -->
                                <form v-else-if="replyForm()" class="cmn-form-wrap form-remand">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="form-inner">
                                            <div class="form-item form-remand-comment">
                                                <label>
                                                    <span>差し戻しコメント：</span>
                                                    <textarea class="cmn-form-textarea" v-model="form.comment" placeholder="差戻し理由を記入してください。"></textarea>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                            <button
                                                wire:click.prevent="retryPost()"
                                                @click="replyRow(form)"
                                                type="button"
                                                class="cmn-formbtn btn-remand">差戻し</button>
                                        </span>
                                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                            <button @click="closeModal()" type="button" class="cmn-formbtn btn-cancel">キャンセル</button>
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
import AppLayout from './../Layouts/AppLayout';
export default {
    components: {
        AppLayout,
    },
    props: ['data', 'data2', 'errors', 'conf'],
    data() {
        return {
            editMode: false,
            isOpen: false,
            approveFlag: false,
            accordionOpened: [],
            userPost: [],
            status: 0,
            form: {
                status: 0,
                comment: '',
            },
            index: 0,
        };
    },
    computed: {
        // ログインしているユーザーの投稿のみデータを格納。
        userPosts: function() {
            //user idが同じ時
            if (this.$page.user.role_id == 10) {
                this.userPost = [];
                for (let i = 0; i < this.data.length; i++) {
                    if (this.data[i].user == this.$page.user.id && !(this.data[i].status == 2)) {
                        this.userPost.push(this.data[i]);
                    }
                }
                return this.userPost;
            } else if (this.$page.user.role_id == 5) {
                //部長role
                this.userPost = [];
                for (let i = 0; i < this.data.length; i++) {
                    if (this.data[i].team == this.$page.user.current_team_id && !(this.data[i].status == 2)) {
                        this.userPost.push(this.data[i]);

                        this.otherRemand(i);
                    }
                }
                return this.userPost;
                //---------------------------------------------------------
            } else if (this.$page.user.role_id == 3) {
                //社長role
                this.userPost = [];
                for (let i = 0; i < this.data.length; i++) {
                    if (this.data[i].status == 1 && this.data[i].role_id == 5 && !(this.data[i].status == 2)) {
                        this.userPost.push(this.data[i]);

                        this.otherRemand(i);
                    }
                }
                return this.userPost;
                //---------------------------------------------------------
            }
            return this.userPost;
        },
        // 差戻しデータ取得
        remandPosts() {
            return this.userPosts.filter(row => {
                return row.status == 3
            })
        },
        // 未承認データ取得
        unapprovedPosts() {
            return this.userPosts.filter(row => {
                return row.status == 1
            })
        },
        // 未承認データから自分の提出日報を抽出
        unapprovedPostsMine() {
            return this.unapprovedPosts.filter(row => {
                return row.user == this.$page.user.id
            })
        },
        // 未承認日報がある時
        notifyTask: function() {
            for (let i = 0; i < this.userPosts.length; i++) {
                // 未承認かつ部長ユーザーか社長の時かつ同一ユーザーではない時
                if (
                    1 == this.userPost[i]['status'] &&
                    !(this.userPost[i]['user'] == this.$page.user.id) &&
                    (this.$page.user.role_id == 5 || this.$page.user.role_id == 3)
                ) {
                    return true;
                } else {
                }
            }
        },
        // 差し戻しがある時
        notifyReply: function() {
            for (let i = 0; i < this.userPosts.length; i++) {
                // 差戻し状態のpostがログインしているユーザーと同一のものがある時
                if (3 == this.userPost[i]['status'] && this.userPost[i]['user'] == this.$page.user.id) {
                    return true;
                }
            }
        },
        // 自分の未承認日報
        notifyWait: function() {
            for (let i = 0; i < this.userPosts.length; i++) {
                // 未承認状態のpostがログインしているユーザーと同一のものがある時
                if (1 == this.userPost[i]['status'] && this.userPost[i]['user'] == this.$page.user.id) {
                    return true;
                }
            }
        },
        // ポストデータが空の時
        usrPosNull: function() {
            if (!this.userPost.length) {
                this.$page.flash.message = '未処理のデータはありません。';
            }
        },
        client_am: function() {
            return this.data2;
        },
        client_pm: function() {
            return this.data2;
        },
    },
    methods: {
        otherRemand: function(popData) {
            if (!(this.data[popData].user == this.$page.user.id) && this.data[popData].status == 3) {
                this.userPost.pop();
            }
        },
        // --------------------------
        openModal: function() {
            this.isOpen = true;
        },
        closeModal: function() {
            this.isOpen = false;
            this.reset();
            this.editMode = false;
            this.approveFlag = false;
        },
        toggleAccordion: function(data){
            if (this.accordionOpened.indexOf(data) >= 0) {
                this.accordionOpened = this.accordionOpened.filter(n => n !== data)
            }
            else {
                this.accordionOpened.push(data)
            }
        },
        reset: function() {
            (this.form = {}), (this.params = {});
        },
        edit: function(userPost) {
            this.form = Object.assign({}, userPost);
            // console.log(this.form);
            this.editMode = true;
            this.openModal();
        },
        approveModal: function(userPost) {
            this.approveFlag = true;
            this.form = Object.assign({}, userPost);
            this.openModal();
        },
        update: function(data) {
            data._method = 'PUT';
            this.$inertia.post('/dashboard/' + data.id, data);
            this.reset();
            this.closeModal();
        },
        // --------------------------
        // -----ボタン実行時の処理-----
        // 差戻し処理
        replyRow: function(data) {
            data._method = 'PUT';
            data['status'] = 3;
            delete data['role_id'];
            this.$inertia.post('/dashboard/' + data.id, data);
            this.reset();
            this.closeModal();
        },
        // 承認処理
        approve: function(data) {
            data._method = 'PUT';
            data['status'] = 2;
            delete data['role_id'];
            this.$inertia.post('/dashboard/' + data.id, data);
            this.reset();
            this.closeModal();
        },
        // 提出処理
        submission: function(data) {
            data._method = 'PUT';
            data['status'] = 1;
            delete data['role_id'];
            this.$inertia.post('/dashboard/' + data.id, data);
            this.reset();
            this.closeModal();
        },
        // 権限判定
        judgeRole: function(index) {
            if (
                // roleが一般か判定
                this.$page.user.role_id == 10 &&
                this.userPost[index].status == 3 &&
                this.$page.user.id == this.userPost[index].user
            ) {
                return true;
            } else if (
                // roleが部長か判定
                this.$page.user.role_id == 5 &&
                this.userPost[index].status == 3 &&
                this.$page.user.id == this.userPost[index].user
            ) {
                return true;
            } else {
                return false;
            }
        },
        // --------------------------
        // -----ボタンとフォーム-----
        // 承認ボタン出現フラグ
        aprFlags: function(index) {
            // 承認ボタン
            if (
                // 未承認かつ一般ユーザーの投稿かつログインしているのが部長の時
                (1 == this.userPost[index]['status'] &&
                    10 == this.userPost[index]['role_id'] &&
                    5 == this.$page.user.role_id) ||
                // 未承認かつ部長ユーザーの投稿かつログインしているのが社長の時
                (1 == this.userPost[index]['status'] && 5 == this.userPost[index]['role_id'] && 3 == this.$page.user.role_id)
            ) {
                return true;
                // 承認済みの時
            } else if (2 == this.userPost[index]['status']) {
                return false;
                // 差し戻しの時
            } else if (3 == this.userPost[index]['status']) {
                return false;
            } else {
                return false;
            }
        },
        // 差戻しボタン出現フラグ
        replyFlag: function(index) {
            // 差戻しボタン

            // 未承認の時
            if (
                // 未承認かつ一般ユーザーの投稿かつログインしているのが部長の時かつ所属チームが同じ時
                (1 == this.userPost[index]['status'] &&
                    10 == this.userPost[index]['role_id'] &&
                    5 == this.$page.user.role_id &&
                    this.$page.user.current_team_id == this.userPost[index]['team']) ||
                // 未承認かつ部長ユーザーの投稿かつログインしているのが社長の時
                (1 == this.userPost[index]['status'] && 5 == this.userPost[index]['role_id'] && 3 == this.$page.user.role_id)
            ) {
                return true;
                // 承認済みの時
            } else if (2 == this.userPost[index]['status']) {
                return false;
                // 差し戻しの時
            } else if (3 == this.userPost[index]['status']) {
                return false;
            } else {
                return false;
            }
        },
        // 差戻しフォーム出現フラグ
        replyForm: function() {
            // 未承認の時
            if (
                // 未承認かつ一般ユーザーの投稿かつログインしているのが部長の時かつ所属チームが同じ時
                (1 == this.form['status'] &&
                    10 == this.form['role_id'] &&
                    5 == this.$page.user.role_id &&
                    this.$page.user.current_team_id == this.form['team']) ||
                // 未承認かつ部長ユーザーの投稿かつログインしているのが社長の時
                (1 == this.form['status'] && 5 == this.form['role_id'] && 3 == this.$page.user.role_id)
            ) {
                return true;
                // 承認済みの時
            } else if (2 == this.form['status']) {
                return false;
                // 差し戻しの時
            } else if (3 == this.form['status']) {
                return false;
            } else {
                return false;
            }
        },
        // 再提出ボタン出現フラグ
        resFlag: function(index) {
            // 差戻しの時
            if (
                // true
                // 差戻しの状態かつログイン者と同一の一般ユーザーの投稿
                3 == this.userPost[index]['status'] &&
                this.$page.user.id == this.userPost[index]['user']
            ) {
                return true;
                // 承認済みの時
            } else if (2 == this.userPost[index]['status']) {
                return false;
                // 未承認
            } else if (1 == this.userPost[index]['status']) {
                return false;
            } else {
                return false;
            }
        },
        // 再提出フォーム出現フラグ
        resForm: function() {
            if (
                // true
                // 差戻しの状態かつログイン者と同一の一般ユーザーの投稿
                3 == this.form['status'] &&
                this.$page.user.id == this.form.user
            ) {
                return true;
                // 承認済みの時
            } else if (2 == this.form['status']) {
                return false;
                // 差し戻しの時
            } else if (1 == this.form['status']) {
                return false;
            } else {
                return false;
            }
        },
        // --------------------------
        test: function() {
            return true;
        },
    },
};
</script>
<style>
.margin_bottom {
    margin-bottom: 10px;
}

.whiteSpace {
    word-break: break-all;
}
</style>
