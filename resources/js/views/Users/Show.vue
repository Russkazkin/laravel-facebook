<template>
<div class="flex flex-col items-center">
    <div class="relative mb-8" v-if="userStatus === 'success' && user">
        <UploadableImage class="w-100 h-64 overflow-hidden z-10" image-width="1500" image-height="300" location="cover" />
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
        <div v-if="!user">Loading...</div>
        <div class="absolute flex items-center bottom-0 right-0 mb-4 mr-12 z-20" v-else>
            <button class="py-1 px-3 bg-gray-400 rounded"
                    v-if="friendButtonText && friendButtonText !== 'Accept'"
                    @click="$store.dispatch('sendFriendRequest', $route.params.userId)"
                    :disabled="friendButtonText === 'Loading...'">
                {{ friendButtonText }}
            </button>
             <button class="mr-2 py-1 px-3 bg-blue-500 rounded"
                    v-if="friendButtonText && friendButtonText === 'Accept'"
                    @click="$store.dispatch('acceptFriendRequest', $route.params.userId)"
                    :disabled="friendButtonText === 'Loading...'">
                Accept
            </button>
            <button class="py-1 px-3 bg-gray-400 rounded"
                    v-if="friendButtonText && friendButtonText === 'Accept'"
                    @click="$store.dispatch('ignoreFriendRequest', $route.params.userId)"
                    :disabled="friendButtonText === 'Loading...'">
                Ignore
            </button>

        </div>
    </div>
    <div v-if="posts === null || postsStatus === 'loading'">Loading posts...</div>
    <p v-else-if="posts.length < 1">No posts found</p>
    <Post v-for="(post, index) in posts" :key="index" :post="post" v-else />
</div>
</template>

<script>
import Post from "../../components/Post";
import {mapGetters} from "vuex";
import UploadableImage from "../../components/UploadableImage";

export default {
    name: "Show",
    components: {
        UploadableImage,
        Post
    },
    async mounted() {
        await this.$store.dispatch("fetchUser", this.$route.params.userId);
        await this.$store.dispatch("fetchUserPosts", this.$route.params.userId);
    },
    computed: {
        ...mapGetters({
            user: 'user',
            friendButtonText: 'friendButtonText',
            userStatus: 'userStatus',
            postsStatus: 'postsStatus',
            posts: "posts",
        }),
    }
}
</script>

<style scoped>

</style>
