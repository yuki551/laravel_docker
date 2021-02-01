<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
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


<!-- ***************************** -->
                    <div v-if="this.$page.user.auth_id == 1">

                        <div>
                            <a :href="route('user.create')">
                            <jet-button class="bg-blue-700 text-base">Userを作成</jet-button>
                            </a>
                        </div>
                    
                        <h2 v-for="row in userPosts11">{{row.name}}</h2>

                        <table class="table-fixed w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12">編集</th>
                                    <th class="px-4 py-2 w-2/12">削除</th>
                                    <th class="px-4 py-2 w-1/12">社員ID</th>
                                    <th class="px-4 py-2 w-2/12">役職</th>
                                    <th class="px-4 py-2 w-5/12">名前</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in userPosts1">
                                    <td class="border px-4 py-2">
                                        <div>
                                            <a :href="route('user.edit',row.id)">
                                            <jet-button class="bg-blue-700 text-base">編集</jet-button>
                                            </a>
                                        </div>
                                    </td>
                                                            
                                    <td class="border px-4 py-2"> 
                                        <div>
                                            <a :href="route('user.show', row.id)">
                                            <jet-button class="bg-red-700 text-base"
                                            >削除</jet-button>
                                            </a>
                                        </div>
                                    </td>

                                    
                                    
                                    <td class="border px-4 py-2">{{ row.id }}</td>
                                    <td class="border px-4 py-2">{{ row.role_name }}</td>
                                    <td class="border px-4 py-2">{{ row.name }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2 v-for="row in userPosts12">{{row.name}}</h2>
                        <table class="table-fixed w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12">編集</th>
                                    <th class="px-4 py-2 w-2/12">削除</th>
                                    <th class="px-4 py-2 w-1/12">社員ID</th>
                                    <th class="px-4 py-2 w-2/12">役職</th>
                                    <th class="px-4 py-2 w-5/12">名前</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in userPosts2">
                                    <td class="border px-4 py-2">
                                        <div>
                                            <a :href="route('user.edit', row.id)">
                                            <jet-button class="bg-blue-700 text-base">編集</jet-button>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="border px-4 py-2"> 
                                        <div>
                                            <a :href="route('user.show', row.id)">
                                            <jet-button class="bg-red-700 text-base"
                                            >削除</jet-button>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="border px-4 py-2">{{ row.id }}</td>
                                    <td class="border px-4 py-2">{{ row.role_name }}</td>
                                    <td class="border px-4 py-2">{{ row.name }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2 v-for="row in userPosts13">{{row.name}}</h2>
                        <table class="table-fixed w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12">編集</th>
                                    <th class="px-4 py-2 w-2/12">削除</th>
                                    <th class="px-4 py-2 w-1/12">社員ID</th>
                                    <th class="px-4 py-2 w-2/12">役職</th>
                                    <th class="px-4 py-2 w-5/12">名前</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in userPosts3">
                                    <td class="border px-4 py-2">
                                        <div>
                                            <a :href="route('user.edit', row.id)">
                                                <jet-button class="bg-blue-700 text-base">編集</jet-button>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="border px-4 py-2"> 
                                        <div>
                                            <a :href="route('user.show', row.id)">
                                            <jet-button class="bg-red-700 text-base"
                                            >削除</jet-button>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="border px-4 py-2">{{ row.id }}</td>
                                    <td class="border px-4 py-2">{{ row.role_name }}</td>
                                    <td class="border px-4 py-2">{{ row.name }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2 v-for="row in userPosts14">{{row.name}}</h2>
                        <table class="table-fixed w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12">編集</th>
                                    <th class="px-4 py-2 w-2/12">削除</th>
                                    <th class="px-4 py-2 w-1/12">社員ID</th>
                                    <th class="px-4 py-2 w-2/12">役職</th>
                                    <th class="px-4 py-2 w-5/12">名前</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in userPosts4">
                                    <td class="border px-4 py-2">
                                        <div>
                                        <a :href="route('user.edit', row.id)">
                                            <jet-button class="bg-blue-700 text-base">編集</jet-button>
                                            </a>
                                        </div>
                                                    </td>
                                                    <td class="border px-4 py-2"> 
                                        <div>
                                            <a :href="route('user.show', row.id)">
                                            <jet-button class="bg-red-700 text-base"
                                            >削除</jet-button>
                                            </a>
                                        </div>
                                        </td>
                                    <td class="border px-4 py-2">{{ row.id }}</td>
                                    <td class="border px-4 py-2">{{ row.role_name }}</td>
                                    <td class="border px-4 py-2">{{ row.name }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2 v-for="row in userPosts15">{{row.name}}</h2>

                        <table class="table-fixed w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-2/12">編集</th>
                                    <th class="px-4 py-2 w-2/12">削除</th>
                                    <th class="px-4 py-2 w-1/12">社員ID</th>
                                    <th class="px-4 py-2 w-2/12">役職</th>
                                    <th class="px-4 py-2 w-5/12">名前</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in userPosts5">
                                    <td class="border px-4 py-2">
                                        <div>
                                        <a :href="route('user.edit', row.id)">
                                            <jet-button class="bg-blue-700 text-base">編集</jet-button>
                                            </a>
                                        </div>
                                                    </td>
                                                    <td class="border px-4 py-2"> 
                                        <div>
                                            <a :href="route('user.show', row.id)">
                                            <jet-button class="bg-red-700 text-base"
                                            >削除</jet-button>
                                            </a>
                                        </div>
                                        </td>
                                    <td class="border px-4 py-2">{{ row.id }}</td>
                                    <td class="border px-4 py-2">{{ row.role_name }}</td>
                                    <td class="border px-4 py-2">{{ row.name }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <!-- ************************************************* -->

                    <div v-else>
                        <h2 v-for="row in userPosts11">{{row.name}}</h2>
                        <table class="table-fixed w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-20">作成日</th>
                                    <th class="px-4 py-2">役職</th>
                                    <th class="px-4 py-2">名前</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in userPosts1">
                                    <td class="border px-4 py-2">{{ row.created_at | moment("YYYY年MM月DD日") }}</td>
                                    <td class="border px-4 py-2">{{ row.role_name }}</td>
                                    <td class="border px-4 py-2">{{ row.name }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2 v-for="row in userPosts12">{{row.name}}</h2>
                        <table class="table-fixed w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-20">作成日</th>
                                    <th class="px-4 py-2">役職</th>
                                    <th class="px-4 py-2">名前</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in userPosts2">
                                    <td class="border px-4 py-2">
                                        {{ row.created_at | moment("YYYY年MM月DD日") }}
                                    </td>
                                    <td class="border px-4 py-2">{{ row.role_name }}</td>
                                    <td class="border px-4 py-2">{{ row.name }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2 v-for="row in userPosts13">{{row.name}}</h2>
                        <table class="table-fixed w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-20">作成日</th>
                                    <th class="px-4 py-2">役職</th>
                                    <th class="px-4 py-2">名前</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in userPosts3">
                                    <td class="border px-4 py-2">{{ row.created_at | moment("YYYY年MM月DD日") }}</td>
                                    <td class="border px-4 py-2">{{ row.role_name }}</td>
                                    <td class="border px-4 py-2">{{ row.name }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2 v-for="row in userPosts14">{{row.name}}</h2>
                        <table class="table-fixed w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-20">作成日</th>
                                    <th class="px-4 py-2">役職</th>
                                    <th class="px-4 py-2">名前</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in userPosts4">
                                    <td class="border px-4 py-2">{{ row.created_at | moment("YYYY年MM月DD日") }}</td>
                                    <td class="border px-4 py-2">{{ row.role_name }}</td>
                                    <td class="border px-4 py-2">{{ row.name }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2 v-for="row in userPosts15">{{row.name}}</h2>

                        <table class="table-fixed w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-20">作成日</th>
                                    <th class="px-4 py-2">役職</th>
                                    <th class="px-4 py-2">名前</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in userPosts5">
                                    <td class="border px-4 py-2">{{ row.created_at | moment("YYYY年MM月DD日") }}</td>
                                    <td class="border px-4 py-2">{{ row.role_name }}</td>
                                    <td class="border px-4 py-2">{{ row.name }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

<!-- ********************************** -->
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
                                <form>
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="">
                                            <div class="mb-4">
                                                <label
                                                    for="exampleFormControlInput1"
                                                    class="block text-gray-700 text-sm font-bold mb-2"
                                                    >Title:</label
                                                >
                                                <input
                                                    type="text"
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="exampleFormControlInput1"
                                                    placeholder="Enter Title"
                                                    v-model="form.title"
                                                />
                                                <div v-if="$page.errors.title" class="text-red-500">
                                                    {{ $page.errors.title[0] }}
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label
                                                    for="exampleFormControlInput2"
                                                    class="block text-gray-700 text-sm font-bold mb-2"
                                                    >Body:</label
                                                >
                                                <textarea
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="exampleFormControlInput2"
                                                    v-model="form.body"
                                                    placeholder="Enter Body"
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
                                                wire:click.prevent="store()"
                                                type="button"
                                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                                v-show="!editMode"
                                                @click="save(form)"
                                            >
                                                Save
                                            </button>
                                        </span>
                                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                            <button
                                                wire:click.prevent="store()"
                                                type="button"
                                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                                v-show="editMode"
                                                @click="update(form)"
                                            >
                                                Update
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
        JetInputError,    },
    props: ['data', 'data2', 'users', 'errors', 'conf'],
    data() {
        return {
            editMode: false,
            isOpen: false,
            userPost: [],
            form: this.$inertia.form({
                status: 0,
                _method: "DELETE",
                confirm: 3,
            }),
        };
    },
    computed: {

        userPosts0: function(){
            this.userPost = [];
            this.userPost2 = [];
            this.userPost3 = [];

            for(let i = 1; i <= this.data2.length; i++){

                for(let j = 0; j < this.data.length; j++){
                    if (this.data[j].current_team_id == i) {
                    this.userPost.push(this.data[j]);
                    }
                }
            this.userPost2.$set("id" , i);
            this.userPost2.$set("users" , this.userPost);
            this.userPost3.$set(i, this.userPost2);
            this.userPost.splice(-this.userPost.length);
            this.userPost2.splice(-this.userPost2.length);
            }
            return this.userPost3;
        },

        userPosts11: function() {
            this.userPost = [];
            for (let i = 0; i < this.data2.length; i++) {
                
                if (this.data2[i].id == 1) {
                    this.userPost.push(this.data2[i]);
                }
            }
            return this.userPost;
        },
        userPosts12: function() {
            this.userPost = [];
            for (let i = 0; i < this.data2.length; i++) {
                if (this.data2[i].id == 2) {
                    this.userPost.push(this.data2[i]);
                }

            }
            return this.userPost;
        },
        userPosts13: function() {
            this.userPost = [];
            for (let i = 0; i < this.data2.length; i++) {
                if (this.data2[i].id == 3) {
                    this.userPost.push(this.data2[i]);
                }
            }
            return this.userPost;
        },
        userPosts14: function() {
            this.userPost = [];
            for (let i = 0; i < this.data2.length; i++) {
                if (this.data2[i].id == 4) {
                    this.userPost.push(this.data2[i]);
                }
            }
            return this.userPost;
        },
        userPosts15: function() {
            this.userPost = [];
            for (let i = 0; i < this.data2.length; i++) {
                if (this.data2[i].id == 5) {
                    this.userPost.push(this.data2[i]);
                }
            }
            return this.userPost;
        },

        userPosts1: function() {
            this.userPost = [];
            for (let i = 0; i < this.data.length; i++) {
                if (this.data[i].current_team_id == 1) {
                    this.userPost.push(this.data[i]);
                }
            }
            return this.userPost;
        },
        userPosts2: function() {
            this.userPost = [];
            for (let i = 0; i < this.data.length; i++) {
                if (this.data[i].current_team_id == 2) {
                    this.userPost.push(this.data[i]);
                }
            }
            return this.userPost;
        },
        userPosts3: function() {
            this.userPost = [];
            for (let i = 0; i < this.data.length; i++) {
                if (this.data[i].current_team_id == 3) {
                    this.userPost.push(this.data[i]);
                }
            }
            return this.userPost;
        },
        userPosts4: function() {
            this.userPost = [];
            for (let i = 0; i < this.data.length; i++) {
                if (this.data[i].current_team_id == 4) {
                    this.userPost.push(this.data[i]);
                }
            }
            return this.userPost;
        },
        userPosts5: function() {
            this.userPost = [];
            for (let i = 0; i < this.data.length; i++) {
                if (this.data[i].current_team_id == 5) {
                    this.userPost.push(this.data[i]);
                }
            }
            return this.userPost;
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
 


        deleteUser(id){

            this.form.post(route("user.destroy", id), {
                preserveScroll: false,
            });
            this.reset();
        },

        editUser: function(id){
            this.$inertia.post(route('user.edit', id));
        },


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
            this.$inertia.post('/dashboard/' + data.id, data);
            // this.editMode = true;
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

        // 編集
        approve: function(data) {
            data._method = 'PUT';
            data['status'] = 2;
            this.$inertia.post('/dashboard/' + data.id, data);
            this.reset();
        },

        confirm(data){
            data._method = 'GET';
            this.form.get(route('user.show'), data);
        },
    },
};
</script>
<style></style>
