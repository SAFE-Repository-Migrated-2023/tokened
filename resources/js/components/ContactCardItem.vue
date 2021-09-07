<template> 
  <div class="rounded-xl shadow-md p-4 mb-4 flex flex-wrap">
        <div class="mb-3">
            <img class="rounded sm:w-28 h-auto mr-6" :src="imgSrc" alt="image">
        </div>
        <div class="flex-grow">
            <div>
                <!-- <a :href="detailsLink" class="link font-bold mb-2 uppercase">Details</a> -->
                <div class="text-sm text-gray-600">
                    <ul>
                        <li><strong>Name:</strong> {{ contact.name }}</li>
                        <li><strong>Title:</strong> {{ contact.title }}</li>
                        <li><strong>Company:</strong> {{ contact.company }}</li>
                        <li><strong>Education:</strong> {{ contact.education }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- <div class="w-full sm:w-auto">
            <div class="mt-6 sm:mt-0">
                <button type="button" class="btn text-red-500" @click="deleteContact">Delete</button>
                <a :href="editLink" class="btn btn-primary ml-5 sm:mt-3">Edit</a>
            </div>
        </div> -->
        <div class="w-full sm:w-auto flex items-center">
            <label :for="id" class="flex items-center cursor-pointer">
                <div class="relative">
                    <input type="checkbox" name="share" :id="id" class="sr-only" v-model="checked" @click="toggleConnection">
                    <div class="block bg-gray-600 w-8 h-5 rounded-full"></div>
                    <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"></div>
                </div>
                <div class="ml-3 font-medium">

                    <div class="text-red-700" v-if="checked">
                    Disconnect
                    </div>
                    <div class="text-gray-700" v-else>
                    Connect
                    </div>
                </div>
            </label>
        </div>
    </div>
</template>
<script>
export default {
    created() {
        console.log(this.contact);
    },
    data() {
        return {
            id: this.contact.id,
            checked: this.contact.share
        };
    },
    props: {
        contact: Object,
    },
    emits: ['contactDeleted'],
    computed: {
       imgSrc(){
            return this.contact.image;
       },
    //    editLink(){
    //        return '/contacts/' + this.contact.id + '/edit';
    //    },
    //    detailsLink(){
    //        return '/contacts/' + this.contact.id;
    //    }
    },
    methods: {
       deleteContact() {
           axios.post('/contacts/' + this.contact.id, {_method: 'delete'})
                .then((response)=>{
                    this.$emit('contactDeleted', this.contact.id);
                });
       },
       toggleConnection() {
           axios.post('/contacts/' + this.contact.id + '/connect', {_method: 'put', share: !this.checked});
       }
    }
}
</script>