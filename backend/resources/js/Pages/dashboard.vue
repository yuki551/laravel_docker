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

                    <table v-if="this.$page.user.role_id == 3" class="w-full">
                        <tbody>
                            <div v-for="(row, index) in userPosts" class="margin_bottom">
                                <tr>
                                    <th colspan="4" class="bg-gray-200 border px-4 py-2 w-1/12">名前</th>
                                    <th colspan="2" class="bg-gray-200 border px-4 py-2 w-1/12">team</th>
                                </tr>
                                <tr class="border px-4 py-2">
                                    <td colspan="4" class="border px-4 py-2">{{ row.user_name }}</td>
                                    <td colspan="2" class="border px-4 py-2">{{ row.team_name }}</td>
                                </tr>
                                <tr class="border px-4 py-2">
                                    <th colspan="3" class="bg-gray-200 border px-4 py-2 w-5/12">作成日</th>
                                    <th colspan="2" class="bg-gray-200 border px-4 py-2 w-5/12">Action</th>
                                    <th colspan="1" class="bg-gray-200 border px-4 py-2">状態</th>
                                </tr>

                                <tr class="border px-4 py-2">
                                    <td colspan="3" class="border px-4 py-2">{{ row.created_at }}</td>
                                    <td colspan="2" class="border px-4 py-2 text-center">
                                        <button
                                            v-if="replyFlag(index)"
                                            @click="edit(row)"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        >
                                            差戻し
                                        </button>
                                        <button
                                            v-if="aprFlags(index)"
                                            wire:click.prevent="update()"
                                            @click="approve(row)"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                        >
                                            承認
                                        </button>
                                    </td>
                                    <td colspan="1" class="border px-4 py-2">{{ conf[row.status] }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="bg-gray-200 border px-4 py-2">概要(午前)</th>
                                    <th colspan="1" class="bg-gray-200 border px-4 py-2">営業先(午前)</th>
                                    <th colspan="2" class="bg-gray-200 border px-4 py-2">概要(午後)</th>
                                    <th colspan="1" class="bg-gray-200 border px-4 py-2">営業先(午後)</th>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border px-4 py-2">{{ row.summary_am }}</td>
                                    <td colspan="1" class="border px-4 py-2">{{ row.client_name_am }}</td>
                                    <td colspan="2" class="border px-4 py-2">{{ row.summary_pm }}</td>
                                    <td colspan="1" class="border px-4 py-2">{{ row.client_name_pm }}</td>
                                </tr>
                                <th colspan="3" class="bg-gray-200 border px-4 py-2">内容(午前)</th>
                                <th colspan="3" class="bg-gray-200 border px-4 py-2">内容(午後)</th>
                                <tr>
                                    <td colspan="3" class="border px-4 py-2 whiteSpace">
                                        {{ row.contents_am }}
                                    </td>
                                    <td colspan="3" class="border px-4 py-2 whiteSpace">
                                        {{ row.contents_pm }}
                                    </td>
                                </tr>
                                <th colspan="6" class="bg-gray-200 border px-4 py-2">上司コメント</th>
                                <tr>
                                    <td colspan="6" class="border px-4 py-2">{{ row.comment }}</td>
                                </tr>
                            </div>
                        </tbody>
                    </table>
                    <table v-else-if="this.$page.user.role_id == 5" class="w-full">
                        <tbody>
                            <div v-for="(row, index) in userPosts" class="margin_bottom">
                                <tr>
                                    <th colspan="4" class="bg-gray-200 border px-4 py-2 w-1/12">名前</th>
                                    <th colspan="2" class="bg-gray-200 border px-4 py-2 w-1/12">team</th>
                                </tr>
                                <tr class="border px-4 py-2">
                                    <td colspan="4" class="border px-4 py-2">{{ row.user_name }}</td>
                                    <td colspan="2" class="border px-4 py-2">{{ row.team_name }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="bg-gray-200 border px-4 py-2 w-5/12">作成日</th>
                                    <th colspan="2" class="bg-gray-200 border px-4 py-2 w-5/12">Action</th>
                                    <th colspan="1" class="bg-gray-200 border px-4 py-2">状態</th>
                                </tr>

                                <tr class="border px-4 py-2">
                                    <td colspan="3" class="border px-4 py-2">{{ row.created_at }}</td>
                                    <td colspan="2" class="border px-4 py-2 text-center">
                                        <button
                                            v-if="resFlag(index)"
                                            wire:click.prevent="retryPost()"
                                            type="button"
                                            @click="edit(row)"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        >
                                            再提出
                                        </button>
                                        <button
                                            v-if="replyFlag(index)"
                                            @click="edit(row)"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        >
                                            差戻し
                                        </button>
                                        <button
                                            v-if="aprFlags(index)"
                                            wire:click.prevent="update()"
                                            @click="approve(row)"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                        >
                                            承認
                                        </button>
                                    </td>
                                    <td colspan="1" class="border px-4 py-2">{{ conf[row.status] }}</td>
                                </tr>
                                <th colspan="2" class="bg-gray-200 border px-4 py-2">概要(午前)</th>
                                <th colspan="1" class="bg-gray-200 border px-4 py-2">営業先(午前)</th>
                                <th colspan="2" class="bg-gray-200 border px-4 py-2">概要(午後)</th>
                                <th colspan="1" class="bg-gray-200 border px-4 py-2">営業先(午後)</th>
                                <tr>
                                    <td colspan="2" class="border px-4 py-2">{{ row.summary_am }}</td>
                                    <td colspan="1" class="border px-4 py-2">{{ row.client_name_am }}</td>
                                    <td colspan="2" class="border px-4 py-2">{{ row.summary_pm }}</td>
                                    <td colspan="1" class="border px-4 py-2">{{ row.client_name_pm }}</td>
                                </tr>
                                <th colspan="3" class="bg-gray-200 border px-4 py-2">内容(午前)</th>
                                <th colspan="3" class="bg-gray-200 border px-4 py-2">内容(午後)</th>
                                <tr>
                                    <td colspan="3" class="border px-4 py-2 whiteSpace">
                                        {{ row.contents_am }}
                                    </td>
                                    <td colspan="3" class="border px-4 py-2 whiteSpace">
                                        {{ row.contents_pm }}
                                    </td>
                                </tr>
                                <th colspan="6" class="bg-gray-200 border px-4 py-2">上司コメント</th>
                                <tr>
                                    <td colspan="6" class="border px-4 py-2">{{ row.comment }}</td>
                                </tr>
                            </div>
                        </tbody>
                    </table>
                    <table v-else-if="this.$page.user.role_id == 10" class="w-full">
                        <tbody>
                            <div v-for="(row, index) in userPosts" class="margin_bottom">
                                <tr>
                                    <th colspan="4" class="bg-gray-200 border px-4 py-2 w-1/12">名前</th>
                                    <th colspan="2" class="bg-gray-200 border px-4 py-2 w-1/12">team</th>
                                </tr>
                                <tr class="border px-4 py-2">
                                    <td colspan="4" class="border px-4 py-2">{{ row.user_name }}</td>
                                    <td colspan="2" class="border px-4 py-2">{{ row.team_name }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="bg-gray-200 border px-4 py-2 w-5/12">作成日</th>
                                    <th colspan="2" class="bg-gray-200 border px-4 py-2 w-5/12">Action</th>
                                    <th colspan="1" class="bg-gray-200 border px-4 py-2">状態</th>
                                </tr>

                                <tr class="border px-4 py-2">
                                    <td colspan="3" class="border px-4 py-2">{{ row.created_at }}</td>
                                    <td colspan="2" class="border px-4 py-2 text-center">
                                        <button
                                            v-if="judgeRole(index)"
                                            @click="edit(row)"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        >
                                            再提出
                                        </button>
                                    </td>
                                    <td colspan="1" class="border px-4 py-2">{{ conf[row.status] }}</td>
                                </tr>
                                <th colspan="2" class="bg-gray-200 border px-4 py-2">概要(午前)</th>
                                <th colspan="1" class="bg-gray-200 border px-4 py-2">営業先(午前)</th>
                                <th colspan="2" class="bg-gray-200 border px-4 py-2">概要(午後)</th>
                                <th colspan="1" class="bg-gray-200 border px-4 py-2">営業先(午後)</th>
                                <tr>
                                    <td colspan="2" class="border px-4 py-2">{{ row.summary_am }}</td>
                                    <td colspan="1" class="border px-4 py-2">{{ row.client_name_am }}</td>
                                    <td colspan="2" class="border px-4 py-2">{{ row.summary_pm }}</td>
                                    <td colspan="1" class="border px-4 py-2">{{ row.client_name_pm }}</td>
                                </tr>
                                <th colspan="3" class="bg-gray-200 border px-4 py-2">内容(午前)</th>
                                <th colspan="3" class="bg-gray-200 border px-4 py-2">内容(午後)</th>
                                <tr>
                                    <td colspan="3" class="border px-4 py-2 whiteSpace">
                                        {{ row.contents_am }}
                                    </td>
                                    <td colspan="3" class="border px-4 py-2 whiteSpace">
                                        {{ row.contents_pm }}
                                    </td>
                                </tr>
                                <th colspan="6" class="bg-gray-200 border px-4 py-2">上司コメント</th>
                                <tr>
                                    <td colspan="6" class="border px-4 py-2">{{ row.comment }}</td>
                                </tr>
                            </div>
                        </tbody>
                    </table>
                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>
                            <!-- This element is to trick the browser into centering the modal contents. -->
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                            <div
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="modal-headline"
                            >
                                <!-- 再提出フォーム -->
                                <form v-if="resForm()">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="">
                                            <div class="mb-4">
                                                <label
                                                    for="exampleFormControlInput1"
                                                    class="block text-gray-700 text-sm font-bold mb-2"
                                                    >名前:{{ this.$page.user['name'] }}
                                                </label>
                                                <input
                                                    type="hidden"
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="exampleFormControlInput1"
                                                    placeholder="Enter Title"
                                                    v-model="form.user"
                                                />
                                                <div v-if="$page.errors.title" class="text-red-500">
                                                    {{ $page.errors.title[0] }}
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label
                                                    for="exampleFormControlInput1"
                                                    class="block text-gray-700 text-sm font-bold mb-2"
                                                    >報告日時:{{ this.form['updated_at'] }}</label
                                                >
                                                <input
                                                    type="hidden"
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
                                                <label
                                                    for="exampleFormControlInput1"
                                                    class="block text-gray-700 text-sm font-bold mb-2"
                                                    >所属部署:{{ this.$page.user.current_team.name }}</label
                                                >
                                                <input
                                                    type="hidden"
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
                                                <label
                                                    for="exampleFormControlInput1"
                                                    class="block text-gray-700 text-sm font-bold mb-2"
                                                    >業務報告(午前):</label
                                                >

                                                <textarea
                                                    class="shadow appearance-none border rounded w-full py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="exampleFormControlInput2"
                                                    v-model="form.summary_am"
                                                    placeholder="業務"
                                                ></textarea>
                                                <div v-if="$page.errors.title" class="text-red-500">
                                                    {{ $page.errors.title[0] }}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <textarea
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="exampleFormControlInput2"
                                                    v-model="form.contents_am"
                                                    placeholder="内容"
                                                ></textarea>
                                                <div v-if="$page.errors.body" class="text-red-500">
                                                    {{ $page.errors.body[0] }}
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label
                                                    for="exampleFormControlInput1"
                                                    class="block text-gray-700 text-sm font-bold mb-2"
                                                    >業務報告(午後):</label
                                                >

                                                <textarea
                                                    class="shadow appearance-none border rounded w-full py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="exampleFormControlInput2"
                                                    v-model="form.summary_pm"
                                                    placeholder="業務"
                                                ></textarea>
                                                <div v-if="$page.errors.title" class="text-red-500">
                                                    {{ $page.errors.title[0] }}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <textarea
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="exampleFormControlInput2"
                                                    v-model="form.contents_pm"
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
                                                wire:click.prevent="retryPost()"
                                                type="button"
                                                @click="submission(form)"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                            >
                                                再提出
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
                                <!-- 差戻しフォーム -->
                                <form v-else-if="replyForm()">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="">
                                            <div class="mb-4">
                                                <label
                                                    for="exampleFormControlInput2"
                                                    class="block text-gray-700 text-sm font-bold mb-2"
                                                    >差し戻しコメント:</label
                                                >
                                                <textarea
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="exampleFormControlInput2"
                                                    v-model="form.comment"
                                                    placeholder="Enter comment"
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
                                                v-if="replyForm(index)"
                                                wire:click.prevent="retryPost()"
                                                type="button"
                                                @click="replyRow(form)"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                            >
                                                差戻し
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
                                        <!-- <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto"> </span>
                                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto"> </span> -->
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
    props: ['data', 'errors', 'conf'],
    data() {
        return {
            editMode: false,
            isOpen: false,
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
        // ポストデータが空の時
        usrPosNull: function() {
            if (!this.userPost.length) {
                this.$page.flash.message = '未処理のデータはありません。';
            }
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
