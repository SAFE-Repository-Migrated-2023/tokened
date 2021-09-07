<template>
<ul class="divide-y divide-gray-200">
    <contact-card-item v-for="contact in contactsArray" :key="contact.id" :contact="contact" @contact-deleted="onContactDeleted" />
</ul>
</template>
<script>
import ContactCardItem from './ContactCardItem';
export default {
    components: {
        ContactCardItem,
    },
    props: {
        contacts: Array,
    },
    data: function () {
        return {
            contactsArray: this.contacts
        }
    },
    methods: {
        onContactDeleted(id) {
            console.log(this.contacts);
            let index = this.contactsArray.findIndex(item => item.id === id );
            this.contactsArray.splice(index, 1);
        }
    }
}
</script>