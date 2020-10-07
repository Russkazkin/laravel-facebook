const state = {
    newsPosts: null,
    newsPostsStatus: null,
    postMessage: '',
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
    postMessage: state => {
        return state.postMessage;
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
    },
    async postMessage({commit, state}){
        commit("setPostsStatus", "loading");
        try {
            const post = (await axios.post('/api/posts', { body: state.postMessage })).data;
            commit("pushPost", post);
            commit("updateMessage", "");
        } catch (error) {
            console.log('Unable to fetch posts, ' + error.response.status);
        }
    },

};
const mutations = {
    setPosts(state, posts) {
        state.newsPosts = posts;
    },
    setPostsStatus(state, status) {
        state.newsStatus = status;
    },
    updateMessage(state, message) {
        state.postMessage = message;
    },
    pushPost(state, post) {
        state.newsPosts.unshift(post);
    }

};

export default { state, getters, actions, mutations };
