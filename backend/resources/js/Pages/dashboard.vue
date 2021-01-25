<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div v-if="notification == 1 && this.$page.user.role_id == 5" class="bg-blue-400 shadow">
            <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    未承認の日報があります。
                </h2>
            </div>
        </div>
        <div v-if="notification == 3 && this.$page.user.role_id == 10" class="bg-blue-400 shadow">
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
                    <table v-if="this.$page.user.role_id == 5" class="w-full">
                        <tbody>
                            <div v-for="(row, index) in userPosts" class="margin_bottom">
                                <th colspan="3" class="bg-gray-200 border px-4 py-2 w-6/12">作成日</th>
                                <th colspan="2" class="bg-gray-200 border px-4 py-2 w-5/12">Action</th>
                                <th colspan="1" class="bg-gray-200 border px-4 py-2">状態</th>
                                <tr class="border px-4 py-2">
                                    <td colspan="3" class="border px-4 py-2">{{ row.created_at }}</td>
                                    <td colspan="2" class="border px-4 py-2 text-center">
                                        <button
                                            @click="edit(row)"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        >
                                            差戻し
                                        </button>
                                        <button
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
                                    <td colspan="1" class="border px-4 py-2">{{ row.client_am }}</td>
                                    <td colspan="2" class="border px-4 py-2">{{ row.summary_pm }}</td>
                                    <td colspan="1" class="border px-4 py-2">{{ row.client_pm }}</td>
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
                    <table v-else class="w-full">
                        <tbody>
                            <div v-for="(row, index) in userPosts" class="margin_bottom">
                                <th colspan="3" class="bg-gray-200 border px-4 py-2 w-6/12">作成日</th>
                                <th colspan="2" class="bg-gray-200 border px-4 py-2 w-5/12">Action</th>
                                <th colspan="1" class="bg-gray-200 border px-4 py-2">状態</th>
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
                                    <td colspan="1" class="border px-4 py-2">{{ row.client_am }}</td>
                                    <td colspan="2" class="border px-4 py-2">{{ row.summary_pm }}</td>
                                    <td colspan="1" class="border px-4 py-2">{{ row.client_pm }}</td>
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
                                <form v-if="notification == 3">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="">
                                            <div class="mb-4">
                                                <label
                                                    for="exampleFormControlInput1"
                                                    class="block text-gray-700 text-sm font-bold mb-2"
                                                    >名前:{{ form.username }}
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
                                                    >報告日時:{{ form.date }}</label
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
                                                    >所属部署:{{ form.teamname }}</label
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
                                            <!-- 社長か部長の時表示 -->
                                            <button
                                                v-if="this.$page.user.role_id == 5 || this.$page.user.role_id == 3"
                                                wire:click.prevent="retryPost()"
                                                type="button"
                                                @click="replyRow(form)"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                            >
                                                差戻し
                                            </button>
                                        </span>
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
                                <form v-else-if="notification == 1">
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
                                            <!-- 社長か部長の時表示 -->
                                            <button
                                                v-if="this.$page.user.role_id == 5 || this.$page.user.role_id == 3"
                                                wire:click.prevent="retryPost()"
                                                type="button"
                                                @click="replyRow(form)"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                            >
                                                差戻し
                                            </button>
                                        </span>
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
                    if (this.data[i].user == this.$page.user.id) {
                        this.userPost.push(this.data[i]);
                    }
                }
            } else if (this.$page.user.role_id == 5) {
                //部長role
                this.userPost = [];
                for (let i = 0; i < this.data.length; i++) {
                    if (this.data[i].team == this.$page.user.current_team_id) {
                        this.userPost.push(this.data[i]);
                    }
                }
            } else if (this.$page.user.role_id == 3) {
                //社長role
                return this.data;
            }
            return this.userPost;
        },
        notification: function() {
            for (let i = 0; i < this.userPosts.length; i++) {
                // 差戻し時かつユーザーが一般ユーザーの時
                if (3 == this.userPost[i]['status'] && this.$page.user.role_id == 10) {
                    return 3;
                }
                // 未承認かつ部長ユーザーの時
                if (1 == this.userPost[i]['status'] && this.$page.user.role_id == 5) {
                    return 1;
                }
            }
        },
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
            (this.form = {}), (this.params = {});
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
        // 差戻し
        replyRow: function(data) {
            data._method = 'PUT';
            data['status'] = 3;
            this.$inertia.post('/dashboard/' + data.id, data);
            this.reset();
            this.closeModal();
        },
        // 承認
        approve: function(data) {
            data._method = 'PUT';
            data['status'] = 2;
            this.$inertia.post('/dashboard/' + data.id, data);
            this.reset();
        },
        // 提出
        submission: function(data) {
            data._method = 'PUT';
            data['status'] = 1;
            this.$inertia.post('/dashboard/' + data.id, data);
            this.reset();
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
            }
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
