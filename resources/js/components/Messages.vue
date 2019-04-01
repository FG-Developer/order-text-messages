<template>
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Messages Other Status</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th><b>Restaurant Name</b></th>
                                <th><b>Customer Number</b></th>
                                <th><b>Message</b></th>
                                <th><b>Status</b></th>
                                <th><b>Status Msg</b></th>
                                <th><b>Created At</b></th>
                                <th><b>Updated At</b></th>
                            </thead>
                            <tbody>
                                <tr v-for="item in allMessages.data">
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.restaurant_name }}</td>
                                    <td>{{ item.phone_number }}</td>
                                    <td>{{ item.message.substring(0, 50) }} ...</td>
                                    <td>{{ item.status }}</td>
                                    <td>{{ item.status_msg }}</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>{{ item.updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :data="allMessages" v-on:pagination-change-page="getAllMessages"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Last 50 Sent Message</div>
                    <div class="card-body">
                        <form v-on:submit.prevent @submit="searcInLasthMessage">
                            <input type="text" v-model="keyword" placeholder="[Phone, Message, Restaurant] Min. 3 char." style="width: 300px;" required minlength="3">
                            <input type="submit" value="Search">
                        </form>

                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th><b>Restaurant Name</b></th>
                                <th><b>Customer Number</b></th>
                                <th><b>Message</b></th>
                                <th><b>Created At</b></th>
                                <th><b>Updated At</b></th>
                            </thead>
                            <tbody>
                                <tr v-for="item in lastMessages.data">
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.restaurant_name }}</td>
                                    <td>{{ item.phone_number }}</td>
                                    <td>{{ item.message.substring(0, 75) }} ...</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>{{ item.updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                allMessages: {},
                lastMessages: {},
                keyword: ''
            }
        },
        created: function(){
            this.getAllMessages();
            this.getLastMessages();
        },
        methods: {
            getAllMessages(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/messages' + '?page=' + page)
                    .then(response => {
                        console.log(response.data);
                        this.allMessages = response.data;
                    })
                    .catch(error => {
                        console.log('Something went wrong. Please try again.');
                    });
            },
            getLastMessages() {

                var q = '';
                if (this.keyword !== '' && this.keyword.length > 2) {
                    q = '?q=' + this.keyword;
                }

                axios.get('/api/last-sent-messages' + q)
                    .then(response => {
                        this.lastMessages = response.data;
                    })
                    .catch(error => {
                        console.log('Something went wrong. Please try again.');
                    });
            },
            searcInLasthMessage(){
                this.getLastMessages();
            }

        }
    }
</script>
