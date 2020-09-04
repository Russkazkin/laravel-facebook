<template>
<div class="flex flex-col items-center py-4">
    <NewPost/>
    <p v-if="loading">Loading posts...</p>
    <Post v-for="post in posts" :key="post.data.post_id" :post="post" v-else />
</div>
</template>

<script>
import NewPost from "../components/NewPost";
import Post from "../components/Post";

export default {
    name: "NewsFeed",
    components: {
        NewPost,
        Post,
    },
    data() {
        return {
            posts: null,
            loading: true,
        }
    },
    async mounted() {
        try {
            this.posts = (await axios.get('/api/posts')).data.data;
        } catch (error) {
            console.log('Unable to fetch posts, ' + error.status)
        } finally {
            this.loading = false;
        }
    },
}
</script>

<style scoped>

</style>
