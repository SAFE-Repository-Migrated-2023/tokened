<template> 
    <div class="my-10">
        <div class="bg-gray-100 overflow-hidden rounded shadow">
            <div class="bg-green-500 py-1 rounded transition-all" :style="{width: value + '%'}"></div>
        </div>
        <div class="bg-blue text-xs leading-none text-center mt-3">{{value}}%</div>
    </div>
</template>
<script>
export default {   
    props: {
        value: Number,
    }
}
</script>