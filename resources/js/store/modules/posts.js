const state = {
    newsPosts: null,
    newsStatus: null,
};
const getters = {
    newsPosts: state => {
        return state.newsPosts
    },
    newsStatus: state => {
        return {
            postsStatus: state.newsPostsStatus,
        }
    },
};
const actions = {
    async fetchNewsPosts({commit, state}){
        commit("setPostsStatus", "loading");
        try {
            const posts = (await axios.get('/api/posts')).data.data;
            commit("setPosts", posts);
            commit("setPostsStatus", "success");
        } catch (error) {
            console.log('Unable to fetch posts, ' + error.response.status);
            commit("setPostsStatus", "error");
        }
    }
};
const mutations = {
    setPosts(state, posts) {
        state.newsPosts = posts;
    },
    setPostsStatus(state, status) {
        state.newsStatus = status;
    },

};

export default { state, getters, actions, mutations };
