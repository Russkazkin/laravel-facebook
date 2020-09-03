<template>
<div class="flex flex-col items-center py-4">
    <NewPost/>
    <Post/>
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
        }
    },
    async mounted() {
        try {
            this.posts = (await axios.get('/api/posts')).data;
        } catch (error) {
            console.log('Unable to fetch posts, ' + error.status)
        } finally {

        }
    },
}
</script>

<style scoped>

</style>
