<template>
<div class="flex flex-col items-center">
    <div class="relative">
        <div class="w-100 h-64 overflow-hidden z-10">
            <img class="object-cover w-full" src="https://images.unsplash.com/photo-1530790359200-e2cac35c770d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2555&q=80" alt="user profile wallpaper">
        </div>
        <div class="absolute flex items-center bottom-0 left-0 -mb-8 ml-12 z-20">
            <div class="w-32">
                <img src="https://thispersondoesnotexist.com/image"
                     alt="user profile img"
                     class="object-cover w-32 h-32 border-4 border-gray-200 rounded-full shadow-lg">
            </div>
            <p class="ml-4 text-gray-100 text-2xl text-shadow">
                {{ user.data.attributes.name }}
            </p>
        </div>
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
            posts: null,
        }
    },
    async mounted() {
        try {
            this.user = (await axios.get('/api/users/' + this.$route.params.userId)).data;
            this.posts = (await axios.get('/api/users/' + this.$route.params.userId + '/posts')).data;
        } catch (error) {
            console.log('Unable to fetch data, ' + error.status)
        } finally {
            this.loading = false;
        }
    }
}
</script>

<style scoped>

</style>
