<template>
<div class="flex flex-col items-center py-4">
    <NewPost/>
    <p v-if="postsStatus === 'loading'">Loading posts...</p>
    <Post v-for="(post, index) in posts" :key="index" :post="post" v-else />
</div>
</template>

<script>
import NewPost from "../components/NewPost";
import Post from "../components/Post";
import {mapGetters} from "vuex";

export default {
    name: "NewsFeed",
    components: {
        NewPost,
        Post,
    },
    computed: {
        ...mapGetters({
            posts: "posts",
            postsStatus: "postsStatus",
        }),
    },
    async mounted() {
        await this.$store.dispatch("fetchNewsPosts");
    },
}
</script>

<style scoped>

</style>
