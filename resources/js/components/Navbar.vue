<template>
<div class="bg-gray-50">
    <nav class="flex flex-wrap items-stretch px-8 py-2 max-w-6xl mx-auto">
        <div class="flex md:w-auto w-full px-8 py-2 items-center flex-shrink-0">
            <a href="/" class="font-bold text-xl">{{logoName}}</a>  
            <a role="button" class="md:hidden ml-auto text-white p-2 bg-blue-800" @click="toggleMenu">Menu</a>
        </div>
    
        <div id="navMenu" class="md:flex flex-grow bg-blue-50 md:bg-transparent" :class="navMenuClasses">
            <div class="md:flex ml-auto justify-end items-center">
            <a v-for="menuItem in menuItems" :key="menuItem.id" class="md:inline-block block p-2 m-3 font-semibold" :href="menuItem.link">{{menuItem.title}}</a>
            </div>
        </div>
    </nav>
</div>
</template>
<script>
export default {    
    data() {
        return {
            mobileMode: true
        };
    },
    props: {
        logoName: String,
        menuItems: Array,
    },
    computed: {
        navMenuClasses() {
            return {hidden: this.mobileMode};
        }
    },
    methods: {
        toggleMenu() {
            this.mobileMode = !this.mobileMode;
        }
    }
}
</script>