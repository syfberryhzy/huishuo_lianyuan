<template>

</template>
<script>
    export default {
        props: ['url'],
        mounted() {
            if (this.url) {
                setTimeout(() => {
                    window.location.href = this.url;
                }, 3000)
            }
        }
    }
</script>
