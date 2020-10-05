const state = {
    user: false,
    userStatus: null,
    posts: [],
    postsStatus: null,
};
const getters = {
    user: state => {
        return state.user;
    },
    posts: state => {
        return state.posts
    },
    userStatus: state => {
        return state.userStatus;
    },
    postsStatus: state => {
        return state.postsStatus;
    },
    friendship: state => {
        return state.user.data.attributes.friendship;
    },
    friendButtonText: (state, getters, rootState) => {
        if(getters.friendship === null){
            return "Add Friend";
        }else if(
            getters.friendship.data.attributes.confirmed_at === null
            && getters.friendship.data.attributes.friend_id !== rootState.User.authUser.data.user_id
        ) {
            return  "Pending Friend Request";
        } else if (getters.friendship.data.attributes.confirmed_at !== null){
            return '';
        }
        return 'Accept';
    }
};
const actions = {
    async fetchUser({commit, dispatch}, userId){
        commit("setUserStatus", "loading");
        try {
            const user = (await axios.get('/api/users/' + userId)).data;
            commit("setUser", user);
            commit("setUserStatus", "success");

        } catch (error) {
            console.log('Unable to fetch data, ' + error.response.status);
            commit("setUserStatus", "error");
        } finally {
            this.loading = false;
        }
    },
    async fetchUserPosts({commit, dispatch}, userId) {
        commit("setPostsStatus", "loading");
        try {
            const posts = (await axios.get('/api/users/' + userId + '/posts')).data.data;
            commit("setPosts", posts);
            commit("setPostsStatus", "success");
        } catch (error) {
            console.log('Unable to fetch data, ' + error.response.status);
            commit("setPostsStatus", "error");
        }
    },
    async sendFriendRequest({commit, getters}, friend_id) {
        if(getters.friendButtonText !== 'Add Friend') {
            return;
        }
        try {
            const friendship = (await axios.post('/api/friend-request', { 'friend_id': friend_id })).data;
            commit("setUserFriendship", friendship);
        } catch (e) {
            console.error(e.response.data.errors.detail);
        }
    },
     async acceptFriendRequest({commit, state}, user_id) {
        try {
            const friendship = (await axios.post('/api/friend-request-response', { 'user_id': user_id, 'status': 1 })).data;
            commit("setUserFriendship", friendship);
        } catch (e) {
            console.error(e.response.data.errors.detail);
        } finally {

        }
    },
    async ignoreFriendRequest({commit, state}, user_id) {
        try {
            (await axios.delete('/api/friend-request-response/delete', { data: {'user_id': user_id }})).data;
            commit("setUserFriendship", null);
        } catch (e) {
            console.error(e.response.data.errors.detail);
        } finally {

        }
    },

};
const mutations = {
    setUser(state, user) {
        state.user = user;
    },
    setPosts(state, posts) {
        state.posts = posts;
    },
    setUserFriendship(state, friendship) {
        state.user.data.attributes.friendship = friendship;
    },
    setUserStatus(state, status) {
        state.userStatus = status;
    },
    setPostsStatus(state, status) {
        state.postsStatus = status;
    }
};

export default { state, getters, actions, mutations };
