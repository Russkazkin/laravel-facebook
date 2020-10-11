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
    async likePost({commit, state}, {postId, postKey}) {
        try {
            const likes = (await axios.post('/api/posts/' + postId + '/like')).data;
            commit("pushLikes", {likes: likes, postKey: postKey});
        } catch (error) {
            console.error(error);
        }
    },
    async commentPost({commit, state}, {body, postId, postKey}) {
        try {
            const comments = (await axios.post('/api/posts/' + postId + '/comment', {body})).data;
            commit("pushComments", {comments, postKey});
        } catch (error) {
            console.error(error);
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
    updateMessage(state, message) {
        state.postMessage = message;
    },
    pushPost(state, post) {
        state.newsPosts.unshift(post);
    },
    pushLikes(state, {likes, postKey}) {
        state.newsPosts[postKey].data.attributes.likes = likes;
    },
    pushComments(state, {comments, postKey}) {
        state.newsPosts[postKey].data.attributes.comments = comments;
    }

};

export default { state, getters, actions, mutations };
