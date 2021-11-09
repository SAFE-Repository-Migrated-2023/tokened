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
        }
    },
    methods: {
        check() {
            axios.post('/check', {aid: this.aid, _method: 'post'})
                .then((response) => {
                    let data = response.data;
                    this.message = data.status;

                    if (data.error){
                        this.message = data.error_message;
                        return;
                    }

                    if (data.status == 'AUTHORIZED' && data.logged_in){
                        window.location.href = data.redirect;
                        return;
                    }

                    this.progress = Math.round(100/12 * (this.attempt+1));
                    this.attempt++;
                    if(this.attempt < 12){
                        setTimeout( () => {
                            this.check();
                        }, 1000);
                    }

                    //kill session
                    if(this.attempt == 12){
                        this.killSession();
                    }
                });
       },
       killSession() {
            axios.post('/kill', {_method: 'post'})
                .then(() => {
                    window.location.href = '/';
                });
       }
    }
}
</script>