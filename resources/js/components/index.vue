<template>
    <div class="container">
        <div class="row header">
            <div class="col">
                <h1>Shortener</h1>
            </div>
        </div>
        <div class="row input">
            <div class="col">
                <form action="" @submit.prevent="onSubmit" @keydown="form.errors.clear()">
                    <div class="input-group">
                        <input v-model="form.url" type="text" class="form-control"
                               placeholder="webpage url" name="url">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Short It!</button>
                        </div>
                    </div>
                    <span class="small text-danger" v-if="form.errors.has('url')"
                          v-text="form.errors.get('url')"></span>
                </form>
            </div>
        </div>
        <div class="row output">
            <div class="col">
                <h3 v-text="shorted_url"></h3>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from '../utils/Form';

    export default {
        data() {
            return {
                app_url: process.env.MIX_APP_URL,
                shorted_url: '',
                form: new Form({
                    url: ''
                })
            }
        },
        methods: {
            onSubmit() {
                this.form.post('/api/shorten')
                    .then(response => this.shorted_url = this.app_url + '/' + response.url);
            }
        }
    }
</script>

<style>
    .container {
        height: 100vh;
        background-color: #eee;
    }

    .row {
        height: 33.33vh;
        text-align: center;
    }

    .row .col {
        margin: auto 0;
    }
</style>
