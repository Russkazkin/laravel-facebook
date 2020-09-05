<template>
<div>
    <div class="w-100 h-64 overflow-hidden">
        <img class="object-cover w-full" src="https://images.unsplash.com/photo-1530790359200-e2cac35c770d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2555&q=80" alt="user profile wallpaper">
    </div>
</div>
</template>

<script>
export default {
    name: "Show",
    data() {
        return {
            loading: true,
            user: null,
        }
    },
    async mounted() {
        try {
            this.user = (await axios.get('/api/users/' + this.$route.params.userId)).data;
        } catch (error) {
            console.log('Unable to fetch user, ' + error.status)
        } finally {
            this.loading = false;
        }
    }
}
</script>

<style scoped>

</style>
