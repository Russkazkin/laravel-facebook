<template>
<div class="flex flex-col items-center">
    <div class="relative mb-8">
        <div class="w-100 h-64 overflow-hidden z-10">
            <img class="object-cover w-full" src="https://photographylife.com/wp-content/uploads/2017/01/What-is-landscape-photography.jpg" alt="user profile wallpaper">
        </div>
        <div class="absolute flex items-center bottom-0 left-0 -mb-8 ml-12 z-20">
            <div class="w-32">
                <img src="https://thispersondoesnotexist.com/image"
                     alt="user profile img"
                     class="object-cover w-32 h-32 border-4 border-gray-200 rounded-full shadow-lg">
            </div>
            <p v-if="loading" class="ml-4 text-gray-100 text-2xl text-shadow">
                Loading...
            </p>
            <p v-else class="ml-4 text-gray-100 text-2xl text-shadow">
                {{ user.data.attributes.name }}
            </p>
        </div>
        <div class="absolute flex items-center bottom-0 right-0 mb-4 mr-12 z-20">
            <button class="py-1 px-3 bg-gray-400 rounded"
                    @click="$store.dispatch('sendFriendRequest', $route.params.userId)"
                    :disabled="friendButtonText === 'Loading...'">
                {{ friendButtonText }}
            </button>
        </div>
    </div>
    <p v-if="loading">Loading posts...</p>
    <Post v-for="post in posts" :key="post.data.post_id" :post="post" v-else />
    <p v-if="!loading && posts.length < 1">No posts found</p>
</div>
</template>

<script>
import Post from "../../components/Post";
import {mapGetters} from "vuex";

export default {
    name: "Show",
    components: {
        Post
    },
    data() {
        return {
            loading: true,
            posts: null,
        }
    },
    async mounted() {
        await this.$store.dispatch("fetchUser", this.$route.params.userId);

        try {
            this.posts = (await axios.get('/api/users/' + this.$route.params.userId + '/posts')).data.data;
        } catch (error) {
            console.log('Unable to fetch data, ' + error.status)
        } finally {
            this.loading = false;
        }
    },
    computed: {
        ...mapGetters({
            user: 'user',
            friendButtonText: 'friendButtonText',
        }),
    }
}
</script>

<style scoped>

</style>
