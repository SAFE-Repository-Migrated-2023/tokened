<template>
    <div>
        <progress-bar :value="progress"></progress-bar>
        <div v-if="message" class="text-center">
            <h2 class="mt-6 font-extrabold text-gray-900">{{message}}</h2>
        </div>
    </div>
</template>
<script>
import ProgressBar from './ProgressBar';
export default {
    components: {
        ProgressBar,
    },
    props: {
        aid: String,
    },
    data: function () {
        return {
            attempt: 0,
            progress: 0,
            message: null,
            timer: ''
        }
    },
    methods: {
        check() {
            axios.post('/check', {aid: this.aid, _method: 'post'})
                .then((response) => {
                    this.testLogin(response);
                });
       },
       killSession() {
            axios.post('/kill', {_method: 'post'})
                .then(() => {
                    window.location.href = '/';
                });
       },
       testLogin(response) {
            let data = response.data;
            this.message = data.status;

            if (data.error){
                this.clearTimer();
                this.clearBar();
                this.message = data.error_message;
                return;
            }

            if (data.logged_in){
                console.log('loggedin');
                this.clearTimer();
                this.maxBar();
                window.location.href = data.redirect;
                return;
            }

            this.progress = Math.round(100/12 * (this.attempt+1));
            this.attempt++;

            //kill session
            if(this.attempt == 12){
                this.message = 'TIMEOUT';
                this.clearTimer();
                this.clearBar();
                this.killSession();
            }
        },
        clearTimer() {
            clearInterval(this.timer);
        },
        clearBar() {
            this.progress = 0;
        },
        maxBar() {
            this.progress = 100;
        }
    },
    created() {
        this.timer = setInterval(this.check, 5000)
    }
}
</script>